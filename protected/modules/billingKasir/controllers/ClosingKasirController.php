<?php

class ClosingKasirController extends MyAuthController
{
    
    public function actionIndex()
    {
        $format = new MyFormatter();
        $informasi = array();
        
        $model = new BKClosingkasirT();
        $model->tglclosingkasir = date('Y-m-d H:i:s');
        $model->closingsaldoawal = 0;
        
        $mSetorBank = new BKSetorbankT();
        $mBuktBayar = new BKTandabuktibayarT();
        $mBuktBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $mBuktBayar->tgl_awal = date('d M Y 00:00:00');
        $mBuktBayar->tgl_akhir = date('d M Y 23:59:59');
        $mBuktBayar->shift_id = Yii::app()->user->getState('shift_id');
        $mBuktBayar->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
        
        if(isset($_POST['BKTandabuktibayarT']))
        {
            $mBuktBayar->attributes = $_POST['BKTandabuktibayarT'];
            $mBuktBayar->tgl_awal = $format->formatDateTimeForDb($_POST['BKTandabuktibayarT']['tgl_awal']);
            $mBuktBayar->tgl_akhir = $format->formatDateTimeForDb($_POST['BKTandabuktibayarT']['tgl_akhir']);
            $mBuktBayar->create_loginpemakai_id = $_POST['BKTandabuktibayarT']['create_loginpemakai_id'];
            
            $model->closingdari = $mBuktBayar->tgl_awal;
            $model->sampaidengan = $mBuktBayar->tgl_akhir;
            
            $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->shift_id = $mBuktBayar->shift_id;
            
            $mSetorBank->ygmenyetor_id = $mBuktBayar->create_loginpemakai_id;
            $mSetorBank->create_loginpemakai_id = Yii::app()->user->id;
            
        }
        $criteria = new CDbCriteria;
        $criteria->join .= "left join loginpemakai_k m on m.loginpemakai_id = t.create_loginpemakai_id";
		if(!empty($mBuktBayar->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$mBuktBayar->ruangan_id);					
		}
		if(!empty($mBuktBayar->create_loginpemakai_id)){
			$criteria->addCondition("m.pegawai_id = ".$mBuktBayar->create_loginpemakai_id);					
		}
        $criteria->addCondition('t.closingkasir_id IS NULL');
        $criteria->addBetweenCondition('DATE(t.tglpenerimaan)', $mBuktBayar->tgl_awal, $mBuktBayar->tgl_akhir);
        $rPenerimaanUmum = PenerimaanumumT::model()->findAll($criteria);
        $total_penerimaan_umum = 0;
        foreach($rPenerimaanUmum as $val)
        {
            $total_penerimaan_umum += $val['totalharga'];
        }
        $informasi['total_penerimaan_umum'] = $total_penerimaan_umum;
        // MyFormatter::formatNumberForUser($total_penerimaan_umum);
        $criteria_dua = new CDbCriteria;
        $criteria_dua->join .= "left join loginpemakai_k m on m.loginpemakai_id = t.create_loginpemakai_id";
		if(!empty($mBuktBayar->ruangan_id)){
			$criteria->addCondition("t.create_ruangan = ".$mBuktBayar->ruangan_id);					
		}
		if(!empty($mBuktBayar->create_loginpemakai_id)){
			$criteria->addCondition("m.pegawai_id = ".$mBuktBayar->create_loginpemakai_id);					
		}
        $criteria_dua->addCondition('t.closingkasir_id IS NULL');
        $criteria_dua->addCondition('t.batalkeluarumum_id IS NULL');
        $criteria_dua->addBetweenCondition('DATE(t.tglpengeluaran)', $mBuktBayar->tgl_awal, $mBuktBayar->tgl_akhir);
        $rPengeluaranUmum = PengeluaranumumT::model()->findAll($criteria_dua);
        $total_pengeluaran_umum = 0;
        
        foreach($rPengeluaranUmum as $val)
        {
            $total_pengeluaran_umum += $val['totalharga'];
        }
        $informasi['total_pengeluaran_umum'] = $total_pengeluaran_umum;
        //MyFormatter::formatNumberForUser($total_pengeluaran_umum);
        $attributes = array('lookup_type'=>'nilaiuang', 'lookup_aktif'=>true);
        $rPecahanUang = LookupM::model()->findAllByAttributes($attributes, array('order'=>'lookup_urutan'));
        
        
        if(isset($_POST['BKClosingkasirT']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            $model->attributes = $_POST['BKClosingkasirT'];
            $model->closingdari = empty($model->closingdari) ? NULL : $format->formatDateTimeForDb($model->closingdari);
            $model->sampaidengan = empty($model->sampaidengan) ? NULL : $format->formatDateTimeForDb($model->sampaidengan);
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->update_time = date('Y-m-d H:i:s');
            $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $model->shift_id = Yii::app()->user->getState('shift_id');
            
            try{
                if($model->validate())
                {
                    if($model->save())
                    {
                        $x = 0;
                        foreach($_POST['jum_recehan'] as $key=>$val)
                        {
                            $rincianCloding = new RincianclosingT;
                            $rincianCloding->closingkasir_id = $model->closingkasir_id;
                            $rincianCloding->nourutrincian = $x+1;
                            $rincianCloding->nilaiuang = $key;
                            $rincianCloding->banyakuang = (int) $val;
                            $rincianCloding->jumlahuang = $key*$val;
                            $rincianCloding->save();
                            $x++;
                        }
                        
                        $penerimaan = true;
                        if(isset($_POST['isPenerimaanUmum']))
                        {
                            $penerimaan = $this->savePenerimaan($model, $rPenerimaanUmum);
                        }

                        $pengeluaran = true;
                        if(isset($_POST['isPengeluaranUmum']))
                        {
                            $pengeluaran = $this->savePengeluaran($model, $rPengeluaranUmum);
                        }
                        
                        if(isset($_POST['setorBank']))
                        {
                            $mSetorBank->attributes = $_POST['BKSetorbankT'];
                            $mSetorBank->create_time = date('Y-m-d h:m:s');
                            $mSetorBank->tgldisetor = $format->formatDateTimeForDb($_POST['BKSetorbankT']['tgldisetor']);
                            if($mSetorBank->validate())
                            {
                                if($mSetorBank->save())
                                {
                                    $buktiBayar =  $this->saveTandaBuktiBayar($model, $_POST['BKClosingkasirT']['nobuktibayar']);
                                    
                                    if($penerimaan && $pengeluaran && $buktiBayar)
                                    {
                                        $transaction->commit();
                                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                                    }else{
                                        Yii::app()->user->setFlash('error',"Data gagal disimpan");
                                    }
                                }else{
                                    Yii::app()->user->setFlash('error',"Data gagal setor bank disimpan");
                                }
                            }
                        }else{
                            $buktiBayar =  $this->saveTandaBuktiBayar($model, $_POST['BKClosingkasirT']['nobuktibayar']);
                            
                            if($penerimaan && $pengeluaran && $buktiBayar)
                            {
                                $transaction->commit();
                                Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                                
                            }else{
                                Yii::app()->user->setFlash('error',"Data gagal disimpan");
                            }                            
                        }
                    }
                }else{
                    Yii::app()->user->setFlash('error',"Data tutup kasir gagal disimpan");
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error',"Data tidak bisa disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
            
        }
        //Mengembalikan format tanggal
        $mBuktBayar->tgl_awal = date('d M Y H:i:s', strtotime($mBuktBayar->tgl_awal));
        $mBuktBayar->tgl_akhir = date('d M Y H:i:s', strtotime($mBuktBayar->tgl_akhir));
        
        $this->render('index',
            array(
                'model'=>$model,
                'mBuktBayar'=>$mBuktBayar,
                'rPenerimaanUmum'=>$rPenerimaanUmum,
                'rPengeluaranUmum'=>$rPengeluaranUmum,
                'rPecahanUang'=>$rPecahanUang,
                'informasi'=>$informasi,
                'mSetorBank'=>$mSetorBank,
                'format'=>$format
            )
        );
    }
    
    protected function savePenerimaan($params, $penerimaan)
    {
        $record = false;
        foreach($penerimaan as $val)
        {
            $record = PenerimaanumumT::model()->updateByPk($val['penerimaanumum_id'], array('closingkasir_id'=>$params['closingkasir_id']));
            TandabuktibayarT::model()->updateByPk($val['tandabuktibayar_id'], array('closingkasir_id'=>$params['closingkasir_id']));
        }
        return $record;
    }
    
    protected function savePengeluaran($params, $pengeluaran)
    {
        $record = false;
        foreach($pengeluaran as $val)
        {
            $record = PengeluaranumumT::model()->updateByPk($val['pengeluaranumum_id'], array('closingkasir_id'=>$params['closingkasir_id']));
            TandabuktibayarT::model()->updateByPk($val['tandabuktibayar_id'], array('closingkasir_id'=>$params['closingkasir_id']));
        }
        return $record;
    }

    protected function saveTandaBuktiBayar($params, $tanda)
    {
        $record = false;
        $tanda = array_filter($tanda, 'strlen');
        foreach($tanda as $val)
        {
            $attributes = array(
                'nobuktibayar' => trim($val)
            );
            $result = TandabuktibayarT::model()->findByAttributes($attributes);
            $record = TandabuktibayarT::model()->updateByPk($result['tandabuktibayar_id'], array('closingkasir_id'=>$params['closingkasir_id']));
        }
        return $record;
    }
    
    public function actionInformasi(){
        
        $model = new BKInformasiclosingkasirV('searchInformasi');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        if(isset($_GET['BKInformasiclosingkasirV'])){
            $model->attributes = $_GET['BKInformasiclosingkasirV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasiclosingkasirV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasiclosingkasirV']['tgl_akhir']);
        }
        // $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');
        // $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
        
        // print_r($model->tgl_awal); exit;
        
        $this->render('informasi',array('model'=>$model));
    }
    public function actionRincianSetoran($idSetor){
        $this->layout = '//layouts/iframe';
        $modSetor = BKSetorbankT::model()->findByPk($idSetor);
        if(!$modSetor){
            Yii::app()->user->setFlash('warning', 'Tidak ada transaksi setor ke Bank !');
            $modSetor = new BKSetorbankT;
        }
        $this->render('rincianSetoran',array(
            'modSetor'=>$modSetor,
        ));
        
    }
    public function actionRincian($idClosing){
        $this->layout = '//layouts/iframe';
        /*
        $criteria=new CDbCriteria;
        $criteria->addCondition('closingkasir_id = '.$idClosing);
        $criteria->select = "closingkasir_id, nilaiuang, banyakuang, jumlahuang";
        $criteria->group = "closingkasir_id, nilaiuang, banyakuang, jumlahuang";
        $models = BKInformasiclosingkasirV::model()->findAll($criteria);
        $this->render('rincian',array(
            'models'=>$models,
        ));
         * 
         */
        
        $closing = ClosingkasirT::model()->findByPk($idClosing);
        $bkm = TandabuktibayarT::model()->findAllByAttributes(array('closingkasir_id'=>$idClosing), array('order'=>'tglbuktibayar asc'));
        $rincian = RincianclosingT::model()->findAllByAttributes(array('closingkasir_id' => $idClosing), array('order'=>'nourutrincian'));
        $this->render('rincian',array(
            'closing'=>$closing,
            'bkm'=>$bkm,
            'rincian'=>$rincian,
        ));
        
    }
    public function actionBatalclosing($idClosing){
        $this->layout = '//layouts/iframe';
        $model = BKClosingkasirT::model()->findByPk($idClosing);
        $modRincian = BKRincianclosingT::model()->findAllByAttributes(array('closingkasir_id'=>$model->closingkasir_id));
        $status;
        $transaction = Yii::app()->db->beginTransaction();
        try{
            if(empty($model->setorkebank_id)){
                $modTandabukti = BKTandabuktibayarT::model()->findAllByAttributes(array('closingkasir_id'=>$idClosing));
                if(count($modTandabukti) > 0){
                    foreach($modTandabukti AS $buktibayar){
                        $buktibayar->closingkasir_id = "";
                        $buktibayar->save();
                    }
                }
                foreach($modRincian AS $rincian){
                    $rincian->delete();
                }
                $model->delete();
                $transaction->commit();
                Yii::app()->user->setFlash('success', 'Closing Kasir berhasil dibatalkan !');
                $status = 1;
            }else{
                Yii::app()->user->setFlash('error', 'Closing Kasir gagal dibatalkan karena sudah melakukan setoran ke bank !');
                $status = 0;
                $this->redirect(array('RincianSetoran', 'idSetor'=>$model->setorbank_id));
            }
        }catch (Exception $exc) {
            Yii::app()->user->setFlash('error',"Closing Kasir gagal dibatalkan ".MyExceptionMessage::getMessage($exc,true));
            $transaction->rollback();
        }
        $this->render('batalclosing',array(
            'model'=>$model,
            'modRincian'=>$modRincian,
            'status'=>$status,
        ));
        
    }
    
    function actionSetTglShift()
    {
        $res = array(
            'awal'=>'',
            'akhir'=>'',
        );
        if (isset($_POST['id'])) {
            $shift = ShiftM::model()->findByPk($_POST['id']);
            
            
            $base = strtotime("00:00:00");
            $awal = strtotime($shift->shift_jamawal);
            $akhir = strtotime($shift->shift_jamakhir);
            
            $now = time();
            
            if ($awal > $akhir) {
                $now += (24 * 3600);
            }
            $res['awal'] = MyFormatter::formatDateTimeForUser(date('Y-m-d '.$shift->shift_jamawal));
            $res['akhir'] = MyFormatter::formatDateTimeForUser(date('Y-m-d '.$shift->shift_jamakhir, $now));
            
        }
        echo CJSON::encode($res);
        Yii::app()->end();
    }
}

