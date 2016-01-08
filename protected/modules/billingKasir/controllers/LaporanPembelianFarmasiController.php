<?php

class LaporanPembelianFarmasiController extends MyAuthController {

    public $path_view = 'billingKasir.views.laporanPembelianFarmasi.';
    
    public function actionIndex()
    {
            $format = new MyFormatter();
            $model=new BKFakturPembelianT();
            $model->unsetAttributes();
            $model->tgl_awal = date('d M Y');
            $model->tgl_akhir = date('d M Y');
            if(isset($_GET['BKFakturPembelianT'])){
                    $model->attributes=$_GET['BKFakturPembelianT'];
                    $model->tgl_awal=$format->formatDateTimeForDb($_GET['BKFakturPembelianT']['tgl_awal']);
                    $model->tgl_akhir=$format->formatDateTimeForDb($_GET['BKFakturPembelianT']['tgl_akhir']);
//		if($_GET['berdasarkanJatuhTempo']>0){
//                    $model->tgl_awalJatuhTempo = $format->formatDateTimeForDb($_GET['BKFakturPembelianT']['tgl_awalJatuhTempo']);
//                    $model->tgl_akhirJatuhTempo = $format->formatDateTimeForDb($_GET['BKFakturPembelianT']['tgl_akhirJatuhTempo']);
//                } else {
//                    $model->tgl_awalJatuhTempo = null;
//                    $model->tgl_akhirJatuhTempo = null;
//                }
		    
	    }

            $this->render($this->path_view.'index',array(
                    'model'=>$model,
            ));
    }
    public function actionPrint(){
        $format = new MyFormatter();
        $model = new BKFakturPembelianT();
        $judulLaporan = 'Laporan Faktur Pembelian Farmasi';
        //Data Grafik
        $data['title'] = 'Laporan Faktur Pembelian Farmasi';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['BKFakturPembelianT'])) {
            $model->attributes = $_REQUEST['BKFakturPembelianT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKFakturPembelianT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKFakturPembelianT']['tgl_akhir']);
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if(empty($model->tgl_awal)){
            $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        }
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
}




