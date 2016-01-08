<?php
class KesimpulanSaranController extends MyAuthController
{
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	
	public function actionIndex($pendaftaran_id,$kesimpulanmcu_id=null)
	{
		$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
		$modPendaftaran = MCPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		
		$ModKesimpulanMCU = MCKesimpulanmcuT::model()->findByattributes(array('pendaftaran_id'=>$pendaftaran_id));
		if(count($ModKesimpulanMCU)>0){
			if($ModKesimpulanMCU->kesimpulan1_status == true){
				$ModKesimpulanMCU->kesimpulan_radio = 1;
			}
			if($ModKesimpulanMCU->kesimpulan2_status == true){
				$ModKesimpulanMCU->kesimpulan_radio = 2;
			}
			if($ModKesimpulanMCU->kesimpulan3_status == true){
				$ModKesimpulanMCU->kesimpulan_radio = 3;
			}
			$ModKesimpulanMCU->kesimpulan_checkbox = true;
			$ModKesimpulanMCU->saran_checkbox = true;
		}else{
			$ModKesimpulanMCU = new MCKesimpulanmcuT();
			$ModKesimpulanMCU->kesimpulan1_desc = 'Baik / dapat bekerja di tempat sekarang tanpa syarat (FIT)';
			$ModKesimpulanMCU->kesimpulan2_desc = 'Ada kelainan dan perlu pemeriksaan atau pengobatan lebih lanjut, namun masih dapat tetap bekerja ditempat sekarang (FIT dengan Catatan)';
			$ModKesimpulanMCU->kesimpulan3_desc = 'perlu pemeriksaan lebih lanjut, untuk sementara tidak dapat bekerja ditempat sekarang (UNFIT)';
			$ModKesimpulanMCU->kesimpulan_checkbox=0;
			$ModKesimpulanMCU->saran1_status=0;
			$ModKesimpulanMCU->saran1_desc='Kembali ke Poliklinik untuk :';
			$ModKesimpulanMCU->saran1_1_status=0;
			$ModKesimpulanMCU->saran1_1_desc='Berobat / konsuitasi ke dokter';
			$ModKesimpulanMCU->saran1_2_status=0;
			$ModKesimpulanMCU->saran1_2_desc='Pemeriksaan ulang';
			$ModKesimpulanMCU->saran1_3_status=0;
			$ModKesimpulanMCU->saran1_3_desc='Konsultasi diet / olahraga';
			$ModKesimpulanMCU->saran2_status=0;
			$ModKesimpulanMCU->saran2_desc='Periksa secara teratur ke dokter';
			$ModKesimpulanMCU->saran3_status=0;
			$ModKesimpulanMCU->saran3_desc='Penerapan pola hidup sehat';
			$ModKesimpulanMCU->saran3_1_desc='* Tidak merokok';
			$ModKesimpulanMCU->saran3_2_desc='* Olah raga teratur dengan detak jantung minimal 110.0x/mnt, maksimal 140.0x/mnt yang dilakukan sealam 30-40mnt.
	Jenis olahraga : Jalan cepat, senam aerobic';
			$ModKesimpulanMCU->saran3_3_desc='* Diet';
			$ModKesimpulanMCU->saran3_3_1_status=0;
			$ModKesimpulanMCU->saran3_3_1_desc='Rendah Lemak';
			$ModKesimpulanMCU->saran3_3_2_status=0;
			$ModKesimpulanMCU->saran3_3_2_desc='Rendah Purine';
			$ModKesimpulanMCU->saran3_3_3_status=0;
			$ModKesimpulanMCU->saran3_3_3_desc='Rendah Kalori';
			$ModKesimpulanMCU->saran3_3_4_status=0;
			$ModKesimpulanMCU->saran3_3_4_desc='Rendah Garam';
			$ModKesimpulanMCU->saran3_4_desc='* Tidur cukup 6-8jam/hari. Kelola stress';
			$ModKesimpulanMCU->tgl_kesimpulanmcu = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
		}
		
		if(isset($_POST['MCKesimpulanmcuT'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modPermintaanMcu=  MCPermintaanmcuT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
				$ModKesimpulanMCU = new MCKesimpulanmcuT();
				$postKesimpulan = $_POST['MCKesimpulanmcuT'];
				switch($postKesimpulan['kesimpulan_radio']) {
					case '1':
						$ModKesimpulanMCU->kesimpulan1_status = 1;
						$ModKesimpulanMCU->kesimpulan2_status = 0;
						$ModKesimpulanMCU->kesimpulan3_status = 0;
						break;
					case '2':
						$ModKesimpulanMCU->kesimpulan1_status = 0;
						$ModKesimpulanMCU->kesimpulan2_status = 1;
						$ModKesimpulanMCU->kesimpulan3_status = 0;
						break;
					case '3':
						$ModKesimpulanMCU->kesimpulan1_status = 0;
						$ModKesimpulanMCU->kesimpulan2_status = 0;
						$ModKesimpulanMCU->kesimpulan3_status = 1;
						break;
				}
				$ModKesimpulanMCU->attributes = $_POST['MCKesimpulanmcuT'];
				$ModKesimpulanMCU->kesimpulan1_desc = $_POST['MCKesimpulanmcuT']['kesimpulan1_desc'];
				$ModKesimpulanMCU->kesimpulan2_desc = $_POST['MCKesimpulanmcuT']['kesimpulan2_desc'];
				$ModKesimpulanMCU->kesimpulan3_desc = $_POST['MCKesimpulanmcuT']['kesimpulan3_desc'];
				$ModKesimpulanMCU->saranperorangan = $postKesimpulan['saranperorangan'];
				$ModKesimpulanMCU->pendaftaran_id = $pendaftaran_id;
				$ModKesimpulanMCU->create_time = date('Y-m-d H:i:s');
				$ModKesimpulanMCU->update_time = date('Y-m-d H:i:s');
				$ModKesimpulanMCU->create_loginpemakai_id = Yii::app()->user->id;
				$ModKesimpulanMCU->update_loginpemakai_id = Yii::app()->user->id;
				$ModKesimpulanMCU->create_ruangan = Yii::app()->user->getState('ruangan_id');
				$ModKesimpulanMCU->ruangan_id = Yii::app()->user->getState('ruangan_id');
				$ModKesimpulanMCU->pasien_id = $modPendaftaran->pasien_id;
				$ModKesimpulanMCU->permintaanmcu_id = !empty($modPermintaanMcu->permintaanmcu_id)?$modPermintaanMcu->permintaanmcu_id:null;
				$ModKesimpulanMCU->tgl_kesimpulanmcu = MyFormatter::formatDateTimeForDb($postKesimpulan['tgl_kesimpulanmcu']);
				$ModKesimpulanMCU->keterangan_kesimpulanmcu =$postKesimpulan['keterangan_kesimpulanmcu'];
				$ModKesimpulanMCU->nama_pemeriksa_kes =$postKesimpulan['nama_pemeriksa_kes'];
				if($ModKesimpulanMCU->validate()){
					if($ModKesimpulanMCU->save()){
						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data berhasil disimpan");
						$this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id, 'kesimpulanmcu_id'=>$ModKesimpulanMCU->kesimpulanmcu_id,'sukses'=>1));
					}
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}
            
		$this->render('index',array('ModKesimpulanMCU'=>$ModKesimpulanMCU,
				));
	}
	
	/**
     * @param type $pendaftaran_id
     */
    public function actionPrintMcu($kesimpulanmcu_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
		$ModKesimpulanMCU = MCKesimpulanmcuT::model()->findByPk($kesimpulanmcu_id);
		$modPendaftaran=MCPendaftaranT::model()->findByPk($ModKesimpulanMCU->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
		$modPeriksaKacamata = MCPeriksakacamataT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modHearingTest = MCHearingtestT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modHasilPemeriksaanRad = MCHasilpemeriksaanradT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time ASC'));
		$modTreadMill = MCTreadmillT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modJantungKoroner = JantungkoronerT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modPasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time ASC'));
		$modHasilPemeriksaanLab = MCHasilPemeriksaanLabT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time ASC'));
		
		if(count($modHasilPemeriksaanLab)>0){
			$modHasilPemeriksaanLabDetail = MCDetailHasilPemeriksaanLabT::model()->findAllByAttributes(array('pemeriksaanlab_id'=>$modHasilPemeriksaanLab->pemeriksaanlab_id));
		}else{
			$modHasilPemeriksaanLabDetail = null;
		}
		
		
        $judul_print = 'Medical Check Up';
        $this->render('printMcu', array(
                            'format'=>$format,
                            'ModKesimpulanMCU'=>$ModKesimpulanMCU,
							'modPendaftaran'=>$modPendaftaran,
							'modPasien'=>$modPasien,
                            'judul_print'=>$judul_print,
							'modPemeriksaanFisik'=>$modPemeriksaanFisik,
							'modPeriksaKacamata'=>$modPeriksaKacamata,
							'modHearingTest'=>$modHearingTest,
							'modHasilPemeriksaanRad'=>$modHasilPemeriksaanRad,
							'modTreadMill'=>$modTreadMill,
							'modJantungKoroner'=>$modJantungKoroner,
							'modPasienMorbiditas'=>$modPasienMorbiditas,
							'modHasilPemeriksaanLabDetail'=>$modHasilPemeriksaanLabDetail
        ));
    } 
	
    public function actionPrintMcuPerorangan($kesimpulanmcu_id) 
    {
        $this->layout='//layouts/printWindows';
		$ModKesimpulanMCU = MCKesimpulanmcuT::model()->findByPk($kesimpulanmcu_id);
		$modPendaftaran=MCPendaftaranT::model()->findByPk($ModKesimpulanMCU->pendaftaran_id);
		$modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
		$modAnamnesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modHasilPemeriksaanLab = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time ASC'));
		$modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modJantungKoroner = JantungkoronerT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'create_time DESC'));
		$modHasilPemeriksaanLabMCU = MCHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'create_ruangan'=>Params::RUANGAN_ID_KLINIK_MCU), array('order'=>'create_time ASC'));
		if(!empty($modHasilPemeriksaanLabMCU)>0){
			$modDetailHasilPemeriksaanLabMCU = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id'=>$modHasilPemeriksaanLabMCU->hasilpemeriksaanlab_id), array('order'=>'detailhasilpemeriksaanlab_id ASC'));
		}else{
			$modDetailHasilPemeriksaanLabMCU = null;
		}
		if(!empty($modAnamnesa)){
			$modRiwayatIndividuR = RiwayatindividuR::model()->findAllByAttributes(array('anamesa_id'=>$modAnamnesa->anamesa_id), array('order'=>'riwayatindividu_id ASC'));
			$modRiwayatKeluargaR = RiwayatkeluargaR::model()->findAllByAttributes(array('anamesa_id'=>$modAnamnesa->anamesa_id), array('order'=>'riwayatkeluarga_id ASC'));
			$criteria=new CDbCriteria;
			$criteria->group = 'jenis_faktor_resiko,anamesa_id';
			$criteria->select = 'jenis_faktor_resiko,anamesa_id';
			$criteria->addCondition("anamesa_id = ".$modAnamnesa->anamesa_id);
			$modRiwayatResikoKerjaJenis = MCRiwayatresikokerjaR::model()->findAll($criteria);
		}else{
			$modRiwayatIndividuR = null;
			$modRiwayatKeluargaR = null;
			$modRiwayatResikoKerjaJenis = null;
		}
		if(!empty($modPemeriksaanFisik)){
			$criteria=new CDbCriteria;
			$criteria->group = 'jenis_tht,pemeriksaanfisik_id';
			$criteria->select = 'jenis_tht,pemeriksaanfisik_id';
			$criteria->addCondition("pemeriksaanfisik_id = ".$modPemeriksaanFisik->pemeriksaanfisik_id);
			$modRiwayatThtJenis = MCRiwayatthtR::model()->findAll($criteria);
		}else{
			$modRiwayatThtJenis = null;
		}
		$modHasilPemeriksaanRad = MCHasilpemeriksaanradT::model()->findAllByAttributes(array('pendaftaran_id'=>33288), array('order'=>'create_time ASC'));
        $this->render('printMcuPerorangan', array(
                            'ModKesimpulanMCU'=>$ModKesimpulanMCU,
							'modPendaftaran'=>$modPendaftaran,
							'modPasien'=>$modPasien,
							'modAnamnesa'=>$modAnamnesa,
							'modHasilPemeriksaanLab'=>$modHasilPemeriksaanLab,
							'modPemeriksaanFisik'=>$modPemeriksaanFisik,
							'modJantungKoroner'=>$modJantungKoroner,
							'modHasilPemeriksaanLabMCU'=>$modHasilPemeriksaanLabMCU,
							'modDetailHasilPemeriksaanLabMCU'=>$modDetailHasilPemeriksaanLabMCU,
							'modRiwayatIndividuR'=>$modRiwayatIndividuR,
							'modRiwayatKeluargaR'=>$modRiwayatKeluargaR,
							'modRiwayatResikoKerjaJenis'=>$modRiwayatResikoKerjaJenis,
							'modRiwayatThtJenis'=>$modRiwayatThtJenis,
							'modHasilPemeriksaanRad'=>$modHasilPemeriksaanRad
        ));
    }
}