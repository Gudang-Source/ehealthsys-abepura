<?php

class LaporanKasHarianController extends MyAuthController {
    
    public function actionLaporanKasHarian() {
        $model = new BKClosingkasirT('search');
        $this->pageTitle = Yii::app()->name.' - '.'Laporan Laboratorium';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        $filter = (isset($_GET['filter_tab']) ? $_GET['filter_tab'] : null);
        if (isset($_GET['BKClosingkasirT'])) {
            $model->attributes = $_GET['BKClosingkasirT'];
            $model->jns_periode = $_GET['BKClosingkasirT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKClosingkasirT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKClosingkasirT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['BKClosingkasirT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['BKClosingkasirT']['bln_akhir']);
            $model->thn_awal = $_GET['BKClosingkasirT']['thn_awal'];
            $model->thn_akhir = $_GET['BKClosingkasirT']['thn_akhir'];
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



        $this->render('rekapKas/index', array(
                        'model' => $model,'filter'=>$filter,'format'=>$format
        ));
    }
public function actionPrintLaporanKasHarian() {
       $model = new BKClosingkasirT('search');
        $this->pageTitle = Yii::app()->name.' - '.'Laporan Laboratorium';
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $modDetail = null;
        $modRincian = null;
        $filter = (isset($_GET['filter_tab']) ? $_GET['filter_tab'] : null);
        if (isset($_GET['BKClosingkasirT'])) {
            $model->attributes = $_GET['BKClosingkasirT'];
           $model->jns_periode = $_GET['BKClosingkasirT']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKClosingkasirT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKClosingkasirT']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['BKClosingkasirT']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['BKClosingkasirT']['bln_akhir']);
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

        $data = array();
        //Data Grafik
        $data['title'] = 'Grafik Laporan Kas Harian';
        $judulLaporan = 'Laporan Kas Harian';
        $rincianUang = array();
        $data['type'] = $_REQUEST['type'];
//        if (isset($_REQUEST['LBClosingkasirT'])) {
//            $model->attributes = $_REQUEST['LBClosingkasirT'];
//            $format = new MyFormatter();
//            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']);
//            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']);
//        }
//        echo " test";
        if($_REQUEST['filter_tab'] == 'rekap')
                {
                    $judulLaporan = 'REKAPITULASI LAPORAN PENDAPATAN HARIAN';
                    $data['filter'] = "rekap";
                    
                }
                else if($_GET['filter_tab'] == 'detail')
                {
                    $judulLaporan = 'LAPORAN DETAIL PEMBAYARAN';
                    $data['filter'] = "detail";
                    
                }


            // if(isset($_REQUEST['BKClosingkasirT'])){
            //     $model = new BKClosingkasirT();
            //     if($_REQUEST['filter_tab'] == 'rekap')
            //     {
            //         $judulLaporan = 'REKAPITULASI LAPORAN PENDAPATAN HARIAN';
            //         $data['filter'] = "rekap";
                    
            //     }
            //     else if($_GET['filter_tab'] == 'detail')
            //     {
            //         $judulLaporan = 'LAPORAN DETAIL PEMBAYARAN';
            //         $data['filter'] = "detail";
                    
            //     }
            //     $model->attributes = $_REQUEST['BKClosingkasirT'];
            //     $format = new MyFormatter();
            //     if(!empty($_REQUEST['BKClosingkasirT']['tgl_awal']))
            //     {
            //         $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_awal']);
            //     }
            //     if(!empty($_REQUEST['BKClosingkasirT']['tgl_awal']))
            //     {
            //         $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_akhir']);
            //     }
            // }
        
//        $data['caraPrint'] = $_REQUEST['caraPrint'];
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'rekapKas/_print';
        
        $this->printFunction($model,$modDetail, $data, $caraPrint, $judulLaporan, $target,$modRincian,$rincianUang);
    }

    public function actionPrintLaporanKasHarianOLD() {
        $format = new MyFormatter();
        $criteria=new CDbCriteria;

        $criteria->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran,t.create_ruangan';
        $criteria->group = 't.closingkasir_id, t.create_ruangan, rincianclosing_t.closingkasir_id, t.keterangan_closing';
        $criteria->addBetweenCondition('t.tglclosingkasir',$format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_awal']),$format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_akhir']));
        
        $criteria->addCondition('t.create_ruangan = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id';
        
        $criteria3 = new CDbCriteria;

        $criteria3->select = 't.closingkasir_id, rincianclosing_t.closingkasir_id,pendaftaran_t.pendaftaran_id, pasien_m.pasien_id, pendaftaran_t.no_pendaftaran, pasien_m.nama_pasien,
                            sum(t.terimauangmuka) as terimauangmuka,
                            sum(rincianclosing_t.jumlahuang) as jumlahuang,
                            sum(t.piutang) as piutang, 
                            sum(t.terimauangpelayanan) as uangpelayanan,
                            sum(rincianclosing_t.jumlahuang + t.piutang) as total,
                            t.keterangan_closing, 
                            sum(t.totalsetoran) as totalsetoran, 
                            sum(t.totalpengeluaran) as totalpengeluaran, t.create_ruangan';
        $criteria3->group = 't.closingkasir_id, t.create_ruangan, rincianclosing_t.closingkasir_id, t.keterangan_closing,pendaftaran_t.pendaftaran_id, pendaftaran_t.no_pendaftaran, pasien_m.pasien_id, pasien_m.nama_pasien';
        $criteria3->compare('t.create_ruangan',Yii::app()->user->getState('ruangan_id'));
        $criteria3->addBetweenCondition('t.tglclosingkasir',$format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_awal']),$format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_akhir']));
        $criteria3->join ='LEFT JOIN rincianclosing_t ON rincianclosing_t.closingkasir_id = t.closingkasir_id LEFT JOIN tandabuktibayar_t 
                          ON tandabuktibayar_t.closingkasir_id = t.closingkasir_id LEFT JOIN pembayaranpelayanan_t ON 
                          pembayaranpelayanan_t.tandabuktibayar_id = tandabuktibayar_t.tandabuktibayar_id LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pembayaranpelayanan_t.pendaftaran_id
                          LEFT JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id';
        
