<?php

class KunjunganPendapatanController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.kunjunganPendapatan.';

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
        $model = new SEPendapatanrsR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['SEPendapatanrsR'])) {
            $model->attributes = $_GET['SEPendapatanrsR'];
            $model->jns_periode = $_GET['SEPendapatanrsR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPendapatanrsR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPendapatanrsR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPendapatanrsR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPendapatanrsR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPendapatanrsR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPendapatanrsR']['thn_akhir'];
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
				SELECT date_trunc('month', a.tanggal) as periode, sum(coalesce(a.pendapatan,0)) as jumlah_pendapatan, sum(coalesce(b.kunjungan,0)) as jumlah_kunjungan
FROM (SELECT tanggal, sum(coalesce(jumlah,0)) as pendapatan
FROM pendapatanrs_r
WHERE rekening_id = 8
GROUP BY tanggal
ORDER BY tanggal) a

JOIN (SELECT tanggal, sum(coalesce(kunjungan_ri,0)) + sum(coalesce(kunjungan_rd,0)) + sum(coalesce(kunjungan_rd,0)) as kunjungan
FROM kunjunganrs_r
GROUP BY tanggal
ORDER BY tanggal) b ON b.tanggal=a.tanggal
WHERE DATE(a.tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
GROUP BY periode
ORDER BY periode
									";
                break;
            case 'tahun' : $sql = "
				SELECT date_trunc('year', a.tanggal) as periode, sum(coalesce(a.pendapatan,0)) as jumlah_pendapatan, sum(coalesce(b.kunjungan,0)) as jumlah_kunjungan
FROM (SELECT tanggal, sum(coalesce(jumlah,0)) as pendapatan
FROM pendapatanrs_r
WHERE rekening_id = 8
GROUP BY tanggal
ORDER BY tanggal) a

JOIN (SELECT tanggal, sum(coalesce(kunjungan_ri,0)) + sum(coalesce(kunjungan_rd,0)) + sum(coalesce(kunjungan_rd,0)) as kunjungan
FROM kunjunganrs_r
GROUP BY tanggal
ORDER BY tanggal) b ON b.tanggal=a.tanggal
WHERE DATE(a.tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
GROUP BY periode
ORDER BY periode

									";
                break;
            default : $sql = "
				SELECT date_trunc('day', a.tanggal) as periode, sum(coalesce(a.pendapatan,0)) as jumlah_pendapatan, sum(coalesce(b.kunjungan,0)) as jumlah_kunjungan
FROM (SELECT tanggal, sum(coalesce(jumlah,0)) as pendapatan
FROM pendapatanrs_r
WHERE rekening_id = 8
GROUP BY tanggal
ORDER BY tanggal) a

JOIN (SELECT tanggal, sum(coalesce(kunjungan_ri,0)) + sum(coalesce(kunjungan_rd,0)) + sum(coalesce(kunjungan_rd,0)) as kunjungan
FROM kunjunganrs_r
GROUP BY tanggal
ORDER BY tanggal) b ON b.tanggal=a.tanggal
WHERE DATE(a.tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
GROUP BY periode
ORDER BY periode
								";
        }

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarLineChart = $result;

        $dataBubbleChart = array();
        foreach ($dataBarLineChart as $data) {
            $temp['periode'] = $data['periode'];
            $temp['y'] = $data['jumlah_pendapatan'];
            $temp['value'] = $data['jumlah_pendapatan'];
            $temp['y2'] = $data['jumlah_kunjungan'];
            $temp['value2'] = $data['jumlah_kunjungan'];

            array_push($dataBubbleChart, $temp);
        }
        //=== start table ===

        $dataTable = $dataBarLineChart;
        //=== end table ===

        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'dataBubbleChart' => $dataBubbleChart,
            'dataBarLineChart' => $dataBarLineChart,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable,
            'format' => $format
        ));
    }

}

?>