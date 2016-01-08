
<?php

class RencanaLemburTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
                public $defaultAction = 'buat';
        
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionBuat($norencana=null)
	{
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$modRencanaLembur = new KPRencanaLemburT();
		$sukses = false;
		$rencana=array();
		$modaftersave=array();
		$namanama = "";
		$format = new MyFormatter();
		// Uncomment the following line if AJAX validation is needed

		if(!empty($norencana)){
				$rencana=KPRencanaLemburT::model()->findAllByAttributes(array('norencana'=>$norencana));
				$modRencanaLembur->norencana=$rencana[0]->norencana;
				$modRencanaLembur->tglrencana=$rencana[0]->tglrencana;
				$modRencanaLembur->keterangan = (isset($rencana[0]->keterangan) ? $rencana[0]->keterangan:"");
				$modRencanaLembur->pemberitugas_nama = (isset($rencana[0]->pemberitugas_id) ? PegawaiM::model()->findByPk($rencana[0]->pemberitugas_id)->nama_pegawai:"");
				$modRencanaLembur->menyetujui_nama = (isset($rencana[0]->menyetujui_id) ? PegawaiM::model()->findByPk($rencana[0]->menyetujui_id)->nama_pegawai:"");
				$modRencanaLembur->mengetahui_nama = (isset($rencana[0]->mengetahui_id) ? PegawaiM::model()->findByPk($rencana[0]->mengetahui_id)->nama_pegawai:"");
		}else{
				$modRencanaLembur->tglrencana = date('d M Y H:i:s');
		}

		if(isset($_POST['KPRencanaLemburT']))
		{  
			$transaction = Yii::app()->db->beginTransaction();
			try{
				//Mendefinisikan variabel konstan
				$create_time = date('Y-m-d H:i:s');
				$create_loginpemakai_id = Yii::app()->user->id;
				//Membuat objek dari form 
				$alldata = $_POST['KPRencanaLemburT'];                                                                       
				$sukses = 0;
				$gagal = 0;

				foreach ($alldata as $attr => $value) {                            
					if(is_array($value)){
						$i = 0;
						$modRencanaLemburTab[$i] = new KPRencanaLemburT();                                   
						$modRencanaLemburTab[$i]->attributes = $alldata;
						$modRencanaLemburTab[$i]->attributes = $value;
						$modRencanaLemburTab[$i]->jamMulai = $value['jamMulai'];
						$modRencanaLemburTab[$i]->jamSelesai = $value['jamSelesai'];
						$modRencanaLemburTab[$i]->create_time=$create_time;
						$modRencanaLemburTab[$i]->create_loginpemakai_id=$create_loginpemakai_id;
						$modRencanaLemburTab[$i]->create_ruangan=Yii::app()->user->getState('ruangan_id');

						$modRencanaLemburTab[$i]->tglrencana = $format->formatDateTimeForDb($modRencanaLemburTab[$i]->tglrencana);
						$tglrencana = date('Y-m-d',strtotime($modRencanaLemburTab[$i]->tglrencana));

						if(empty($modRencanaLemburTab[$i]->jamMulai)){
							$modRencanaLemburTab[$i]->tglmulai = null;
						}else{
							$tglmulai = $tglrencana." ".$modRencanaLemburTab[$i]->jamMulai.":00";
							$modRencanaLemburTab[$i]->tglmulai = $tglmulai;
						}
						if(empty($modRencanaLemburTab[$i]->jamSelesai)){
							$modRencanaLemburTab[$i]->tglselesai = null;
						}else{
							$tglselesai = $tglrencana." ".$modRencanaLemburTab[$i]->jamSelesai.":00";
							$modRencanaLemburTab[$i]->tglselesai = $tglselesai;
						}

							if($modRencanaLemburTab[$i]->validate()){
								$modRencanaLemburTab[$i]->save();
								$sukses++;
							}else{
								$gagal++;
								$nama[$gagal] = $modRencanaLemburTab[$i]->pegawai->nama_pegawai;
							}
						$i++;
					}

				}
				if($sukses > 0){
					Yii::app()->user->setFlash('success',$sukses." data telah berhasil disimpan !");
					$transaction->commit();
					$this->redirect(array('buat','norencana'=>$modRencanaLemburTab[0]->norencana, 'sukses'=>$sukses));
				}else{
					foreach($nama as $i=>$val){
						$namanama .= "<br>".$i.". ".$nama[$i];
					}
					Yii::app()->user->setFlash('error',$namanama."<br>Gagal disimpan");
					$transaction->rollback();
				}
			}catch (Exception $exc){
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}

		}
                
		$this->render('buat',array(
			'modRencanaLembur'=>$modRencanaLembur,
			'rencana'=>$rencana,
			'sukses'=>$sukses,
		));
	}

	      

	/**
	 * Manages all models.
	 */
	public function actionInformasi()
	{
                
		$modRencanaLembur=new KPRencanaLemburT('searchInformasiRencanaLembur');
		$modRencanaLembur->unsetAttributes();  // clear any default values
		
                if(isset($_GET['KPRencanaLemburT'])){
			$modRencanaLembur->tgl_awal=$_GET['KPRencanaLemburT']['tgl_awal'];
			$modRencanaLembur->tgl_akhir=$_GET['KPRencanaLemburT']['tgl_akhir'];
                }else{
                    $modRencanaLembur->tgl_awal = date ('d M Y');
                    $modRencanaLembur->tgl_akhir = date ('d M Y');
                }
                
                
		$this->render('informasi',array(
			'modRencanaLembur'=>$modRencanaLembur,
		));
	}

	/**
         * Untuk melihat detail transaksi rencana lembur
         */
        public function actionLihatDetail($norencana)
	{
                $this->layout='//layouts/iframe';
                
		$modRencanaLembur = KPRencanaLemburT::model()->findByAttributes(array('norencana'=>$norencana));
                $modRencanaLemburDetail = KPRencanaLemburT::model()->findAllByAttributes(array('norencana'=>$norencana));
                $format = new MyFormatter;
                $modRencanaLembur->tglrencana = $format->formatDateTimeId($modRencanaLembur->tglrencana);
                
                $this->render('lihatdetail',array(
			'modRencanaLembur'=>$modRencanaLembur, 'modDetail'=>$modRencanaLemburDetail,
                        'norencana'=>$norencana
		));
                
	}
        
        
        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
