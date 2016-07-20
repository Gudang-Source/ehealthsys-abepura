<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.views.penjaminPasienM');
Yii::import('sistemAdministrator.controllers.PenjaminPasienMController');
class PenjaminPasienMMCController extends PenjaminPasienMController
{                                         
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.penjaminPasienM.';
	public $path_view_penjamin = 'mcu.views.penjaminPasienMMC.';

	
	public function actionAdmin($id='')
	{
                                                     
		$model=new SAPenjaminPasienM('searchPenjaminMCU');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SAPenjaminPasienM'])){
			$model->attributes=$_GET['SAPenjaminPasienM'];
                }

		$this->render($this->path_view_penjamin.'admin',array(
			'model'=>$model,
		));
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
		   $this->render($this->path_view_penjamin.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
	   }
	   else if($caraPrint=='EXCEL')    
	   {
		   $this->layout='//layouts/printExcel';
		   $this->render($this->path_view_penjamin.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
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
		   $mpdf->WriteHTML($this->renderPartial($this->path_view_penjamin.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
		   $mpdf->Output();
	   }                       
	}
}
