<?php

class DefaultController extends MyAuthController
{
	//public $layout='//layouts/antrian';
	
    public function actionIndex()
	{
        $format = new MyFormatter();
        $modKomentar        = new KomentarS();
        $modBuatjanji       = new BuatjanjipoliT();
        $modBookingkamar    = new BookingkamarT();
        //$modBookingkamar->bookingkamar_no = MyGenerator::noBookingKamar();
        //========== Menu Ketersediaan Kamar ================
        $model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }
        //========== Akhir Menu Ketersediaan Kamar ==========

		$this->render('index',array('modKomentar'=>$modKomentar, 'modBuatjanji'=>$modBuatjanji, 'modBookingkamar'=>$modBookingkamar, 'model'=>$model, 'row'=>$row, 'format'=>$format));

		if (isset($_GET['RDJadwaldokterM'])){
            $mulai = (!empty($_GET['RDJadwaldokterM']['jadwaldokter_mulai'])) ? date('Y-m-d',strtotime('01 '.$_GET['RDJadwaldokterM']['jadwaldokter_mulai'])) : date('Y-m-d');
            $tgl = explode('-',$mulai);
            $day = cal_days_in_month(CAL_GREGORIAN, $tgl[1], $tgl[0]);
            $grid = $this->createGrid($day,$tgl[1],$tgl[0],$_GET['RDJadwaldokterM']);
            echo json_encode($grid);
        }
	}

	/**
     * method untuk membuat calendar jadwal dokter
     * @param string $jumlahhari
     * @param string $bulan
     * @param string $tahun
     * @param array $variable
     * @return string berupa grid calender dengan jadwal dokter
     */
    protected function createGrid($jumlahhari,$bulan,$tahun,$variable=null){
        $tglMulai = strtotime($tahun.'-'.$bulan.'-'.'01');
        return $this->renderPartial("_createGrid",array('tglMulai'=>$tglMulai, 'bulan'=>$bulan,'tahun'=>$tahun,'jumlahHari'=>$jumlahhari,'variable'=>$variable),true);
    }
	
    public function actionView($id)
    {
        $this->layout ='//layouts/iframe';
        $model= EKPenjaminPasienM::model()->findByAttributes(array('penjamin_id'=>$id));
        $this->render('view_asuransi',array(
            'model'=>$model,
        ));
    }
	
    public function actionAsuransi()
    {
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_asuransi',array(
					   'model'=>$model,
		));
    }
   public function actionFasilitas()
    {
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_fasilitas',array(
					   'model'=>$model,
		));
    }		

	public function actionKperawatan()
    {
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_kamarperawatan',array(
					   'model'=>$model,
		));
    }

	public function actionJdokter()
    {
	$format = new MyFormatter();
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_jadwaldokter',array(
					   'model'=>$model,
					   'format'=>$format
		));
    }	

	public function actionPpelayanan()
    {
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_paketpelayanan',array(
					   'model'=>$model,
		));
    }
	
	public function actionIkamar()
    {
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_infokamar',array(
					   'model'=>$model,
						'row'=>$row,
		));
    }	

	public function actionKritikSaran()
    {
		$modKomentar  = new KomentarS();		
		$this->render('_kritiksaran',array(
					   'model'=>$modKomentar,
		));
    }

	public function actionBjanji()
    {
	$format = new MyFormatter();
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_buatjanji',array(
					   'model'=>$model,
						'format'=>$format
		));
    }	

	public function actionBkamar()
    {
	$format = new MyFormatter();
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_bookingkamar',array(
					   'model'=>$model,
					   'format'=>$format
		));
    }	

	public function actionDenah()
    {
	$model =INInformasikamarinapV::model()->findAll('kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
        $row = $this->renderKamarRuangan($model);
        if ((isset($_POST['ajax']))&&(isset($_POST['ruangan']))){
            $ruangan = $_POST['ruangan'];
            $model =INInformasikamarinapV::model()->findAll(((!empty($ruangan)) ? "ruangan_id =".$ruangan." and " : "").'kamarruangan_aktif = true order by ruangan_id, kelaspelayanan_id, kamarruangan_nokamar, kamarruangan_nobed');
            $row = $this->renderKamarRuangan($model);
  
            echo json_encode($row);
            Yii::app()->end();
        }		
		$this->render('_denah',array(
					   'model'=>$model,
		));
    }
	
    public function actionViewJadwal($jadwaldokter_tgl)
    {
        // var_dump($jadwaldokter_tgl);
        // exit;    
        $this->layout ='//layouts/iframe';
        $model= JadwaldokterM::model()->findAllByAttributes(array('jadwaldokter_tgl'=>$jadwaldokter_tgl));
        $this->render('view_jadwaldokter',array(
            'model'=>$model,
        ));
    }

    public function actionViewPengumuman($id)
    {
        $this->layout ='//layouts/iframe';
        $model= Pengumuman::model()->findByAttributes(array('pengumuman_id'=>$id));
        $this->render('view_pengumuman',array(
            'model'=>$model,
        ));
    }

    public function actionSimpanKomentar()
    {
        $modKomentar = new KomentarS();
        $komen = $_POST['KomentarS'];
        
        if(isset($_POST['KomentarS']))
        {
            $modKomentar->attributes=$_POST['KomentarS'];
            if($_POST['KomentarS']['emailkomentar']=='' || $_POST['KomentarS']['emailkomentar']==NULL){
                $modKomentar->emailkomentar='user@pengunjung.com';    
            }
            $modKomentar->komentar_tampilkan=TRUE;
            $modKomentar->tglkomentar=date('Y-m-d');
            // var_dump($modKomentar->tglkomentar);
            // exit;
            $modKomentar->save();
        }
        $this->redirect(array('index'));
    }

    public function actionSimpanJanji(){
        $modPasien = new PPPasienM();
        $modBuatJanjiPoli = new BuatjanjipoliT();
        $format = new MyFormatter;

        if(isset($_POST['BuatjanjipoliT']) && isset($_POST['PPPasienM'])){

            $no_rm = $_POST['PPPasienM']['no_rekam_medik'];
            $modPasien->attributes          = $_POST['PPPasienM'];
            $modBuatJanjiPoli->attributes   = $_POST['BuatjanjipoliT'];
            $modBuatJanjiPoli->tglbuatjanji = date('Y-m-d H:i:s');
            $modBuatJanjiPoli->tgljadwal    = $format->formatDateTimeForDb($_POST['BuatjanjipoliT']['tgljadwal']);
            $modBuatJanjiPoli->create_time  = date('Y-m-d H:i:s');
            $modBuatJanjiPoli->update_time  = date('Y-m-d H:i:s');
            $modBuatJanjiPoli->create_loginpemakai_id   =Yii::app()->user->id;
            $modBuatJanjiPoli->update_loginpemakai_id   =Yii::app()->user->id;
            $modBuatJanjiPoli->create_ruangan   = Yii::app()->user->getState('ruangan_id');


            if($no_rm==null || $no_rm==''){ //proses input pasien baru
                $modPasien->umur = $_POST['PPPasienM']['umur'];
                $modPasien->tanggal_lahir = $format->formatDateTimeForDb($_POST['PPPasienM']['tanggal_lahir']);
                $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
                $modPasien->no_rekam_medik = MyGenerator::noRekamMedikJanjiPoli();
                $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
                $modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                $modPasien->agama = Params::DEFAULT_AGAMA;
                $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
                $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
                $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
                $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
                $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
                $modPasien->create_loginpemakai_id=Yii::app()->user->id;
                $modPasien->update_loginpemakai_id=Yii::app()->user->id;
                $modPasien->create_ruangan= Yii::app()->user->getState('ruangan_id');
                $modPasien->statusrekammedis = 'AKTIF';
                $modPasien->create_time = date('Y-m-d H:i:s');
                $modPasien->no_telepon_pasien = '62';

                if($modPasien->validate()) {
                    $modPasien->save();
                    $modBuatJanjiPoli->pasien_id=$modPasien->pasien_id;
                }
                if($modBuatJanjiPoli->validate()) {
                    $modBuatJanjiPoli->save();
                }
                
            }else{ //proses input pasien lama
                $criteria = new CDbCriteria();
                $criteria->compare('no_rekam_medik', $no_rm);
                $pasien = PasienM::model()->find($criteria);

                $modPasien->pasien_id=$pasien->pasien_id;
                $parameter = array(
                    'alamat_pasien' => $modPasien->alamat_pasien,
                    'rt' => $modPasien->rt,
                    'rw' => $modPasien->rw
                );
                $update = PasienM::model()->updateByPk($pasien->pasien_id, $parameter);
                
                $modBuatJanjiPoli->pasien_id=$modPasien->pasien_id;

                if($modBuatJanjiPoli->validate()) {
                    $modBuatJanjiPoli->save();
                }
            }//
            
        }
        $this->redirect(array('index'));
    }

    public function actionSimpanBooking(){
        $modPasien = new BKPasienM();
        $modBookingkamar = new PPBookingKamarT();
        $format = new MyFormatter;

        if(isset($_POST['BookingkamarT']) && isset($_POST['BKPasienM'])){
            $modPasien->attributes          = $_POST['BKPasienM'];
            $modBookingkamar->attributes    = $_POST['BookingkamarT'];
            $no_rm                          = $_POST['BKPasienM']['no_rekam_medik'];

            $modBookingkamar->tgltransaksibooking    = date('d M Y H:i:s');            
            $modBookingkamar->statuskonfirmasi       = "BELUM KONFIRMASI";
            $modBookingkamar->create_loginpemakai_id = Yii::app()->user->id;
            $modBookingkamar->update_loginpemakai_id = Yii::app()->user->id;
            $modBookingkamar->tglbookingkamar = $format->formatDateTimeForDb($_POST['BookingkamarT']['tglbookingkamar']);

            if($no_rm==null || $no_rm==''){ //proses input pasien baru
                $modPasien->umur = $_POST['BKPasienM']['umur'];
                $modPasien->tanggal_lahir = $format->formatDateTimeForDb($_POST['BKPasienM']['tanggal_lahir']);
                $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
                $modPasien->no_rekam_medik = MyGenerator::noRekamMedikBookingKamar();
                $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
                $modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                $modPasien->agama = Params::DEFAULT_AGAMA;
                $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
                $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
                $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
                $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
                $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
                $modPasien->create_loginpemakai_id=Yii::app()->user->id;
                $modPasien->update_loginpemakai_id=Yii::app()->user->id;
                $modPasien->create_ruangan= Yii::app()->user->getState('ruangan_id');
                $modPasien->statusrekammedis = 'AKTIF';
                $modPasien->create_time = date('Y-m-d H:i:s');
                $modPasien->no_telepon_pasien = '62';

                if($modPasien->validate()) {
                    $modPasien->save();
                    $modBookingkamar->pasien_id=$modPasien->pasien_id;
                }
                if($modBookingkamar->validate()) {
                    $modBookingkamar->save();
                    KamarruanganM::model()->updateByPk($modBookingkamar->kamarruangan_id,array('keterangan_kamar'=>"BOOKING"));
                }
                
            }else{ //proses input pasien lama
                $criteria = new CDbCriteria();
                $criteria->compare('no_rekam_medik', $no_rm);
                $pasien = PasienM::model()->find($criteria);

                $modPasien->pasien_id=$pasien->pasien_id;
                $parameter = array(
                    'alamat_pasien' => $modPasien->alamat_pasien,
                    'rt' => $modPasien->rt,
                    'rw' => $modPasien->rw
                );
                $update = PasienM::model()->updateByPk($pasien->pasien_id, $parameter);
                
                $modBookingkamar->pasien_id=$modPasien->pasien_id;

                if($modBookingkamar->validate()) {
                    $modBookingkamar->save();
                    KamarruanganM::model()->updateByPk($modBookingkamar->kamarruangan_id,array('keterangan_kamar'=>"BOOKING"));
                }
            }//

        }
        $this->redirect(array('index'));
    }

    protected function renderKamarRuangan($model){
        $result = '';
        $tempRuangan = '';
        $list1 = array();
            
        foreach ($model as $i=>$row){
            if ($row->ruangan_id != $tempRuangan){
                $tempJumlah = 0;
                $list1[$row->ruangan_id]['name'] = $row->ruangan_nama;
                $list1[$row->ruangan_id]['ruangan_id'] = $row->ruangan_id;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                $list1[$row->ruangan_id]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
                $tempJumlah = $row->kamarruangan_jmlbed;
                $tempRuangan = $row->ruangan_id;
            }
            else{
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['name'] = $row->kamarruangan_nokamar;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kelaspelayanan'] = $row->kelaspelayanan_namalainnya;
                if ($row->kamarruangan_jmlbed >= $tempJumlah){
                    $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['jml'] = $row->kamarruangan_jmlbed;
                    $tempJumlah = $row->kamarruangan_jmlbed;
                }
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['name'] = $row->kamarruangan_nokamar;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['no'] = $row->kamarruangan_nobed;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['status'] = $row->kamarruangan_status;
                $list1[$tempRuangan]['kamar'][$row->kelaspelayanan_id]['kamar'][$row->kamarruangan_nokamar]['bed'][$i]['id'] = $row->kamarruangan_id;
            }
        }

        foreach ($list1 as $i=>$v){
        
            $result .= '<div class="contentKamar" style="max-height:398px;overflow-y: scroll;">';
                        
                $ruangan = RuanganM::model()->findByPk($v['ruangan_id']);
                $dataRuangan ='';

                // var_dump($v['ruangan_id']);//
                // var_dump(count($ruangan));
                
                
                if (count($ruangan) == 1){
                    $dataRuangan .='<table width=\'100px\'>';
                    $dataRuangan .='<tr><td rowspan=2><img src=\''.Yii::app()->baseUrl.'/images/'.$ruangan->ruangan_image.'\' class=\'image_ruangan\'></td><td>Fasilitas</td><td>'.((!empty($ruangan->ruangan_fasilitas)) ? $ruangan->ruangan_fasilitas : " - ").'</td></tr>';
                    $dataRuangan .='<tr><td>Lokasi</td><td>'.((!empty($ruangan->ruangan_lokasi)) ? $ruangan->ruangan_lokasi : " - ").'</td></tr>';
                    $dataRuangan .='</table>';
                }
				
                foreach ($v['kamar'] as $j=>$w){
					$w['jml'] = (isset($w['jml']) ? $w['jml'] : 0);
                    $result .='<h4 class="popover-title"><img src=\''. Yii::app()->baseUrl.'/images/blue-home-icon.png\' style=\'height:30px;\'/ class="idhome" onclick="home_kk()" data-toggle="tooltip" title="Klik Disini untuk kembali ke tampilan awal">'.$v['name'].' - '.$w['kelaspelayanan'].' - '.$w['jml'].'<a href="" class="pull-right poping" data-content="'.$dataRuangan.'" onclick="return false;"><img src=\''. Yii::app()->baseUrl.'/images/fasilitas.png\' style=\'height:30px;\'/>Detail</a></h4>
                        <ul>';
                    foreach ($w['kamar'] as $x=>$y){
                        $result .='<li class="bed">
                            <div class="popover-inner">
                            <h6 class="popover-title">'.$y['name'].'</h3>
                            <div class="popover-content">';
                        foreach ($y['bed'] as $a=>$b){                
                            $kamar = MasukkamarT::model()->find('kamarruangan_id = '.$b['id'].' order by tglmasukkamar desc');
                            
                            $dataPasien = '';
                            if (count($kamar) == 1){
                                $dataPasien .='<table>';
                                $dataPasien .='<tr><td>No. RM </td><td>: '.$kamar->admisi->pasien->no_rekam_medik.'</td></tr>';
                                $dataPasien .='<tr><td>Nama </td><td>: '.$kamar->admisi->pasien->nama_pasien.'</td></tr>';
                                $dataPasien .='<tr><td>Jenis Kelamin </td><td>: '.$kamar->admisi->pasien->jeniskelamin.'</td></tr>';
                                $dataPasien .= '</table>';
                            }
                        
                            $result .='<p><a href="" class="btn '.(($b['status']) ? 'btn-danger' : 'btn-primary').'" rel="popover" data-content="'.(($b['status']) ? 'Pasien Kosong' : $dataPasien).'" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/'.(($b['status']) ?  'RanjangRumahSakit2' : 'RanjangRumahSakit').'.png\'/>No. Bed : '.$b['no'].'</a></p>';
                        }
                        for($d=1;$d<=($w['jml'] - (count($y['bed'])));$d++){
                            $result .='<p><a href="" class="btn btn-info" onclick="return false"><img src=\''. Yii::app()->baseUrl.'/images/delete.png\'/>Kosong</a></p>';
                        }
                        $result .='</div>
                            </div>
                        </li>';
                    }
                    $result .='</ul>';
                }
                   
                $result .='</div>';
            }
            //exit;
        return $result;
    }
	
	public function actionGetTglLahir()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            // $umur = explode(' ', $_POST['umur']);
            $today = date('Y-m-d');
            if(!empty($_POST['thn'])&&!empty($_POST['bln'])&&!empty($_POST['hr'])){
                // $thn = $umur[0];
                // $bln = $umur[2];
                // $hr = $umur[4];
              
                $thn = $_POST['thn'];
                $bln = $_POST['bln'];
                $hr = $_POST['hr'];

                if($thn=='')$thn=0;if($bln=='')$bln=0;
                    $dateCalculate = strtotime(date("Y-m-d", strtotime($today)) . "-$thn year");
                    $date = date('Y-m-d', $dateCalculate);
                    $dateCalculate = strtotime(date("Y-m-d", strtotime($date)) . "-$bln month");
                    $date = date('Y-m-d', $dateCalculate);
                    $dateCalculate = strtotime(date("Y-m-d", strtotime($date)) . "-$hr day");
                    $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d', $dateCalculate), 'yyyy-MM-dd'),'medium',null);
                    $data['tglLahir'] = $tgl;
                     // $data['thn'] = $tgl;
                     // $data['bln'] = $tgl;
                     // $data['hr'] = $tgl;
            } else {
                $tgl = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($today, 'yyyy-MM-dd'),'medium',null);
                $data['tglLahir'] = $tgl;
                 // $data['thn'] = $tgl;
                 // $data['bln'] = $tgl;
                 // $data['hr'] = $hr;

            }        

            echo json_encode($data);
            //echo json_encode(array("name"=>"John","time"=>"2pm"));
            Yii::app()->end();
        }
    }
	
	public function actionGetUmur()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $format = new MyFormatter;
            $tglLahir = $format->formatDateTimeForDb($_POST['tglLahir']);
            $dob=$tglLahir; $today=date("Y-m-d");
            list($y,$m,$d)=explode('-',$dob);
            list($ty,$tm,$td)=explode('-',$today);
            if($td-$d<0){
                $day=($td+30)-$d;
                $tm--;
            }
            else{
                $day=$td-$d;
            }
            if($tm-$m<0){
                $month=($tm+12)-$m;
                $ty--;
            }
            else{
                $month=$tm-$m;
            }
            $year=$ty-$y;
            
            // $data['umur'] = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
            $data['thn'] = str_pad($year, 2, '0', STR_PAD_LEFT);
            $data['bln'] = str_pad($month, 2, '0', STR_PAD_LEFT);
            $data['hr'] = str_pad($day, 2, '0', STR_PAD_LEFT);
            //$data['umur'] = $dob;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
	
	public function actionAddKabupaten()
    {
        $modelKab = new KabupatenM;
        $modProp = PropinsiM::model()->findAll();

        if(isset($_POST['KabupatenM']))
        {
            $modelKab->attributes = $_POST['KabupatenM'];
            $modelKab->kabupaten_aktif = true;
            if($modelKab->save())
            {
                $data= KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$_POST['KabupatenM']['propinsi_id'],),array('order'=>'kabupaten_nama'));
                $data=CHtml::listData($data,'kabupaten_id','kabupaten_nama');

                if(empty($data)){
                    $kabupatenOption = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $kabupatenOption = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($data as $value=>$name)
                    {
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                }

                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Kabupaten <b>".$_POST['KabupatenM']['kabupaten_nama']."</b> berhasil ditambahkan </div>",
                        'kabupaten'=>$kabupatenOption,
                        ));
                    exit;               
                }
            } 

        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formAddKabupaten', array('model'=>$modelKab,'modProp'=>$modProp), true)));
            exit;               
        }
    }
	
	public function actionAddKecamatan()
    {
        $modelKec = new KecamatanM;
        //$modProp = PropinsiM::model()->findAll(array('order'=>'propinsi_nama'));

        if(isset($_POST['KecamatanM']))
        {
            $modelKec->attributes = $_POST['KecamatanM'];
            $modelKec->kecamatan_aktif = true;
            if($modelKec->save())
            {
                $data= KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$_POST['KecamatanM']['kabupaten_id'],),array('order'=>'kecamatan_nama'));
                $data=CHtml::listData($data,'kecamatan_id','kecamatan_nama');

                if(empty($data)){
                    $kecamatanOption = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $kecamatanOption = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($data as $value=>$name)
                    {
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                }

                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Kecamatan <b>".$_POST['KecamatanM']['kecamatan_nama']."</b> berhasil ditambahkan </div>",
                        'kecamatan'=>$kecamatanOption,
                        ));
                    exit;             
                }
            } 

        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formAddKecamatan', array('model'=>$modelKec), true)));
            exit;               
        }
    }
	
	public function actionAddKelurahan()
    {
        $modelKel = new KelurahanM;

        if(isset($_POST['KelurahanM']))
        {
            $modelKel->attributes = $_POST['KelurahanM'];
            $modelKel->kelurahan_aktif = true;
            if($modelKel->save())
            {
                $data= KelurahanM::model()->findAllByAttributes(array('kecamatan_id'=>$_POST['KelurahanM']['kecamatan_id']),array('order'=>'kelurahan_nama'));
                $data=CHtml::listData($data,'kelurahan_id','kelurahan_nama');

                if(empty($data)){
                    $kelurahanOption = CHtml::tag('option',array('value'=>''),CHtml::encode('-Pilih-'),true);
                }else{
                    $kelurahanOption = CHtml::tag('option',array('value'=>''),CHtml::encode('-Pilih-'),true);
                    foreach($data as $value=>$name)
                    {
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                }

                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Kelurahan <b>".$_POST['KelurahanM']['kelurahan_nama']."</b> berhasil ditambahkan </div>",
                        'kelurahan'=>$kelurahanOption,
                        ));
                    exit;             
                }
            } 

        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formAddKelurahan', array('model'=>$modelKel,), true)));
            exit;               
        }
    }
	
	public function actionGetHari()
    {
          if(Yii::app()->getRequest()->getIsAjaxRequest()) 
            {
                $format = new MyFormatter();
                $tanggalWaktu=$_POST['tanggal'];
                
                $tanggal=trim(substr($tanggalWaktu,0,-8)); //Menampilkan Tanggal Tanpa Jam
                $tanggalDB = $format->formatDateTimeForDb($tanggal);//Mengubah Tanggal inputan ke tanggal database
                $hari=date('l', strtotime($tanggalDB)); //Mendapatkan nilai hari dari tanggal yang dipilih

                 if(strtolower($hari)=='sunday')
                    {
                        $hari='Minggu';
                    }
                 else if(strtolower($hari)=='monday')
                    {
                        $hari='Senin';
                    }
                 else if(strtolower($hari)=='tuesday')
                    {
                        $hari='Selasa';
                    }
                 else if(strtolower($hari)=='wednesday')
                    {
                        $hari='Rabu';
                    }
                 else if(strtolower($hari)=='thursday')
                    {
                        $hari='Kamis';
                    }
                 else if(strtolower($hari)=='friday')
                    {
                        $hari='Jumat';
                    }
                 else if(strtolower($hari)=='saturday')
                    {
                        $hari='Sabtu';
                    }    
                $data['hari']=$hari;
                echo json_encode($data);
                Yii::app()->end();
            }
    }

}// end class