        $model      = BKClosingkasirT::model()->findAll($criteria);
        $modDetail  = BKClosingkasirT::model()->findAll($criteria3);
        $criteria2=new CDbCriteria;
        $model      = BKClosingkasirT::model()->findAll($criteria);
        $modDetail  = BKClosingkasirT::model()->findAll($criteria3);
        $modRincian = new RincianclosingT;
        
        $data = array();
        //Data Grafik
        $data['title'] = 'Grafik Laporan Kas Harian';
        $judulLaporan = 'Laporan Kas Harian';
        $rincianUang = array();
        $data['type'] = $_REQUEST['type'];
//        if (isset($_REQUEST['LBClosingkasirT'])) {
//            $model->attributes = $_REQUEST['LBClosingkasirT'];
//            $format = new MyFormatter();
//            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_awal']);
//            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBClosingkasirT']['tgl_akhir']);
//        }
//        echo " test";
        
            if(isset($_REQUEST['BKClosingkasirT'])){
                $model = new BKClosingkasirT();
                if($_REQUEST['filter_tab'] == 'rekap')
                {
                    $judulLaporan = 'REKAPITULASI LAPORAN PENDAPATAN HARIAN';
                    $data['filter'] = "rekap";
                    
                }
                else if($_GET['filter_tab'] == 'detail')
                {
                    $judulLaporan = 'LAPORAN DETAIL PEMBAYARAN';
                    $data['filter'] = "detail";
                    
                }
                $model->attributes = $_REQUEST['BKClosingkasirT'];
                $format = new MyFormatter();
                if(!empty($_REQUEST['BKClosingkasirT']['tgl_awal']))
                {
                    $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_awal']);
                }
                if(!empty($_REQUEST['BKClosingkasirT']['tgl_awal']))
                {
                    $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKClosingkasirT']['tgl_akhir']);
                }
            }
        
//        $data['caraPrint'] = $_REQUEST['caraPrint'];
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'rekapKas/_print';
        
        $this->printFunction($model,$modDetail, $data, $caraPrint, $judulLaporan, $target,$modRincian,$rincianUang);
    }

    public function actionFrameGrafikKasHarian() {
        $this->layout = '//layouts/iframe';
        $model = new BKClosingkasirT('search');
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['BKClosingkasirT'])) {
            $model->attributes = $_GET['BKClosingkasirT'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKClosingkasirT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKClosingkasirT']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    protected function printFunction($model, $modDetail, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $rincianUang = array();
        $modRincian = array();
        $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal).' s/d '.MyFormatter::formatDateTimeForUser($model->tgl_akhir);
//        echo $caraPrint;
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint , 'modRincian'=>$modRincian));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian), true));
            $mpdf->Output();
        }
    }
    
    protected function parserTanggal($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row){
        if (!empty($row)){
            $result[] = $row;
        }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
        
    }
    
 public function getTabularFormTabs($form, $model)
{
    $tabs = array();
    $count = 0;
    foreach (array('en'=>'English', 'fi'=>'Finnish', 'sv'=>'Swedish') as $locale => $language)
    {
        $tabs[] = array(
            'active'=>$count++ === 0,
            'label'=>$language,
            'content'=>$this->renderPartial('rekapTransaksiBedah/_table', array('form'=>$form, 'model'=>$model, 'locale'=>$locale, 'language'=>$language), true),
        );
    }
    return $tabs;
}
}