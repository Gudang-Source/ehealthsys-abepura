<?php

class ReevaluasiasetTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'index';


	public function actionIndex()
	{
		$model = new MAReevaluasiasetT;
		$models = new MAReevaluasiasetdetailT;
		$format = new MyFormatter();
		
		if(isset($_POST['MAReevaluasiasetT']))
		{
			$model->attributes = $_POST['MAReevaluasiasetT'];
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->update_loginpemakai_id = Yii::app()->user->id;
			$model->create_time = date('Y-m-d');
			$model->update_time = date('Y-m-d');
			$model->reevaluasiaset_no = $_POST['MAReevaluasiasetT']['reevaluasiaset_no'];
			$model->pegawaimengetahui_id =$_POST['pegawai_id'];
			$model->pegawaimenyetujui_id =$_POST['pegawai_id_'];
			$model->reevaluasiaset_tgl =  $format->formatDateTimeForDb($_POST['MAReevaluasiasetT']['reevaluasiaset_tgl']);
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$model->save();
			
			foreach ($_POST as $key=>$data){
				
				$models->barang_id = $_POST['barang_id'];
				$models->invtanah_id = $_POST['invtanah'];
				$models->invgedung_id = $_POST['invgedung'];
				$models->invperalatan_id = $_POST['invperalatan'];
				$models->invjalan_id = $_POST['invjalan'];
				$models->invasetlain_id = $_POST['invasetlain'];
				$models->reevaluasiaset_umurekonomis = $_POST['ue'];
				$models->reevaluasiaset_nilaibuku = $_POST['nb'];
				$models->reevaluasiaset_hargaperolehan = $_POST['hrgperolehan'];
				$models->reevaluasiaset_selisihreevaluasi = $_POST['selisih'];
				$models->reevaluasiaset_id = $model->reevaluasiaset_id;
				if($models->save()){
					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
					$this->redirect(array('index','id'=>$model->reevaluasiaset_id,'sukses'=>1));
				}
			}		
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}


	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model = new BarangV();
		$judulLaporan='Reevaluasi Aset';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
}
