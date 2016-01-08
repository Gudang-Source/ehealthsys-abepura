<?php

class KelahiranbayiTController extends MyAuthController
{
	public function actionIndex($id,$bayi=null)
        {
            $model=new PSKelahiranbayiT;
            $modPendaftaran=PSPendaftaranT::model()->findByPk($id);
            $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPersalinan = PSPersalinanT::model()->findByAttributes(array('pendaftaran_id'=>$id, 'pasien_id'=>$modPasien->pasien_id), array('order'=>'persalinan_id Desc')); 
			if (!isset($modPersalinan)){
				Yii::app()->user->setFlash('error',"Data Persalinan Pasien tidak ditemukan. Silahkan lakukan transaksi persalinan terlebih dahulu!");
				$redirect = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->createUrl($this->module->id.'/daftarPasien/index');
				echo "<script type='text/javascript'>setTimeout(function(){window.location.href = '".$redirect."';},5000);</script>";
            }
            if(isset($modPersalinan->persalinan_id)){
                $modKelahiran = PSKelahiranbayiT::model()->with('persalinan')->findAllByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id));
                $dataKelahiran = PSKelahiranbayiT::model()->findAllByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id));
                $modKelahiranTerdahulu = PSKelahiranbayiT::model()->with('persalinan')->findByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id));                
            }else{
                $modKelahiran = array();
                $dataKelahiran = array();
                $modKelahiranTerdahulu = array();
            }
            if (count($dataKelahiran) > 0){
                if (($model->islahirtunggal == 0)||($model->islahirtunggal == '')){
                    //$dataKelahiran = PSKelahiranbayiT::model()->findAllByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id));
                    $jumlahKelahiranBayi = count($dataKelahiran);
                    $jumlahKembar = $modKelahiranTerdahulu->jmlkembar;
                    
                    if ($jumlahKelahiranBayi < $jumlahKembar){                    
                        $model=new PSKelahiranbayiT;
                        $model->tgllahirbayi = date('d M Y');
                        $model->jamlahir = date('H:i:s');
                        $model->islahirtunggal = $modKelahiranTerdahulu->islahirtunggal;
                        $model->jmlkembar = $modKelahiranTerdahulu->jmlkembar;
                        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        
                    }
                    else{
                        if (isset($bayi)){
                            $model = PSKelahiranbayiT::model()->findByAttributes(array('kelahiranbayi_id'=>$bayi));    
                        }else{
                            $model = PSKelahiranbayiT::model()->findByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id), array('limit'=>1));
                        }
                    }
                }else{
                    if (isset($bayi)){
                            $model = PSKelahiranbayiT::model()->findByAttributes(array('kelahiranbayi_id'=>$bayi));    
                        }else{
                            $model = PSKelahiranbayiT::model()->findByAttributes(array('persalinan_id'=>$modPersalinan->persalinan_id), array('limit'=>1));
                        }
                }
            }
            else{
                $model=new PSKelahiranbayiT;
                $model->tgllahirbayi = date('d M Y');
                $model->jamlahir = date('H:i:s');
                $jumlahKembar = 0;
            }
	    $model->namabayi = 'Bayi Ny. '.$modPasien->nama_pasien;
            $appgards = PSMetodeapgarM::model()->findAll(array('order'=>'metodeapgar_id'),"metodeapgar_aktif = TRUE");
            if(isset($_POST['PSKelahiranbayiT']))
            {
                $model->attributes=$_POST['PSKelahiranbayiT'];
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->persalinan_id = $modPersalinan->persalinan_id;
                
                $model->nourutbayi = MyGenerator::noUrutBayi($modPasien->pasien_id);

                if (empty($model->namabayi)){
                    $model->namabayi = 'Bayi Ny. '.$modPasien->nama_pasien;
                }
                $model->create_time = date('d M Y H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $jumlahappgard = count($_POST['appgard']);
                
                if ($jumlahappgard == count($appgards)){
                    $model->metodeApgar = 5;
                    
                }
                if($model->validate())
                {   
                    if (count($dataKelahiran) > 0){
                        $model->islahirtunggal = $modKelahiranTerdahulu->islahirtunggal;
                        $model->tgllahirbayi = $model->tgllahirbayi;
                    }else{
                        $model->tgllahirbayi = $model->tgllahirbayi.' '.$model->jamlahir;
                    }
                    $interpretasi = 0;
                    $as = $_POST['appgard'];
                    foreach($as as $key => $data){ 
                            $isi = substr($data, 0,1);

                            $interpretasi = $isi + $interpretasi; 
                            $model->warnakulit = substr($as[1],1);
                            $model->denyutjantung = substr($as[2],1);
                            $model->responrefleks = substr($as[3],1);
                            $model->pernapasan = substr($as[5],1);
                            $model->aktivitasotot = substr($as[4],1);
                    }

                    $interpretasiMod = PSInterpretasiskorM::model()->findAllByAttributes(array(),array('order'=>'interpretasimax'));
                    foreach ($interpretasiMod as $baris){
                        if ($interpretasi >= $baris->interpretasimin){
                            if ($interpretasi <= $baris->interpretasimax){                                   
                                $interpretasiSkor = $baris->interpretasiskor_id;
                            }
                        }
                    }
                    $modInterpretasi = PSInterpretasiskorM::model()->findByPk($interpretasiSkor);
                    $model->interpretasi = $modInterpretasi->intepretasi_nama;
                    $success = true;
                    $jumlahKelahiranBayi = 0;
                    $transaction = Yii::app()->db->beginTransaction();
                    try{
                        if ($model->save()){
                            
                            $menitKeApgar = PSApgarscoreT::model()->findByAttributes(array('menitke'=>$model->menitke, 'kelahiranbayi_id'=>$model->kelahiranbayi_id));
                            if (count($menitKeApgar) > 0){
                                $message = "Menit Ke-$model->menitke telah terisi";
                                $success = false;
                            }
                            foreach($as as $key => $data){

                                $isi = $isi = substr($data, 0,1);
                                $modScoreApgar = new PSApgarscoreT;
                                $modScoreApgar->kelahiranbayi_id = $model->kelahiranbayi_id;
                                $modScoreApgar->metodeapgar_id = $key;
                                $modScoreApgar->interpretasiskor_id = $interpretasiSkor;
                                $modScoreApgar->tglapgarscore = date('d M Y H:i:s');
                                $modScoreApgar->nilai_apgar = $isi;
                                $modScoreApgar->menitke = $model->menitke;
                                $modScoreApgar->jmlscore = $interpretasi;
                                $modScoreApgar->create_time = date('d M Y');
                                $modScoreApgar->create_loginpemakai_id = Yii::app()->user->id;
                                $modScoreApgar->create_ruangan = Yii::app()->user->getState('ruangan_id');

                                if ($modScoreApgar->save()){

                                } else{
                                    $success = false;
                                }
                            }
                        }
                        if ($success == false){
                            $transaction->rollback();
                            
                                Yii::app()->user->setFlash('error',"Data gagal disimpan ".$message);
                           
                        } else {
                            $transaction->commit();
                            
                            Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                            if ($jumlahKelahiranBayi+1 < $jumlahKembar){            
                                $this->redirect(Yii::app()->createUrl($this->module->id.'/kelahiranbayiT/index&id='.$id));
                            } else {
                                $this->redirect(Yii::app()->createUrl($this->module->id.'/daftarPasien/index'));
                            }
                        }

                    }
                    catch (Exception $exc) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    }
                }
                else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                }
                
                
            }
            
            $this->render('index',array('model'=>$model, 'modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'modPersalinan'=>$modPersalinan, 'appgards'=>$appgards, 'modKelahiran'=>$modKelahiran));
        }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
        
    public function actionDataApgar()
    {
        
        if (Yii::app()->request->isAjaxRequest)
            $kelahiran = (isset($_POST['kelahiranbayi_id']) ? $_POST['kelahiranbayi_id'] : null);
            $menitke = PSApgarscoreT::model()->findAll(array(
                'select'=>'t.menitke',
                'condition'=>'kelahiranbayi_id = '.$kelahiran,
                'order'=>'menitke',
                'distinct'=>true,
            ));
            $modApgarScore = PSApgarscoreT::model()->findAllByAttributes(array('kelahiranbayi_id'=>$kelahiran));
                echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_dataApgar', array('menitke'=>$menitke, 'modApgarScore'=>$modApgarScore, 'noid'=>$kelahiran), true)));
            exit; 
        }
	
	public function actionGetMenitKe()
    {
        if(Yii::app()->request->isAjaxRequest){
            $menitke = $_POST['menitke'];
            $kelahiranbayi_id = $_POST['kelahiranbayi_id'];

            $hasil = ApgarscoreT::model()->findAllByAttributes(array('menitke'=>$menitke, 'kelahiranbayi_id'=>$kelahiranbayi_id));
            if (count($hasil) > 0){
                $hasil = true;
            } else {
                $hasil = false;
            }

            echo CJSON::encode($hasil);
            exit;
        }
    }

}