<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaporanController
 *
 * @author root
 */

Yii::import("gudangFarmasi.models.*");

class LaporanController extends MyAuthController {
    public $path_view_tips = "gudangFarmasi.views.tips.";
    public $path_view_gudang = "gudangFarmasi.views.laporan.";
    public function actionLaporanMutasiObatAlkes(){
        $model = new GFMutasioaruanganT;
        $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if (isset($_GET['GFMutasioaruanganT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
//            if($_GET['GFMutasioaruanganT']['ruanganasal_id']){
//            $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        }
        $this->render($this->path_view_gudang.'mutasiObatAlkes/index',array(
            'model'=>$model,'format'=>$format
        ));
    }
    public function actionPrintLaporanMutasiObatAlkes(){
        $model = new GFMutasioaruanganT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Mutasi Obat Alkes';

        //Data Grafik
        $data['title'] = 'Grafik Mutasi Obat Alkes';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFMutasioaruanganT'])) {
            $model->attributes = $_REQUEST['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = $this->path_view_gudang.'mutasiObatAlkes/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    /**
     * actionLaporanMutasiIntern laporan mutasi obat alkes
     */
    public function actionLaporanMutasiIntern(){
        $model = new GFMutasioaruanganT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if (isset($_GET['GFMutasioaruanganT'])) {
            $format = new MyFormatter;
            $model->attributes = $_GET['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
            $model->thn_awal = $_GET['GFMutasioaruanganT']['thn_awal'];
            $model->thn_akhir = $_GET['GFMutasioaruanganT']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
			
        }
        $this->render($this->path_view_gudang.'mutasiIntern/index',array(
            'model'=>$model,'format'=>$format
        ));
    }
    /**
     * actionLaporanMutasiIntern print laporan mutasi obat alkes
     */
    public function actionPrintLaporanMutasiIntern(){
        $model = new GFMutasioaruanganT('searchLaporanMutasiIntern');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Mutasi Obat Alkes';
        //Data Grafik
        $data['title'] = 'Grafik Mutasi Obat Alkes';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['GFMutasioaruanganT'])) {
            $model->attributes = $_REQUEST['GFMutasioaruanganT'];
            $model->jns_periode = $_REQUEST['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['GFMutasioaruanganT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        $target = $this->path_view_gudang.'mutasiIntern/Print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    /**
     * actionPrintLaporanMutasiInternDetail print detail dari tombol di grid
     */
    public function actionLaporanMutasiInternDetail($id, $caraPrint){
        $this->layout = '//layouts/iframe';
        $judulLaporan = 'Laporan Mutasi Obat Alkes Detail';
        $format = new MyFormatter();
        $modDetail = array();
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
        if($caraPrint == "PRINT")
            $this->layout = '//layouts/printWindows';
        if (isset($_REQUEST['GFMutasioaruanganT'])) {
            $criteria = new CdbCriteria();
            $tgl_awal =  $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_awal']);
            $tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFMutasioaruanganT']['tgl_akhir']);
            $criteria->addBetweenCondition('tglmutasioa',$tgl_awal,$tgl_akhir);
			if(!empty($id)){
				$criteria->addCondition("mutasioaruangan_id = ".$id);		
			}
            $model = GFMutasioaruanganT::model()->find($criteria);
            $modDetail = GFMutasioadetailT::model()->findAllByAttributes(array('mutasioaruangan_id'=>$id));
        }
        $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama;
        $periode = date('d-m-Y H:i:s',  strtotime($tgl_awal))." s/d ".date('d-m-Y H:i:s',  strtotime($tgl_akhir));
        $this->render($this->path_view_gudang.'mutasiIntern/PrintDetail', array('model'=>$model, 'modDetail'=>$modDetail, 'judulLaporan'=>$judulLaporan, 'ruanganAsal'=>$ruanganAsal, 'periode'=>$periode,'caraPrint'=>$caraPrint));
    }
    public function actionFrameGrafikLaporanMutasiObatAlkes(){
        $this->layout = '//layouts/iframe';

        $model = new GFMutasioaruanganT;
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Mutasi Obat Alkes';
        $data['type'] = $_GET['type'];

        if (isset($_GET['GFMutasioaruanganT'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['GFMutasioaruanganT'];
            $model->jns_periode = $_GET['GFMutasioaruanganT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFMutasioaruanganT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['GFMutasioaruanganT']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $this->render($this->path_view_gudang.'_grafik', array(
            'format'=>$format,
            'model' => $model,
            'data'=>$data,
        ));
    }
    
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
//        $model->tgl_awal = date('Y-m-d h:i:s',strtotime($model->tgl_awal));
//        $model->tgl_akhir = date('Y-m-d h:i:s',strtotime($model->tgl_akhir));
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
//        var_dump($model->tgl_awal);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ((isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null) == 'PDF') {
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
