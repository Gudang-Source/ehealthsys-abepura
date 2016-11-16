<?php

class LaporanAkuntansiController extends MyAuthController {

    public function actionLaporanJurnal() {
        $model = new AKLaporanJurnalV;
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
            
        if (isset($_GET['AKLaporanJurnalV'])) {
            $model->attributes = $_GET['AKLaporanJurnalV'];
            $model->jns_periode = $_GET['AKLaporanJurnalV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['AKLaporanJurnalV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['AKLaporanJurnalV']['bln_akhir']);
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
        $this->render('jurnal/admin', array('model' => $model));
    }

    public function actionPrintLaporanJurnal() {
        $model = new AKLaporanJurnalV('searchPrint');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Jurnal';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Jurnal Berdasarkan Jenis Jurnal';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['AKLaporanJurnalV'])) {
            $model->attributes = $_REQUEST['AKLaporanJurnalV'];
            $model->jns_periode = $_GET['AKLaporanJurnalV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['AKLaporanJurnalV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['AKLaporanJurnalV']['bln_akhir']);
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
        $target = 'jurnal/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJurnal() {
        $this->layout = '//layouts/iframe';
        $model = new AKLaporanJurnalV('search');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jurnal Berdasarkan Jenis Jurnal';
        $data['type'] = $_GET['type'];
        if (isset($_GET['AKLaporanJurnalV'])) {
            $model->attributes = $_GET['AKLaporanJurnalV'];
            $model->jns_periode = $_GET['AKLaporanJurnalV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['AKLaporanJurnalV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['AKLaporanJurnalV']['bln_akhir']);
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

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanBukuBesar() {
        $format = new MyFormatter();
        $modelLaporan = new AKLaporanbukubesarV('searchLaporan');
        $modelLaporan->unsetAttributes();
        $modelLaporan->periodeposting_id = isset(AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id) ? AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id : null;
        $criteria = new CDbCriteria;
        if (isset($_GET['AKLaporanbukubesarV'])) {
            $modelLaporan->attributes = $_GET['AKLaporanbukubesarV'];
            $modelLaporan->namarekening = $_GET['AKLaporanbukubesarV']['namarekening'];
            $modelLaporan->koderekening = $_GET['AKLaporanbukubesarV']['koderekening'];
            $modelLaporan->periodeposting_id = $_GET['AKLaporanbukubesarV']['periodeposting_id'];
            $modelLaporan->ruangan_id = $_GET['AKLaporanbukubesarV']['ruangan_id'];

            $criteria->compare('rekeningjurnal5_nama', $_GET['AKLaporanbukubesarV']['namarekening']);
            $criteria->compare('kdrekening5', $_GET['AKLaporanbukubesarV']['koderekening']);
            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
            if (!empty($modelLaporan->ruangan_id)) {
                $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
            }
            if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
                $qr_rekeningjurnal5_nama = null;
            } else {
                $qr_rekeningjurnal5_nama = "AND rekeningjurnal5_nama = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'";
            }
            if (empty($_GET['AKLaporanbukubesarV']['koderekening'])) {
                $qr_kdrekening5 = null;
            } else {
                $qr_kdrekening5 = "AND kdrekening = '" . $_GET['AKLaporanbukubesarV']['koderekening'] . "'";
            }
        } else {
            $qr_rekeningjurnal5_nama = null;
            $qr_kdrekening5 = null;
            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
        }
		$criteria->group = 'instalasi_id,instalasi_nama,ruangan_id,ruangan_nama,rekperiod_id,perideawal,sampaidgn,deskripsi,isclosing,konfiganggaran_id,deskripsiperiode,tglanggaran,sd_tglanggaran,tglrencanaanggaran,sd_tglrencanaanggaran,tglrevisianggaran,sd_tglrevisianggaran,digitnilaianggaran,isclosing_anggaran,'
				. 'periodeposting_id,periodeposting_nama,tglperiodeposting_awal,tglperiodeposting_akhir,deskripsiperiodeposting,bukubesar_id,rekening5_nb,uraiantransaksi,saldodebit,'
				. 'saldokredit,saldoakhirberjalan,jurnalrekening_id,jenisjurnal_id,jenisjurnal_nama,tglbuktijurnal,nobuktijurnal,kodejurnal,noreferensi,tglreferensi,nobku,urianjurnal,jurnaldetail_id,'
				. 'rekeningjurnal1_kode,rekeningjurnal2_kode,rekeningjurnal3_kode,rekeningjurnal4_kode,rekeningjurnal5_kode,uraiantransaksijurnal,saldodebitjurnal,saldokreditjurnal,koreksi,'
				. 'catatan,jurnalposting_id,tgljurnalpost,keterangan,rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id,rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5, nourut, no_referensi,rekeningjurnal5_saldonormal,rekeningjurnal1_nama, rekeningjurnal2_nama, rekeningjurnal3_nama,rekeningjurnal4_nama,rekeningjurnal5_nama,tglbukubesar';
//		$criteria->select = $criteria->group.',sum(saldodebitjurnal) as saldodebitjurnal, sum(saldokreditjurnal) as saldokreditjurnal';
        $criteria->order = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id, tglbukubesar, nourut';
        $model = AKLaporanbukubesarV::model()->findAll($criteria);

        if ($modelLaporan->ruangan_id == '') {
            $query_ruangan_id = null;
        } else {
            $query_ruangan_id = "ruangan_id=" . $modelLaporan->ruangan_id . " AND";
        }

        $criteria2 = new CDbCriteria();
        $criteria2->select = 'count(rekeningjurnal5_nama) as urutan';
        if (!empty($modelLaporan->ruangan_id)) {
            $criteria2->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
        }
        if (!empty($modelLaporan->periodeposting_id)) {
            $criteria2->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
        }
        if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
            $qr_rekeningjurnal5_nama = null;
        } else {
            $criteria2->addCondition("rekeningjurnal5_nama = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'");
        }
        if (empty($_GET['AKLaporanbukubesarV']['koderekening'])) {
            $qr_kdrekening5 = null;
        } else {
            $criteria2->addCondition("kdrekening5 = '" . $_GET['AKLaporanbukubesarV']['koderekening'] . "'");
        }
        $criteria2->group = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id,rekeningjurnal5_nama';
        $jmlRekening = AKLaporanbukubesarV::model()->findAll($criteria2);
//        $sql= "select  from laporanbukubesar_v WHERE ".$query_ruangan_id."  ='".$modelLaporan->periodeposting_id."' ".$qr_rekeningjurnal5_nama." ".$qr_kdrekening5." group by ";
//        $jmlRekening = Yii::app()->db->createCommand($sql)->queryAll();

        $this->render('bukuBesar/admin', array(
            'model' => $model,
            'modelLaporan' => $modelLaporan,
            'jmlrekening' => $jmlRekening
        ));
    }

