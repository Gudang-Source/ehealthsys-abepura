<?php

class LaporanController extends MyAuthController {

    public $path_view = 'rawatJalan.views.laporan.';
    public function actionLaporanSensusHarian() {
        $model = new RJLaporansensusharian('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        if (isset($_GET['RJLaporansensusharian'])) {
            $model->attributes = $_GET['RJLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'sensus._table', array('model'=>$model),true);
                }else{
                   $this->render($this->path_view.'sensus/adminSensus', array(
            'model' => $model,
        ));
                }

       
    }

    public function actionPrintLaporanSensusHarian() {
        $model = new RJLaporansensusharian('search');
        $ruanganId = Yii::app()->user->getState('ruangan_id');
        $ruanganNama = RuanganM::model()->findByPk($ruanganId);
        $judulLaporan = 'Laporan Sensus Harian Rawat Jalan <br/> '.$ruanganNama->ruangan_nama.'';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJLaporansensusharian'])) {
            $model->attributes = $_REQUEST['RJLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporansensusharian']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'sensus/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikSensusHarian() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporansensusharian('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        
        if (isset($_GET['RJLaporansensusharian'])) {
            $model->attributes = $_GET['RJLaporansensusharian'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_akhir']);
        }
        
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanKunjungan() {
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
			echo $this->renderPartial($this->path_view.'kunjungan._tableKunjungan', array('model'=>$model),true);
		}else{
			$this->render($this->path_view.'kunjungan/adminKunjungan', array(
			 'model' => $model,
			 ));
		 }
    }

    public function actionPrintLaporanKunjungan() {
        $model = new RJInfokunjunganrjV('search');
        $judulLaporan = 'Laporan Info Kunjungan Pasien Rawat Jalan';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Info Kunjungan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_REQUEST['RJInfokunjunganrjV'])) {
            $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'kunjungan/_printKunjungan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjungan() {
        $this->layout = '//layouts/iframe';
        $model = new RJInfokunjunganrjV('searchGrafik');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Info Kunjungan';
        $data['type'] = isset($_REQUEST['type'])?$_REQUEST['type']:null;
        if (isset($_GET['RJInfokunjunganrjV'])) {
            $model->attributes = $_GET['RJInfokunjunganrjV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
        }
        
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBukuRegister() {
        $model = new RJBukuregisterpasien('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        if (isset($_GET['RJBukuregisterpasien'])) {
            $model->attributes = $_GET['RJBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'bukuRegister._tableBukuRegister', array('model'=>$model),true);
                }else{
                  $this->render($this->path_view.'bukuRegister/adminBukuRegister', array(
            'model' => $model,
        ));
        }     
        
    }

    public function actionPrintLaporanBukuRegister() {
        $model = new RJBukuregisterpasien('search');
        $judulLaporan = 'Laporan Buku Register Pasien Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RJBukuregisterpasien'])) {
            $model->attributes = $_REQUEST['RJBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJBukuregisterpasien']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'bukuRegister/_printBukuRegister';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikBukuRegister() {
        $this->layout = '//layouts/iframe';
        $model = new RJBukuregisterpasien('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJBukuregisterpasien'])) {
            $model->attributes = $_GET['RJBukuregisterpasien'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_akhir']);
        }
        
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporan10BesarPenyakit() {
        $model = new RJLaporan10besarpenyakit('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y 23:59:59');
        $model->jumlahTampil = 10;

        if (isset($_GET['RJLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['RJLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'10Besar._table10Besar', array('model'=>$model),true);
                }else{
                   $this->render($this->path_view.'10Besar/admin10BesarPenyakit', array(
                    'model' => $model,
                ));
                }
        
    }

    public function actionPrintLaporan10BesarPenyakit() {
        $model = new RJLaporan10besarpenyakit('search');
        $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RJLaporan10besarpenyakit'])) {
            $model->attributes = $_REQUEST['RJLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporan10besarpenyakit']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'10Besar/_print10Besar';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafik10BesarPenyakit() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporan10besarpenyakit('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['RJLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_akhir']);
        }
               
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanCaraMasukPasien() {
        $model = new RJLaporancaramasukpasienrj('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_id');
        $model->asalrujukan_id = $asalrujukan;
        $model->is_rujukan = 'non_rujukan';
        $filter=array();
        if (isset($_GET['RJLaporancaramasukpasienrj']))
        {
            $model->attributes = $_GET['RJLaporancaramasukpasienrj'];
            $model->is_rujukan = $_GET['RJLaporancaramasukpasienrj']['is_rujukan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_akhir']);
        }

        $this->render($this->path_view.'caraMasuk/adminCaraMasukPasien', array(
            'model' => $model, 'filter'=>$filter
        ));
    }

    public function actionPrintLaporanCaraMasukPasien() {
        $model = new RJLaporancaramasukpasienrj('search');
        $judulLaporan = 'Laporan Cara Masuk Pasien Rawat Jalan';
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_REQUEST['type'];
        $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'),'asalrujukan_id','asalrujukan_id');
        $model->asalrujukan_id = $asalrujukan;
        $model->is_rujukan = 'non_rujukan';
        $filter=array();
        if (isset($_REQUEST['RJLaporancaramasukpasienrj'])) {
            $model->attributes = $_REQUEST['RJLaporancaramasukpasienrj'];
            $model->is_rujukan = $_GET['RJLaporancaramasukpasienrj']['is_rujukan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporancaramasukpasienrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporancaramasukpasienrj']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'caraMasuk/_printCaraMasuk';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target,$filter);
    }

    public function actionFrameGrafikLaporanCaraMasukPasien() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporancaramasukpasienrj('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporancaramasukpasienrj'])) {
            $model->attributes = $_GET['RJLaporancaramasukpasienrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanTindakLanjut() {
        $model = new RJLaporantindaklanjutrj('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $temp = array();
        foreach (LookupM::getItems('carakeluar') as $i=>$data){
            $temp[] = strtoupper($data);
        }
        $model->carakeluar = $temp;
        
        if (isset($_GET['RJLaporantindaklanjutrj'])) {
            $model->attributes = $_GET['RJLaporantindaklanjutrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'tindakLanjut._tableTindakLanjut', array('model'=>$model),true);
                }else{
                   $this->render($this->path_view.'tindakLanjut/adminTindakLanjut', array(
            'model' => $model,
        ));
                }
        
       
    }

    public function actionPrintLaporanTindakLanjut() {
        $model = new RJLaporantindaklanjutrj('search');
        $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
        $data['type'] = $_REQUEST['type'];
        
         if (isset($_GET['RJLaporantindaklanjutrj'])) {
            $model->attributes = $_GET['RJLaporantindaklanjutrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'tindakLanjut/_printTindakLanjut';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanTindakLanjut() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporantindaklanjutrj('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik 
        $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporantindaklanjutrj'])) {
            $model->attributes = $_GET['RJLaporantindaklanjutrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanKonsulAntarPoli() {
        $model = new RJLaporankonsulantarpoli('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $ruanganrawatjalan = CHtml::listData(RuanganrawatjalanV::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
        $model->ruangantujuan_id = $ruanganrawatjalan;
        if (isset($_GET['RJLaporankonsulantarpoli'])) {
            $model->attributes = $_GET['RJLaporankonsulantarpoli'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'konsulPoli._tableKonsul', array('model'=>$model),true);
                }else{
                    $this->render($this->path_view.'konsulPoli/adminKonsulAntarPoli', array(
                     'model' => $model,
                ));
        
                }
    }

    public function actionPrintLaporanKonsulAntarPoli() {
        $model = new RJLaporankonsulantarpoli('search');
        $judulLaporan = 'Laporan Konsul Antar Poli Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsul Antar Poli';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RJLaporankonsulantarpoli'])) {
            $model->attributes = $_REQUEST['RJLaporankonsulantarpoli'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporankonsulantarpoli']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporankonsulantarpoli']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'konsulPoli/_printKonsulPoli';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanKonsulAntarPoli() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporankonsulantarpoli('searchGrafik');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Konsul Antar Poli';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporankonsulantarpoli'])) {
            $model->attributes = $_GET['RJLaporankonsulantarpoli'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanKepenunjang() {
        $model = new RJLaporankepenunjangrj('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');  

        $kepenunjang = CHtml::listData(RuanganpenunjangV::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
        $model->ruanganpenunj_id = $kepenunjang;
        if (isset($_GET['RJLaporankepenunjangrj'])) {
            $model->attributes = $_GET['RJLaporankepenunjangrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_akhir']);
        }

         if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'kepenunjang._tableKepenunjang', array('model'=>$model),true);
                }else{
                   $this->render($this->path_view.'kepenunjang/adminKepenunjang', array(
                    'model' => $model,
                ));

                }
       
    }

    public function actionPrintLaporanKepenunjang() {
        $model = new RJLaporankepenunjangrj('search');
        $judulLaporan = 'Laporan Kepenunjang Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kepenunjang';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RJLaporankepenunjangrj'])) {
            $model->attributes = $_REQUEST['RJLaporankepenunjangrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporankepenunjangrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporankepenunjangrj']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'kepenunjang/_printKepenunjang';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanKepenunjang() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporankepenunjangrj('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kepenunjang';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporankepenunjangrj'])) {
            $model->attributes = $_GET['RJLaporankepenunjangrj'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBiayaPelayanan() {
        $model = new RJLaporanbiayapelayanan('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $filter=array();
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['RJLaporanbiayapelayanan'])) {
            $model->attributes = $_GET['RJLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'biayaPelayanan._tableBiayaPelayanan', array('model'=>$model),true);
                }else{
                   $this->render($this->path_view.'biayaPelayanan/adminBiayaPelayanan', array(
                    'model' => $model, 'filter'=>$filter
                    ));

                }

        
    }

    public function actionPrintLaporanBiayaPelayanan() {
        $model = new RJLaporanbiayapelayanan('search');
        $judulLaporan = 'Laporan Biaya Pelayanan Rawat Jalan';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Biaya Pelayanan';
        $data['type'] = $_REQUEST['type'];
        
        $filter=array();
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        
        if (isset($_REQUEST['RJLaporanbiayapelayanan'])) {
            $model->attributes = $_REQUEST['RJLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporanbiayapelayanan']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'biayaPelayanan/_printBiayaPelayanan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBiayaPelayanan() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporanbiayapelayanan('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Biaya Pelayanan';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporanbiayapelayanan'])) {
            $model->attributes = $_GET['RJLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    public function actionLaporanPendapatanRuangan() {
        $model = new RJLaporanpendapatanruangan('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['RJLaporanpendapatanruangan'])) {
            $model->attributes = $_GET['RJLaporanpendapatanruangan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
        }


        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'pendapatanRuangan._tablePendapatanRuangan', array('model'=>$model),true);
                }else{
                   $this->render($this->path_view.'pendapatanRuangan/adminPendapatanRuangan', array(
                    'model' => $model,
                ));

                }
       
    }

    public function actionPrintLaporanPendapatanRuangan() {
        $model = new RJLaporanpendapatanruangan('search');
        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Jalan';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RJLaporanpendapatanruangan'])) {
            $model->attributes = $_REQUEST['RJLaporanpendapatanruangan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporanpendapatanruangan']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'pendapatanRuangan/_printPendapatanRuangan';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatanRuangan() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporanpendapatanruangan('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporanpendapatanruangan'])) {
            $model->attributes = $_GET['RJLaporanpendapatanruangan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    public function actionLaporanJasaInstalasi() {
        $model = new RJLaporanjasainstalasi('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $filter= array();
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $model->tindakansudahbayar_id = CustomFunction::getStatusBayar();
        if (isset($_GET['RJLaporanjasainstalasi'])) {
            $model->attributes = $_GET['RJLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_akhir']);
        }

        if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'jasaInstalasi._tableJasaInstalasi', array('model'=>$model),true);
                }else{
                    $this->render($this->path_view.'jasaInstalasi/adminJasaInstalasi', array(
                    'model' => $model, 'filter'=>$filter
                ));

                }

       
    }

    public function actionPrintLaporanJasaInstalasi() {
        $model = new RJLaporanjasainstalasi('search');
        $judulLaporan = 'Laporan Jasa Instalasi Rawat Jalan';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_REQUEST['type'];
        
        if (isset($_REQUEST['RJLaporanjasainstalasi'])) {
            $model->attributes = $_REQUEST['RJLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporanjasainstalasi']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'jasaInstalasi/_printJasaInstalasi';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaInstalasi() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporanjasainstalasi('searchGrafik');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporanjasainstalasi'])) {
            $model->attributes = $_GET['RJLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
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
    
    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new RJLaporanpemakaiobatalkesV;
        $model->unsetAttributes();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $jenisObat =CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;
        if(isset($_GET['RJLaporanpemakaiobatalkesV']))
        {
            $model->attributes = $_GET['RJLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesV']['tgl_akhir']);
        }

         if (Yii::app()->request->isAjaxRequest) {
                    echo $this->renderPartial($this->path_view.'pemakaiObatAlkes._tablePemakaiObatAlkes', array('model'=>$model),true);
                }else{
                  $this->render($this->path_view.'pemakaiObatAlkes/adminPemakaiObatAlkes',array('model'=>$model));

                }

        
    }

    public function actionPrintLaporanPemakaiObatAlkes() {
        $model = new RJLaporanpemakaiobatalkesV('search');
        $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Jalan';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_REQUEST['type'];
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $jenisObat =CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;
        if (isset($_REQUEST['RJLaporanpemakaiobatalkesV'])) {
            $model->attributes = $_REQUEST['RJLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'pemakaiObatAlkes/_printPemakaiObatAlkes';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new RJLaporanpemakaiobatalkesV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = isset($_GET['type'])?$_GET['type']:null;
        if (isset($_GET['RJLaporanpemakaiobatalkesV'])) {
            $model->attributes = $_GET['RJLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
                
        $this->render($this->path_view.'_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
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
	
	public function actionGetPenjaminPasienForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

           if($encode) {
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
					$criteria = new CDbCriteria();
					$criteria->addCondition('carabayar_id = '.$carabayar_id);
					$criteria->addCondition('penjamin_aktif is true');
					$criteria->order = 'penjamin_nama ASC';
                    $penjamindata = PenjaminpasienM::model()->findAll($criteria);
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');
                    echo CHtml::hiddenField(''.$namaModel.'[penjamin_id]');
                    echo "<div style='margin-left:0px;'>".CHtml::checkBox('checkAllCaraBayar',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                    echo "</div><br/>";
                    $i = 0;
                    if (count($penjamin) > 0){
                        foreach($penjamin as $value=>$name) {
                            echo '<label class="checkbox">';
                            echo CHtml::checkBox(''.$namaModel.'[penjamin_id][]', true, array('value'=>$value));
                            echo '<label for="'.$namaModel.'_penjamin_id_'.$i.'">'.$name.'</label></label>';

                            $i++;
                        }
                    } else{
                        echo '<label>Data Tidak Ditemukan</label>';
                    }
                }
           }
        }
        Yii::app()->end();
    }

}