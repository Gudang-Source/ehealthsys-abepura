<?php

class LaporanSEPController extends MyAuthController{
	
	protected $path_view = 'asuransi.views.laporanSEP.';
	
	public function actionIndex(){
		$model = new ARLaporansepR('searchLaporan');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['ARLaporansepR'])) {
            $model->attributes = $_GET['ARLaporansepR'];            
            $model->jns_periode = $_GET['ARLaporansepR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ARLaporansepR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ARLaporansepR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['ARLaporansepR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['ARLaporansepR']['bln_akhir']);
            $model->thn_awal = $_GET['ARLaporansepR']['thn_awal'];
            $model->thn_akhir = $_GET['ARLaporansepR']['thn_akhir'];
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

        $this->render($this->path_view.'admin', array(
            'model' => $model,'format'=>$format
        ));
	}
	
	protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
//        $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
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
    
    public function actionPrintLaporanSEP() {
        $model = new ARLaporansepR('searchLaporanPrint');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Indikator Dokter';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Indikator Dokter';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
        if (isset($_REQUEST['ARLaporansepR'])) {
            $model->attributes = $_GET['ARLaporansepR'];            
            $model->jns_periode = $_GET['ARLaporansepR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ARLaporansepR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ARLaporansepR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['ARLaporansepR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['ARLaporansepR']['bln_akhir']);
            $model->thn_awal = $_GET['ARLaporansepR']['thn_awal'];
            $model->thn_akhir = $_GET['ARLaporansepR']['thn_akhir'];
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
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
	
	public function actionFrameGrafikLaporanSEP() {
        $this->layout = '//layouts/iframe';
        $model = new ARLaporansepR('searchGrafik');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Grafik Indikator Dokter';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

        if (isset($_GET['ARLaporansepR'])) {
            $model->attributes = $_GET['ARLaporansepR'];
            $model->jns_periode = $_REQUEST['ARLaporansepR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ARLaporansepR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ARLaporansepR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['ARLaporansepR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['ARLaporansepR']['bln_akhir']);
            $model->thn_awal = $_GET['ARLaporansepR']['thn_awal'];
            $model->thn_akhir = $_GET['ARLaporansepR']['thn_akhir'];
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

        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
	
    /**
	* update nilai grafik garis dan speedo dari request ajax
	*/
	public function actionUpdateGrafik(){
		if(Yii::app()->request->isAjaxRequest) {
			$model = new ARLaporansepR();
			$format = new MyFormatter();
				if (isset($_GET['ARLaporansepR'])) {
						$model->attributes = $_GET['ARLaporansepR'];
						$model->jns_periode = $_REQUEST['ARLaporansepR']['jns_periode'];
						$model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['ARLaporansepR']['tgl_awal']);
						$model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['ARLaporansepR']['tgl_akhir']);
						$model->bln_awal = $format->formatMonthForDb($_REQUEST['ARLaporansepR']['bln_awal']);
						$model->bln_akhir = $format->formatMonthForDb($_REQUEST['ARLaporansepR']['bln_akhir']);
						$model->thn_awal = $_GET['ARLaporansepR']['thn_awal'];
						$model->thn_akhir = $_GET['ARLaporansepR']['thn_akhir'];
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
				
			$index_garis = array();
			$result_garis = array();
			$periodeGrafik = $format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_awal))))." s.d ".$format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_akhir))));
			$return['title'] = "Grafik Laporan Indikator Dokter <br> Periode: ".$periodeGrafik;

			$dataProviderGaris = $model->searchGrafik();
			$dataProviderSpeedo = $model->searchGrafik();
			$hasilGaris = $dataProviderGaris->getData(); 
			foreach ($hasilGaris as $i=>$v){
				if(strlen($v['data']) > 2){
					$index_garis[] = $format->formatDateTimeForUser($v['data']);
				}else{
					$index_garis[] = $format->getMonthUser((int)$v['data'])." ".$v['data_2'];
				}
				$result_garis[] = array($i+1,(int)$v['jumlah']);
			}
			$return['garis']['result'] = $result_garis;
			$return['garis']['index'] = $index_garis;
			$return['speedo']['result'] = (int)$dataProviderSpeedo->getTotalItemCount();

			echo json_encode($return);
			Yii::app()->end();
		}
	}
}

