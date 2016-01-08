<?php

class LaporanController extends MyAuthController {
    
    public function actionLaporanSensusHarian() {
        $model = new RMLaporansensuspenunjangV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $kunjungan = LookupM::getItems('kunjungan');
        $model->kunjungan = $kunjungan;
        if (isset($_GET['RMLaporansensuspenunjangV'])) {
            $model->attributes = $_GET['RMLaporansensuspenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporansensuspenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporansensuspenunjangV']['tgl_akhir']);
        }

        $this->render('sensus/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanSensusHarian() {
        $model = new RMLaporansensuspenunjangV('search');
        $judulLaporan = 'Laporan Sensus Harian Rehabilitasi Medis';
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporansensuspenunjangV'])) {
            $model->attributes = $_REQUEST['RMLaporansensuspenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporansensuspenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporansensuspenunjangV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'sensus/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikSensusHarian() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporansensuspenunjangV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['RMLaporansensuspenunjangV'])) {
            $model->attributes = $_GET['RMLaporansensuspenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporansensuspenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporansensuspenunjangV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanKunjungan() {
        $model = new RMLaporanpasienpenunjangV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $model->kunjungan = LookupM::getItems('kunjungan');
        if (isset($_GET['RMLaporanpasienpenunjangV'])) {
            $model->attributes = $_GET['RMLaporanpasienpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanpasienpenunjangV']['tgl_akhir']);
        }

        $this->render('kunjungan/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanKunjungan() {
        $model = new RMLaporanpasienpenunjangV('search');
        $judulLaporan = 'Laporan Kunjungan Rehabilitasi Medis';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kunjungan Rehabilitasi Medis';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporanpasienpenunjangV'])) {
            $model->attributes = $_REQUEST['RMLaporanpasienpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporanpasienpenunjangV']['tgl_akhir']);
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'kunjungan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjungan() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporanpasienpenunjangV('search');
        $model->tgl_awal = date('d M Y H:i:s');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['RMLaporanpasienpenunjangV'])) {
            $model->attributes = $_GET['RMLaporanpasienpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanpasienpenunjangV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporan10BesarPenyakit() {
        $model = new RMLaporan10besarpenyakit('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
        $model->jumlahTampil = 10;

        if (isset($_GET['RMLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['RMLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporan10besarpenyakit']['tgl_akhir']);
        }

        $this->render('10Besar/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporan10BesarPenyakit() {
        $model = new RMLaporan10besarpenyakit('search');
        $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Rehabilitasi Medis';

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Rehabilitasi Medis';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporan10besarpenyakit'])) {
            $model->attributes = $_REQUEST['RMLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporan10besarpenyakit']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '10Besar/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafik10BesarPenyakit() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporan10besarpenyakit('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Rehabilitasi Medis';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['RMLaporan10besarpenyakit'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporan10besarpenyakit']['tgl_akhir']);
        }
               
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new RMLaporanpemakaiobatalkesV;
        $model->unsetAttributes();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $jenisObat =CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;
        if(isset($_GET['RMLaporanpemakaiobatalkesV']))
        {
            $model->attributes = $_GET['RMLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
        $this->render('pemakaiObatAlkes/index',array('model'=>$model));
    }

    public function actionPrintLaporanPemakaiObatAlkes() {
        $model = new RMLaporanpemakaiobatalkesV('search');
        $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rehabilitasi Medis';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Rehabilitasi Medis';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporanpemakaiobatalkesV'])) {
            $model->attributes = $_REQUEST['RMLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemakaiObatAlkes/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporanpemakaiobatalkesV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Rehabilitasi Medis';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMLaporanpemakaiobatalkesV'])) {
            $model->attributes = $_GET['RMLaporanpemakaiobatalkesV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanpemakaiobatalkesV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanpemakaiobatalkesV']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanJasaInstalasi() {
        $model = new RMLaporanjasainstalasi('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $filter=true;
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $tindakan = array('sudah', 'belum');
        $model->tindakansudahbayar_id = $tindakan;
        if (isset($_GET['RMLaporanjasainstalasi'])) {
            $model->attributes = $_GET['RMLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanjasainstalasi']['tgl_akhir']);
        }

        $this->render('jasaInstalasi/index', array(
            'model' => $model, 'filter'=>$filter
        ));
    }

    public function actionPrintLaporanJasaInstalasi() {
        $model = new RMLaporanjasainstalasi('search');
        $judulLaporan = 'Laporan Jasa Instalasi Rehabilitasi Medis';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporanjasainstalasi'])) {
            $model->attributes = $_REQUEST['RMLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporanjasainstalasi']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'jasaInstalasi/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaInstalasi() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporanjasainstalasi('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMLaporanjasainstalasi'])) {
            $model->attributes = $_GET['RMLaporanjasainstalasi'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanjasainstalasi']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanjasainstalasi']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBiayaPelayanan() {
        $model = new RMLaporanbiayapelayanan('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['RMLaporanbiayapelayanan'])) {
            $model->attributes = $_GET['RMLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanbiayapelayanan']['tgl_akhir']);
        }

        $this->render('biayaPelayanan/index', array(
            'model' => $model, 'filter'=>$filter
        ));
    }

    public function actionPrintLaporanBiayaPelayanan() {
        $model = new RMLaporanbiayapelayanan('search');
        $judulLaporan = 'Laporan Biaya Pelayanan Rehabilitasi Medis';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Biaya Pelayanan Rehabilitasi Medis';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporanbiayapelayanan'])) {
            $model->attributes = $_REQUEST['RMLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporanbiayapelayanan']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'biayaPelayanan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBiayaPelayanan() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporanbiayapelayanan('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Biaya Pelayanan Rehabilitasi Medis';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMLaporanbiayapelayanan'])) {
            $model->attributes = $_GET['RMLaporanbiayapelayanan'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanbiayapelayanan']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanbiayapelayanan']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPendapatanRuangan() {
        $model = new RMLaporanpendapatanruanganV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $filter = true;
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['RMLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['RMLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanpendapatanruanganV']['tgl_akhir']);
        }

        $this->render('pendapatanRuangan/index', array(
            'model' => $model, 'filter'=>$filter
        ));
    }

    public function actionPrintLaporanPendapatanRuangan() {
        $model = new RMLaporanpendapatanruanganV('search');
        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rehabilitasi Medis';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporanpendapatanruanganV'])) {
            $model->attributes = $_REQUEST['RMLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporanpendapatanruanganV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatanRuangan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatanRuangan() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporanpendapatanruanganV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['RMLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporanpendapatanruanganV']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBukuRegister() {
        $model = new RMBukuregisterpenunjangV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');

        if (isset($_GET['RMBukuregisterpenunjangV'])) {
            $model->attributes = $_GET['RMBukuregisterpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMBukuregisterpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMBukuregisterpenunjangV']['tgl_akhir']);
        }

        $this->render('bukuRegister/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanBukuRegister() {
        $model = new RMBukuregisterpenunjangV('search');
        $judulLaporan = 'Laporan Buku Register Pasien Rehabilitasi Medis';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rehabilitasi Medis';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMBukuregisterpenunjangV'])) {
            $model->attributes = $_REQUEST['RMBukuregisterpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMBukuregisterpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMBukuregisterpenunjangV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'bukuRegister/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikBukuRegister() {
        $this->layout = '//layouts/iframe';
        $model = new RMBukuregisterpenunjangV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Rehabilitasi Medis';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMBukuregisterpenunjangV'])) {
            $model->attributes = $_GET['RMBukuregisterpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMBukuregisterpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMBukuregisterpenunjangV']['tgl_akhir']);
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanCaraMasukPasien() {
        $model = new RMLaporancaramasukpenunjangV('search');
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $filter=true;
        $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
        $model->asalrujukan_id = $asalrujukan;
        $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'),'ruangan_id','ruangan_id');
        $model->ruanganasal_id = $ruanganasal;
        if (isset($_GET['RMLaporancaramasukpenunjangV'])) {
            $model->attributes = $_GET['RMLaporancaramasukpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporancaramasukpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporancaramasukpenunjangV']['tgl_akhir']);
        }

        $this->render('caraMasuk/index', array(
            'model' => $model, 'filter' => $filter
        ));
    }

    public function actionPrintLaporanCaraMasukPasien() {
        $model = new RMLaporancaramasukpenunjangV('search');
        $judulLaporan = 'Laporan Cara Masuk Pasien Rehabilitasi Medis';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['RMLaporancaramasukpenunjangV'])) {
            $model->attributes = $_REQUEST['RMLaporancaramasukpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RMLaporancaramasukpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RMLaporancaramasukpenunjangV']['tgl_akhir']);
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'caraMasuk/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanCaraMasukPasien() {
        $this->layout = '//layouts/iframe';
        $model = new RMLaporancaramasukpenunjangV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_GET['type'];
        if (isset($_GET['RMLaporancaramasukpenunjangV'])) {
            $model->attributes = $_GET['RMLaporancaramasukpenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['RMLaporancaramasukpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RMLaporancaramasukpenunjangV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();

        $periode = $format->formatDateTimeId($model->tgl_awal).' s/d '.$format->formatDateTimeId($model->tgl_akhir);

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

}