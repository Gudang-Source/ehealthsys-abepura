<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InfoBayarUangMukaController extends MyAuthController {

	public $path_view = 'billingKasir.views.infoBayarUangMuka.';

	public function actionIndex() {
		$format = new MyFormatter();
		$model = new BKInformasibayaruangmukaV('search');
		$model->tgl_awal = date('d M Y');
		$model->tgl_akhir = date('d M Y');
		if (isset($_GET['BKInformasibayaruangmukaV'])) {
			$model->attributes = $_GET['BKInformasibayaruangmukaV'];
			$model->no_pendaftaran = $_GET['BKInformasibayaruangmukaV']['no_pendaftaran'];
			$model->no_rekam_medik = $_GET['BKInformasibayaruangmukaV']['no_rekam_medik'];
			$model->nama_pasien = $_GET['BKInformasibayaruangmukaV']['nama_pasien'];
			$model->instalasi_id = $_GET['BKInformasibayaruangmukaV']['instalasi_id'];
			$model->ruangan_id = $_GET['BKInformasibayaruangmukaV']['ruangan_id'];
			if (!empty($_GET['BKInformasibayaruangmukaV']['tgl_awal'])) {
				$model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasibayaruangmukaV']['tgl_awal']);
			}
			if (!empty($_GET['BKInformasibayaruangmukaV']['tgl_awal'])) {
				$model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasibayaruangmukaV']['tgl_akhir']);
			}
		}

		$this->render($this->path_view . 'index', array(
			'model' => $model, 
			'format' => $format
		));
	}
	
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(BKRuanganM::getItems($instalasi_id),'ruangan_id','ruangan_nama');
			
            if($encode){
                echo CJSON::encode($models);
            } else {
				if(count($models) > 1){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

}