    public function actionPrintLaporanBukuBesar() {
        $format = new MyFormatter();
        $modelLaporan = new AKLaporanbukubesarV('searchLaporan');
        $modelLaporan->unsetAttributes();
        $periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode();
        $modelLaporan->periodeposting_id = isset($periodeposting_id->periodeposting_id)?$periodeposting_id->periodeposting_id:null;
        if (!empty($lap)) $modelLaporan->periodeposting_id = $lap->periodeposting_id;
        $criteria = new CDbCriteria;
        if (isset($_GET['AKLaporanbukubesarV'])) {
            $modelLaporan->attributes = $_GET['AKLaporanbukubesarV'];
            $modelLaporan->namarekening = $_GET['AKLaporanbukubesarV']['namarekening'];
            $modelLaporan->koderekening = $_GET['AKLaporanbukubesarV']['koderekening'];
            $modelLaporan->periodeposting_id = $_GET['AKLaporanbukubesarV']['periodeposting_id'];

            $criteria->compare('rekeningjurnal5_nama', $_GET['AKLaporanbukubesarV']['namarekening']);
            $criteria->compare('kdrekeningdetail5', $_GET['AKLaporanbukubesarV']['koderekening']);
            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }

            if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
                $qr_rekeningjurnal5_nama = null;
            } else {
                $qr_rekeningjurnal5_nama = "AND rekeningjurnal5_nama = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'";
            }
            if (empty($_GET['AKLaporanbukubesarV']['koderekening'])) {
                $qr_kdrekening5 = null;
            } else {
                $qr_kdrekening5 = "AND kdrekeningdetail5 = '" . $_GET['AKLaporanbukubesarV']['koderekening'] . "'";
            }
        } else {
            $qr_rekeningjurnal5_nama = null;
            $qr_kdrekening5 = null;
            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
        }
        $criteria->compare('ruangan_id', $_GET['AKLaporanbukubesarV']['ruangan_id']);
        $criteria->order = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id, tglbukubesar, nourut';
        $model = AKLaporanbukubesarV::model()->findAll($criteria);

        if ($modelLaporan->ruangan_id == '') {
            $query_ruangan_id = null;
        } else {
            $query_ruangan_id = "ruangan_id=" . $modelLaporan->ruangan_id . " AND";
        }
        $criteria2 = new CDbCriteria();
        $criteria2->select = 'count(rekeningjurnal5_nama) as urutan';
        if (!empty($modelLaporan->ruangan_id)) {
            $criteria2->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
        }
        if (!empty($modelLaporan->periodeposting_id)) {
            $criteria2->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
        }
        if (empty($_GET['AKLaporanbukubesarV']['namarekening'])) {
            $qr_rekeningjurnal5_nama = null;
        } else {
            $criteria2->addCondition("rekeningjurnal5_nama = '" . $_GET['AKLaporanbukubesarV']['namarekening'] . "'");
        }
        if (empty($_GET['AKLaporanbukubesarV']['koderekening'])) {
            $qr_kdrekening5 = null;
        } else {
            $criteria2->addCondition("kdrekeningdetail5 = '" . $_GET['AKLaporanbukubesarV']['koderekening'] . "'");
        }
        $criteria2->group = 'rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id,rekeningjurnal5_nama';
        $jmlRekening = AKLaporanbukubesarV::model()->findAll($criteria2);
