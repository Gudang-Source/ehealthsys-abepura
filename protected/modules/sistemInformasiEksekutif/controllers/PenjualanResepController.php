<?php

class PenjualanResepController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.penjuanganResep.';

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * menampilkan halaman dashboard (iframe)
     * beberapa menggunakan DAO (createCommand) agar lebih cepat
     */
    public function actionSetIFrameDashboard() {

        $this->layout = '//layouts/iframeNeon';
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $dataPie = array();
        $dataPieChart = array();
        $dataBarLineChart = array();

        $format = new MyFormatter();
        $model = new SELappenjualanresepR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SELappenjualanresepR'])) {
            $model->attributes = $_GET['SELappenjualanresepR'];
            $model->jns_periode = $_GET['SELappenjualanresepR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SELappenjualanresepR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SELappenjualanresepR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SELappenjualanresepR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SELappenjualanresepR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SELappenjualanresepR']['thn_awal'];
            $model->thn_akhir = $_GET['SELappenjualanresepR']['thn_akhir'];
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal . " 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }
        //=== chart ===
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, sum(penjualanresep) as jumlah_resep, sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan
                    FROM lappenjualanresep_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY periode
                    ORDER BY periode ASC
            ";
                break;
        case 'tahun' : $sql = "
                    SELECT 
                    date_trunc('year', tanggal) as periode, sum(penjualanresep) as jumlah_resep, sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan
                    FROM lappenjualanresep_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY periode
                    ORDER BY periode ASC

                ";
                break;
            default : $sql = "
                    SELECT 
                    date_trunc('day', tanggal) as periode, sum(penjualanresep) as jumlah_resep, sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan
                    FROM lappenjualanresep_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY periode
                    ORDER BY periode ASC

            ";
        }

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarLineChart = $result;

        $sql = "
                    SELECT 
                    sum(penjualanresep) as jumlah_resep, sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan
                    FROM lappenjualanresep_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'                   
                    ";


        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataPie = $result;
        $color = array(
            "1"=> "#FF6600",
            "2"=> "#FCD202",
            "3"=> "#B0DE09",
            "4"=> "#0D8ECF",
            "5"=> "#2A0CD0",
            );
        $i = 1;
       
        foreach ($dataPie as $key => $value) {
            if ($key == "jumlah_resep") {
                $key = "Resep";
            } elseif ($key == "jumlah_resepluar") {
                $key = "Resep Luar";
            } elseif ($key == "jumlah_bebas") {
                $key = "Bebas";
            } elseif ($key == "jumlah_dokter") {
                $key = "Dokter";
            } else {
                $key = "Pegawai";
            }
            $temp['jenis'] = $key;
            $temp['jumlah'] = $value;
            $temp['color'] = $color[$i];

            array_push($dataPieChart, $temp);
            $i++;
        }
        //=== end chart ===
        //=== start table ===
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(penjualanresep) as jumlah_resep,sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, sum(penjualanresep) as jumlah_resep,sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, sum(penjualanresep) as jumlah_resep,sum(penjualanresepluar) as jumlah_resepluar, sum(penjualanbebas) as jumlah_bebas, sum(penjualandokter) as jumlah_dokter, sum(penjualankaryawan) as jumlah_karyawan');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
        }

        $dataTable = new CActiveDataProvider($model, array(
            'criteria' => $criteria
        ));
         
        //=== end table ===

        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'dataBarLineChart' => $dataBarLineChart,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable,
            'format' => $format
        ));
    }

}

?>