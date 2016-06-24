
<?php

class PemeriksaanFisikController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
    protected $path_view = 'rawatJalan.views.pemeriksaanFisik.';
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $simpanpemeriksaanfisik = false;
	public $simpanpemeriksaangambar = true;
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	
	public function actionIndex($pendaftaran_id)
	{   
   	    $format = new MyFormatter();
            $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modRJMetodeGSCM = RJMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_id');
			$modBagianTubuh = new RJBagiantubuhM();
			$modGambarTubuh = new RJGambartubuhM();
			$modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $cekPemeriksaanFisik=RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            
            $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id'))?null:KonsulpoliT::model()->findByAttributes(array(
                'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
            ), array(
                'order'=>'tglkonsulpoli desc',
            ));
            
            if(COUNT($cekPemeriksaanFisik)>0)
				{  //Jika Pasien Sudah Melakukan Pemeriksaan Fisik  Sebelumnya
					$modPemeriksaanFisik=$cekPemeriksaanFisik;
					$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
					// $modPemeriksaanFisik->paramedis_nama = empty($pegawai)?null:$pegawai->nama_pegawai;
					$modPemeriksaanFisik->update_time=date('Y-m-d H:i:s');
					$modPemeriksaanFisik->update_loginpemakai_id=Yii::app()->user->id;
					if((!empty($modPemeriksaanFisik->gcs_eye))&&(!empty($modPemeriksaanFisik->gcs_verbal))&&(!empty($modPemeriksaanFisik->gcs_motorik))){
						$modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
					}
				}else{  //Jika Pasien Belum Pernah melakukan Pemeriksaan Fisik
					$modPemeriksaanFisik=new RJPemeriksaanFisikT;
					$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
					$modPemeriksaanFisik->paramedis_nama = empty($pegawai)?null:$pegawai->nama_pegawai;
					$modPemeriksaanFisik->pegawai_id=$modPendaftaran->pegawai_id;
					$modPemeriksaanFisik->pendaftaran_id=$modPendaftaran->pendaftaran_id;
					$modPemeriksaanFisik->pasien_id=$modPasien->pasien_id;
					$modPemeriksaanFisik->tglperiksafisik=date('Y-m-d H:i:s');
					$modPemeriksaanFisik->create_time=date('Y-m-d H:i:s');
					$modPemeriksaanFisik->create_ruangan= isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
					$modPemeriksaanFisik->create_loginpemakai_id=Yii::app()->user->id;
                                        if (!empty($konsul)) {
                                            $modPendaftaran->pegawai_id = $konsul->pegawai_id;
                                            $modPendaftaran->ruangan_id = $konsul->ruangan_id;
                                            $modPemeriksaanFisik->pegawai_id = $konsul->pegawai_id;
                                        }
				}
                                
                    if(isset($_POST['RJPemeriksaanFisikT']))
                    {
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                                $modPemeriksaanFisik->attributes=$_POST['RJPemeriksaanFisikT'];  
                                $modPemeriksaanFisik->keadaanumum = isset($_POST['RJPemeriksaanFisikT']['keadaanumum']) ? ((count($_POST['RJPemeriksaanFisikT']['keadaanumum'])>0) ? implode(', ', $_POST['RJPemeriksaanFisikT']['keadaanumum']) : '') : ''; 
                                $modPemeriksaanFisik->tglperiksafisik=$format->formatDateTimeForDb($_POST['RJPemeriksaanFisikT']['tglperiksafisik']);
                                $modPemeriksaanFisik->denyutjantung=isset($_POST['RJPemeriksaanFisikT']['denyutjantung']) ? $_POST['RJPemeriksaanFisikT']['denyutjantung'] :"";
                                $modPemeriksaanFisik->jn_paten=$_POST['RJPemeriksaanFisikT']['jn_paten'];
                                $modPemeriksaanFisik->jn_obstruktifpartial=$_POST['RJPemeriksaanFisikT']['jn_obstruktifpartial'];
                                $modPemeriksaanFisik->jn_obstruktifnormal=$_POST['RJPemeriksaanFisikT']['jn_obstruktifnormal'];
                                $modPemeriksaanFisik->jn_stridor=$_POST['RJPemeriksaanFisikT']['jn_stridor'];
                                $modPemeriksaanFisik->jn_gargling=$_POST['RJPemeriksaanFisikT']['jn_gargling'];
                                $modPemeriksaanFisik->pgp_normal=$_POST['RJPemeriksaanFisikT']['pgp_normal'];
                                $modPemeriksaanFisik->pgp_kussmaul=$_POST['RJPemeriksaanFisikT']['pgp_kussmaul'];
                                $modPemeriksaanFisik->pgp_takipnea=$_POST['RJPemeriksaanFisikT']['pgp_takipnea'];
                                $modPemeriksaanFisik->pgp_retraktif=$_POST['RJPemeriksaanFisikT']['pgp_retraktif'];
                                $modPemeriksaanFisik->pgp_dangkal=$_POST['RJPemeriksaanFisikT']['pgp_dangkal'];
                                $modPemeriksaanFisik->pgd_simetri=$_POST['RJPemeriksaanFisikT']['pgd_simetri'];
                                $modPemeriksaanFisik->pgd_asimetri=$_POST['RJPemeriksaanFisikT']['pgd_asimetri'];
                                $modPemeriksaanFisik->sirkulasi_nadicarotis=$_POST['RJPemeriksaanFisikT']['sirkulasi_nadicarotis'];
                                $modPemeriksaanFisik->sirkulasi_nadiradialis=$_POST['RJPemeriksaanFisikT']['sirkulasi_nadiradialis'];
                                $modPemeriksaanFisik->cfr_kecil_2=$_POST['RJPemeriksaanFisikT']['cfr_kecil_2'];
                                $modPemeriksaanFisik->cfr_besar_2=$_POST['RJPemeriksaanFisikT']['cfr_besar_2'];
                                $modPemeriksaanFisik->kulit_normal=$_POST['RJPemeriksaanFisikT']['kulit_normal'];
                                $modPemeriksaanFisik->kulit_jaundice=$_POST['RJPemeriksaanFisikT']['kulit_jaundice'];
                                $modPemeriksaanFisik->kulit_cyanosis=$_POST['RJPemeriksaanFisikT']['kulit_cyanosis'];
                                $modPemeriksaanFisik->kulit_pucat=$_POST['RJPemeriksaanFisikT']['kulit_pucat'];
                                $modPemeriksaanFisik->kulit_berkeringat=$_POST['RJPemeriksaanFisikT']['kulit_berkeringat'];
                                $modPemeriksaanFisik->akral=$_POST['RJPemeriksaanFisikT']['akral'];
                                // var_dump($modPemeriksaanFisik->attributes); die;
                                if($modPemeriksaanFisik->validate()){
									if($modPemeriksaanFisik->save()){
                                                                                $dat = PasienpulangT::model()->findByAttributes(array(
                                                                                    // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                                                                                    'pendaftaran_id'=>$pendaftaran_id
                                                                                ));
                                                                                $adm = PasienadmisiT::model()->findByAttributes(array(
                                                                                    // 'carakeluar_id'=>Params::CARAKELUAR_ID_RAWATINAP,
                                                                                    'pendaftaran_id'=>$pendaftaran_id
                                                                                ));
                                                                                if (!(!empty($adm) || !empty($dat))) $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
										$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
										$konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
										if(count($konsulPoli)>0){
										  $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
										}
										$this->simpanpemeriksaanfisik = true;
									}
                                }
								if(isset($_POST['RJPemeriksaangambarT'])){
									if(count($_POST['RJPemeriksaangambarT'])>0){
										foreach($_POST['RJPemeriksaangambarT'] as $i =>$postperiksagbr){
											$this->simpanpemeriksaangambar &= $this->simpanPemeriksaanGambar($postperiksagbr,$modPemeriksaanFisik,$modGambarTubuh);
										}
									}
								}
                                                                // var_dump($modPemeriksaanFisik->attributes);
                                                                // var_dump($this->simpanpemeriksaanfisik,$this->simpanpemeriksaangambar); 
                                                                // die;
								if($this->simpanpemeriksaanfisik && $this->simpanpemeriksaangambar){
									$transaction->commit();
									Yii::app()->user->setFlash('success',"Data Pemeriksaan Fisik berhasil disimpan");
									$this->redirect($_POST['url']); 
								}else{
									$transaction->rollback();
									Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
									$this->redirect($_POST['url']); 
								}
								
                                
							}catch (Exception $exc){
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error',"Data Pemeriksaan Fisik gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
							}
                    } 
                    
                    
                  $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss'));       
                  $this->render($this->path_view.'index',array('modPasien'=>$modPasien,
                        'modPemeriksaanFisik'=>$modPemeriksaanFisik,
                        'modPendaftaran'=>$modPendaftaran,
                        'modRJMetodeGSCM'=>$modRJMetodeGSCM,
						'modBagianTubuh'=>$modBagianTubuh,
						'modGambarTubuh'=>$modGambarTubuh,
						'modPemeriksaanGambar'=>$modPemeriksaanGambar
		));

	}
        
        //-- Rawat Jalan --//
        //function ajax get Text Tekanan Body Mass Index untuk form Pemeriksaan Fisik
        public function actionGetBMIText(){
            if (Yii::app()->request->isAjaxRequest){
                $bmi = (isset($_POST['bmi']) ? $_POST['bmi'] : null) ;
                $criteria2 = new CDbCriteria();
                $criteria2->select = 'max(bmi_minimum) as max_bmi';
                $modBMI = BodymassindexM::model()->find($criteria2);
                $criteria = new CDbCriteria();

                if ($bmi > $modBMI->max_bmi){
                     $criteria->condition = 'bmi_minimum <= '.$bmi.' and bmi_maksimum = 0';
                }else{
                    $criteria->addCondition($bmi.' >= bmi_minimum');
                    $criteria->addCondition($bmi.' <= bmi_maksimum');
                }
                $data = array();
                $bmi = BodymassindexM::model()->find($criteria);
                $data['text'] = (isset($bmi->bmi_defenisi) ? $bmi->bmi_defenisi : "");
                echo json_encode($data);                
            }
            Yii::app()->end();
        }
		
        // function untuk simpan data pemeriksaan gambar
		// RND-RND-7611
        public function simpanPemeriksaanGambar($postperiksagbr,$modPemeriksaanFisik,$modGambarTubuh){
            $format = new MyFormatter;
			
			$modPemeriksaanGambar = new RJPemeriksaangambarT;
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
				return $modPemeriksaanGambar->save();
			} else {
                                return false;
			}
			
        }
        
        //-- Rawat Jalan --//
    //function ajax get Text Tekanan Darah untuk form Pemeriksaan Fisik
    public function actionGetTextTekananDarah(){
        if(Yii::app()->request->isAjaxRequest){
            $systolic = $_POST['systolic'];
            $diastolic = $_POST['diastolic'];
            $criteria2 = new CDbCriteria();
            $criteria2->select = 'max(systolic_min) as sys_max';
            $modSys = SysdiaM::model()->find($criteria2);
            $criteria3 = new CDbCriteria();
            $criteria3->select = 'max(diastolic_min) as dias_max';
            $modDia = SysdiaM::model()->find($criteria3);
            
            $criteria = new CDbCriteria();
            
            if ($systolic > $modSys->sys_max){
                $criteria->condition = 'systolic_min <= '.$systolic.' and systolic_max = 0';
            }else{
                $criteria->addCondition($systolic.' >= systolic_min');
                $criteria->addCondition($systolic.' <= systolic_max');
            }
            
            if ($diastolic > $modDia->dias_max){
                $criteria->condition = 'diastolic_min <= '.$diastolic.' and diastolic_max = 0';
            }else{
                $criteria->addCondition($diastolic.' >= diastolic_min');
                $criteria->addCondition($diastolic.' <= diastolic_max');
            }
            
            $modSysDia = SysdiaM::model()->find($criteria);
            $data['text'] = $modSysDia->sysdia_nama;
            echo json_encode($data);
            
        }
        Yii::app()->end();
    }
        
    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintPemeriksaanFisik($pendaftaran_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modPemeriksaanFisik=RJPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modPemeriksaanGambar = RJPemeriksaangambarT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modGambarTubuh = new RJGambartubuhM();
		$modBagianTubuh = new RJBagiantubuhM();
         if((!empty($modPemeriksaanFisik->gcs_eye))&&(!empty($modPemeriksaanFisik->gcs_verbal))&&(!empty($modPemeriksaanFisik->gcs_motorik))){
			$modPemeriksaanFisik->namaGCS = $modPemeriksaanFisik->gcs_eye + $modPemeriksaanFisik->gcs_verbal + $modPemeriksaanFisik->gcs_motorik;
		}
		
        $judul_print = 'PEMERIKSAAN FISIK';
        $this->render($this->path_view.'print', array(
                            'format'=>$format,
                            'modPendaftaran'=>$modPendaftaran,
                            'judul_print'=>$judul_print,
                            'modPasien'=>$modPasien,
                            'modPemeriksaanFisik'=>$modPemeriksaanFisik,
							'modPemeriksaanGambar'=>$modPemeriksaanGambar,
							'modGambarTubuh'=>$modGambarTubuh,
							'modBagianTubuh'=>$modBagianTubuh
        ));
    } 
	
    // RND-5044 action pindahan dari Controller/ActionAjaxController
    public function actionGetMetodeGCS(){
         if(Yii::app()->request->isAjaxRequest) {
         $gcs_eye=$_POST['gcs_eye'];
         $gcs_motorik=$_POST['gcs_motorik'];
         $gcs_verbal=$_POST['gcs_verbal'];
         
         $jumlah = $gcs_eye + $gcs_motorik+$gcs_verbal;
         
//         $namaGCS=GcsM::model()->find(''.$jumlah.'>=gcs_nilaimin AND '.$jumlah.'<=gcs_nilaimax AND gcs_aktif=TRUE');
//         if(COUNT($namaGCS)>0){//Jika Nilai GCSnya ada
//         $data['idGCS']=$namaGCS->gcs_id;
//         $data['namaGCS']=$namaGCS->gcs_nama;
//         }else{
//             $data['pesan']='Nilai GCS Tidak Ditemukan';
//         }
		 $data = $jumlah; //LNG 815
         echo json_encode($data);
         Yii::app()->end();
        }
    }
    
    public function actionGetfromDevice(){
        if (Yii::app()->request->isAjaxRequest){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $file = dirname('c:/OstarP2/x').'/OstarXML.xml';
            } else {
                $file = Yii::app()->getBaseUrl('webroot').'/data/xml/ostar.xml';
            }
            
            $data2 = simplexml_load_file($file);
            $a = $data2->BPMRecord[0]['H'];
            $b = $data2->BPMRecord[0]['L'];
            $c = $data2->BPMRecord[0]['P'];

            $tambah = '';
            if (strlen($a) < 3){
                for($i = strlen($a); $i < 3; $i++){
                    $tambah = $tambah.'0';
                }
                $a = $tambah.$a;
            }
            $tambah = '';
            if (strlen($b) < 3){
                for($i = strlen($b); $i < 3; $i++){
                    $tambah = $tambah.'0';
                }
                $b = $tambah.$b;
            }
            
            $data['sys'] = "$a";
            $data['dias'] = "$b";
            $data['detaknadi'] = "$c";
            $data['tekanandarah'] = $a.' / '.$b;
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionMasterKeadaanUmum() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']),true);
            $criteria->order = "keadaanumum_nama ASC";
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
    
    // RND-5044 action pindahan dari Controller/ActionAutoCompleteController
    public function actionAutocompleteParamedisRJ()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit=10;
            $models = ParamedisV::model()->findAll($criteria);
             foreach ($models as $item) {
                 $arr[] = $item->nama_pegawai;
             }

            echo CJSON::encode($arr);
        }
        Yii::app()->end();
    }
	
    public function actionTambahBagianTubuh()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$pesan = '';
			$form = '';
				if(!empty($_POST['bagiantubuh_id'])){
					$modPemeriksaanGbr = new RJPemeriksaangambarT();
					$modPemeriksaanGbr->bagiantubuh_id			= $_POST['bagiantubuh_id'];
					$modPemeriksaanGbr->namabagtubuh			= $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
					$modPemeriksaanGbr->keterangan_periksa_gbr	= $_POST['keterangan'];
					$modPemeriksaanGbr->kordinat_tubuh_x		= $_POST['pic_x'];
					$modPemeriksaanGbr->kordinat_tubuh_y		= $_POST['pic_y'];
					$form = $this->renderPartial($this->path_view.'_rowDetail', array('modPemeriksaanGbr'=>$modPemeriksaanGbr), true);
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
				$loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
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
    
}
