<?php
//Yii::import('rawatJalan.controllers.PemeriksaanFisikController');
//Yii::import('rawatJalan.models.*');
//class PemeriksaanFisikTRIController extends PemeriksaanFisikController
//{
//    
//}
class PemeriksaanFisikTRIController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $simpanpemeriksaanfisik = false;
	public $simpanpemeriksaangambar = true;


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	
	public function actionIndex()
	{   
            $this->layout='//layouts/iframe';
//            $result = $this->xmlParser();
            $pendaftaran_id = (isset($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:null);
            $pasienadmisi_id = (isset($_GET['pasienadmisi_id'])?$_GET['pasienadmisi_id']:null);
			$tglperiksafisik = (isset($_GET['tglperiksafisik'])?$_GET['tglperiksafisik']:null);
            $modBagianTubuh = new RIBagiantubuhM();
			$modGambarTubuh = new RIGambartubuhM();
			$modPemeriksaanGambar = RIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            if (isset($pendaftaran_id)){ // jika di klik ubah di tabel Riwayat Fisik
            $pendaftaran_id = $pendaftaran_id;
            $pasienadmisi_id = $pasienadmisi_id;            
                $cekPemeriksaanFisik=RIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'tglperiksafisik'=>$tglperiksafisik));
                $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
                $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
                $tabelPemeriksaan = RIPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id),array('order'=>'create_time DESC'));
            }else{
                $cekPemeriksaanFisik=RIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id'=>null));
                $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
                $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
                $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id)) : array();
                $tabelPemeriksaan = RIPemeriksaanFisikT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id),array('order'=>'create_time DESC'));
            }
            
            $format = new MyFormatter();
            $modRIMetodeGSCM = RIMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_singkatan,metodegcs_nilai DESC');
            
                if(COUNT($cekPemeriksaanFisik)>0)
                    {  //Jika Pasien Sudah Melakukan Pemeriksaan Fisik  Sebelumnya
                        $modPemeriksaanFisik=$cekPemeriksaanFisik;
			$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			if (!empty($pegawai)) $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
                    }
                else
                    {  //Jika Pasien Belum Pernah melakukan Pemeriksaan Fisik
                        $modPemeriksaanFisik=new RIPemeriksaanFisikT;
                        $modPemeriksaanFisik->pegawai_id=$modPendaftaran->pegawai_id;
                        $modPemeriksaanFisik->pendaftaran_id=$modPendaftaran->pendaftaran_id;
                        $modPemeriksaanFisik->pasien_id=$modPasien->pasien_id;
                        $modPemeriksaanFisik->tglperiksafisik=date('Y-m-d H:i:s');
			$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
			if (!empty($pegawai)) $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
                    }
