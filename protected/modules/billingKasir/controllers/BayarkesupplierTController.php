<?php

class BayarkesupplierTController extends MyAuthController
{
	public function actionIndex()
	{
                                $model = new BayarkesupplierT('search');
                                $modFaktur = new BKFakturPembelianT;
                                $format = new MyFormatter();
                                
                                if (isset($_GET['BayarkesupplierT'])) {
                                    if (isset($_GET['BKFakturPembelian']))
                                        $modFaktur->attributes=$_GET['BKFakturPembelianT'];
                                    $model->tgl_awal = $format->formatDateTimeForDb($_GET['BayarkesupplierT']['tgl_awal']);
                                    $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BayarkesupplierT']['tgl_akhir']);
                                    if ($_GET['berdasarkanpembayaran']>0){
                                        $model->tgl_awalbayarkesupplier = $format->formatDateTimeForDb($_GET['BayarkesupplierT']['tgl_awalbayarkesupplier']);
                                        $model->tgl_akhirbayarkesupplier = $format->formatDateTimeForDb($_GET['BayarkesupplierT']['tgl_akhirbayarkesupplier']);
                                    } else {
                                        $model->tgl_awalbayarkesupplier = null;
                                        $model->tgl_akhirbayarkesupplier = null;
                                    }
                                }
		$this->render('index',array(
                                    'model'=>$model,
                                    'modFaktur'=>$modFaktur,
                                ));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}