//        $sql= "select count(rekeningjurnal5_nama) as urutan from LaporanBukuBesar_V WHERE ".$query_ruangan_id." periodeposting_id ='".$modelLaporan->periodeposting_id."'".$qr_rekeningjurnal5_nama." ".$qr_kdrekening5." group by rekeningjurnal5_nama, rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id order by rekeningjurnal1_id, rekeningjurnal2_id,rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id";
//        $jmlRekening = Yii::app()->db->createCommand($sql)->queryAll();

        if ($_REQUEST['caraPrint'] == 'GRAFIK') {
            $model = new AKLaporanbukubesarV;

            if (isset($_REQUEST['AKLaporanbukubesarV'])) {
                $model->attributes = $_REQUEST['AKLaporanbukubesarV'];
                $model->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
            }
        }
        $judulLaporan = 'Laporan Buku Besar Berdasarkan Nama Rekening';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Buku Besar Berdasarkan Nama Rekening';
        isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'bukuBesar/_print';

        $periodeposting_id = AKPeriodepostingM::model()->findByPk($modelLaporan->periodeposting_id);

        $periode = isset($periodeposting_id->periodeposting_nama) ? $periodeposting_id->periodeposting_nama : "";

        $caraPrint = $_REQUEST['caraPrint'];
        $judulLaporan = 'Laporan Buku Besar';

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('bukuBesar/_print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'jmlRekening' => $jmlRekening, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('bukuBesar/_print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'jmlRekening' => $jmlRekening, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = 'L';                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
            $mpdf->tMargin = 5;
            $mpdf->WriteHTML($this->renderPartial('bukuBesar/_print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'jmlRekening' => $jmlRekening, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    public function actionFrameGrafikLaporanBukuBesar() {
        $this->layout = '//layouts/iframe';
        $model = new AKLaporanbukubesarV('search');
        $model->tgl_awal = date('d M Y 00:00:00');
        $model->tgl_akhir = date('d M Y H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Besar Berdasarkan Nama Rekening';
        $data['type'] = $_GET['type'];
        if (isset($_GET['AKLaporanbukubesarV'])) {
            $model->attributes = $_GET['AKLaporanbukubesarV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanbukubesarV']['tgl_akhir']);
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target) {
        $format = new MyFormatter();
        $periode = $this->parserTanggal($model->tgl_awal) . ' s/d ' . $this->parserTanggal($model->tgl_akhir);

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    protected function parserTanggal($tgl) {
        $tgl = explode(' ', $tgl);
        $result = array();
        foreach ($tgl as $row) {
            if (!empty($row)) {
                $result[] = $row;
            }
        }
        return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
    }

    public function actionLaporanArusKas() {
        $format = new MyFormatter();
        $model = new AKLaporanaruskasV();
        $model->unsetAttributes();
//		$model->periodeposting_id = AKLaporanaruskasV::model()->getTglPeriode()->periodeposting_id;
        if (isset($_GET['AKLaporanaruskasV'])) {
            $model->attributes = $_GET['AKLaporanaruskasV'];
            $model->ruangan_id = $_GET['AKLaporanaruskasV']['ruangan_id'];
            $model->periodeposting_id = $_GET['AKLaporanaruskasV']['periodeposting_id'];
        }
        $this->render('aruskas/admin', array('model' => $model));
    }

    public function actionPrintLaporanArusKas() {
        $model = new AKLaporanaruskasV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $periode = '';
//		$model->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
        $criteria = new CDbCriteria;
        if (isset($_GET['AKLaporanaruskasV'])) {
            $model->attributes = $_GET['AKLaporanaruskasV'];
            $model->ruangan_id = $_GET['AKLaporanaruskasV']['ruangan_id'];
            $model->periodeposting_id = !empty($_GET['AKLaporanaruskasV']['periodeposting_id']) ? $_GET['AKLaporanaruskasV']['periodeposting_id'] : null;
        } else {
            if (!empty($model->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $model->periodeposting_id);
            }
            if (!empty($model->ruangan_id)) {
                $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
            }
        }

        if (!empty($model->periodeposting_id)) {
            $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);
            $periode = $periodeposting_id->periodeposting_nama;
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $judulLaporan = 'Laporan Arus Kas';

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('aruskas/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('aruskas/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = 'L';                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
            $mpdf->tMargin = 5;
            $mpdf->WriteHTML($this->renderPartial('aruskas/_print', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    public function actionLaporanNeraca() {
        $modelLaporan = new AKLaporanneracaV('searchNeraca');
        $modelLaporan->unsetAttributes();
//		$modelLaporan->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
        $criteria = new CDbCriteria;
        if (isset($_GET['AKLaporanneracaV'])) {
            $modelLaporan->attributes = $_GET['AKLaporanneracaV'];
            $format = new MyFormatter();
            $modelLaporan->ruangan_id = $_GET['AKLaporanneracaV']['ruangan_id'];
            $modelLaporan->periodeposting_id = $_GET['AKLaporanneracaV']['periodeposting_id'];

            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
            if (!empty($modelLaporan->ruangan_id)) {
                $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
            }
        } else {
            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
            if (!empty($modelLaporan->ruangan_id)) {
                $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
            }
        }

        $model = AKLaporanneracaV::model()->findAll($criteria);

        $this->render('neraca/admin', array(
            'model' => $model,
            'modelLaporan' => $modelLaporan,
        ));
    }

    public function actionPrintLaporanNeraca() {
        $modelLaporan = new AKLaporanneracaV('searchNeraca');
        $modelLaporan->unsetAttributes();
        $periode = '';
//		$modelLaporan->periodeposting_id = AKLaporanbukubesarV::model()->getTglPeriode()->periodeposting_id;
        $criteria = new CDbCriteria;
        if (isset($_GET['AKLaporanneracaV'])) {
            $modelLaporan->attributes = $_GET['AKLaporanneracaV'];
            $format = new MyFormatter();
            $modelLaporan->ruangan_id = $_GET['AKLaporanneracaV']['ruangan_id'];
            $modelLaporan->periodeposting_id = $_GET['AKLaporanneracaV']['periodeposting_id'];

            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
            if (!empty($modelLaporan->ruangan_id)) {
                $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
            }
        } else {
            if (!empty($modelLaporan->periodeposting_id)) {
                $criteria->addCondition('periodeposting_id = ' . $modelLaporan->periodeposting_id);
            }
            if (!empty($modelLaporan->ruangan_id)) {
                $criteria->addCondition('ruangan_id = ' . $modelLaporan->ruangan_id);
            }
        }

        $model = AKLaporanneracaV::model()->findAll($criteria);

        if (!empty($model->periodeposting_id)) {
            $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);
            $periode = $periodeposting_id->periodeposting_nama;
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $judulLaporan = 'Laporan Posisi Keuangan / Neraca';

        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('neraca/Print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('neraca/Print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = 'L';                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
            $mpdf->tMargin = 5;
            $mpdf->WriteHTML($this->renderPartial('neraca/Print', array('model' => $model, 'modelLaporan' => $modelLaporan, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    public function actionLaporanLabaRugi() {
        $model = new AKLaporanlabarugiV('searchLaporan');
        $format = new MyFormatter();
        $lap = AKLaporanlabarugiV::model()->getTglPeriode();
        if (!empty($lap)) $model->periodeposting_id = $lap->periodeposting_id;
        if (isset($_GET['AKLaporanlabarugiV'])) {
            $model->attributes = $_GET['AKLaporanlabarugiV'];
            $model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
        }
        $this->render('labarugi/admin', array('model' => $model));
    }

    public function actionPrintLaporanLabaRugi() {
        $model = new AKLaporanlabarugiV('searchLaporanPrint');
        $model->unsetAttributes();
        $judulLaporan = 'Laporan Laba Rugi';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Laba Rugi';
        isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
        if (isset($_REQUEST['AKLaporanlabarugiV'])) {
            $model->attributes = $_REQUEST['AKLaporanlabarugiV'];
            $format = new MyFormatter();
            $model->periodeposting_id = $_GET['AKLaporanlabarugiV']['periodeposting_id'];
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'labarugi/_print';

        $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

        $periode = $periodeposting_id->periodeposting_nama;

        $format = new MyFormatter();
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    public function actionLaporanPerubahanModal() {
        $format = new MyFormatter();
        $model = new AKLaporanperubahanmodalV('search');
        $model->unsetAttributes();

        $tgl_periode = AKLaporanperubahanmodalV::model()->getTglPeriode();
        $model->periodeposting_id = (isset($tgl_periode->periodeposting_id) ? $tgl_periode->periodeposting_id : NULL);

        if (isset($_GET['AKLaporanperubahanmodalV'])) {
            $model->attributes = $_GET['AKLaporanperubahanmodalV'];
            $model->periodeposting_id = (isset($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) ? $_GET['AKLaporanperubahanmodalV']['periodeposting_id'] : NULL);
            $model->ruangan_id = (isset($_GET['AKLaporanperubahanmodalV']['ruangan_id']) ? $_GET['AKLaporanperubahanmodalV']['ruangan_id'] : NULL);
        }

        $this->render('perubahanmodal/admin', array(
            'model' => $model,
            'format' => $format
        ));
    }

    public function actionPrintLaporanPerubahanModal() {
        $format = new MyFormatter();
        $model = new AKLaporanperubahanmodalV('search');
        $model->unsetAttributes();

        $judulLaporan = 'Laporan Perubahan Modal';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Arus Kas';
        isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : "";
        if (isset($_REQUEST['AKLaporanperubahanmodalV'])) {
            $model->attributes = $_REQUEST['AKLaporanperubahanmodalV'];
            $model->periodeposting_id = $_GET['AKLaporanperubahanmodalV']['periodeposting_id'];
          //  $model->ruangan_id = $_GET['AKLaporanperubahanmodalV']['ruangan_id'];
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'perubahanmodal/_print';

        $periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);

        $periode = $periodeposting_id->periodeposting_nama;

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format'=>$format));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format'=>$format));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format'=>$format), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    public function actionLaporanRasio() {
        $model = new AKSaldorekeningrasioV('search');
        $model->unsetAttributes();
        // $model->tglAwal = date('Y-m-d 00:00:00');
        // $model->tgl_akhir = date('Y-m-d H:i:s');

        $periode['tglAwal'] = date('Y-m-d 00:00:00');
        $periode['tglAkhir'] = date('Y-m-d H:i:s');

        if (isset($_GET['LaporanrasioV'])) {
            $model->attributes = $_GET['LaporanrasioV'];
            $format = new MyFormatter();
            // $model->tglAwal = $format->formatDateTimeMediumForDB($_GET['LaporanrasioV']['tglAwal']);
            // $model->tglAkhir = $format->formatDateTimeMediumForDB($_GET['LaporanrasioV']['tglAkhir']);
            // $model->ruangan_id = $_GET['LaporanrasioV']['ruangan_id'];
            // $periode['tglAwal']     = $model->tglAwal;
            // $periode['tglAkhir']    = $model->tglAkhir;
        }

        $this->render('rasio/admin', array('model' => $model, 'periode' => $periode));
    }

    public function actionprintLaporanRasio() {
        $model = new AKSaldorekeningrasioV('search');
        $model->unsetAttributes();
        $judulLaporan = 'Laporan Rasio';
        // $model->tglAwal     = date('Y-m-d 00:00:00');
        // $model->tglAkhir    = date('Y-m-d H:i:s');
        //Data Grafik       
        $data['title'] = 'Grafik Laporan Rasio';
        isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : '';
        if (isset($_REQUEST['LaporanrasioV'])) {
            $model->attributes = $_REQUEST['LaporanrasioV'];
//            $format = new MyFormatter();
            // $model->tglAwal = $format->formatDateTimeMediumForDB($_REQUEST['LaporanrasioV']['tglAwal']);
            // $model->tglAkhir = $format->formatDateTimeMediumForDB($_REQUEST['LaporanrasioV']['tglAkhir']);
            // $model->ruangan_id = $_GET['LaporanrasioV']['ruangan_id'];
        }
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'rasio/_print';

        $format = new MyFormatter();
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }

    /* Digunakan di Modul Akuntansi RND-8264
     * 
     */

    public function actionRekeningAkuntansi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
            $term = strtolower(trim($_GET['term']));

            $condition = "LOWER(nmrincianobyek) LIKE '%" . $term . "%' OR LOWER(nmobyek) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
            if (isset($_GET['id_jenis_rek'])) {
                $condition = "(LOWER(nmrincianobyek) LIKE '%" . $term . "%' OR LOWER(nmobyek) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rincianobyek_nb = 'D' OR obyek_nb = 'D' OR jenis_nb = 'D')";
                if ($_GET['id_jenis_rek'] == 'Kredit') {
                    $condition = "(LOWER(nmrincianobyek) LIKE '%" . $term . "%' OR LOWER(nmobyek) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rincianobyek_nb = 'K' OR obyek_nb = 'K' OR jenis_nb = 'K')";
                }
            }

            $criteria->addCondition($condition);
            $criteria->order = 'nmrincianobyek';
            $models = RekeningakuntansiV::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                if (isset($model->rincianobyek_id)) {
                    $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdobyek . "-" . $model->kdrincianobyek;
                    $nama_rekening = $model->nmrincianobyek;
                } else {
                    if (isset($model->obyek_id)) {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdobyek;
                        $nama_rekening = $model->nmobyek;
                    } else {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
                        $nama_rekening = $model->nmrekening3;
                    }
                }
                $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
                $returnVal[$i]['value'] = $nama_rekening;
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    public function actionRekeningKodeAkuntansi() {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();

            $term = strtolower($_GET['term']);
            $condition = "LOWER(kdrincianobyek) LIKE '%" . $term . "%' OR LOWER(kdobyek) LIKE '%" . $term . "%' OR LOWER(kdrekening3) LIKE '%" . $term . "%'";
            $criteria->addCondition($condition);
            $criteria->order = 'kdrincianobyek';
            $models = RekeningakuntansiV::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    if (isset($model->rincianobyek_id)) {
                        $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdobyek . "-" . $model->kdrincianobyek;
                        $nama_rekening = $model->kdrincianobyek;
                    } else {
                        if (isset($model->obyek_id)) {
                            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdobyek;
                            $nama_rekening = $model->kdobyek;
                        } else {
                            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
                            $nama_rekening = $model->kdrekening3;
                        }
                    }
                    $returnVal[$i]['label'] = $kode_rekening;
                    $returnVal[$i]['value'] = $nama_rekening;
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
            }
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

}

?>