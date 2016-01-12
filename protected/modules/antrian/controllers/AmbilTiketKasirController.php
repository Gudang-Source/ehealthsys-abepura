<?php

class AmbilTiketKasirController extends AmbilTiketController {

    public $layout = '//layouts/kiosAntrian';

    public function actionIndex() {
        $criteria = new CdbCriteria();
        $criteria->addCondition('loket_aktif = true');
        $criteria->order = "loket_nourut";
        $modLokets = ANLoketM::model()->findAll('iskasir = TRUE AND loket_aktif=TRUE ORDER BY loket_nourut');
        $model = new ANAntrianT;

        $this->render('index', array('model' => $model, 'modLokets' => $modLokets));
    }

    /**
     * untuk menyimpan tiket (ajax)
     */
    public function actionSimpanTiket() {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['pesan'] = "Data gagal disimpan! ";
            if (isset($_POST['data'])) {
                parse_str($_POST['data'], $post);
                $model = new ANAntrianT;
                $model->attributes = $post['ANAntrianT'];
                $model->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                $model->ruangan_id = Params::DEFAULT_RUANGAN_KIOSK_KASIR;
                $model->tglantrian = date('Y-m-d H:i:s');
                $model->noantrian = (empty($model->noantrian) ? MyGenerator::noAntrianLoket($model->loket_id, $model->loket->loket_formatnomor) : $model->noantrian);
                $delaytombol = $this->actionGetDelayTombolAntrian();


                if ($model->validate()) {
                    $model->save();
                    $data['model'] = $model;
                    $data['delaytombol'] = $delaytombol;
                    $data['pesan'] = "Data berhasil disimpan!";
                } else {
                    $data['pesan'] = "Data gagal disimpan! " . CHtml::errorSummary($model);
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrint($antrian_id) {
        $modAntrian = ANAntrianT::model()->findByPk($antrian_id);
        $this->layout = '//layouts/printWindows';
        $this->render('printNoAntrian', array('modAntrian' => $modAntrian));
    }

    public function actionGetDelayTombolAntrian() {
        //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
        $konfig = KonfigsystemK::model()->find();

        $delaytombol = $konfig->delaytombolantrian;

        return $delaytombol;
    }

}
