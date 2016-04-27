<?php

class PersalinanTController extends MyAuthController {

    public function actionIndex($id) {

        $modPendaftaran=PSPendaftaranT::model()->findByPk($id);
        $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPersalinan = PSPersalinanT::model()->with(array('pendaftaran','pegawai'))->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pasien_id'=>$modPasien->pasien_id));
        $format = new MyFormatter;

        if (count($modPersalinan) > 0) {
            $model = PSPersalinanT::model()->with(array('pendaftaran','pegawai'))->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id, 'pasien_id'=>$modPasien->pasien_id));
            $model->tglmulaipersalinan = MyFormatter::formatDateTimeForUser($model->tglmulaipersalinan);
            if (!empty($model->tglselesaipersalinan)) $model->tglselesaipersalinan = MyFormatter::formatDateTimeForUser($model->tglselesaipersalinan);
            if (!empty($model->tglmelahirkan)) $model->tglmelahirkan = MyFormatter::formatDateTimeForUser($model->tglmelahirkan);
        }else{
            $model = new PSPersalinanT;
            $model->tglmulaipersalinan = date('d M Y H:i:s');
            $model->tglabortus = date('d M Y H:i:s');
        }


        if (isset($_POST['PSPersalinanT'])) {
            $model->attributes = $_POST['PSPersalinanT'];
            $model->pasien_id = $modPasien->pasien_id;
            $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->tglselesaipersalinan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglselesaipersalinan']); 
            $model->tglmulaipersalinan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglmulaipersalinan']);
            if(!empty($_POST['PSPersalinanT']['bidan2_id'])){
				$model->bidan2_id=$_POST['PSPersalinanT']['bidan2_id'];
			}
            if(!empty($_POST['PSPersalinanT']['bidan3_id'])){
				$model->bidan3_id=$_POST['PSPersalinanT']['bidan3_id'];
			}
            if(isset($_POST['PSPersalinanT']['tglabortus'])){
                $model->tglabortus = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglabortus']); 
            }else{
                unset($model->tglabortus);
            }
            $model->tglmelahirkan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglmelahirkan']);
            
            if ($model->validate()) {
                if ($model->save()){
                    Yii::app()->user->setFlash('success',"Data Berhasil disimpan ");
                    $this->redirect(Yii::app()->createUrl($this->module->id.'/persalinanT/index&id='.$id.'&sukses=1'));
                }
            } else {
                Yii::app()->user->setFlash('error',"Data gagal disimpan ");
            }
            
        }
        $this->render('index', array('format'=>$format,'model' => $model, 'modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien, 'modPersalinan'=>$modPersalinan));
    }
    
}