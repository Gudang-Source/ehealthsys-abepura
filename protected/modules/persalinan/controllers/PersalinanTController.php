<?php

class PersalinanTController extends MyAuthController {

    public function actionIndex($id) {

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
                $modRiwayatKelahiran = null;

                $modGinekologi->tglperiksaobgyn = date("d M Y H:i:s");
            }else{
                $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForUser($modGinekologi->tglperiksaobgyn);
                $modRiwayatKelahiran = PSRiwayatkelahiranT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");            
            }
                       
        }else{           
            $modRiwayatKelahiran = PSRiwayatkelahiranT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");                        
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

                //$successRiwayatKelahiran = false;
                if ($modGinekologi->save()){

                    $cekRiwayatkelahiran = PSRiwayatkelahiranT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");

                    if (!empty($cekRiwayatkelahiran)){
                        $hapusRiwayatKelahiran = PSRiwayatkelahiranT::model()->deleteAll('pemeriksaanginekologi_id='.$modGinekologi->pemeriksaanginekologi_id.''); 
                    }
                    //Riwayat Kelahiran
                    if (isset($_POST['PSRiwayatkelahiranT'])){
                            $cekRiwayatkelahiran = PSRiwayatkelahiranT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");

                            //if ( count($_POST['PSRiwayatkelahiranT']) != count($cekRiwayatkelahiran) ){
                            if (!empty($cekRiwayatkelahiran)){
                                $hapusRiwayatKelahiran = PSRiwayatkelahiranT::model()->deleteAll('pemeriksaanginekologi_id='.$modGinekologi->pemeriksaanginekologi_id.''); 
                            }
                            foreach($_POST['PSRiwayatkelahiranT'] as $i=>$item)
                            {
                                if(is_integer($i)) {
                                    $modRiwayatKelahiran=new PSRiwayatkelahiranT;
                                    if(isset($_POST['PSRiwayatkelahiranT'][$i])){
                                        $modRiwayatKelahiran->attributes=$_POST['PSRiwayatkelahiranT'][$i];                                           
                                        $modRiwayatKelahiran->pemeriksaanginekologi_id = $modGinekologi->pemeriksaanginekologi_id;                                            

                                        if($modRiwayatKelahiran->save()) {                                                                                                
                                           $successRiwayatKelahiran = true;
                                        } else {
                                           $successRiwayatKelahiran = false; 
                                        }

                                    }
                                }
                            }


                                if ( (empty($_POST['PSPersalinanT']['paritaske'])) OR  (empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan'])) ){
                                    if ($successRiwayatKelahiran){                                                                
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
                        
                        foreach ($_POST['PemeriksaanfisikT'] as $key=>$val) {
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
                        }


                        // var_dump($modPemeriksaan->attributes, $modPemeriksaan->validate(), $modPemeriksaan->errors); die;
                        if ($modPemeriksaan->save()) {
                            //var_dump();die;
                            $trans->commit();
                            Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                            $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));

                        }else {                            
                            $trans->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ");
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
            'modRiwayatKelahiran'=>$modRiwayatKelahiran
                ));
    }
    
}