//            $modPemeriksaanFisik->td_diastolic = $result[2];
//            $modPemeriksaanFisik->td_systolic = $result[1];
//            $modPemeriksaanFisik->detaknadi = $result[3];
//            
//            $modPemeriksaanFisik->tekanandarah = $this->panjangText($modPemeriksaanFisik->td_diastolic, $modPemeriksaanFisik->td_systolic);;
//            echo $modPemeriksaanFisik->tekanandarah;exit();
                    // input baru 
                    if(isset($_POST['RIPemeriksaanFisikT']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id']))
                    {
//                        echo nl2br(print_r($_POST['RIPemeriksaanFisikT'],1));
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                                $modPemeriksaanFisik->attributes=$_POST['RIPemeriksaanFisikT'];
                                if ($_POST['RIPemeriksaanFisikT']['gcs_id'] < 1) {
                                    $_POST['RIPemeriksaanFisikT']['gcs_id'] = null;
                                }
//                                $modPemeriksaanFisik->keadaanumum = isset($_POST['RIPemeriksaanFisikT']['keadaanumum'])? $_POST['RIPemeriksaanFisikT']['keadaanumum'] : "-";
                                $modPemeriksaanFisik->keadaanumum = isset($_POST['RIPemeriksaanFisikT']['keadaanumum']) ? implode(', ', $_POST['RIPemeriksaanFisikT']['keadaanumum']) : '';
                                $modPemeriksaanFisik->tglperiksafisik=$format->formatDateTimeForDb($_POST['RIPemeriksaanFisikT']['tglperiksafisik']);
//                                $modPemeriksaanFisik->indexmassatubuh=isset($_POST['imtValue'])?$_POST['imtValue']:null;
                                $modPemeriksaanFisik->pasienadmisi_id = $_GET['pasienadmisi_id'];
                                $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
                                $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
                                $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;
								
								$modPemeriksaanFisik->jn_paten=$_POST['RIPemeriksaanFisikT']['jn_paten'];
                                $modPemeriksaanFisik->jn_obstruktifpartial=$_POST['RIPemeriksaanFisikT']['jn_obstruktifpartial'];
                                $modPemeriksaanFisik->jn_obstruktifnormal=$_POST['RIPemeriksaanFisikT']['jn_obstruktifnormal'];
                                $modPemeriksaanFisik->jn_stridor=$_POST['RIPemeriksaanFisikT']['jn_stridor'];
                                $modPemeriksaanFisik->jn_gargling=$_POST['RIPemeriksaanFisikT']['jn_gargling'];
                                $modPemeriksaanFisik->pgp_normal=$_POST['RIPemeriksaanFisikT']['pgp_normal'];
                                $modPemeriksaanFisik->pgp_kussmaul=$_POST['RIPemeriksaanFisikT']['pgp_kussmaul'];
                                $modPemeriksaanFisik->pgp_takipnea=$_POST['RIPemeriksaanFisikT']['pgp_takipnea'];
                                $modPemeriksaanFisik->pgp_retraktif=$_POST['RIPemeriksaanFisikT']['pgp_retraktif'];
                                $modPemeriksaanFisik->pgp_dangkal=$_POST['RIPemeriksaanFisikT']['pgp_dangkal'];
                                $modPemeriksaanFisik->pgd_simetri=$_POST['RIPemeriksaanFisikT']['pgd_simetri'];
                                $modPemeriksaanFisik->pgd_asimetri=$_POST['RIPemeriksaanFisikT']['pgd_asimetri'];
                                $modPemeriksaanFisik->sirkulasi_nadicarotis=$_POST['RIPemeriksaanFisikT']['sirkulasi_nadicarotis'];
                                $modPemeriksaanFisik->sirkulasi_nadiradialis=$_POST['RIPemeriksaanFisikT']['sirkulasi_nadiradialis'];
                                $modPemeriksaanFisik->cfr_kecil_2=$_POST['RIPemeriksaanFisikT']['cfr_kecil_2'];
                                $modPemeriksaanFisik->cfr_besar_2=$_POST['RIPemeriksaanFisikT']['cfr_besar_2'];
                                $modPemeriksaanFisik->kulit_normal=$_POST['RIPemeriksaanFisikT']['kulit_normal'];
                                $modPemeriksaanFisik->kulit_jaundice=$_POST['RIPemeriksaanFisikT']['kulit_jaundice'];
                                $modPemeriksaanFisik->kulit_cyanosis=$_POST['RIPemeriksaanFisikT']['kulit_cyanosis'];
                                $modPemeriksaanFisik->kulit_pucat=$_POST['RIPemeriksaanFisikT']['kulit_pucat'];
                                $modPemeriksaanFisik->kulit_berkeringat=$_POST['RIPemeriksaanFisikT']['kulit_berkeringat'];
                                $modPemeriksaanFisik->akral=$_POST['RIPemeriksaanFisikT']['akral'];
								//$modPemeriksaanFisik->validate();
								if($modPemeriksaanFisik->validate()){
									if($modPemeriksaanFisik->save()){
										//$updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
										$this->simpanpemeriksaanfisik = true;
									}
								}
								if(isset($_POST['RIPemeriksaangambarT'])){
									if(count($_POST['RIPemeriksaangambarT'])>0){
										foreach($_POST['RIPemeriksaangambarT'] as $i =>$postperiksagbr){
											$this->simpanpemeriksaangambar &= $this->simpanPemeriksaanGambar($postperiksagbr,$modPemeriksaanFisik,$modGambarTubuh);
                                                                                        var_dump($this->simpanpemeriksaangambar);
										}
									}
								}
				//var_dump($this->simpanpemeriksaanfisik && $this->simpanpemeriksaangambar); die;				
                                if($this->simpanpemeriksaanfisik && $this->simpanpemeriksaangambar){
									$transaction->commit();
									Yii::app()->user->setFlash('success',"Data Pemeriksaan Fisik berhasil disimpan");
									$this->redirect(array('index', 'pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1));
                                }else{
									$transaction->rollback();
									Yii::app()->user->setFlash('error',"Data Pemeriksaan Fisik gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
									$this->redirect($_POST['url']);
								}
								
                             }
                        catch (Exception $exc) 
                            {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error',"Data Pemeriksaan Fisik gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
								$this->redirect($_POST['url']);
                            }
                    } 
                    // end input baru
                    // update data
                    if(isset($_POST['RIPemeriksaanFisikT']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id']) && isset($_GET['tglperiksafisik']))
                    {
                        $modPemeriksaanFisik->attributes=$_POST['RIPemeriksaanFisikT'];
                        $modPemeriksaanFisik->keadaanumum = isset($_POST['RIPemeriksaanFisikT']['keadaanumum']) ? implode(', ', $_POST['RIPemeriksaanFisikT']['keadaanumum']) : ''; 
                        $modPemeriksaanFisik->tglperiksafisik=$format->formatDateTimeForDb($_POST['RIPemeriksaanFisikT']['tglperiksafisik']);
                        $modPemeriksaanFisik->indexmassatubuh=isset($_POST['imtValue'])?$_POST['imtValue']:null;
                        $modPemeriksaanFisik->pasienadmisi_id = $_GET['pasienadmisi_id'];
                        $modPemeriksaanFisik->update_time = date('Y-m-d H:i:s');
                        $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modPemeriksaanFisik->update_loginpemakai_id = Yii::app()->user->id;
                        
                        
                        if ($modPemeriksaanFisik->save()){
                        Yii::app()->user->setFlash('success',"Update Data Pemeriksaan Fisik Berhasil");
                        $this->refresh();
                        }
                    }   
                    //end update data
                  $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss'));       
                  $this->render('index',array('modPasien'=>$modPasien,
                        'modPemeriksaanFisik'=>$modPemeriksaanFisik,
                        'modPendaftaran'=>$modPendaftaran,
                        'modRIMetodeGSCM'=>$modRIMetodeGSCM,
                        'modAdmisi'=>$modAdmisi,
                        'format'=>$format,
                        'tabelPemeriksaan'=>$tabelPemeriksaan,
                        'modGambarTubuh'=>$modGambarTubuh,
						'modBagianTubuh'=>$modBagianTubuh,
						'modPemeriksaanGambar'=>$modPemeriksaanGambar,
		));

	}
        
        public function actionHapusRiwayatPemeriksaan(){
            if(Yii::app()->request->isAjaxRequest) {
                $idPemeriksaanFisik = (isset($_POST['pemeriksaanfisik_id'])?$_POST['pemeriksaanfisik_id']:null);
                $data['pesan'] = "";
                $data['sukses'] = 0;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $deletePemeriksaanFisik = RIPemeriksaanFisikT::model()->deleteByPk($idPemeriksaanFisik);
                    if($deletePemeriksaanFisik){
                        $data['pesan'] = "Riwayat Pemeriksaan Fisik Berhasil Dihapus!";
                        $data['sukses'] = 1;
                        $transaction->commit();
                    }else{
                        $data['pesan'] = "Gagal Menghapus Pemeriksaan Fisik";
                        $data['sukses'] = 0;
                        $transaction->rollback();
                    }
                }catch (Exception $exc) {
                    $transaction->rollback();
                    $data['pesan'] = "Hapus Data Gagal :".MyExceptionMessage::getMessage($exc,true);
                }
                echo CJSON::encode($data);
            }
            Yii::app()->end();
        }	
        
        //function ajax get Text Tekanan Body Mass Index untuk form Pemeriksaan Fisik
        public function actionGetBMIText(){
            if (Yii::app()->request->isAjaxRequest){
                $bmi = (isset($_POST['bmi']) ? $_POST['bmi'] : null) ;
                $criteria2 = new CDbCriteria();
                $criteria2->select = 'max(bmi_minimum) as max_bmi';
                $modBMI = BodymassindexM::model()->find($criteria2);
                $criteria = new CDbCriteria();
                //$criteria->addCondition($bmi.' >= bmi_minimum');

                if ($bmi > $modBMI->max_bmi){
                     $criteria->condition = 'bmi_minimum <= '.$bmi.' and bmi_maksimum = 0';
                     //$criteria->condition('0 <= bmi_maksimum');
                }else{
                    $criteria->addCondition($bmi.' >= bmi_minimum');
                    $criteria->addCondition($bmi.' <= bmi_maksimum');
                }
                //echo $bmi;exit();
                //$criteria->order='bmi_minimum ASC';
                $data = array();
                $bmi = BodymassindexM::model()->find($criteria);
                $data['text'] = (isset($bmi->bmi_defenisi) ? $bmi->bmi_defenisi : "");
                echo json_encode($data);                
            }
            Yii::app()->end();
        }
//        protected function xmlParser(){            
//            $file = dirname('c:/').'/data/xml/ostar.xml';
//            echo $file;
//                    ////'http://www.php.net/feed.atom';
//            $data = simplexml_load_file($file);
////            print_r($data);
//            //echo count($data);
//            
//            $result = array($data->BPMRecord[0]['Date_Time'], $data->BPMRecord[0]['H'], $data->BPMRecord[0]['L'], $data->BPMRecord[0]['P']);
//            return $result;
//        }
//        
//        protected function panjangText($a,$b){
//            $tambah = '';
//            if (strlen($a) < 3){
//                for($i = strlen($a); $i < 3; $i++){
//                    $tambah = $tambah.'0';
//                }
//                $a = $tambah.$a;
//            }
//            $tambah = '';
//            if (strlen($b) < 3){
//                for($i = strlen($b); $i < 3; $i++){
//                    $tambah = $tambah.'0';
//                }
//                $b = $tambah.$b;
//            }
//            
//            return $b.' / '.$a;
//        }

        /**
     * @param type $pendaftaran_id
     */
    public function actionPrintPemeriksaanFisik($pendaftaran_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran=RIPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPemeriksaanFisik=RIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modPemeriksaanGambar = RIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modGambarTubuh = new RIGambartubuhM();
		$modBagianTubuh = new RIBagiantubuhM();
        $jumlah=0;
        $hasil=null;
        $gcs_eye=$modPemeriksaanFisik->gcs_eye;
        $gcs_motorik=$modPemeriksaanFisik->gcs_motorik;
        $gcs_verbal=$modPemeriksaanFisik->gcs_verbal;
         
        $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
        $namaGCS=GcsM::model()->find(''.$jumlah.'>=gcs_nilaimin AND '.$jumlah.'<=gcs_nilaimax AND gcs_aktif=TRUE');
        if(COUNT($namaGCS)>0){//Jika Nilai GCSnya ada
            $hasil=$namaGCS->gcs_nama;
        }else{
            $hasil='Nilai GCS Tidak Ditemukan';
        }
        
        $judul_print = 'PEMERIKSAAN FISIK';
        $this->render('print', array(
                            'format'=>$format,
                            'hasil'=>$hasil,
                            'modPendaftaran'=>$modPendaftaran,
                            'judul_print'=>$judul_print,
                            'modPasien'=>$modPasien,
                            'modPemeriksaanFisik'=>$modPemeriksaanFisik,
							'modPemeriksaanGambar'=>$modPemeriksaanGambar,
							'modGambarTubuh'=>$modGambarTubuh,
							'modBagianTubuh'=>$modBagianTubuh
        ));
    } 

    public function actionAjaxDetailFisik()
        {
            if(Yii::app()->request->isAjaxRequest) {
            $idFisik = $_POST['idFisik'];
            $pendaftaran_id = $_POST['pendaftaran_id'];
	    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPemeriksaanFisik = RIPemeriksaanFisikT::model()->findByPk($idFisik);
	    $jumlah=0;
	    $hasil=null;
	    $gcs_eye=$modPemeriksaanFisik->gcs_eye;
	    $gcs_motorik=$modPemeriksaanFisik->gcs_motorik;
	    $gcs_verbal=$modPemeriksaanFisik->gcs_verbal;
		$modPemeriksaanGambar = RIPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modGambarTubuh = new RIGambartubuhM();
		$modBagianTubuh = new RIBagiantubuhM();
	    $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
	    $namaGCS=GcsM::model()->find(''.$jumlah.'>=gcs_nilaimin AND '.$jumlah.'<=gcs_nilaimax AND gcs_aktif=TRUE');
	    if(COUNT($namaGCS)>0){//Jika Nilai GCSnya ada
		$hasil=$namaGCS->gcs_nama;
	    }else{
		$hasil='Nilai GCS Tidak Ditemukan';
	    }
            $data['result'] = $this->renderPartial('_viewDetailFisik', array(
				'modPemeriksaanFisik'=>$modPemeriksaanFisik,
				'modPendaftaran'=>$modPendaftaran,
				'hasil'=>$hasil,
				'modPemeriksaanGambar'=>$modPemeriksaanGambar,
				'modGambarTubuh'=>$modGambarTubuh,
				'modBagianTubuh'=>$modBagianTubuh,
					), true);

            echo json_encode($data);
             Yii::app()->end();
            }
        }
		
	public function actionMasterKeadaanUmum() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']),true);
            $keluhans = KeadaanumumM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key'=>$keluhan->keadaanumum_nama,
                                  'value'=>$keluhan->keadaanumum_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
	
	public function simpanPemeriksaanGambar($postperiksagbr,$modPemeriksaanFisik,$modGambarTubuh){
		$format = new MyFormatter;

		$modPemeriksaanGambar = new RIPemeriksaangambarT;
		$modPemeriksaanGambar->attributes = $postperiksagbr; 
		$modPemeriksaanGambar->pemeriksaanfisik_id = $modPemeriksaanFisik->pemeriksaanfisik_id; 
		$modPemeriksaanGambar->gambartubuh_id = $modGambarTubuh->DataGambarAnatomi->gambartubuh_id; 
		$modPemeriksaanGambar->pendaftaran_id = $modPemeriksaanFisik->pendaftaran_id; 
		$modPemeriksaanGambar->pasien_id = $modPemeriksaanFisik->pasien_id; 
		$modPemeriksaanGambar->tglpemeriksaan = date('Y-m-d H:i:s');
		$modPemeriksaanGambar->create_time = date('Y-m-d H:i:s');
		$modPemeriksaanGambar->create_loginpemakai_id = Yii::app()->user->id;
		$modPemeriksaanGambar->create_ruangan = Yii::app()->user->getState('ruangan_id');

		if($modPemeriksaanGambar->validate()){ 
			$modPemeriksaanGambar->save();
			return true;
		} else {
			return false;
		}

	}
	
	public function actionTambahBagianTubuh()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$pesan = '';
			$form = '';
				if(!empty($_POST['bagiantubuh_id'])){
					$modPemeriksaanGbr = new RIPemeriksaangambarT();
					$modPemeriksaanGbr->bagiantubuh_id			= $_POST['bagiantubuh_id'];
					$modPemeriksaanGbr->namabagtubuh			= $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
					$modPemeriksaanGbr->keterangan_periksa_gbr	= $_POST['keterangan'];
					$modPemeriksaanGbr->kordinat_tubuh_x		= $_POST['pic_x'];
					$modPemeriksaanGbr->kordinat_tubuh_y		= $_POST['pic_y'];
					$form = $this->renderPartial('_rowDetail', array('modPemeriksaanGbr'=>$modPemeriksaanGbr), true);
					$axis['x']=$modPemeriksaanGbr->kordinat_tubuh_x;
					$axis['y']=$modPemeriksaanGbr->kordinat_tubuh_y;
					echo CJSON::encode(array('pesan'=>$pesan,'form'=>$form,'axis'=>$axis,'bagiantubuh_id'=>$modPemeriksaanGbr->bagiantubuh_id));
				}else{
					$pesan = 'Bagian tubuh tidak boleh kosong!';
					echo CJSON::encode(array('pesan'=>$pesan));
				}
			
            
        }
        Yii::app()->end();
    }
	
    public function actionHapusBagianTubuh()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$pesan = '';
				$loadPemeriskaanGamabr = RIPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
				if($loadPemeriskaanGamabr->delete()){
					$pesan = '';
					echo CJSON::encode(array('pesan'=>$pesan));
				}else{
					$pesan = "Bagian Tubuh gagal dihapus!";
					echo CJSON::encode(array('pesan'=>$pesan));
				}
        }
        Yii::app()->end();
    }
	
    public function actionGetMetodeGCS(){
         if(Yii::app()->request->isAjaxRequest) {
         $gcs_eye=$_POST['gcs_eye'];
         $gcs_motorik=$_POST['gcs_motorik'];
         $gcs_verbal=$_POST['gcs_verbal'];
         
         $jumlah = $gcs_eye + $gcs_motorik+$gcs_verbal;
         
         //$namaGCS=GcsM::model()->find(''.$jumlah.'>=gcs_nilaimin AND '.$jumlah.'<=gcs_nilaimax AND gcs_aktif=TRUE');
         //if(COUNT($namaGCS)>0){//Jika Nilai GCSnya ada
         //$data['idGCS']=$namaGCS->gcs_id;
         //$data['namaGCS']=$namaGCS->gcs_nama;
         //}else{
         //    $data['pesan']='Nilai GCS Tidak Ditemukan';
         //}
		 $data = $jumlah; //LNG 815
         echo json_encode($data);
         Yii::app()->end();
        }
    }
}