//		$model=KPRencanaLemburT::model()->findByPk($id);
		$model=KPRencanaLemburT::model()->findAllByAttributes(array('norencana'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rencana-lembur-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
        /**
        * Digunakan pada
        * @category Transaksi Rencana Lembur 
        */
       public function actionMengetahui()
       {
           if(Yii::app()->request->isAjaxRequest) {
               $criteria = new CDbCriteria();
               $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
               $criteria->order = 'nama_pegawai';
               $criteria->addCondition('pegawai_aktif is true');
               $criteria->limit=5;
               $models = PegawaiM::model()->findAll($criteria);
               $returnVal = array();
               foreach($models as $i=>$model)
               {
                   $attributes = $model->attributeNames();
                   foreach($attributes as $j=>$attribute) {
                       $returnVal[$i]["$attribute"] = $model->$attribute;
                   }
                   $returnVal[$i]['label'] = $model->nama_pegawai;
                   $returnVal[$i]['value'] = $model->nama_pegawai;
               }

               echo CJSON::encode($returnVal);
           }
           Yii::app()->end();
       }
       /**
        * Digunakan pada 
        * @category Transaksi Rencana Lembur 
        */
       public function actionMenyetujui()
       {
           if(Yii::app()->request->isAjaxRequest) {
               $criteria = new CDbCriteria();
               $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
               $criteria->order = 'nama_pegawai';
               $criteria->addCondition('pegawai_aktif is true');
               $criteria->limit=5;
               $models = PegawaiM::model()->findAll($criteria);
               $returnVal = array();
               foreach($models as $i=>$model)
               {
                   $attributes = $model->attributeNames();
                   foreach($attributes as $j=>$attribute) {
                       $returnVal[$i]["$attribute"] = $model->$attribute;
                   }
                   $returnVal[$i]['label'] = $model->nama_pegawai;
                   $returnVal[$i]['value'] = $model->nama_pegawai;
               }

               echo CJSON::encode($returnVal);
           }
           Yii::app()->end();
       }
       /**
        * Digunakan pada 
        * @category Transaksi Rencana Lembur 
        */
       public function actionPegawaiLembur()
       {
           if(Yii::app()->request->isAjaxRequest) {
               $criteria = new CDbCriteria();
               $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
               $criteria->order = 'nama_pegawai';
               $criteria->addCondition('pegawai_aktif is true');
               $criteria->limit=5;                
               $models = PegawaiM::model()->findAll($criteria);  
               $returnVal = array();
               foreach($models as $i=>$model)
               {
                   $attributes = $model->attributeNames();
                   foreach($attributes as $j=>$attribute) {
                       $returnVal[$i]["$attribute"] = $model->$attribute;
                   }
                   $returnVal[$i]['label'] = $model->nama_pegawai;
                   $returnVal[$i]['value'] = $model->nama_pegawai;
               }

               echo CJSON::encode($returnVal);
           }
           Yii::app()->end();
        }
           
    
		/**
		 * Untuk transaksi rencana lembur pegawai
		 */
		public function actionGetPegawaiLembur()
		{
			$tr = "";
			if(Yii::app()->request->isAjaxRequest) {

				$modRencanaLembur=new KPRencanaLemburT;
				if(!empty($_POST['pegawailembur_id'])){
					$pegawailembur_id=$_POST['pegawailembur_id'];
					$modPegawai=PegawaiM::model()->findByPk($pegawailembur_id);
				}
				else if (!empty($_POST['nomorindukpegawaiPegawaiLembur'])){
					$nomorindukpegawaiPegawaiLembur=$_POST['nomorindukpegawaiPegawaiLembur'];
					$modPegawai=PegawaiM::model()->findByAttributes(array('nomorindukpegawai'=>$nomorindukpegawaiPegawaiLembur));
					$pegawailembur_id=$modPegawai->pegawai_id;
				}


				if(!empty($modPegawai->pegawai_id)){
					$tr.="<tr>
							<td>". CHtml::activeTextField($modRencanaLembur,'['.$pegawailembur_id.']nourut',array('class'=>'span1 noUrut','readonly'=>TRUE)).
								   CHtml::activeHiddenField($modRencanaLembur,'['.$pegawailembur_id.']pegawai_id',array('value'=>$modPegawai->pegawai_id, 'class'=>'karlemburNama')).                                
								   CHtml::activeHiddenField($modPegawai,'nomorindukpegawai',array('value'=>$modPegawai->nomorindukpegawai, 'class'=>'karlemburNik')).                                
						   "</td>
							<td>".$modPegawai->nomorindukpegawai."</td>
							<td>".$modPegawai->nama_pegawai."</td>";      //<td>".$modPegawai->jabatan->jabatan_nama."</td>                  

					$tr.="<td>".CHtml::activetextField($modRencanaLembur,'['.$pegawailembur_id.']jamMulai',array('placeholder'=>'00:00','class'=>'span1 detailRequired','readonly'=>false, 'maxLength'=>5, 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onblur'=>'checkTime(this);'))."</td>";
					$tr.="<td>".CHtml::activetextField($modRencanaLembur,'['.$pegawailembur_id.']jamSelesai',array('placeholder'=>'00:00','class'=>'span1','readonly'=>false, 'maxLength'=>5, 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onblur'=>'checkTime(this);'))."</td>";

					$tr.="        <td>".CHtml::activetextField($modRencanaLembur,'['.$pegawailembur_id.']alasanlembur',array('class'=>'span3','readonly'=>false, 'onkeypress'=>'return $(this).focusNextInputField(event)'))."</td>
							<td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'#',array('href'=>'','onclick'=>'hapusBaris(this); return false;'))."</td>
						 </tr>   
						";

					$data['tr']=$tr;
					echo json_encode($data);
					Yii::app()->end();
				}else{
					// Jika data pegawai salah
				}
			}
		}
		
        public function actionPrint($norencana,$caraPrint = null)
        {
            $format = new MyFormatter;    
            $rencana=KPRencanaLemburT::model()->findAllByAttributes(array('norencana'=>$norencana));
            
            
            $judul_print = '<h3>Rencana Lembur<h3>';
            $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
            if (isset($_GET['frame'])){
                $this->layout='//layouts/iframe';
            }
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
            }
            
            
            
            $this->render('Print', array(
                    'format'=>$format,
                    'judul_print'=>$judul_print,
                    'rencana'=>$rencana,
                    'caraPrint'=>$caraPrint
            ));
            
        }
}
