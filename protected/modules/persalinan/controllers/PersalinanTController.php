<?php

class PersalinanTController extends MyAuthController {

    public function actionIndex($id) {

        $getPersalinanId = PSPersalinanT::model()->find(" pendaftaran_id = '".$id."' ");
        
        $modPendaftaran=PSPendaftaranT::model()->findByPk($id);
        $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPemeriksaan = PemeriksaanfisikT::model()->findByAttributes(array(
            'pendaftaran_id'=>$id,
        ), array(
            'condition'=>'pasienadmisi_id is null'
        ));
        $modPersalinan = PSPersalinanT::model()->with(array('pendaftaran','pegawai'))->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pasien_id'=>$modPasien->pasien_id));
        $modGinekologi = PSPemeriksaanginekologiT::model()->findByAttributes(array(
            'pendaftaran_id'=>$id,
        ), array(
            'condition'=>'pasienadmisi_id is null'
        ));
        $modDetails = null;
        
        $format = new MyFormatter;
        
        if (count($getPersalinanId)>0){
            $modObsterikus = PSPemeriksaanobstetrikT::model()->findByAttributes(array(
                'persalinan_id'=>$getPersalinanId->persalinan_id,
            ));
            
            if (count($modObsterikus)>0){
                $modObsterikus->plasenta_lahir = MyFormatter::formatDateTimeForUser($modObsterikus->plasenta_lahir);
                $modObsterikus->obs_periksadalam = MyFormatter::formatDateTimeForUser($modObsterikus->obs_periksadalam);
                
                $modPeriksaKala4 = PSPemeriksaankala4T::model()->findByAttributes(array(
                    'pemeriksaanobstetrik_id'=>$modObsterikus->pemeriksaanobstetrik_id,
                ));
                
                $modPartograf = PSPemeriksaanpartografT::model()->findByAttributes(array(
                    'persalinan_id'=>$getPersalinanId->persalinan_id,
                ));               
                
                

                if (count($modPeriksaKala4) < 1){
                    $modPeriksaKala4 = new PSPemeriksaankala4T;                
                }
                
                if (count($modPartograf) < 1){
                    $modPartograf = new PSPemeriksaanpartografT;   
                     $modPartografObat = new PSPemeriksaanpartografobatT;        
                }else{                    
                    $modPartografObat = PSPemeriksaanpartografobatT::model()->findByAttributes(array(
                        'pemeriksaanpartograf_id'=>$modPartograf->pemeriksaanpartograf_id,
                    ));
                    
                    if (count($modPartografObat) < 1){
                        $modPartografObat = new PSPemeriksaanpartografobatT;                
                    }
                }
            }else{
                $modObsterikus = new PSPemeriksaanobstetrikT;
                $modPeriksaKala4 = new PSPemeriksaankala4T;
                $modPartograf = new PSPemeriksaanpartografT;
                $modPartografObat = new PSPemeriksaanpartografobatT;    
                            
            }
            
           
        }else{
            $modObsterikus = new PSPemeriksaanobstetrikT;            
            $modPeriksaKala4 = new PSPemeriksaankala4T;
            $modPartograf = new PSPemeriksaanpartografT;
            $modPartografObat = new PSPemeriksaanpartografobatT;    
                        
        }
                

        if (count($modPersalinan) > 0) {
            $model = PSPersalinanT::model()->with(array('pendaftaran','pegawai'))->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pasien_id'=>$modPasien->pasien_id));
            $model->tglmulaipersalinan = MyFormatter::formatDateTimeForUser($model->tglmulaipersalinan);            
            if (!empty($model->tglselesaipersalinan)) $model->tglselesaipersalinan = MyFormatter::formatDateTimeForUser($model->tglselesaipersalinan);
            if (!empty($model->tglmelahirkan)) $model->tglmelahirkan = MyFormatter::formatDateTimeForUser($model->tglmelahirkan);
            if (isset($model->paritaske)){
                    if (is_numeric($model->paritaske)){
                        $model->paritaske = (isset($model->paritaske) ? ucwords(implode('',CustomFunction::getNomorUrutText($model->paritaske,$model->paritaske))) :"-");                         
                    }else{
                        $model->paritaske =  (isset($model->paritaske) ?$model->paritaske:'-'); //(isset($persalinan->paritaske) ? implode('',CustomFunction::getNomorUrutText($persalinan->paritaske,$persalinan->paritaske)) :"-"); 
                    }
                }
        }else{                        
            $model = new PSPersalinanT;
            $model->tglmulaipersalinan = date('d M Y H:i:s');
            $model->tglabortus = date('d M Y H:i:s');
            $model->pegawai_id = $modPendaftaran->pegawai_id;
        }
        
        if (empty($modPemeriksaan)) {
            $modPemeriksaan = new PemeriksaanfisikT;
        } else {
            if (!empty($modPemeriksaan->obs_periksadalam)) $modPemeriksaan->obs_periksadalam = MyFormatter::formatDateTimeForUser($modPemeriksaan->obs_periksadalam);
            if (!empty($modPemeriksaan->plasenta_lahir)) $modPemeriksaan->plasenta_lahir = MyFormatter::formatDateTimeForUser($modPemeriksaan->plasenta_lahir);
        }
                
        
        if (empty($modGinekologi)){
            
            $modGinekologi = PSPemeriksaanginekologiT::model()->findByAttributes(array(
            'pendaftaran_id'=>$id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
            ));
            
            if (empty($modGinekologi)){
                $modGinekologi = new PSPemeriksaanginekologiT;
                $modRiwayatKehamilan = null;
                $modRiwayatKB = new PSRiwayatkbT;
                
                $modGinekologi->tglperiksaobgyn = date("d M Y H:i:s");                                                                
            }else{
                $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForUser($modGinekologi->tglperiksaobgyn);
                $modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");            
                
                $modRiwayatKB = PSRiwayatkbT::model()->find(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' AND kb_status = TRUE");
                
                if (count($modRiwayatKB)< 1){
                    $modRiwayatKB = new PSRiwayatkbT;
                }  
            }                       
        }else{           
            $modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");                        
            $modRiwayatKB = PSRiwayatkbT::model()->find(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."'  AND kb_status = TRUE ");
            if (count($modRiwayatKB)< 1){
                $modRiwayatKB = PSRiwayatkbT::model()->find(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."'  AND kb_status = FALSE ");
                if (count($modRiwayatKB)< 1){
                    $modRiwayatKB = new PSRiwayatkbT;
                }                
            }
            
            $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForUser($modGinekologi->tglperiksaobgyn);
        
        }
        
        //simpan pemeriksaan ginekologi dipisah, dikarenakan pemeriksaan dalam kandungan .... tidak harus bersamaan dengan persalinan_t dan pemeriksaanfisik_t
        
        if ( (empty($_POST['PSPersalinanT']['paritaske'])) OR  (empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan'])) ){
            $trans = Yii::app()->db->beginTransaction();
        }
                        
        if (isset($_POST['PSPemeriksaanginekologiT']))
        {
            
            if (!empty($_POST['PSPemeriksaanginekologiT']['pegawai_id']))
            {                    
                
                //Pemeriksaan Ginekologi
                foreach ($_POST['PSPemeriksaanginekologiT'] as $key=>$val) {
                    $modGinekologi[$key] = $val;
                }


                if ($modGinekologi->isNewRecord) {
                    $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForDb($modGinekologi->tglperiksaobgyn);
                    $modGinekologi->pasien_id = $modPendaftaran->pasien_id;
                    $modGinekologi->pendaftaran_id = $modPendaftaran->pendaftaran_id;  
                    if (!empty($modPendaftaran->pasienadmisi_id)){
                        $modGinekologi->pasienadmisi_id = $modPendaftaran->pasienadmisi_id; 
                    }
                    $modGinekologi->create_time = date('Y-m-d H:i:s');
                    $modGinekologi->create_loginpemakai_id = Yii::app()->user->id;
                    $modGinekologi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                }else{
                    $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForDb($modGinekologi->tglperiksaobgyn);
                    $modGinekologi->update_time = date('Y-m-d H:i:s');
                    $modGinekologi->update_loginpemakai_id = Yii::app()->user->id;
                }
                $modGinekologi->gin_keluhan = isset($_POST['PSPemeriksaanginekologiT']['gin_keluhan']) ? ((count($_POST['PSPemeriksaanginekologiT']['gin_keluhan'])>0) ? implode(',', $_POST['PSPemeriksaanginekologiT']['gin_keluhan']) : '') : '';
                
                
                //$successRiwayatKehamilan = false;die
                    if ($modGinekologi->save()){

                        $cekRiwayatkehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");

                        if (!empty($cekRiwayatkehamilan)){
                            $hapusRiwayatKehamilan = PSRiwayatkehamilanT::model()->deleteAll('pemeriksaanginekologi_id='.$modGinekologi->pemeriksaanginekologi_id.''); 
                        }
                        //Riwayat Kehamilan     //Riwayat keluarga berencana
                        if (isset($_POST['PSRiwayatkehamilanT']) || isset($_POST['PSRiwayatkbT'])){
                                $cekRiwayatkehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");
                                //if ( count($_POST['PSRiwayatkehamilanT']) != count($cekRiwayatkehamilan) ){
                            if (!empty($_POST['PSRiwayatkehamilanT'])){    
                                if (!empty($cekRiwayatkehamilan)){
                                    $hapusRiwayatKehamilan = PSRiwayatkehamilanT::model()->deleteAll('pemeriksaanginekologi_id='.$modGinekologi->pemeriksaanginekologi_id.''); 
                                }
                                foreach($_POST['PSRiwayatkehamilanT'] as $i=>$item)
                                {
                                    if(is_integer($i)) {
                                        $modRiwayatKehamilan=new PSRiwayatkehamilanT;
                                        if(isset($_POST['PSRiwayatkehamilanT'][$i])){
                                            $modRiwayatKehamilan->attributes=$_POST['PSRiwayatkehamilanT'][$i];                                           
                                            $modRiwayatKehamilan->pemeriksaanginekologi_id = $modGinekologi->pemeriksaanginekologi_id;                                            

                                            if($modRiwayatKehamilan->save()) {                                                                                                
                                                //var_dump($modRiwayatKehamilan);die;
                                               $successRiwayatKehamilan = true;
                                            } else {

                                               $successRiwayatKehamilan = false; 
                                            }

                                        }
                                    }
                                }
                            }

                            
                            if (isset($_POST['PSRiwayatkbT']['kb_status'])){                                                                                                                       
                                if ($_POST['PSRiwayatkbT']['kb_status'] == 1) //true
                                {                                    
                                    $cekRiwayatKBYa = PSRiwayatkbT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' AND kb_status = TRUE ");
                                    //if ( count($_POST['PSRiwayatkehamilanT']) != count($cekRiwayatkehamilan) ){
                                    if (!empty($cekRiwayatKBYa)){
                                        $hapusRiwayatKBYa = PSRiwayatkbT::model()->deleteAll('pemeriksaanginekologi_id='.$modGinekologi->pemeriksaanginekologi_id.' AND kb_status = TRUE '); 
                                    }
                                
                                    foreach($_POST['PSRiwayatkbT'] as $i=>$item)
                                    {                                        
                                        if(is_integer($i)) {
                                            $modRiwayatKB=new PSRiwayatkbT;
                                            if(isset($_POST['PSRiwayatkbT'][$i])){
                                                $modRiwayatKB->attributes=$_POST['PSRiwayatkbT'][$i];                                           
                                                $modRiwayatKB->pemeriksaanginekologi_id = $modGinekologi->pemeriksaanginekologi_id;
                                                $modRiwayatKB->kb_pasang = MyFormatter::formatDateTimeForDb($modRiwayatKB->kb_pasang);
                                                $modRiwayatKB->kb_lepas = MyFormatter::formatDateTimeForDb($modRiwayatKB->kb_lepas);
                                                $modRiwayatKB->kb_status = $_POST['PSRiwayatkbT']['kb_status'];
                                                if($modRiwayatKB->save()) {                                                                                                
                                                    //var_dump($modRiwayatKehamilan);die;
                                                   $successRiwayatKB = true;
                                                } else {

                                                   $successRiwayatKB = false; 
                                                }

                                            }
                                        }
                                    }
                                }else{
                                    $cekRiwayatKBNo = PSRiwayatkbT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' AND kb_status = FALSE ");
                                    
                                    
                                    if (count($cekRiwayatKBNo)>0){
                                        $modRiwayatKB = PSRiwayatkbT::model()->find("pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' AND kb_status = FALSE ");
                                        $modRiwayatKB->attributes=$_POST['PSRiwayatkbT'];
                                    }else{
                                        $modRiwayatKB=new PSRiwayatkbT;
                                        $modRiwayatKB->attributes=$_POST['PSRiwayatkbT'];                                                                                
                                        $modRiwayatKB->pemeriksaanginekologi_id = $modGinekologi->pemeriksaanginekologi_id;
                                    }
                                    
                                    if($modRiwayatKB->save()) {                                                                                                
                                        //var_dump($modRiwayatKehamilan);die;
                                       $successRiwayatKB = true;
                                    } else {

                                       $successRiwayatKB = false; 
                                    }
                                }
                            }


                                    if ( (empty($_POST['PSPersalinanT']['paritaske'])) OR  (empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan'])) ){
                                        if ($successRiwayatKehamilan){                                                                
                                            $trans->commit();
                                            Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                                            $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));
                                        }else{
                                            $trans->rollback();
                                            Yii::app()->user->setFlash('error',"Data Riwayat Persalinan gagal disimpan ");
                                        }
                                    }

                          /*  }else{
                                $trans->commit();
                                Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                                $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));
                            }*/

                        }else{


                            if ( (empty($_POST['PSPersalinanT']['paritaske'])) OR  (empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan'])) ){

                                $trans->commit();
                                Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                                $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));
                            }

                        }


                }else{
                    
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data Pemeriksaan Ginekologi gagal disimpan ");
                }
            }
        }

        if (isset($_POST['PSPersalinanT'])) {
            $trans = Yii::app()->db->beginTransaction();
            if ( (!empty($_POST['PSPersalinanT']['paritaske'])) AND  (!empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan']) ) ){
                 
               // $trans = Yii::app()->db->beginTransaction();
                $model->attributes = $_POST['PSPersalinanT'];
                $model->pasien_id = $modPasien->pasien_id;
                //var_dump($model->bidan_id);die;
                if (empty($model->bidan_id)){
                    $model->bidan_id = null;
                }
                $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->tglselesaipersalinan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglselesaipersalinan']); 
                $model->tglmulaipersalinan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglmulaipersalinan']);
                if(!empty($_POST['PSPersalinanT']['bidan2_id'])){
                                    $model->bidan2_id=$_POST['PSPersalinanT']['bidan2_id'];
                            }
                if(!empty($_POST['PSPersalinanT']['bidan3_id'])){
                                    $model->bidan3_id=$_POST['PSPersalinanT']['bidan3_id'];
                            }
                if(isset($_POST['PSPersalinanT']['tglabortus'])){
                    $model->tglabortus = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglabortus']); 
                }else{
                    unset($model->tglabortus);
                }
                $model->tglmelahirkan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglmelahirkan']);
                
                if ($model->validate()) {
                    
                    if ($model->save()){
                        
                        $cekPemeriksaanKala4 = false;
                        $cekPemeriksaanPartograf = false;
                       // var_dump(empty($_POST['PSPemeriksaanobstetrikT'][1]['pemeriksaanobstetrik_id']));die;
                        foreach($_POST['PSPemeriksaanobstetrikT'] as $i=>$item)
                        {                                                                    
                            if(is_integer($i)) {
                                if (empty($_POST['PSPemeriksaanobstetrikT'][$i]['pemeriksaanobstetrik_id'])){
                                            $modObsterikus=new PSPemeriksaanobstetrikT;
                                    //if ($modObsterikus->isNewRecord) {
                                        //if(isset($_POST['PSPemeriksaanobstetrikT'][$i])){                                            
                                            $modObsterikus->attributes=$_POST['PSPemeriksaanobstetrikT'][$i];                                           
                                            $modObsterikus->persalinan_id = $model->persalinan_id;
                                            $modObsterikus->create_loginpemakai_id = Yii::app()->user->id;
                                            $modObsterikus->create_time = date('Y-m-d H:i:s');
                                            $modObsterikus->create_ruangan = Yii::app()->user->getState('ruangan_id');                                    
                                            $modObsterikus->obs_periksadalam = MyFormatter::formatDateTimeForDb( $modObsterikus->obs_periksadalam);
                                            $modObsterikus->plasenta_lahir = MyFormatter::formatDateTimeForDb( $modObsterikus->plasenta_lahir);                                         
                                            $modObsterikus->save();                                        
                                       // }
                                }else{//   }else{                                                     
                                        $modObsterikus = $modObsterikus::model()->findByPk($_POST['PSPemeriksaanobstetrikT'][$i]['pemeriksaanobstetrik_id']);
                                        $modObsterikus->attributes=$_POST['PSPemeriksaanobstetrikT'][$i];
                                        //var_dump($_POST['PSPemeriksaanobstetrikT'][$i]);die;
                                        $modObsterikus->update_loginpemakai_id = Yii::app()->user->id;
                                        $modObsterikus->update_time = date('Y-m-d H:i:s');
                                        $modObsterikus->obs_periksadalam = MyFormatter::formatDateTimeForDb( $modObsterikus->obs_periksadalam);
                                        $modObsterikus->plasenta_lahir = MyFormatter::formatDateTimeForDb( $modObsterikus->plasenta_lahir);                                    
                                        $modObsterikus->save();                                    
                                   // }
                                }
                                
                            }
                                    
                           
                            foreach($_POST['PSPemeriksaankala4T'][$i] as $j=>$items)
                            {  
                                if(is_integer($j)) {
                                    if (empty($_POST['PSPemeriksaankala4T'][$i][$j]['pemeriksaankala4_id'])){                                        
                                        $modPeriksaKala4 = new PSPemeriksaankala4T;
                                        $modPeriksaKala4->attributes= $_POST['PSPemeriksaankala4T'][$i][$j];                                    
                                        //var_dump($_POST['PSPemeriksaankala4T'][$i][$j]);die;
                                        $modPeriksaKala4->pemeriksaanobstetrik_id = $modObsterikus->pemeriksaanobstetrik_id;
                                        $modPeriksaKala4->kala4_tanggal = MyFormatter::formatDateTimeForDb($modPeriksaKala4->kala4_tanggal);
                                        $modPeriksaKala4->kala4_waktu = date('H:i:s', strtotime($modPeriksaKala4->kala4_tanggal));
                                        $modPeriksaKala4->create_loginpemakai_id = Yii::app()->user->id;
                                        $modPeriksaKala4->create_time = date('Y-m-d H:i:s');
                                        $modPeriksaKala4->create_ruangan = Yii::app()->user->getState('ruangan_id');                                            
                                        $modPeriksaKala4->save();
                                        $cekPemeriksaanKala4 = true;
                                    }else{
                                        $modPeriksaKala4 = PSPemeriksaankala4T::model()->findByPk($_POST['PSPemeriksaankala4T'][$i][$j]['pemeriksaankala4_id']);
                                        $modPeriksaKala4->attributes=$_POST['PSPemeriksaankala4T'][$i][$j];                                        
                                        $modPeriksaKala4->update_loginpemakai_id = Yii::app()->user->id;
                                        $modPeriksaKala4->update_time = date('Y-m-d H:i:s');
                                        $modPeriksaKala4->kala4_tanggal = MyFormatter::formatDateTimeForDb($modPeriksaKala4->kala4_tanggal);
                                        $modPeriksaKala4->kala4_waktu = date('H:i:s', strtotime($modPeriksaKala4->kala4_tanggal));
                                        $modPeriksaKala4->save();
                                        $cekPemeriksaanKala4 = true;                                        
                                    }  
                                }
                                
                                
                                    //if(is_integer($i)) {
                                        
                                    //}                        $modObsterikus->attributes=$_POST['PSPemeriksaanobstetrikT'][$i];  
                            }
                        }
                        
                        if ($model->carapersalinan == Params::CARAPERSALINAN_NORMAL ){
                            foreach($_POST['PSPemeriksaanpartografT'] as $i=>$item)
                            {
                                if(is_integer($i)) {
                                    if (empty($_POST['PSPemeriksaanpartografT'][$i]['pemeriksaanpartograf_id'])){
                                                $modPartograf=new PSPemeriksaanpartografT;
                                        //if ($modObsterikus->isNewRecord) {
                                            //if(isset($_POST['PSPemeriksaanobstetrikT'][$i])){                                            
                                                $modPartograf->attributes=$_POST['PSPemeriksaanpartografT'][$i];                                           
                                                $modPartograf->persalinan_id = $model->persalinan_id;
                                                $modPartograf->create_loginpemakai_id = Yii::app()->user->id;
                                                $modPartograf->create_time = date('Y-m-d H:i:s');
                                                $modPartograf->create_ruangan = Yii::app()->user->getState('ruangan_id');                                    
                                                $modPartograf->pto_tglperiksa = MyFormatter::formatDateTimeForDb( $modPartograf->pto_tglperiksa);
                                                $modPartograf->pto_ketubanpecah = MyFormatter::formatDateTimeForDb( $modPartograf->pto_ketubanpecah);
                                                $modPartograf->pto_mules = MyFormatter::formatDateTimeForDb( $modPartograf->pto_mules);
                                               // var_dump($modPartograf->attributes);die;
                                                $modPartograf->save();                                                    
                                           // }
                                    }else{//   }else{             
                                            //var_dump($_POST['PSPemeriksaanobstetrikT'] );die;
                                            $modPartograf = $modPartograf::model()->findByPk($_POST['PSPemeriksaanpartografT'][$i]['pemeriksaanpartograf_id']);
                                            $modPartograf->attributes=$_POST['PSPemeriksaanpartografT'][$i];
                                            //var_dump($_POST['PSPemeriksaanobstetrikT'][$i]);die;
                                            $modPartograf->update_loginpemakai_id = Yii::app()->user->id;
                                            $modPartograf->update_time = date('Y-m-d H:i:s');
                                            $modPartograf->pto_tglperiksa = MyFormatter::formatDateTimeForDb( $modPartograf->pto_tglperiksa);
                                            $modPartograf->pto_ketubanpecah = MyFormatter::formatDateTimeForDb( $modPartograf->pto_ketubanpecah);
                                            $modPartograf->pto_mules = MyFormatter::formatDateTimeForDb( $modPartograf->pto_mules);
                                            $modPartograf->save();                                                    
                                       // }
                                    }

                                }
                            }
                        }
                        //var_dump($modPeriksaKala4->kala4_tanggal);die;
                       /* foreach ($_POST['PemeriksaanfisikT'] as $key=>$val) {
                            $modPemeriksaan[$key] = $val;
                        }
                        
                        if ($modPemeriksaan->isNewRecord) {
                            $modPemeriksaan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $modPemeriksaan->pegawai_id = $modPendaftaran->pegawai_id;
                            $modPemeriksaan->pasien_id = $modPendaftaran->pasien_id;
                            $modPemeriksaan->tglperiksafisik = date('Y-m-d H:i:s');
                            $modPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
                            $modPemeriksaan->create_time = date('Y-m-d H:i:s');
                            $modPemeriksaan->plasenta_lahir = (empty($modPemeriksaan->plasenta_lahir)?null:$format->formatDateTimeForDb($modPemeriksaan->plasenta_lahir));
                            $modPemeriksaan->obs_periksadalam = (empty($modPemeriksaan->obs_periksadalam)?null:$format->formatDateTimeForDb($modPemeriksaan->obs_periksadalam));
                            $modPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        }else{
                            $modPemeriksaan->plasenta_lahir = (empty($modPemeriksaan->plasenta_lahir)?null:$format->formatDateTimeForDb($modPemeriksaan->plasenta_lahir));
                            $modPemeriksaan->obs_periksadalam = (empty($modPemeriksaan->obs_periksadalam)?null:$format->formatDateTimeForDb($modPemeriksaan->obs_periksadalam));
                        }*/


                        // var_dump($modPemeriksaan->attributes, $modPemeriksaan->validate(), $modPemeriksaan->errors); die;
                        if ($cekPemeriksaanKala4) {                            
                            //var_dump();die;
                            if ($model->carapersalinan == Params::CARAPERSALINAN_NORMAL){
                                if ($modPartograf->save()){
                                    
                                    $trans->commit();
                                    Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                                    $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));
                                }else{                                    
                                    $trans->rollback();
                                    Yii::app()->user->setFlash('error',"Data Pemeriksaan Partograf Gagal Disimpan ");
                                }
                                
                            }else{
                                $trans->commit();
                                Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                                $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));                                
                            }                            
                        }else {                                         
                            $trans->rollback();
                            Yii::app()->user->setFlash('error',"Data Pemeriksaan Kala 4 Gagal Disimpan");
                        }
                    }
                } else {                    
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                }
            }else {
                
                    $trans->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                }
        }
                         
        $this->render('index', array('format'=>$format,'model' => $model, 
            'modPendaftaran'=>$modPendaftaran, 
            'modPasien'=>$modPasien, 
            'modPersalinan'=>$modPersalinan, 
            'modPemeriksaan'=>$modPemeriksaan,
            'modGinekologi'=>$modGinekologi,
            'modRiwayatKehamilan'=>$modRiwayatKehamilan,
            'modRiwayatKB' => $modRiwayatKB,
            'modObsterikus' => $modObsterikus,
            'modPeriksaKala4' => $modPeriksaKala4,
            'modPartograf' => $modPartograf,
            'modPartografObat' => $modPartografObat,
                ));
    }
    
    public function actionRiwayatKehamilanKeluhan() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(gin_keluhan)', strtolower($_GET['tag']),true);
            $criteria->order = "gin_keluhan ASC";
            $keluhans = PSPemeriksaanginekologiT::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key'=>$keluhan->gin_keluhan,
                                  'value'=>$keluhan->gin_keluhan);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
    
}