<?php
Yii::import('sistemAdministrator.controllers.RekeningPelayananController');
Yii::import('sistemAdministrator.models.*');
class RekeningPelayananAKController extends RekeningPelayananController
{
	/**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.rekeningPelayanan.';

    public function actionCreate() {
        $model = new AKPelayananRekM();
        $modTindakanRuangan = new AKPelayananRekM('search');
        $modTindakanRuangan->unsetAttributes();
        $modTindakanRuangan->ruangan_id = null; //default tidak muncul data
        /*
        if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
            //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            //$model->ruangan_nama = Yii::app()->user->getState('ruangan_nama');
            $modTindakanRuangan->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
         * 
         */
        if (isset($_GET['AKPelayananRekM'])) {
            $modTindakanRuangan->attributes = $_GET['AKPelayananRekM'];
            $modTindakanRuangan->ruangan_id = $_GET['AKPelayananRekM']['ruangan_id'];
            //$modTindakanRuangan->kelompoktindakan_nama = $_GET['AKPelayananRekM']['kelompoktindakan_nama'];
            //$modTindakanRuangan->kategoritindakan_nama = $_GET['AKPelayananRekM']['kategoritindakan_nama'];
            //$modTindakanRuangan->daftartindakan_kode = $_GET['AKPelayananRekM']['daftartindakan_kode'];
            $modTindakanRuangan->daftartindakan_nama = $_GET['AKPelayananRekM']['daftartindakan_nama'];
        }

