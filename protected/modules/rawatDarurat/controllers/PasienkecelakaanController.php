<?php

class PasienkecelakaanController extends MyAuthController {

    public function actionPasienKecelakaan() {
        $model = new RDLaporanpasienkecelakaanV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
//       $jenis = CHtml::listData(JeniskecelakaanM::model()->findAll('jeniskecelakaan_aktif = true'), 'jeniskecelakaan_id', 'jeniskecelakaan_nama');
//        $model->jeniskecelakaan_id = RDLaporanpasienkecelakaanV;
        if (isset($_GET['RDLaporanpasienkecelakaanV'])) {
            $model->attributes = $_GET['RDLaporanpasienkecelakaanV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasienkecelakaanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasienkecelakaanV']['tgl_akhir']);
        }
         if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial('_table', array('model'=>$model),true);
                }else{
                      $this->render('index', array(
                    'model' => $model,
                ));
            }
    }

    public function actionPrintLaporanPasienKecelakaan() {
        $model = new RDLaporanpasienkecelakaanV('search');
        $judulLaporan = 'Laporan Pasien Kecelakaan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Kecelakaan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RDLaporanpasienkecelakaanV'])) {
            $model->attributes = $_REQUEST['RDLaporanpasienkecelakaanV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDLaporanpasienkecelakaanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDLaporanpasienkecelakaanV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPasienKecelakaan() {
        $this->layout = '//layouts/iframe';
        $model = new RDLaporanpasienkecelakaanV('search');
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien Kecelakaan';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['RDLaporanpasienkecelakaanV'])) {
            $model->attributes = $_GET['RDLaporanpasienkecelakaanV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasienkecelakaanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasienkecelakaanV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
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
	
	/**
	* Mengatur dropdown kabupaten
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
	public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$model = new RDLaporanpasienkecelakaanV;
			if($model_nama !=='' && $attr == ''){
				$propinsi_id = $_POST["$model_nama"]['propinsi_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$propinsi_id = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$propinsi_id = $_POST["$model_nama"]["$attr"];
			}
			$kabupaten = null;
			if($propinsi_id){
				$kabupaten = $model->getKabupatenItems($propinsi_id);
				$kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
			}
			if($encode){
				echo CJSON::encode($kabupaten);
			} else {
				if(empty($kabupaten)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kabupaten as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengatur dropdown kecamatan
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$model = new RDLaporanpasienkecelakaanV;
			if($model_nama !=='' && $attr == ''){
				$kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$kabupaten_id = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$kabupaten_id = $_POST["$model_nama"]["$attr"];
			}
			$kecamatan = null;
			if($kabupaten_id){
				$kecamatan = $model->getKecamatanItems($kabupaten_id);
				$kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
			}

			if($encode){
				echo CJSON::encode($kecamatan);
			} else {
				if(empty($kecamatan)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kecamatan as $value=>$name)
					{
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	/**
	 * Mengatur dropdown kelurahan
	 * @param type $encode jika = true maka return array jika false maka set Dropdown 
	 * @param type $model_nama
	 * @param type $attr
	 */
	public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$model = new RDLaporanpasienkecelakaanV;
			if($model_nama !=='' && $attr == ''){
				$kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$kecamatan_id = $_POST["$attr"];
			}
			elseif ($model_nama !== '' && $attr !== '') {
				$kecamatan_id = $_POST["$model_nama"]["$attr"];
			}
			$kelurahan = null;
			if($kecamatan_id){
				$kelurahan = $model->getKelurahanItems($kecamatan_id);
				$kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
			}

			if($encode){
				echo CJSON::encode($kelurahan);
			} else {
				if(empty($kelurahan)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}else{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($kelurahan as $value=>$name)
					{
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}

}
?>
