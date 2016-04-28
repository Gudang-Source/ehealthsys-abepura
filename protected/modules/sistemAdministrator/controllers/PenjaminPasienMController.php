
<?php

class PenjaminPasienMController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.penjaminPasienM.';
	public $tips = 'sistemAdministrator.views.';

	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SAPenjaminPasienM;

		if(isset($_POST['SAPenjaminPasienM']))
		{
			$valid=true;
			foreach($_POST['SAPenjaminPasienM'] as $i=>$item)
			{
				
				if(is_integer($i)) {
					$model=new SAPenjaminPasienM;
					if(isset($_POST['SAPenjaminPasienM'][$i]))
						$model->attributes=$_POST['SAPenjaminPasienM'][$i];
						$model->carabayar_id = $_POST['SAPenjaminPasienM']['carabayar_id'];
						$model->penjamin_aktif = true;
						$valid=$model->validate() && $valid;
						echo $i;
					if($valid) {
						$model->save();
							Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					} else {
							Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
					}
				}
			}
			$this->redirect(array('admin','id'=>1));
		}   

		$this->render($this->path_view.'create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['SAPenjaminPasienM']))
		{
			$model->attributes=$_POST['SAPenjaminPasienM'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('admin','id'=>1));
			}
		}
	
		$this->render($this->path_view.'update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SAPenjaminPasienM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($id = '')
	{
            if ($id == 1):
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            endif;
		$model=new SAPenjaminPasienM('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAPenjaminPasienM'])){
			$model->attributes=$_GET['SAPenjaminPasienM'];
		}
		$this->render($this->path_view.'admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=SAPenjaminPasienM::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sapenjamin-pasien-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
	public function actionDelete()
	{   
		if(Yii::app()->request->isPostRequest)
		{
			$id = $_POST['id'];
			if(!empty($id)){
				TanggunganpenjaminM::model()->deleteAllByAttributes(array('penjamin_id'=>$id));
				JenistarifpenjaminM::model()->deleteAllByAttributes(array('penjamin_id'=>$id));
				$this->loadModel($id)->delete();
				if (Yii::app()->request->isAjaxRequest)
					{
						echo CJSON::encode(array(
							'status'=>'proses_form', 
							'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
							));
						exit;               
					}

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
        
	/**
	*Mengubah status aktif
	* @param type $id 
	*/
   public function actionRemoveTemporary()
   {
		$id = $_POST['id'];   
		if(isset($_POST['id']))
		{
		   $update = SAPenjaminPasienM::model()->updateByPk($id,array('penjamin_aktif'=>false));
		   if($update)
			{
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'proses_form', 
						));
					exit;               
				}
			 }
		} else {
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'proses_form', 
						));
					exit;               
				}
		}
	}
                
	public function actionPrint()
	{
	   $model= new SAPenjaminPasienM;
	   $model->unsetAttributes();
	   
	   if(isset($_REQUEST['SAPenjaminPasienM'])){
		   $model->attributes=$_REQUEST['SAPenjaminPasienM'];
	   }             
	   $judulLaporan='Laporan Data Penjamin Pasien';
	   $caraPrint=$_REQUEST['caraPrint'];
	   if($caraPrint=='PRINT')
	   {
		   $this->layout='//layouts/printWindows';
		   $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
	   }
	   else if($caraPrint=='EXCEL')    
	   {
		   $this->layout='//layouts/printExcel';
		   $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
	   }
	   else if($_REQUEST['caraPrint']=='PDF')
	   {

		   $ukuranKertasPDF=Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
		   $posisi=Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
		   $mpdf=new MyPDF('',$ukuranKertasPDF); 
		   $mpdf->useOddEven = 2;  
		   $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
		   $mpdf->WriteHTML($stylesheet,1);  
		   $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
		   $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
		   $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
	   }                       
	}
}
