<?php
class LaporanNeracaController extends MyAuthController{
	
	public $path_view = 'akuntansi.views.laporanNeraca.';
	
	public function actionIndex() {
        $model = new AKLaporanneracaV('searchLaporan2');
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("'".date("Y-m-d")."'::date between tglperiodeposting_awal and tglperiodeposting_akhir");
		$periode = PeriodepostingM::model()->find($criteria);
		
		if (!empty($periode))
			$model->periodeposting_id = $periode->periodeposting_id;
		
		//$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		//$model->thn_awal = date('Y');
		
		if (isset($_GET['AKLaporanneracaV'])) {
			
			$model->attributes = $_GET['AKLaporanneracaV'];
			$format = new MyFormatter();
			// $model->bulan = $_GET['AKLaporanneracaV']['bulan'];
			// $model->thn_awal = $_GET['AKLaporanneracaV']['thn_awal'];
		}
		$models = $model->findAll($model->searchLaporan2());
		echo $this->render($this->path_view.'admin', array(
			'model' => $model,
			'models' => $models,
				), true
		);
    }

    public function actionPrintLaporanLabaRugi() {
        $model = new AKLaporanneracaV('searchLaporan2');
		$model->unsetAttributes();
		//$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		//$model->thn_awal = date('Y');
		$judulLaporan = 'Laporan Neraca';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Neraca';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
		if (isset($_REQUEST['AKLaporanneracaV'])) {
			$model->attributes = $_REQUEST['AKLaporanneracaV'];
			$format = new MyFormatter();
//			$model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
			//$model->bulan = $_GET['AKLaporanneracaV']['bulan'];
			//$model->thn_awal = $_GET['AKLaporanneracaV']['thn_awal'];
		}
		$models = $model->findAll($model->searchLaporan2());
		$caraPrint = $_REQUEST['caraPrint'];
		$target = $this->path_view.'_print';

//		$periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

//		$periode = $periodeposting_id->periodeposting_nama;

		$format = new MyFormatter();
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
        
        public function actionPrintLaporanNeraca() {
        $model = new AKLaporanneracaV('searchLaporan2');
		$model->unsetAttributes();
		$model->tgl_awal = date('m-d', strtotime('first day of this month'));
		$model->thn_awal = date('Y');
		$judulLaporan = 'Laporan Neraca';

		//Data Grafik       
		$data['title'] = 'Grafik Laporan Neraca';
		isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
		if (isset($_REQUEST['AKLaporanneracaV'])) {
			$model->attributes = $_REQUEST['AKLaporanneracaV'];
			$format = new MyFormatter();
//			$model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
			$model->bulan = $_GET['AKLaporanneracaV']['bulan'];
			$model->thn_awal = $_GET['AKLaporanneracaV']['thn_awal'];
		}
		$models = $model->findAll($model->searchLaporan2());
		$caraPrint = $_REQUEST['caraPrint'];
		$segmen = isset($_REQUEST['Segmen']) ? $_REQUEST['Segmen'] : null;
		$target = $this->path_view.'_print';
//		if($caraPrint == 'EXCEL' || $caraPrint == 'PDF'){
//			$target = $this->path_view.'_print_pdf_excel';
//		}

//		$periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

//		$periode = $periodeposting_id->periodeposting_nama;

		$format = new MyFormatter();
		if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
			$this->layout = '//layouts/printWindows';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$target = $this->path_view.'_table_pdf';
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');	  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');		 //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->SetHTMLFooter('{PAGENO}');
//			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
           /* $mpdf->SetHTMLHeader(
                    '
<table width="100%">
        <TR>
            <TD ROWSPAN=3 WIDTH=80 ALIGN=CENTER VALIGN=MIDDLE>
                 <img src="'.Params::urlProfilRSDirectory().$data->logo_rumahsakit.'" style="float:left; max-width: 80px; width:80px;" class="image_report"/>
            </TD>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan="50">
                <B><FONT FACE="Liberation Serif" SIZE=5 color="black">'.$data->nama_rumahsakit.'</FONT></B>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan="50">
                <FONT FACE="Liberation Serif" color="black">'.$data->alamatlokasi_rumahsakit.'</FONT>
            </TD>
        </TR>
         <TR>
            <TD ALIGN=CENTER VALIGN=MIDDLE colspan="50">
                <FONT FACE="Liberation Serif" color="black">Telp./Fax. '.$data->no_telp_profilrs.' / '.$data->no_faksimili.'</FONT>
            </TD>
        </TR>
         <TR>
            <TD colspan="50" HEIGHT=2 style="border-bottom: 3px solid #000000" ></TD>
        </TR>
             <TR>
                <TD colspan="50" ALIGN=CENTER VALIGN=MIDDLE ><font color="black"><h3>'.$judulLaporan.'</h3></font></TD>
            </TR>
         <TR>
            <TD colspan="50" ALIGN=CENTER VALIGN=MIDDLE></TD>
        </TR>  
</table>
<table class="table table-striped table-condensed">
<tr>
	<td width="35%"><b>Rincian</b></td>
'.
$this->periodeHeader($periode,$models)					
.'
</tr>
</table>

            ', 'O', true);*/
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'segmen'=>$segmen), true));
			$mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
		}
	}
	
	public function PeriodeHeader($periode = null,$models){
		$dataArray = array();
		foreach ($models AS $row => $data) {
			$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
		}
		foreach ($dataArray AS $row => $data) {
			if (count($data) > 1) {
				if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
					$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
					$periode_array .= "<th ALIGN=CENTER>".MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])))."</th>";			
				} else {
					$periode_array .= "<td></td>";
				}
				$jmlKolom ++;
			} else {
				if (!empty($models) || !empty($data)) {
					$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;
					$periode_array .= "<th ALIGN=CENTER>".MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data)))."</th>";
				} else {
					$periode_array .= "<td></td>";
				}
				$jmlKolom ++;
			}
		}
		return $periode_array;
	}
}