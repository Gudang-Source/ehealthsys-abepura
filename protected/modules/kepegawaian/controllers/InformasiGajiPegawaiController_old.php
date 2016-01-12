<?php
class InformasiGajiPegawaiController extends MyAuthController{
	public $layout='//layouts/column1';

	public function actionIndex($pegawai = null){
		$format = new MyFormatter();
		$modelpegawai = KPPegawaiM::model()->find('pegawai_id = ' . Yii::app()->user->id . '');
		$model = new KPPenggajianpegawaiV;
		$model->tgl_awal=date('Y-m-d');
		$model->tgl_akhir=date('Y-m-d');
		$pegawai = Yii::app()->user->id;
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['KPPenggajianpegawaiV']))
		{
			$model->attributes=$_GET['KPPenggajianpegawaiV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['KPPenggajianpegawaiV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPPenggajianpegawaiV']['tgl_akhir']);
		}      
		
		$this->render('index',array(
			'modelpegawai'=>$modelpegawai,
			'model'=>$model,
			'pegawai'=>$pegawai,
			'format'=>$format,
		));	
	}
	
	public function actionDetailGaji($pegawai_id,$nopenggajian) {
		$this->layout = '//layouts/iframe';
		$modelpegawai = KPPegawaiM::model()->findByPk($pegawai_id);
		$model = PenggajianpegT::model()->findByAttributes(array('nopenggajian'=>$nopenggajian));
		$modDetail = PenggajiankompT::model()->findAllByAttributes(array('penggajianpeg_id'=>$model->penggajianpeg_id));
		$this->render('detailPenggajian',array(
			 'modelpegawai'=>$modelpegawai,
			 'model'=>$model,
			 'modDetail'=>$modDetail,
		));
	}
	
	public function actionPrintPenggajian($id,$gaji_id) {
        $modelpegawai = KPPegawaiM::model()->findByPk($id);
		$modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $gaji_id . '');
        $model = PenggajianpegT::model()->findByPk($gaji_id);
        $modelpegawai->attributes = (isset($_REQUEST['KPPegawaiM']) ? $_REQUEST['KPPegawaiM'] : null);
		$judulLaporan = '--- Detail Penggajian Pegawai ---';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('PrintPenggajian', array('model' => $model, 'modelpegawai'=>$modelpegawai, 'modDetail'=>$modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('PrintPenggajian', array('model' => $model, 'modelpegawai'=>$modelpegawai, 'modDetail'=>$modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);
            $mpdf->WriteHTML($this->renderPartial('PrintPenggajian', array('model' => $model, 'modelpegawai'=>$modelpegawai, 'modDetail'=>$modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
         }
	}
}