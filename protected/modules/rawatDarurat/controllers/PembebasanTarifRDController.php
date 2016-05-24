<?php

Yii::import("rawatJalan.controllers.PembebasanTarifController");
Yii::import("rawatJalan.models.*");
class PembebasanTarifRDController extends PembebasanTarifController
{
        /**
         * untuk load data pasien setelah di pilih no rekam medik
         */
        public function actionLoadDataPasien()
        {
            if(Yii::app()->request->isAjaxRequest){
                $data = RDInfokunjunganrdV::model()->findByAttributes(array('no_rekam_medik'=>$_POST['no_rekam_medik']));
                $post = array(
                    'tgl_pendaftaran'=>MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran),
                    'no_pendaftaran'=>$data->no_pendaftaran,
                    'umur'=>$data->umur,
                    'jeniskasuspenyakit_nama'=>$data->jeniskasuspenyakit_nama,
                    'instalasi_nama' => $data->instalasi_nama,
                    'ruangan_nama'=>$data->ruangan_nama,
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'pasien_id'=>$data->pasien_id,
                    'jeniskelamin'=>$data->jeniskelamin,
                    'statusperkawinan'=>$data->statusperkawinan,
                    'nama_pasien'=>$data->nama_pasien,
                    'nama_bin'=>$data->nama_bin,
                );
                echo CJSON::encode($post);
                Yii::app()->end();
            }
        }
        
        public function actionDaftarPasienTindakanRuangan()
        {
            if(Yii::app()->request->isAjaxRequest) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                    $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                    $criteria->order = 'tgl_pendaftaran DESC';
                    $models = RDInfokunjunganrdV::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien;
                            $returnVal[$i]['value'] = $model->no_rekam_medik;
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                    }

                    echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        
}

?>