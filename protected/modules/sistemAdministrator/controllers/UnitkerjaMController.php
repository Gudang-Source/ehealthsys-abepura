
<?php

class UnitkerjaMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $successSaveUnitKerja=false;
	public $successSaveUnitRuangan=false;
	public $successDeleteUnitRuangan=false;
	public $path_view = 'sistemAdministrator.views.unitkerjaM.';
	

	/**
	 * Menampilkan detail data.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render($this->path_view.'view',array(
				'model'=>$model,
		));
	}

	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate()
	{
		$model=new SAUnitkerjaM;
		if(isset($_POST['SAUnitkerjaM']))
		{
			$transaction = Yii::app()->db->beginTransaction();
				try {
						$model->attributes=$_POST['SAUnitkerjaM'];
					if ($model->save()){
						$this->successSaveUnitKerja = true;
						$jumlahRuangan = 0;
						$modRuangans = $_POST['ruangan_id'];
						if (isset($modRuangans)){
							$idUnitKerja = $model->unitkerja_id;
							foreach ($modRuangans as $i => $ruangan)
							{
								$modRuanganUnit = new SAUnitkerjaruanganM;
								$modRuanganUnit->ruangan_id=$ruangan;
								$modRuanganUnit->unitkerja_id=$idUnitKerja;
								
								if ($modRuanganUnit->validate()){
									if($modRuanganUnit->save()){
										$this->successSaveUnitRuangan = true;
									}else{
										$this->successSaveUnitRuangan = false;
									}
								}
							}
						}
					}
					
					if($this->successSaveUnitKerja && $this->successSaveUnitRuangan){
						Yii::app()->user->setFlash('success', "Data Unit Kerja Berhasil Disimpan");
						$transaction->commit();
						$this->redirect(array('admin','id'=>$model->unitkerja_id));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data Unit Kerja Gagal Disimpan");
					}  
				} catch (Exception $ex) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data Unit Kerja Gagal Disimpan");
				}
		}
		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$modRuanganUnit = SAUnitkerjaruanganM::model()->findAllByAttributes(array('unitkerja_id'=>$id));

		if(isset($_POST['SAUnitkerjaM']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes=$_POST['SAUnitkerjaM'];	
				if($model->save()){
					$this->successSaveUnitKerja = true;
					$idUnitRuangan=$model->unitkerja_id;
					$hapusUnitKerja=SAUnitkerjaruanganM::model()->deleteAllByAttributes(array('unitkerja_id'=>$id));
					$jumlahUnitRuangan=isset($_POST['ruangan_id'])?COUNT($_POST['ruangan_id']):0;
					$dataUnitRuangan=isset($_POST['ruangan_id'])?$_POST['ruangan_id']:0;
					if($jumlahUnitRuangan>0)
					{    
						foreach ($dataUnitRuangan as $i => $unitRuangan)
						{
							$modUnitRuangan = new SAUnitkerjaruanganM;
							$modUnitRuangan->ruangan_id=$unitRuangan;
							$modUnitRuangan->unitkerja_id=$idUnitRuangan;
								if($modUnitRuangan->save()){
									$this->successSaveUnitRuangan = true;
								}else{
									$this->successSaveUnitRuangan = false;
								}   
						}
					}
				}else{
					Yii::app()->user->setFlash('error', "Data Unit Kerja Gagal Disimpan");
				}	
				if($this->successSaveUnitKerja && $this->successSaveUnitRuangan){
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Unit Kerja Berhasil Disimpan");
					$this->redirect(array('admin','id'=>$model->unitkerja_id));
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data Unit Kerja Gagal Disimpan");
				}   
				
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}

		$this->render($this->path_view.'update',array(
				'model'=>$model,
				'modRuanganUnit'=>$modRuanganUnit,
		));
	}

	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			
			$deleteRuangan = SAUnitkerjaruanganM::model()->deleteAllByAttributes(array('unitkerja_id'=>$id));
			if ($deleteRuangan){
				$this->loadModel($id)->delete();				
			}
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	/**
	 * Memanggil dan menonaktifkan status 
	 */
	public function actionNonActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
			 $model->unitkerja_aktif = false;
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}
	/**
	 * Memanggil dan menonaktifkan status 
	 */
	public function actionActive($id)
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$data['sukses']=0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
			 $model->unitkerja_aktif = true;
			 if($model->save()){
				$data['sukses'] = 1;
			 }
			echo CJSON::encode($data); 
		}
	}

	/**
	 * Melihat daftar data.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SAUnitkerjaM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model=new SAUnitkerjaM('searchUnit');
		$model->unsetAttributes();  // clear any default values
		$model->unitkerja_aktif = 1;
		if(isset($_GET['SAUnitkerjaM'])){
			$model->attributes=$_GET['SAUnitkerjaM'];
		}
		$this->render($this->path_view.'admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SAUnitkerjaM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='agunitkerja-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model= new SAUnitkerjaM;
		$model->attributes=$_REQUEST['SAUnitkerjaM'];
		$judulLaporan='Data Unit Kerja';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output($judulLaporan.'-'.date('Y_m_d').'.pdf','I');
		}
	}
	
	public function actionSetRuangan(){
        if (Yii::app()->request->isAjaxRequest){
			$list = '';
			$available = '<li class="ui-helper-hidden-accessible"></li>';
			$instalasi_id = $_POST['instalasi_id'];
                $criteria = new CdbCriteria();
                            if (!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
                            }
				$criteria->addCondition('ruangan_aktif IS TRUE');
                $criteria->order = "ruangan_nama";
                $model = SARuanganM::model()->findAll($criteria);
			foreach ($model as $i => $ruangan){
				$list .= '<option value="'.$ruangan->ruangan_id.'">'.$ruangan->ruangan_nama.'</option>';
				$available .= '<li style="display: block;" class="ui-state-default ui-element ui-draggable" title="'.$ruangan->ruangan_nama.'"><span class="ui-helper-hidden"></span>'.$ruangan->ruangan_nama.'<a href="#" class="action"><span class="ui-corner-all ui-icon ui-icon-plus"></span></a></li>';
			}
			echo CJSON::encode(array(
                'list'=>$list,'available'=>$available,));
            Yii::app()->end();
        }
    }
}
