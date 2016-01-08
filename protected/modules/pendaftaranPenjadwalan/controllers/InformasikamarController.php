<?php

class InformasikamarController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function actionAdmin() {
        $detail = new PPKamarruanganM;
        $ruangan = new PPRuanganM;
        $this->render('admin', array(
            'detail' => $detail, 'ruangan' => $ruangan,
        ));
    }

    public function actionAjaxKamarRuangan(){
        $data = PPKamarruanganM::model()->findAll('ruangan_id=:ruangan_id', array(':ruangan_id' => (int) $_POST['ruangan_id'],), array('order' => 'kamarruangan_nokamar'));
        $data = CHtml::listData($data, 'kamarruangan_nokamar', 'kamarruangan_nokamar');

        if (empty($data)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kamar-'), true);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kamar-'), true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }
    
    public function actionAjaxKelasPelayanan(){
        $data = PPKelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=:ruangan_id', array(':ruangan_id' => (int) $_POST['ruangan_id'],), array('order' => 'kelaspelayanan_id'));
        $data = CHtml::listData($data, 'kelaspelayanan.kelaspelayanan_nama', 'kelaspelayanan.kelaspelayanan_nama');

        if (empty($data)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kelas-'), true);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih Kelas-'), true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }

}

?>
