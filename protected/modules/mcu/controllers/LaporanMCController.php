<?php
Yii::import('rawatJalan.controllers.LaporanController');
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.views.laporan');
class LaporanMCController extends LaporanController {
	
	public $path_view_mcu = 'mcu.views.laporanMC.';
	
	// Laporan Penjamin Pasien //
	public function actionLaporanPenjaminPasien() {
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial($this->path_view_mcu.'penjaminPasien._table', array('model'=>$model),true);
		}else{
			$this->render($this->path_view_mcu.'penjaminPasien/admin', array(
			 'model' => $model,
			 ));
		 }
    }

    public function actionPrintLaporanPenjaminPasien() {
        $model = new RJInfokunjunganrjV('search');
        $judulLaporan = 'Laporan Penjamin Pasien';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Penjamin Pasien';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJInfokunjunganrjV'])) {
            $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view_mcu.'penjaminPasien/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPenjaminPasien() {
        $this->layout = '//layouts/iframe';
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Penjamin Pasien';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $this->render($this->path_view_mcu.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
	// end Laporan Penjamin Pasien
	
	// Laporan MCU Perusahaan
	public function actionLaporanMcuPerusahaan() {
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
		$model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial($this->path_view_mcu.'mcuPerusahaan._table', array('model'=>$model),true);
		}else{
			$this->render($this->path_view_mcu.'mcuPerusahaan/admin', array(
			 'model' => $model,
			 ));
		 }
    }

    public function actionPrintLaporanMcuPerusahaan() {
        $model = new RJInfokunjunganrjV('search');
        $judulLaporan = 'Laporan Medical Check Up Perusahaan';
		$model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Medical Check Up Perusahaan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJInfokunjunganrjV'])) {
            $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view_mcu.'mcuPerusahaan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikMcuPerusahaan() {
        $this->layout = '//layouts/iframe';
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
		$model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

        //Data Grafik
        $data['title'] = 'Grafik Medical Check Up Perusahaan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $this->render($this->path_view_mcu.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
	// end Laporan MCU Perusahaan
	
	// Laporan Peserta MCU Perusahaan
	public function actionLaporanPesertaMcuPerusahaan() {
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
		$model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial($this->path_view_mcu.'pesertaMcuPerusahaan._table', array('model'=>$model),true);
		}else{
			$this->render($this->path_view_mcu.'pesertaMcuPerusahaan/admin', array(
			 'model' => $model,
			 ));
		 }
    }

    public function actionPrintLaporanPesertaMcuPerusahaan() {
        $model = new RJInfokunjunganrjV('search');
        $judulLaporan = 'Laporan Peserta Medical Check Up Perusahaan';
		$model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJInfokunjunganrjV'])) {
            $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view_mcu.'pesertaMcuPerusahaan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPesertaMcuPerusahaan() {
        $this->layout = '//layouts/iframe';
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
		$model->carabayar_id = Params::CARABAYAR_ID_PERUSAHAAN;

        //Data Grafik
        $data['title'] = 'Grafik Peserta Medical Check Up Perusahaan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $this->render($this->path_view_mcu.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
	// end Laporan Peserta MCU Perusahaan
	
	// Laporan Peserta MCU Perorangan
	public function actionLaporanPesertaMcuPerorangan() {
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial($this->path_view_mcu.'pesertaMcuPerorangan._table', array('model'=>$model),true);
		}else{
			$this->render($this->path_view_mcu.'pesertaMcuPerorangan/admin', array(
			 'model' => $model,
			 ));
		 }
    }

    public function actionPrintLaporanPesertaMcuPerorangan() {
        $model = new RJInfokunjunganrjV('search');
        $judulLaporan = 'Laporan Peserta Medical Check Up Perorangan';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJInfokunjunganrjV'])) {
            $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view_mcu.'pesertaMcuPerorangan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPesertaMcuPerorangan() {
        $this->layout = '//layouts/iframe';
        $model = new RJInfokunjunganrjV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Peserta Medical Check Up Perusahaan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $this->render($this->path_view_mcu.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
	// end Laporan Peserta MCU Perorangan
	
	/**
	* set dropdown penjamin pasien dari carabayar_id
	* @param type $encode
	* @param type $namaModel
	*/
	public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
	{
	   if(Yii::app()->request->isAjaxRequest) {
		   $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
		  if($encode)
		  {
			   echo CJSON::encode($penjamin);
		  } else {
			   if(empty($carabayar_id)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   } else {
				   $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
				   if(count($penjamin) > 1)
				   {
					   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   }
				   $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
				   foreach($penjamin as $value=>$name) {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		  }
	   }
	   Yii::app()->end();
	}
}