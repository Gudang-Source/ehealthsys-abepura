<?php

class InformasiKartuAngsuranController extends MyAuthController
{
	public $layout='//layouts/column1';
	// public $defaultAction = 'admin';
	//public $menuActive = array(5,3); // Default. Harap diubah sesuai menu aktif yang ada.
	public function actionIndex()//$no=null
	{		
            //if (isset($_POST['ajax'])) {
              //      if (isset($_POST['param'])) call_user_func(array($this, $_POST['f']), $_POST['param']);
                //    else call_user_func(array($this, $_POST['f']));

                  //  Yii::app()->end();
            //}

            $angsuran = new KOKartuangsuranV;
            $angsuran->tgl_awal = date('Y-m-d');
            $angsuran->tgl_akhir = date('Y-m-d');
         //   $angsuran->no_pinjaman = $no;
            //$angsuran->a_tglAwal = date('Y-m-01');
            //$angsuran->a_tglAkhir = date('Y-m-t');

            if (isset($_GET['KOKartuangsuranV'])) {
                    //$angsuran->a_tglAwal = $angsuran->a_tglAkhir = null;
                    $angsuran->attributes = $_GET['KOKartuangsuranV'];                    
                    $angsuran->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KOKartuangsuranV']['tgl_awal']);
                    $angsuran->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KOKartuangsuranV']['tgl_akhir']);
                    $angsuran->filterTanggal = $_GET['KOKartuangsuranV']['filterTanggal'];
                    //if (!empty($_GET['KOKartuangsuranV']['a_tglAwal'])) $angsuran->a_tglAwal = MyFormatter::formatDateForDb($_GET['KartuangsurananggotaV']['a_tglAwal']);
                    //if (!empty($_GET['KOKartuangsuranV']['a_tglAkhir'])) $angsuran->a_tglAkhir = MyFormatter::formatDateForDb($_GET['KartuangsurananggotaV']['a_tglAkhir']);
                    //if (!empty($_GET['KOKartuangsuranV']['status_pinjaman'])) $angsuran->status_pinjaman = $_GET['KartuangsurananggotaV']['status_pinjaman'];
                    //if (!empty($_GET['KOKartuangsuranV']['nama_anggota'])) $angsuran->nama_pegawai = $_GET['KartuangsurananggotaV']['nama_anggota'];
                    //var_dump($angsuran->a_tglAwal); die;
            }

            $this->render('index',array('angsuran'=>$angsuran));
	}

	public function actionPrint()
	{
		$this->layout = '//layouts/printWindows';		
               
		$angsuran = new KartuangsurananggotaV('search');
		$profil = ProfilkoperasiM::model()->find(array('order'=>'profilkoperasi_id asc'));

		//$angsuran->a_tglAwal = date('01/m/Y');
		//$angsuran->a_tglAkhir = date('t/m/Y');

		if (isset($_GET['KartuangsurananggotaV'])) {
			$angsuran->attributes = $_GET['KartuangsurananggotaV'];
			if (!empty($_GET['KartuangsurananggotaV']['tglAwal'])) $angsuran->tglAwal = MyFormatter::formatDateForDb($_GET['KartuangsurananggotaV']['tglAwal']);
			if (!empty($_GET['KartuangsurananggotaV']['tglAkhir'])) $angsuran->tglAkhir = MyFormatter::formatDateForDb($_GET['KartuangsurananggotaV']['tglAkhir']);
			if (!empty($_GET['KartuangsurananggotaV']['a_tglAwal'])) $angsuran->a_tglAwal = MyFormatter::formatDateForDb($_GET['KartuangsurananggotaV']['a_tglAwal']);
			if (!empty($_GET['KartuangsurananggotaV']['a_tglAkhir'])) $angsuran->a_tglAkhir = MyFormatter::formatDateForDb($_GET['KartuangsurananggotaV']['a_tglAkhir']);
			if (!empty($_GET['KartuangsurananggotaV']['status_pinjaman'])) $angsuran->status_pinjaman = $_GET['KartuangsurananggotaV']['status_pinjaman'];
			if (!empty($_GET['KartuangsurananggotaV']['nama_anggota'])) $angsuran->nama_pegawai = $_GET['KartuangsurananggotaV']['nama_anggota'];
		}
		$periode = MyFormatter::formatDateTimeId($angsuran->a_tglAwal).' s/d '.MyFormatter::formatDateTimeId($angsuran->a_tglAkhir);
		$this->render('print', array('angsuran'=>$angsuran,'profil'=>$profil,'periode'=>$periode));
	}

	protected function detailPinjaman($param) {
		$id = $param['id'];
		$pinjaman = InfopinjamananggotaV::model()->findByAttributes(array('pinjaman_id' => $id));
		echo $this->renderPartial('detail', array('pinjaman' => $pinjaman));
	}
}
