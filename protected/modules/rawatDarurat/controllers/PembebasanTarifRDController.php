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
        
        
}

?>