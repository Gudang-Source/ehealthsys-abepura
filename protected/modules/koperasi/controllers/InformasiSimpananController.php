<?php

class InformasiSimpananController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(5,1); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionIndex($no = null)
	{
	
	$model=new KOKartusimpananV('search');
	$model->unsetAttributes();  // clear any default values
	//$model->nosimpanan = $no;
	$model->tgl_awal = date('Y-m-d');
	$model->tgl_akhir = date('Y-m-d');
	//$model->jenissimpanan_id = array(1,2,3,4);
	if(isset($_GET['KOKartusimpananV']))
	{
		$model->attributes=$_GET['KOKartusimpananV'];
		//$model->unit_id = $_GET['KOKartusimpananV']['unit_id'];
                $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOKartusimpananV']['tgl_awal']);
                $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOKartusimpananV']['tgl_akhir']);
	}
	$this->render('index',array(
		'model'=>$model,
	));
	}

	public function actionPrint() {
		$this->layout='//layouts/print';
		$this->pageTitle = 'ecoopsys - Simpanan Anggota';
		$model=new KartusimpanananggotaV('search');
		//$model->unsetAttributes();  // clear any default values
		if(isset($_GET['KartusimpanananggotaV']))
		{
		$model->attributes=$_GET['KartusimpanananggotaV'];
		$model->jenissimpanan_id = $_GET['KartusimpanananggotaV']['jenissimpanan_id'];
		if (!empty($_GET['KartusimpanananggotaV']['tglAwal'])) $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['KartusimpanananggotaV']['tglAwal']).' 00:00:00';
		if (!empty($_GET['KartusimpanananggotaV']['tglAkhir'])) $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['KartusimpanananggotaV']['tglAkhir']).' 23:59:59';
		}
		//$konfig = KonfigurasikoperasiK::model()->find(array('order'=>'kofigurasikoperasi_id asc'));
		$profil = ProfilS::model()->find(array('order'=>'profilperusahaan_id asc'));
		$periode = MyFormatter::formatDateTimeId(date('d m Y',strtotime($model->tglAwal))).' s/d '.MyFormatter::formatDateTimeId(date('d m Y',strtotime($model->tglAkhir)));
		$this->render('print', array(
			'model'=>$model,
			'profil'=>$profil,
			'periode'=>$periode,
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
