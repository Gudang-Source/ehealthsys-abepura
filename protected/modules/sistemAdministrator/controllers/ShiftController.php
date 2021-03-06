
<?php

class ShiftController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/iframe';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.shift.';
        public $path_tips = 'sistemAdministrator.views.tips.';

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
		$model = new SAShiftM;
		$modBerlaku = new SAShiftberlakuM;
		$berlaku = true;
		if(isset($_POST['SAShiftM']))
		{
			$model->attributes = $_POST['SAShiftM'];
			$model->shift_kode = $_POST['SAShiftM']['shift_kode'];
			$model->shift_urutan = $_POST['SAShiftM']['shift_urutan'];
			if($model->save()){
				
				if (isset($_POST['SAShiftberlakuM'])){
					foreach ($_POST['SAShiftberlakuM'] as $i => $shiftberlaku) {
						if(empty($shiftberlaku['shiftberlaku_id'])){							
							$modBerlaku= new SAShiftberlakuM;
							$modBerlaku->attributes = $shiftberlaku;
							$modBerlaku->shift_id = $model->shift_id;
							$modBerlaku->create_time = date('Y-m-d H:i:s');
							$modBerlaku->create_loginpemakai_id = Yii::app()->user->id;
							$modBerlaku->create_ruangan = Yii::app()->user->getState('ruangan_id');
							$modBerlaku->shiftberlaku_tgl = MyFormatter::formatDateTimeForDb($modBerlaku->shiftberlaku_tgl);
								

							if($modBerlaku->validate()){								
								$berlaku = $berlaku && $modBerlaku->save();
							}else{
								$berlaku = false;
							}
						}
					}
				}
				
				if ($berlaku){
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin'));
				}else{
					var_dump($modBerlaku->getErrors());die;
					Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
				}
			}
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model, 'modBerlaku'=>$modBerlaku
		));
	}

	/**
	 * Memanggil dan Mengubah sebagian data.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
	
		
		$modBerlaku = new SAShiftberlakuM;
		
		
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['SAShiftM']))
		{
			$berlaku=true;
			$model->attributes = $_POST['SAShiftM'];
			$model->shift_kode = $_POST['SAShiftM']['shift_kode'];
			$model->shift_urutan = $_POST['SAShiftM']['shift_urutan'];
			if($model->save()){
				if (isset($_POST['SAShiftberlakuM'])){
					$del = SAShiftberlakuM::model()->deleteAllByAttributes(array(
					'shift_id'=>$model->shift_id,
				));
					foreach ($_POST['SAShiftberlakuM'] as $i => $shiftberlaku) {																				
						$modBerlaku= new SAShiftberlakuM;
						$modBerlaku->attributes = $shiftberlaku;
						$modBerlaku->shift_id = $model->shift_id;
						$modBerlaku->create_time = date('Y-m-d H:i:s');
						$modBerlaku->create_loginpemakai_id = Yii::app()->user->id;
						$modBerlaku->create_ruangan = Yii::app()->user->getState('ruangan_id');
						$modBerlaku->shiftberlaku_tgl = MyFormatter::formatDateTimeForDb($modBerlaku->shiftberlaku_tgl);								
						
						
						if($modBerlaku->validate()){								
							$berlaku = $berlaku && $modBerlaku->save();
						}else{
							$berlaku = false;
						}
					}
				}
				
				if ($berlaku){
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('admin'));
				}else{
					var_dump($modBerlaku->getErrors());die;
					Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
				}
			}
		}

		$this->render($this->path_view.'update',array(
				'model'=>$model,
				'modBerlaku'=>$modBerlaku
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
			$this->loadModel($id)->delete();

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
			$data['sukses'] = 0;
			$model = $this->loadModel($id);
			// set non-active this
			// example: 
			 $model->shift_aktif = 0;
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
		$dataProvider = new CActiveDataProvider('SAShiftM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Pengaturan data.
	 */
	public function actionAdmin()
	{
		$model = new SAShiftM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAShiftM'])){
			$model->attributes = $_GET['SAShiftM'];
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
		$model = SAShiftM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sashift-m-form')
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
		$model = new SAShiftM;
		$model->attributes = $_REQUEST['SAShiftM'];
		$judulLaporan='Laporan Data Shift';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
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
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
}
