    
<?php
Yii::import('pendaftaranPenjadwalan.controllers.BuatJanjiPoliTController');
Yii::import('pendaftaranPenjadwalan.models.*');
class BuatJanjiMCUController extends BuatJanjiPoliTController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = null)
	{
		
		$format = new MyFormatter;
		
		$modPPBuatJanjiMCU=new MCBuatJanjiMCU;
		$modPasien=new MCPasienM;
		$modPasien->isPasienLama = false;
		$modPasien->agama = Params::DEFAULT_AGAMA;
		$modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
		
		if(!empty($id)){
			$modPPBuatJanjiMCU = MCBuatJanjiMCU::model()->findByPk($id);
			if(count($modPPBuatJanjiMCU) > 0){
				$modPasien = MCPasienM::model()->findByPk($modPPBuatJanjiMCU->pasien_id);
			}else{
				$modPasien=new MCPasienM;
			}
		}
		
		
		if(isset($_POST['MCBuatJanjiMCU']))
		{
                      
			$transaction = Yii::app()->db->beginTransaction();
			  try 
			  {    
				   $modPPBuatJanjiMCU->attributes=$_POST['MCBuatJanjiMCU'];
				   $modPPBuatJanjiMCU->tglbuatjanji=date('Y-m-d H:i:s');
				   $modPPBuatJanjiMCU->tgljadwal=$format->formatDateTimeForDb($_POST['MCBuatJanjiMCU']['tgljadwal']);
				   $modPPBuatJanjiMCU->create_time=date('Y-m-d H:i:s');
				   $modPPBuatJanjiMCU->update_time=date('Y-m-d H:i:s');
				   $modPPBuatJanjiMCU->update_loginpemakai_id=Yii::app()->user->id;
				   $modPPBuatJanjiMCU->create_loginpemakai_id=Yii::app()->user->id;
				   $modPPBuatJanjiMCU->create_ruangan= Yii::app()->user->getState('ruangan_id');
				   $modPPBuatJanjiMCU->no_antrianjanji = MyGenerator::noAntrianJanjiPoli(Yii::app()->user->getState('ruangan_id'));
				   
				   if(!isset($_POST['isPasienLama'])){   //Jika Pasiennya Baru
						$modPasien = $this->savePasien($_POST['MCPasienM']);
						$modPPBuatJanjiMCU->pasien_id=$modPasien->pasien_id;
				   }else{ // Jika Pasiennya Lama
						$modPPBuatJanjiMCU->no_rekam_medik = $_POST['no_rekam_medik'];
						$modPasien = MCPasienM::model()->findByAttributes(array('no_rekam_medik'=>$_POST['no_rekam_medik']));
						$modPPBuatJanjiMCU->pasien_id = $modPasien->pasien_id;
				   }
					
					if($modPPBuatJanjiMCU->validate())
					{
						$modPPBuatJanjiMCU->save();
						//Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data Pasien Dan Janji Kunjungan berhasil disimpan.');						
						$transaction->commit();		
						$this->redirect(array('Create','id'=>$modPPBuatJanjiMCU->buatjanjipoli_id,'sukses'=>1));
						$modPPBuatJanjiMCU->isNewRecord = FALSE;
					}
					else 
					{
						$transaction->rollback();
						 Yii::app()->user->setFlash('error', 'Data Gagal disimpan ');
					}


			  }
			  catch(Exception $exc)
			  {
				  $transaction->rollback();
				  Yii::app()->user->setFlash('error', 'Data Gagal disimpan'.MyExceptionMessage::getMessage($exc,true).'');

			  }
		}
		
		$this->render('create',array(
                        'modPasien'=>$modPasien,
                        'modPPBuatJanjiMCU'=>$modPPBuatJanjiMCU

		));
	}
	
	 
}
