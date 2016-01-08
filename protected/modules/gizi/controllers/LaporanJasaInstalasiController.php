<?php
Yii::import('rawatJalan.controllers.LaporanController');
Yii::import('rawatJalan.models.*');
class LaporanJasaInstalasiController extends LaporanController {
    
    public $path_view = 'rawatJalan.views.laporan.';
    public $pathViewLap = 'rawatJalan.views.laporan.';
    
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
                    echo $this->renderPartial('rawatJalan.views.laporan.jasaInstalasi._tableJasaInstalasi', array('model'=>$model),true);
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
            $model = new RJLaporanjasainstalasi('search');
            $model->tgl_awal = date('d M Y 00:00:00');
            $model->tgl_akhir = date('d M Y H:i:s');

            //Data Grafik
            $data['title'] = 'Grafik Laporan Jasa Instalasi';
            $data['type'] = $_GET['type'];
            if (isset($_GET['RJLaporanjasainstalasi'])) {
                $model->attributes = $_GET['RJLaporanjasainstalasi'];
                $format = new MyFormatter();
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_akhir']);
            }

            $this->render($this->pathViewLap.'_grafik', array(
                'model' => $model,
                'data' => $data,
            ));
        }
}
?>