        if (Yii::app()->request->isPostRequest) { //submit by ajax
            $data['sukses'] = 0;
            $data['pesan'] = "";

            if (isset($_POST['AKPelayananRekM'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $loadTindakanRuangan = AKPelayananRekM::model()->findByAttributes(array('daftartindakan_id' => $_POST['AKPelayananRekM']['daftartindakan_id'], 'ruangan_id' => $_POST['AKPelayananRekM']['ruangan_id']));
                    if ($loadTindakanRuangan) {
                        $data['sukses'] = 0;
                        $data['pesan'] = "Tindakan " . $loadTindakanRuangan->daftartindakan->daftartindakan_nama . "sudah ada di " . $loadTindakanRuangan->ruangan->ruangan_nama . "!";
                    } else {

                        if (!empty($_POST['AKPelayananRekM']['rekening5_id_d']) && !empty($_POST['AKPelayananRekM']['rekening5_id_k'])) {
                            $model_d = new AKPelayananRekM;
                            $model_d->ruangan_id = $_POST['AKPelayananRekM']['ruangan_id'];
                            $model_d->daftartindakan_id = $_POST['AKPelayananRekM']['daftartindakan_id'];
                            $model_d->jnspelayanan = $_POST['AKPelayananRekM']['jnspelayanan'];
                            $model_d->komponentarif_id = $_POST['AKPelayananRekM']['komponentarif_id'];
                            $model_d->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_d'];
                            
                            $model_k = new AKPelayananRekM;
                            $model_k->ruangan_id = $_POST['AKPelayananRekM']['ruangan_id'];
                            $model_k->daftartindakan_id = $_POST['AKPelayananRekM']['daftartindakan_id'];
                            $model_k->jnspelayanan = $_POST['AKPelayananRekM']['jnspelayanan'];
                            $model_k->komponentarif_id = $_POST['AKPelayananRekM']['komponentarif_id'];
                            $model_k->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_k'];
                            
                            if ($model_d->save() && $model_k->save()) {
                                $transaction->commit();
                                $data['sukses'] = 1;
                                $data['pesan'] = "Tindakan " . $model_d->daftartindakan->daftartindakan_nama . " di " . $model_d->ruangan->ruangan_nama . " berhasil disimpan!";
                            } else {
                                $transaction->rollback();
                                $data['sukses'] = 0;
                                $data['pesan'] = "Data gagal disimpan! <br>" . CHtml::errorSummary($model);
                            }
                        } else {
                            $model = new AKPelayananRekM;
                            $model->ruangan_id = $_POST['AKPelayananRekM']['ruangan_id'];
                            $model->daftartindakan_id = $_POST['AKPelayananRekM']['daftartindakan_id'];
                            $model->jnspelayanan = $_POST['AKPelayananRekM']['jnspelayanan'];
                            $model->komponentarif_id = $_POST['AKPelayananRekM']['komponentarif_id'];
                            if (!empty($_POST['AKPelayananRekM']['rekening5_id_d'])) {
                                $model->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_d'];
                            }
                            if (!empty($_POST['AKPelayananRekM']['rekening5_id_k'])) {
                                $model->rekening5_id = $_POST['AKPelayananRekM']['rekening5_id_k'];
                            }
                            if ($model->save()) {
                                $transaction->commit();
                                $data['sukses'] = 1;
                                $data['pesan'] = "Tindakan " . $model->daftartindakan->daftartindakan_nama . " di " . $model->ruangan->ruangan_nama . " berhasil disimpan!";
                            } else {
                                $transaction->rollback();
                                $data['sukses'] = 0;
                                $data['pesan'] = "Data gagal disimpan! <br>" . CHtml::errorSummary($model);
                            }
                        }
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Data gagal disimpan!' . MyExceptionMessage::getMessage($exc, true);
                }
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }

        $this->render($this->path_view . 'create', array(
            'model' => $model,
            'modTindakanRuangan' => $modTindakanRuangan,
        ));
    }

    /**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '') {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if ($model_nama !== '' && $attr == '') {
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            } else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            } else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(SARuanganM::getItems($instalasi_id), 'ruangan_id', 'ruangan_nama');

            if ($encode) {
                echo CJSON::encode($models);
            } else {
                if (count($models) > 1) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                }
                if (count($models) > 0) {
                    foreach ($models as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    public function actionAutocompleteTindakan() {
        if (Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $term = isset($_GET['term']) ? $_GET['term'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(daftartindakan_nama)', strtolower($term), true);
            $criteria->compare('LOWER(daftartindakan_kode)', strtolower($term), true, 'OR');
            $criteria->order = 'daftartindakan_nama';
            $criteria->limit = 5;

            $models = SADaftarTindakanM::model()->findAll($criteria);
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->daftartindakan_kode . " " . $model->daftartindakan_nama;
                $returnVal[$i]['value'] = $model->daftartindakan_nama;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($idRuangan, $idTindakan) {
        $modKasusPenyakitRuangan = array();
        $this->render($this->path_view . 'view', array(
            'model' => RuanganM::model()->findByPk($idRuangan),
            'modKasusPenyakitRuangan' => $modKasusPenyakitRuangan,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            // we only allow deletion via POST request
            $transaction = Yii::app()->db->beginTransaction();
            try {
                PelayananrekM::model()->deleteByPk($_GET['id']);
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AKPelayananRekM('search');
        $model->unsetAttributes();  // clear any default values
        if (Yii::app()->session['modul_id'] != Params::MODUL_ID_SISADMIN) {
            // ->ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        if (isset($_GET['AKPelayananRekM'])) {
            $model->attributes = $_GET['AKPelayananRekM'];
            $model->kdrekening5 = $_GET['AKPelayananRekM']['kdrekening5'];
            $model->nmrekening5 = $_GET['AKPelayananRekM']['nmrekening5'];
            //$model->kelompoktindakan_nama = $_GET['AKPelayananRekM']['kelompoktindakan_nama'];
            //$model->kategoritindakan_nama = $_GET['AKPelayananRekM']['kategoritindakan_nama'];
            //$model->daftartindakan_kode = $_GET['AKPelayananRekM']['daftartindakan_kode'];
            $model->daftartindakan_nama = $_GET['AKPelayananRekM']['daftartindakan_nama'];
        }

        $this->render($this->path_view . 'admin', array(
            'model' => $model,
        ));
    }
}
