<?php
class PendaftaranRawatJalanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";

	public $pasientersimpan = false;
	public $pendaftarantersimpan = false;
	public $penanggungjawabtersimpan = false;
	public $karcistersimpan = false;
	public $komponentindakantersimpan = false;
	public $rujukantersimpan = false;
	public $asuransipasientersimpan = false;
	public $septersimpan = false;
        
        public $is_rm_manual = false;
        
	/**
         * menampilkan detail pendaftaran
         * @param type $id
         */
	public function actionView($id)
	{
            $model = $this->loadModel($id);
            $modPasien=PPPasienM::model()->findByPk($model->pasien_id);
			$modPegawai = new PPPegawaiM;
			if(!empty($modPasien->pegawai_id)){
				$modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);
			}
            $modPenanggungJawab = null;
            $modRujukan = null;
            
            if(!empty($model->penanggungjawab_id)){
                $modPenanggungJawab=PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
            }
            if(!empty($model->rujukan_id)){
                $modRujukan=PPRujukanT::model()->findByPk($model->rujukan_id);
            }
            $modTindakan=PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is not null");
            $this->render('view',array(
                    'model'=>$model,
                    'modPasien'=>$modPasien,
                    'modPenanggungJawab'=>$modPenanggungJawab,
                    'modRujukan'=>$modRujukan,
                    'modTindakan'=>$modTindakan,
            ));
	}
        /**
         * form verifikasi sebelum submit
         * @param type $id
         */
        public function actionVerifikasi()
	{
            if (Yii::app()->request->isAjaxRequest){
                $this->layout = '//layouts/iframe';
                if(isset($_POST['PPPendaftaranT'])){
                    $format = new MyFormatter();
                    $model=new PPPendaftaranT;
                    $modPasien=new PPPasienM;
					$modPegawai = new PPPegawaiM;
                    $modPenanggungJawab = null;
                    $modRujukan=null;
                    $modTindakan = null;

                    $model->attributes = $_POST['PPPendaftaranT'];
					$model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
                    $modPasien->attributes = $_POST['PPPasienM'];
					if(!empty($modPasien->pegawai_id)){
	                    $modPegawai->attributes = $modPasien->pegawai->attributes;
					}
                    if($_POST['PPPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['PPPenanggungJawabM'])){
                            $modPenanggungJawab=new PPPenanggungJawabM;
                            $modPenanggungJawab->attributes = $_POST['PPPenanggungJawabM'];
                        }
                    }

                    if($_POST['PPPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['PPRujukanT'])){
                            $modRujukan=new PPRujukanT;
                            $modRujukan->attributes = $_POST['PPRujukanT'];
                            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
                        }
                    }
                    if($_POST['PPPendaftaranT']['is_adakarcis']){
                        if(isset($_POST['PPTindakanPelayananT'])){
                            if(count($_POST['PPTindakanPelayananT']) > 0){
                                foreach($_POST['PPTindakanPelayananT'] as $i => $karcis){
                                    if($karcis['is_pilihtindakan']){
										$modTindakan[$i]=new PPTindakanPelayananT;
                                        $modTindakan[$i]->attributes = $karcis;
                                        $modTindakan[$i]->karcis_id = $karcis['karcis_id'];
                                    }
                                }
                            }
                        }
                    }

                }
                echo CJSON::encode(array(
                    'content'=>$this->renderPartial('verifikasi',array(
                        'model'=>$model,
                        'modPasien'=>$modPasien,
                        'modPegawai'=>$modPegawai,
                        'modPenanggungJawab'=>$modPenanggungJawab,
                        'modRujukan'=>$modRujukan,
                        'modTindakan'=>$modTindakan,
                        'format'=>$format,
                ), true)));
                Yii::app()->end();
            }
	}
	
	public function actionGetRujukanDari($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];
            
           if($encode) {
                echo CJSON::encode($rujukandari);
           } else {
                if(empty($asalrujukan_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id), array('order'=>'namaperujuk'));
                        $rujukandari = CHtml::listData($rujukandari,'rujukandari_id','namaperujuk');
                        foreach($rujukandari as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                        
                }
           }
        }
        Yii::app()->end();
    }
        
        public function actionGetPPKRujukan() {
            if(Yii::app()->request->isAjaxRequest) {
                if (isset($_POST['rujukan_id'])) {
                    $rujukan = RujukandariM::model()->findByPk($_POST['rujukan_id']);
                    echo $rujukan->ppkrujukan;
                } else {
                    echo "";
                }
            }
        }

	/**
	 * Index transaksi pendaftaran
	 */
	public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
	{
            $format = new MyFormatter();
            $model=new PPPendaftaranT;
            $modPasien=new PPPasienM;
            $modPegawai=new PPPegawaiM;
            $modPenanggungJawab=new PPPenanggungJawabM;
            $modRujukan=new PPRujukanT;
            $modRujukanBpjs=new PPRujukanbpjsT;
            $modTindakan=new PPTindakanPelayananT;
            $modPembayaran = new PPPembayaranpelayananT();
            $modAntrian=new PPAntrianT;
            $modAsuransiPasien=new PPAsuransipasienM;
            $modAsuransiPasienBpjs =new PPAsuransipasienbpjsM;
            $modAsuransiPasienBadak =new PPAsuransipasienbadakM();
            $modAsuransiPasienDepartemen =new PPAsuransipasiendepartemenM();
            $modAsuransiPasienPekerja =new PPAsuransipasienpegawaiM();
            $modSep=new PPSepT;
            $dataTindakans = array();
			$modKarcisV =array();
            $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
            $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
            $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
            $modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
            $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
            $modPasien->agama = Params::DEFAULT_AGAMA;
            $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
            $model->is_bpjs = 0;
            $model->is_asubadak = 0;
            $model->is_asudepartemen = 0;
            $model->is_asupekerja = 0;

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
            $criteria = new CDbCriteria;
            $criteria->compare('modul_id',$modul_id);
            $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
            $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
            if(isset($_POST['tujuansms'])){
                $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
            }
            $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
            
            $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;

            if(isset($_POST['buatjanjipoli_id'])){ //dari informasi janji poli
                if(!empty($_POST['buatjanjipoli_id'])){
                    $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['buatjanjipoli_id']);
                    if(!empty($modJanjipoli->pasien_id)){
                        $modPasien = PPPasienM::model()->findByPk($modJanjipoli->pasien_id);
                        $modPasien->tanggal_lahir = date('d/m/Y',strtotime($modPasien->tanggal_lahir));
						if($modPasien->ispasienluar == TRUE){
							$modPasien->no_rekam_medik = null;
							$modPasien->pasien_id = null;
						}
                    }
					$model->no_urutantri = $modJanjipoli->no_antrianjanji;
					$model->buatjanjipoli_id = $_POST['buatjanjipoli_id'];
                    if(!empty($modJanjipoli->ruangan_id))
                        $model->ruangan_id = $modJanjipoli->ruangan_id;
					if(!empty($modJanjipoli->pegawai_id))
                        $model->pegawai_id = $modJanjipoli->pegawai_id;
                }
            }
            
            //==load data
            
            if (!empty($idAntrian)) {
                $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
                    'condition'=>'pendaftaran_id is null',
                ));
                if (empty($modAntrian)) {
                    $modAntrian = new PPAntrianT;
                } else {
                    $model->antrian_id = $modAntrian->antrian_id;
                }
            }
            
            if(isset($id)){
                $model = $this->loadModel($id);
                if(isset($idSep)){
                    $model->is_bpjs = 1; 
                    $modRujukanBpjs= PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
                    $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
                }
                $modPasien=PPPasienM::model()->findByPk($model->pasien_id);
						
                if(!empty($model->penanggungjawab_id)){
                    $modPenanggungJawab=PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
                }
                if(!empty($model->rujukan_id)){
                    $modRujukan=PPRujukanT::model()->findByPk($model->rujukan_id);
                }
                $dataTindakans=PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id),"karcis_id is not null");
                $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
            }
			
            if(isset($idSep)){
                $modSep= PPSepT::model()->findByPk($idSep);
            }

            $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
            if(!empty($pasien_id)){
                $modPasien = PPPasienM::model()->findByPk($pasien_id);
                $modPasien->tanggal_lahir = date('d/m/Y',strtotime($modPasien->tanggal_lahir));
            }
			if(!empty($modPasien->pegawai_id)){
				$modPegawai->attributes = $modPasien->pegawai->attributes;
			}
            
            $ruangan = null;
            if (!empty($sk_id)) {
                $sk = SuratketeranganR::model()->findByPk($sk_id);
                $p = PendaftaranT::model()->findByPk($sk->pendaftaran_id);
                $ruangan = $p->ruangankontrol_id;
                
                if ($p->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                    $asuransi = PPAsuransipasienbpjsM::model()->findByPk($p->asuransipasien_id);
                    if (empty($asuransi)) $asuransi = PPAsuransipasienbpjsM::model()->findByAttributes(array(
                        'pasien_id'=>$p->pasien_id,
                        'carabayar_id'=>$p->carabayar_id,
                    ));
                    if (!empty($asuransi)) {
                        $rujuk = RujukandariM::model()->findByPk(Params::RUJUKANDARI_ID_ABE);
                        $modAsuransiPasienBpjs->nopeserta = $asuransi->nopeserta;
                        $modRujukanBpjs->asalrujukan_id = Params::ASALRUJUKAN_ID_RS;
                        
                        if (!empty($rujuk)) {
                            $modRujukanBpjs->rujukandari_id = $rujuk->rujukandari_id;
                            $modRujukanBpjs->nama_perujuk = $rujuk->namaperujuk;
                            $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');
                            $modRujukanBpjs->no_rujukan = date('dmYHi', strtotime($p->tglrenkontrol) + (3600 * 24 * 3));
                            $modSep->ppkrujukan = $rujuk->ppkrujukan;
                            
                            // var_dump($modRujukanBpjs->attributes); die;
                        }
                    }
                }
            }            
                        
            if(isset($_POST['PPPendaftaranT']))
            {   
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM']);
                    //var_dump($this->is_rm_manual);
                    if($_POST['PPPendaftaranT']['is_adapjpasien']){
                        if(isset($_POST['PPPenanggungJawabM'])){
                            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
                        }
                    }else{
                        $this->penanggungjawabtersimpan = true; 
                    }
                    
                    if($_POST['PPPendaftaranT']['is_pasienrujukan']){
                        if(isset($_POST['PPRujukanT'])){
                            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
                        }
                    }else{
                        $this->rujukantersimpan = true; 
                    }

                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        if(isset($_POST['PPRujukanbpjsT'])){
                            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
                        }
                    }else{
                        $this->rujukantersimpan = true; 
                    }
                    
                    if(isset($_POST['PPAsuransipasienM'])){
                        if(isset($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                            if(!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])){
                                $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
                            }
                        }
						$modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
                    }else{
                        $this->asuransipasientersimpan = true;
                    }
					
                    if(isset($_POST['PPAsuransipasienbpjsM'])){
						if(isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])){
								$modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
                    
					
                    if($_POST['PPPendaftaranT']['is_bpjs']){
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukanBpjs,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasienBpjs);
                        $modSep = $this->simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$_POST['PPSepT']);
                        //var_dump($modSep->attributes);
                        $model->sep_id = $modSep->sep_id;
                        $model->update();
                    }else{
                        $model = $this->simpanPendaftaran($model,$modPasien,$modRujukan,$modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'],$modAsuransiPasien);
                    }
						
					if(isset($_POST['PPAsuransipasienbadakM'])){
						if(isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])){
								$modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
					if(isset($_POST['PPAsuransipasiendepartemenM'])){
						if(isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])){
								$modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
					if(isset($_POST['PPAsuransipasienpegawaiM'])){
						if(isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])){
							if(!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])){
								$modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
							}
						}
						$modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
					}else{
						$this->asuransipasientersimpan = true;
					}
					
                    $this->karcistersimpan = true;
                    $this->komponentindakantersimpan = true;
                    if($_POST['PPPendaftaranT']['is_adakarcis']){
                        if(isset($_POST['PPTindakanPelayananT'])){
                            if(count($_POST['PPTindakanPelayananT']) > 0){
                                foreach($_POST['PPTindakanPelayananT'] as $i => $karcis){
                                    if($karcis['is_pilihtindakan']){
                                        $dataTindakans[$i] = $this->simpanKarcis($modTindakan, $model ,$karcis);
                                        $model->karcis_id = $dataTindakans[$i]->karcis_id;
                                        $model->save();
                                    }
                                }
                            }
                            if(isset($_POST['PPPendaftaranT']['is_bayarkarcis'])){ //fitur belum ada >> RND-666
                                if($_POST['PPPendaftaranT']['is_bayarkarcis']){ //jika di ceklis
                                }
                            }
                        }
                    }
					
					if(!empty($_POST['PPPendaftaranT']['buatjanjipoli_id'])){
						$modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['PPPendaftaranT']['buatjanjipoli_id']);
						$modJanjipoli->pendaftaran_id = $model->pendaftaran_id;
						$modJanjipoli->save();
					}
                        
                    $judul = 'Pendaftaran Pasien';
                    
                    if ($model->statuspasien == 'PENGUNJUNG LAMA') {
                        $judul .= " Lama";
                    } else $judul .= " Baru";
                    
                    $judul .= " Rawat Jalan";
                    
                    $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;
                    
                    
                    
                    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                        array('instalasi_id'=>Params::INSTALASI_ID_RJ, 'ruangan_id'=>$model->ruangan_id, 'modul_id'=>5),
                        array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                        array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                    ));              
                    // die;           
                    if($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan){
                        
                        //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
//                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));

                        // SMS GATEWAY
                        $modPegawai = $model->pegawai;
                        $modRuangan = $model->ruangan;
                        $sms = new Sms();
                        $smspasien = 1;
                        $smsdokter = 1;
                        $smspenanggungjawab = 1;
                        
                        $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
                        $model->no_urutantri = $model->ruangan->ruangan_singkatan."-".$model->no_urutantri;
                        
                        $modPegawai->nama_pegawai = $modPegawai->namaLengkap;
                        
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            
                            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                                $isiPesan = $smsgateway->templatesms;
                                $isiPesan = "${isiPesan}";

                                $attributes = $modPasien->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPenanggungJawab->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modPegawai->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $model->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modRuangan->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tgl_pendaftaran),$isiPesan);
                                $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                                $isiPesan = str_replace("\\n", hex2bin("0a"), $isiPesan);

                                //var_dump($isiPesan);

                                if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                    if(!empty($modPasien->no_mobile_pasien)){
                                        $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                    }else{
                                        $smspasien = 0;
                                    }
                                }elseif($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
                                    if(!empty($modPegawai->nomobile_pegawai)){
                                        $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                                    }else{
                                        $smsdokter = 0;
                                    }
                                } /*elseif($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms){
                                    if(!empty($modPenanggungJawab->no_mobilepj)){
                                        $sms->kirim($modPenanggungJawab->no_mobilepj,$isiPesan);
                                    }else{
                                        $smspenanggungjawab = 0;
                                    }
                                } */
                            }
                        } 
                        
                        // die;
                        // END SMS GATEWAY
                        
                        $transaction->commit();
                        if($this->septersimpan){
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'idSep'=>$modSep->sep_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }else{
                            $this->redirect(array('index','id'=>$model->pendaftaran_id,'sukses'=>1,'smspasien'=>$smspasien,'smsdokter'=>$smsdokter,'smspenanggungjawab'=>$smspenanggungjawab));
                        }
                        
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data pasien gagal disimpan !");
//                        echo "-".$this->pasientersimpan."<br>";
//                        echo "-".$this->pendaftarantersimpan."<br>";
//                        echo "-".$this->penanggungjawabtersimpan."<br>";
//                        echo "-".$this->rujukantersimpan."<br>";
//                        echo "-".$this->karcistersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        exit;
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
                            . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
                            . "</a>";
                    Yii::app()->user->setFlash('error',"Data pasien gagal disimpan ! ".$btn_ulang." ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            
            $this->render('index',array(
                'model'=>$model,
                'modPasien'=>$modPasien,
                'modPegawai'=>$modPegawai,
                'modPenanggungJawab'=>$modPenanggungJawab,
                'modRujukan'=>$modRujukan,
                'modRujukanBpjs'=>$modRujukanBpjs,
                'modTindakan'=>$modTindakan,
                'modAntrian'=>$modAntrian,
                'modAsuransiPasien'=>$modAsuransiPasien,
                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,
                'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,
                'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,
                'dataTindakans'=>$dataTindakans,
                'modSep'=>$modSep,
                'modSmsgateway'=>$modSmsgateway,
				'modKarcisV'=>$modKarcisV,
                'ruangan'=>$ruangan,
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=PPPendaftaranT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
            if(isset($_POST['ajax']) && $_POST['ajax']==='pppendaftaran-t-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
	}
        
        /**
         * proses simpan / ubah data pasien
         * @param type $modPasien
         * @param type $post
         * @return type
         */
        public function simpanPasien($modPasien, $post){
            $format = new MyFormatter();
            $snrm = "";
            if(isset($post['pasien_id']) && (!empty($post['pasien_id']))){
                $load = new $modPasien;
                $modPasien = $load->findByPk($post['pasien_id']);
                $snrm = $modPasien->no_rekam_medik;
            }
            
            $modPasien->attributes = $post;
            $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
            $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
            if(isset($post['tempPhoto'])){
                $modPasien->photopasien = $post['tempPhoto'];
            }
            if(empty($modPasien->pasien_id)){
                $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
                $modPasien->profilrs_id = Params::DEFAULT_PROFIL_RUMAH_SAKIT;
                $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
                $modPasien->ispasienluar = FALSE;
                $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modPasien->create_loginpemakai_id = Yii::app()->user->id;
                $modPasien->create_time = date('Y-m-d H:i:s');
                if (empty($modPasien->no_rekam_medik) || trim($modPasien->no_rekam_medik) == "") {
                    $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
                } else {
                    $this->is_rm_manual = true;
                }
            }else{
                $modPasien->update_loginpemakai_id = Yii::app()->user->id;
                $modPasien->update_time = date('Y-m-d H:i:s');
                $modPasien->no_rekam_medik = $snrm;
            }
            $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
            $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
            
            
            if($modPasien->save()){
                $this->pasientersimpan = true;
            }
            
            return $modPasien;
        }
        /**
         * proses simpan / ubah data pendaftaran
         * @return type
         */
        public function simpanPendaftaran($model,$modPasien,$modRujukan,$modPenanggungJawab,$post, $postPasien, $modAsuransiPasien){
            $format = new MyFormatter();			
            $modP = PendaftaranT::model()->findByAttributes(array(
                'pasien_id'=>$modPasien->pasien_id,
            ), array(
                'condition'=>'pasienbatalperiksa_id is null',
            ));
            $model->attributes = $post;
            $model->pasien_id = $modPasien->pasien_id;
            $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
            $model->rujukan_id = $modRujukan->rujukan_id;
            $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
            $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
            $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
            $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
            $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
            
            // $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            
            if (empty($postPasien['pasien_id']) || empty($modP)) {
                $model->statuspasien = Params::STATUSPASIEN_BARU;
                $model->kunjungan = Params::STATUSKUNJUNGAN_BARU;
            } else if ($this->is_rm_manual) {
                $model->statuspasien = Params::STATUSPASIEN_LAMA;
                $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            } else {
                $model->statuspasien = Params::STATUSPASIEN_LAMA;
                $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            }
            /*
            $model->statuspasien = (empty($postPasien['pasien_id'] || empty($modP)) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
            $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
            
            if ($this->is_rm_manual) {
                $model->statuspasien = Params::STATUSPASIEN_LAMA;
                $model->kunjungan = Params::STATUSKUNJUNGAN_LAMA;
            } */
            
            $model->shift_id = Yii::app()->user->getState('shift_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_time = date("Y-m-d H:i:s");
			if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
				$model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
			}else{
				$model->tgl_pendaftaran = date("Y-m-d H:i:s");
			}
            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
            $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
            $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
            $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
            $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
            $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
            $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
            $model->keterangan_pendaftaran = $post['keterangan_pendaftaran'];
            
			$modRuangan = PPRuanganM::model()->findByPk($model->ruangan_id);
			$estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;
			
			$tgl_awal = date('Y-m-d');
			$tgl_akhir = date('Y-m-d');
			$criteria = new CDbCriteria();
			$criteria->addCondition('ruangan_id = '.$model->ruangan_id);
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
			$criteria->order = 'tgl_pendaftaran DESC';
			$dataPendaftaran = PPPendaftaranT::model()->find($criteria);
			
			if(count($dataPendaftaran) > 0 && $dataPendaftaran->tglakandilayani != null){
				$tanggal = strtotime($dataPendaftaran->tglakandilayani.' + '.$estimasipelayanan.' minute');
				$tglakandilayani = date('Y-m-d H:i:s', $tanggal);
				
				if( $tglakandilayani < $model->tgl_pendaftaran){
					$tglakandilayani = strtotime($tglakandilayani.' + '.$estimasipelayanan.' minute');
					$tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
					$model->tglakandilayani = $tglakandilayani;
				}else{
					$tglakandilayani = strtotime($model->tgl_pendaftaran.' + '.$estimasipelayanan.' minute');
					$tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
					$model->tglakandilayani = $tglakandilayani;
				}
			}else{
				$tanggal = strtotime($model->tgl_pendaftaran.' + '.$estimasipelayanan.' minute');
				$tglakandilayani = date('Y-m-d H:i:s', $tanggal);
				$model->tglakandilayani = $tglakandilayani;
			}
			// var_dump($model->attributes); die;
            if($model->save()){
                if(!empty($model->antrian_id)){
                    PPAntrianT::model()->updateByPk($model->antrian_id,array('pendaftaran_id'=>$model->pendaftaran_id));
                }
                $this->pendaftarantersimpan = true;
            }else{
                $this->pendaftarantersimpan = false;
            }
            return $model;
        }
        /**
         * proses simpan data penanggungjawab pasien
         * @param type $modPenanggungjawab
         * @param type $post
         * @return type
         */
        public function simpanPenanggungjawab($modPenanggungjawab, $post){
            $format = new MyFormatter;
            $modPenanggungjawab->attributes = $post;
            $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);
            
            if($modPenanggungjawab->save()){
                $this->penanggungjawabtersimpan = true;
            }
            return $modPenanggungjawab;
        }
        /**
         * proses simpan data rujukan
         * @param type $modRujukan
         * @param type $post
         * @return type
         */
        public function simpanRujukan($modRujukan, $post){
            $format = new MyFormatter();
            $modRujukan->attributes = $post;
            $modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count($post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
            $modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count($post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
            $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);
            
            if($modRujukan->save()){
                $this->rujukantersimpan = true;
            }
            return $modRujukan;
        }
        /**
         * proses simpan data rujukan
         * @param type $modRujukan
         * @param type $post
         * @return type
         */
        public function simpanRujukanBpjs($modRujukanBpjs, $post){
            $format = new MyFormatter();
            $modRujukanBpjs->attributes = $post;
            $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count($post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
            $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count($post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
            $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);
            
            if($modRujukanBpjs->save()){
                $this->rujukantersimpan = true;
            }
            return $modRujukanBpjs;
        }
        /**
         * proses simpan karcis
         * @param type $modTindakan
         * @param type $post
         * @return type
         */
        public function simpanKarcis($modTindakan, $model, $post){
            $modTindakan->attributes = $post;
            $modTindakan->create_time = date("Y-m-d H:i:s");
            $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
            $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modTindakan->pendaftaran_id=$model->pendaftaran_id;
            $modTindakan->kelaspelayanan_id=$model->kelaspelayanan_id;
            $modTindakan->shift_id =Yii::app()->user->getState('shift_id');
            $modTindakan->carabayar_id=$model->carabayar_id;
            $modTindakan->penjamin_id=$model->penjamin_id;
            $modTindakan->jeniskasuspenyakit_id=$model->jeniskasuspenyakit_id;
            $modTindakan->pasien_id=$model->pasien_id;
            $modTindakan->dokterpemeriksa1_id=$model->pegawai_id;
            $modTindakan->karcis_id=$post['karcis_id'];
            $modTindakan->tgl_tindakan=date('Y-m-d H:i:s');
            $modTindakan->qty_tindakan=1;
            $modTindakan->tarif_satuan=$modTindakan->getTarifSatuan();
            $modTindakan->tarif_tindakan=$modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
            $modTindakan->satuantindakan=Params::SATUAN_TINDAKAN_PENDAFTARAN;
            $modTindakan->cyto_tindakan=0;
            $modTindakan->tarifcyto_tindakan=0;
            $modTindakan->discount_tindakan=0;
            $modTindakan->subsidiasuransi_tindakan=0;
            $modTindakan->subsidipemerintah_tindakan=0;
            $modTindakan->subsisidirumahsakit_tindakan=0;
            $modTindakan->iurbiaya_tindakan=0;
            $modTindakan->tarif_rsakomodasi=0;
            $modTindakan->tarif_medis=0;
            $modTindakan->tarif_paramedis=0;
            $modTindakan->tarif_bhp=0;
            
            if(!empty($modTindakan->karcis_id)){
                $modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
            }
            
            if($modTindakan->save()){
				$this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
                $this->karcistersimpan = true;
            }else{
                $this->karcistersimpan = false;
            }
                
            return $modTindakan;
        }

		/**
		 * simpan asuransi pasien
		 * @param type $modAsuransiPasien
		 * @param type $postPendaftaran
		 * @param type $postPasien
		 * @param type $postAsuransiPasien
		 * @return type
		 */
        public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien, $postAdmisi = null){
            // var_dump($postAdmisi); die;
            
            $format = new MyFormatter();
            
            $carabayar = isset($postPendaftaran['carabayar_id'])?$postPendaftaran['carabayar_id']:null;
            if (empty($carabayar)) $carabayar = isset($postAdmisi['carabayar_id'])?$postAdmisi['carabayar_id']:null;
            
            $penjamin = isset($postPendaftaran['penjamin_id'])?$postPendaftaran['penjamin_id']:null;
            if (empty($penjamin)) $penjamin = isset($postAdmisi['penjamin_id'])?$postAdmisi['penjamin_id']:null;
            
            $modAsuransiPasien->attributes = $postAsuransiPasien;
            $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id'])?$postPasien['pasien_id']:null;
            $modAsuransiPasien->penjamin_id = $penjamin;
            $modAsuransiPasien->carabayar_id = $carabayar;
            $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
            $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
            $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga'])?$postAsuransiPasien['hubkeluarga']:'';
            // var_dump($postPendaftaran);
            // var_dump($postPasien->attributes);
            if($carabayar == Params::CARABAYAR_ID_JAMKESPA) {
                $modAsuransiPasien->nopeserta = $postPasien->no_rekam_medik;
                // $modAsuransiPasien->status_konfirmasi = 1;
            } else if ($carabayar == Params::CARABAYAR_ID_BPJS) {
                $modAsuransiPasien->status_konfirmasi = 1;
                $modAsuransiPasien->tgl_konfirmasi = date('Y-m-d H:i:s');
                $modAsuransiPasien->namaperusahaan = 'BPJS';
            }
            if(empty($postAsuransiPasien['nokartuasuransi'])){
                $modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
            }
            
            if ($modAsuransiPasien->status_konfirmasi == 1) {
                $modAsuransiPasien->status_konfirmasi = "SUDAH DIKONFIRMASI";
            } else if ($modAsuransiPasien->status_konfirmasi == 0) {
                $modAsuransiPasien->status_konfirmasi = "BELUM DIKONFIRMASI";
            }
            //var_dump($modAsuransiPasien->attributes); 
            //var_dump($modAsuransiPasien->validate()); die;
            if($modAsuransiPasien->save()){
                $this->asuransipasientersimpan = true;
            }
            return $modAsuransiPasien;
        }

        public function simpanSep($model,$modPasien,$modRujukanBpjs,$modAsuransiPasienBpjs,$postSep, $isRI = false){
			//echo "<pre>";
//			print_r($_POST);exit;
            $reqSep = null;
            $modSep = new PPSepT;
            $bpjs = new Bpjs();
            $kelas = KelaspelayananM::model()->findByPk($modAsuransiPasienBpjs->kelastanggunganasuransi_id);
            //var_dump($modRujukanBpjs->attributes); die;
            $modSep->tglsep = date('Y-m-d H:i:s');
            $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
            $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
            if (empty($modSep->tglrujukan)) $modSep->tglrujukan = $modSep->tglsep;
            $modSep->norujukan = $modRujukanBpjs->no_rujukan;
            if(isset($postSep['ppkrujukan'])) $modSep->ppkrujukan = $postSep['ppkrujukan']; 
            else $modSep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
            $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
            $modSep->jnspelayanan = ($model->instalasi_id==Params::INSTALASI_ID_RI || $isRI)?Params::JENISPELAYANAN_RI:Params::JENISPELAYANAN_RJ;
            $modSep->catatansep = $postSep['catatansep'];
            $data_diagnosa = explode(', ', $modRujukanBpjs->kddiagnosa_rujukan);
            $modSep->diagnosaawal = isset($data_diagnosa[0])?$data_diagnosa[0]:'';
            $modSep->politujuan = $model->ruangan->ruangan_singkatan;
            $modSep->klsrawat = $kelas->kelasbpjs_id;
            $modSep->tglpulang = date('Y-m-d H:i:s');
            $modSep->create_time = date('Y-m-d H:i:s');
            $modSep->create_loginpemakai_id = Yii::app()->user->id;
            $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
            
            // var_dump($modSep->attributes, $modSep->validate(), $modSep->errors); die;
            
            $lakalantas = 2;
            if (isset($_POST['PPPasienkecelakaanT'])) $lakalantas = 1;
            
            // var_dump($modSep->attributes); die;
            if(isset($_POST['isSepManual'])){
                if($_POST['isSepManual']==false){
                    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id, $lakalantas),true);
                    //var_dump($reqSep); die;
                    if ($reqSep['metadata']['code']==200) {
                        $modSep->nosep = $reqSep['response'];
                        if (empty($modSep->norujukan)) $modSep->norujukan = "-";
                        if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";
                        if($modSep->save()){
                            $this->septersimpan = true;
                            RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
                                'ppkrujukan'=>$modSep->ppkrujukan,
                            ));
                        }
                    } 
                }else{
                    $modSep->nosep = $_POST['PPSepT']['nosep'];
                    if($modSep->save()){
                        $this->septersimpan = true;
                    }
                }
            }else{
                    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id, $lakalantas),true);
                    // var_dump($reqSep); die;
                    if ($reqSep['metadata']['code']==200) {
                            // var_dump($reqSep); die;
                            $modSep->nosep = $reqSep['response'];
                            if (empty($modSep->norujukan)) $modSep->norujukan = "-";
                            if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";
                            if($modSep->save()){
                                    $this->septersimpan = true;
                                    RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
                                        'ppkrujukan'=>$modSep->ppkrujukan,
                                    ));
                            }
                    } 
					
					$this->logBpjs($model, $reqSep);
            }
            return $modSep;
        }
		
		
		function logBpjs($model, $reqSep) {
			$log = new BpjslogR;
			$log->tgl_log = date('Y-m-d H:i:s');
			$log->code = $reqSep['metadata']['code'];
			$log->loginpemakai_id = Yii::app()->user->id;
			if (isset($reqSep['metadata']['message'])) {
				$log->pesan = $reqSep['metadata']['message'];
			}
			$log->pendaftaran_id = $model->pendaftaran_id;
			$log->save();
		}
		
		function flashBpjs($id) {
			$log = BpjslogR::model()->findByAttributes(array(
				'pendaftaran_id'=>$id,
			));
			if (!empty($log) && $log->code != 200) {
				Yii::app()->user->setFlash('error', 'BPJS Error '.$log->code.': '.$log->pesan);
			}
		}
        
        /**
         * menentukan tipepaket_id
         * @param type $modPendaftaran
         * @param type $karcis_id
         * @param type $idTindakan
         * @return type
         */
        public function tipePaketKarcis($modPendaftaran,$karcis_id,$tindakan_id)
        {
            $criteria = new CDbCriteria;
            $criteria->with = array('tipepaket');
			$criteria->addCondition("daftartindakan_id = ".$tindakan_id);
			$criteria->addCondition("tipepaket.carabayar_id = ".$modPendaftaran->carabayar_id);
			$criteria->addCondition("tipepaket.penjamin_id = ".$modPendaftaran->penjamin_id);
			$criteria->addCondition("tipepaket.kelaspelayanan_id = ".$modPendaftaran->kelaspelayanan_id);
            $paket = PaketpelayananM::model()->find($criteria);
            $result = Params::TIPEPAKET_ID_NONPAKET;
            if(isset($paket)) $result = $paket->tipepaket_id;
            
            return $result;
        }
        
        /**
         * untuk menampilkan pasien lama dari autocomplete
         * 1. no_rekam_medik
         * 2. no_identitas_pasien
         * 3. nama_pasien
         * 4. nama_bin (alias)
         */
        public function actionAutocompletePasienLama()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
                $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
                $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
                $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
                $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
                
				if(empty($no_badge)){
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
					$criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
					$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
					$criteria->compare('tanggal_lahir', $tanggal_lahir);
					$criteria->addCondition('ispasienluar = FALSE');
					$criteria->order = 'no_rekam_medik, nama_pasien';
					$criteria->limit = 50;
					$models = PasienM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "")." - ".(!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)")." - ".$format->formatDateTimeForUser($model->tanggal_lahir);
						$returnVal[$i]['value'] = $model->no_rekam_medik;
					}
				}else{
					$criteria = new CDbCriteria();
					$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
					$criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
					$criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
					$criteria->limit = 50;
					$models = PPPasienM::model()->findAll($criteria);
					foreach($models as $i=>$model)
					{
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$returnVal[$i]["$attribute"] = $model->$attribute;
						}
						$returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai.
											' - '.$model->no_rekam_medik.	
											' - '.$model->nama_pasien.	
											' - ('.$model->pegawai->nama_pegawai.
											') - '.$format->formatDateTimeForUser($model->tanggal_lahir);
						$returnVal[$i]['value'] = $model->no_rekam_medik;
					}
				}
				
				

                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
    }
     public function actionAutocompleteAsuransi()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
                $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
                $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta),true);
                $criteria->addCondition('penjamin_id='.$penjamin_id);
                $criteria->addCondition('asuransipasien_aktif is true');
                if($_GET['pasien_id'] == ""){
                    $criteria->addCondition('pasien_id is null');
                    
                }else{
                    $criteria->addCondition('pasien_id='.$pasien_id);
                }
                $criteria->order = 'namapemilikasuransi';
                $criteria->limit = 5;
                $models = PPAsuransipasienM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nopeserta.' - '.$model->namapemilikasuransi;
                    $returnVal[$i]['value'] = $model->nopeserta;
                    $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                    $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
                    $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                    $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                    $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                    $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                    $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
                }

                             
                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
    }

    public function actionAutocompleteAsuransiKartu()
    {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $returnVal = array();
                $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
                $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
                $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi),true);
                $criteria->addCondition('penjamin_id='.$penjamin_id);
                if($_GET['pasien_id'] == ""){
                    $criteria->addCondition('pasien_id is null');
                    
                }else{
                    $criteria->addCondition('pasien_id='.$pasien_id);
                }
                $criteria->order = 'namapemilikasuransi';
                $criteria->limit = 5;
                $models = PPAsuransipasienM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nokartuasuransi.' - '.$model->namapemilikasuransi;
                    $returnVal[$i]['value'] = $model->nokartuasuransi;
                    $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
                    $returnVal[$i]['nopeserta'] = $model->nopeserta;
                    $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
                    $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
                    $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
                    $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
                    $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
                }

                             
                echo CJSON::encode($returnVal);
            }else
                throw new CHttpException(403,'Tidak dapat mengurai data');
            Yii::app()->end();
    }
	
	public function actionAutocompleteAsuransiBadak()
    {
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter();
			$returnVal = array();
			$nopeserta = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : '';
			$penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
			$pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nopeserta)', strtolower($nopeserta),true);
			if(!empty($pasien_id)){
				$criteria->addCondition('pasien_id='.$pasien_id);
			}
			if(!empty($penjamin_id)){
				$criteria->addCondition('penjamin_id='.$penjamin_id);
			}
			$criteria->order = 'namapemilikasuransi';
			$criteria->limit = 5;
			$models = PPAsuransipasienM::model()->findAll($criteria);
			
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->nopeserta.' - '.$model->namapemilikasuransi;
				$returnVal[$i]['value'] = $model->nopeserta;
				$returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
//				$returnVal[$i]['nopeserta'] = $model->nopeserta;
				$returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
				$returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
				$returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
				$returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
				$returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
				
				$modPegawai = '';
				$modPegawai = PPPegawaiM::model()->findByPk($model->pasien->pegawai_id);
				$returnVal[$i]['alamat_pegawai'] = !empty($modPegawai)?$modPegawai->alamat_pegawai:'';
				$returnVal[$i]['notelp_pegawai'] = !empty($modPegawai)?$modPegawai->notelp_pegawai:'';
			}
			echo CJSON::encode($returnVal);
		}else
			throw new CHttpException(403,'Tidak dapat mengurai data');
		Yii::app()->end();
    }

        /**
         * Mengurai data pasien berdasarkan pasien_id
         * @throws CHttpException
         */
        public function actionGetDataPasien()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
                $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
                $returnVal = array();
                if (!empty($pasien_id)) {
                    $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                        'pasien_id'=>$pasien_id,
                    ), array(
                        'condition'=>'tgl_pendaftaran::date = now()::date and pasienbatalperiksa_id is null'
                    ));
                    if (empty($pendafaran)) {
                        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                            'pasien_id'=>$pasien_id,
                        ), array(
                            'condition'=>'pasienbatalperiksa_id is null',
                            'order'=>'tgl_pendaftaran desc',
                        ));
                    }
                } else if (!empty($no_rekam_medik)) {
                    //var_dump($no_rekam_medik); die; 
                    $p = PasienM::model()->findByAttributes(array('no_rekam_medik'=>trim($no_rekam_medik)));
                    //var_dump($p->pasien_id); die;
                    $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                        'pasien_id'=>$p->pasien_id,
                    ), array(
                        'condition'=>'tgl_pendaftaran::date = now()::date and pasienbatalperiksa_id is null'
                    ));
                    if (empty($pendafaran)) {
                        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                            'pasien_id'=>$p->pasien_id,
                        ), array(
                            'condition'=>'pasienbatalperiksa_id is null',
                            'order'=>'tgl_pendaftaran desc',
                        ));
                    }
                } else {
                    $pendaftaran = null;
                }
                
                $returnVal['lebih'] = false;
                $returnVal['adaDaftar'] = false;
                
                $pp = null;
                if (!empty($pendaftaran)) {
                    $returnVal['listDaftar'] = $pendaftaran->attributes;
                    $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
                    $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
                    $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;
                    
                    $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                    
                    switch ($pendaftaran->instalasi_id) {
                    case Params::INSTALASI_ID_RJ:
                        $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal); break;
                    case Params::INSTALASI_ID_RD:
                        $this->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal); break;
                    case Params::INSTALASI_ID_RI:
                        $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal); break;
                    default:
                        $this->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal); break;
                    }
                }
                
                
                
                
                /*
                if (!empty($pendaftaran)) {
                    $returnVal['adaDaftar'] = true;
                    $returnVal['listDaftar'] = $pendaftaran->attributes;
                    $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
                    $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
                    $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;
                    
                    if (!empty($pendaftaran->pasienpulang_id)) {
                        $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
                        if ($pp->carakeluar_id == 5) $returnVal['tindakLanjut'] = true;
                        if (!empty($pendaftaran->pasienadmisi_id)) {
                            $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                            $returnVal['adaInap'] = true;
                            $returnVal['listDaftar']['ruangan'] = $admisi->ruangan;
                        }
                    }
                }
                 * 
                 */
                
                if (isset($_POST['is_manual']) && $_POST['is_manual'] == true) {
                    $rm_last = PasienM::model()->find(array(
                        'condition'=>'ispasienluar = false',
                        'order'=>'no_rekam_medik desc'
                    ));
                    //echo $no_rekam_medik." ".$rm_last->no_rekam_medik; die;
                    if ((int)$no_rekam_medik > (int)$rm_last->no_rekam_medik) {
                        $returnVal['lebih'] = true;
                        echo CJSON::encode($returnVal);
                        Yii::app()->end();
                    }
                }
                
                
                $criteria = new CDbCriteria();
				if(!empty($pasien_id)){$criteria->addCondition("pasien_id = ".$pasien_id); }
				if(!empty($no_rekam_medik)){$criteria->addCondition("no_rekam_medik = '".$no_rekam_medik."'"); }
                $criteria->addCondition('ispasienluar = FALSE');
                $model = PasienM::model()->find($criteria);
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal["$attribute"] = $model->$attribute;
                }
                $returnVal["tanggal_lahir"] = date("d/m/Y",strtotime($model->tanggal_lahir));
				if(!empty($model->pegawai_id)){
					$returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
					$returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
					$returnVal['gelardepan'] = $model->pegawai->gelardepan;
					$returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
					$returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
					$returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
					$returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
				}
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
		
        
        function periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, &$returnVal)
        {
            if (!empty($pendaftaran->pasienpulang_id)) {
				// echo "Kick"; die;
                $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
                if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                    $returnVal['adaDaftar'] = true;
                    $returnVal['listDaftar'] = $pendaftaran->attributes;
                    $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                    $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                    $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                    if (!empty($pendaftaran->pasienadmisi_id)) {
                        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                        $returnVal['adaInap'] = true;
                        $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                    } else {
                        $returnVal['tindakLanjut'] = true;
                    }
                }
            } else {
                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                ), array(
                    'condition'=>'tindakansudahbayar_id is null',
                ));
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                ), array(
                    'condition'=>'oasudahbayar_id is null',
                ));
				
				$isAda = false;
				if (!empty($oa) || !empty($tindakan)) {
					if (empty($pendaftaran->pembayaranpelayanan_id)) 
						$isAda = true;
				}
				
				// var_dump($isAda); die;
				
                // if (date('Y-m-d', time()) == date('Y-m-d', strtotime($pendaftaran->tgl_pendaftaran))) {
                if ($isAda || !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG))) {
					$returnVal['adaDaftar'] = true;
                    $returnVal['listDaftar'] = $pendaftaran->attributes;
                    $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                    $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                    $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                }
            }
        }
        
        function periksaValidasiPasienRD($pendaftaran, $admisi, $pp, &$returnVal)
        {
            if (!empty($pendaftaran->pasienpulang_id)) {
                $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
                if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                    $returnVal['adaDaftar'] = true;
                    $returnVal['listDaftar'] = $pendaftaran->attributes;
                    $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                    $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                    $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                    if (!empty($pendaftaran->pasienadmisi_id)) {
                        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                        $returnVal['adaInap'] = true;
                        $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
                    } else {
                        $returnVal['tindakLanjut'] = true;
                    }
                }
            } else {
                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                ), array(
                    'condition'=>'tindakansudahbayar_id is null',
                ));
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$pendaftaran->pendaftaran_id,
                ), array(
                    'condition'=>'oasudahbayar_id is null',
                ));
				
				$isAda = false;
				if (!empty($oa) || !empty($tindakan)) {
					if (empty($pendaftaran->pembayaranpelayanan_id)) 
						$isAda = true;
				}
                
                if ($isAda || !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG))) {
                    $returnVal['adaDaftar'] = true;
                    $returnVal['listDaftar'] = $pendaftaran->attributes;
                    $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                    $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                    $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                }
            }
        }
        
        function periksaValidasiPasienRI($pendaftaran, $admisi, $pp, &$returnVal)
        {
            if (empty($pendaftaran->pasienpulang_id)) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
                $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
                $returnVal['adaInap'] = true;
                $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
            }
        }
        
        function periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, &$returnVal)
        {
            if (date('Y-m-d', time()) == date('Y-m-d', strtotime($pendaftaran->tgl_pendaftaran))) {
                $returnVal['adaDaftar'] = true;
                $returnVal['listDaftar'] = $pendaftaran->attributes;
                $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
                $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
                $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
            }
        }
        
        
		/**
         * Mengurai data pasien berdasarkan pasien_id
         * @throws CHttpException
         */
        public function actionGetRuanganPoliklinikPasien()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $format = new MyFormatter();
                $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
                $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
                $returnVal = array();
				if(!empty($pasien_id)){
					$criteria = new CDbCriteria();
					if(!empty($pasien_id)){$criteria->addCondition("pasien_id = ".$pasien_id); }
					if(!empty($ruangan_id)){$criteria->addCondition("ruangan_id = '".$ruangan_id."'"); }
					$tgl_awal = date('Y-m-d');
					$tgl_akhir = date('Y-m-d');
					$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
					$model = InfokunjunganrjV::model()->findAll($criteria);
	//                echo count($model);exit;
					if(count($model) > 0){
						$returnVal['status'] = 'Ya';
						$returnVal['pesan']  = "Pasien sudah mendaftarkan sebelumnya ke Poliklinik : <br/>";
						$returnVal['pesan'] .= "<ol type=1>";
						foreach($model as $i=>$ruangan){
							$returnVal['pesan'] .= "<li>".$ruangan->ruangan_nama." - ".($format->formatDateTimeForUser($ruangan->tgl_pendaftaran))."</li>";
						}
						$returnVal['pesan'] .= "</ol>";
					}else{
						$returnVal['status'] = 'Tidak';
					}
				}
//                
				
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        /**
         * Mengatur dropdown kabupaten
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
                if($model_nama !=='' && $attr == ''){
                    $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $propinsi_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $propinsi_id = $_POST["$model_nama"]["$attr"];
                }
                $kabupaten = null;
                if($propinsi_id){
                    $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
                    $kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
                }
                if($encode){
                    echo CJSON::encode($kabupaten);
                } else {
                    if(empty($kabupaten)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kabupaten as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /**
         * Mengatur dropdown kecamatan
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
                if($model_nama !=='' && $attr == ''){
                    $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kabupaten_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $kabupaten_id = $_POST["$model_nama"]["$attr"];
                }
                $kecamatan = null;
                if($kabupaten_id){
                    $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
                    $kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
                }

                if($encode){
                    echo CJSON::encode($kecamatan);
                } else {
                    if(empty($kecamatan)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kecamatan as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /**
         * Mengatur dropdown kelurahan
         * @param type $encode jika = true maka return array jika false maka set Dropdown 
         * @param type $model_nama
         * @param type $attr
         */
        public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PPPasienM;
                if($model_nama !=='' && $attr == ''){
                    $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kecamatan_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $kecamatan_id = $_POST["$model_nama"]["$attr"];
                }
                $kelurahan = null;
                if($kecamatan_id){
                    $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
                }

                if($encode){
                    echo CJSON::encode($kelurahan);
                } else {
                    if(empty($kelurahan)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kelurahan as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        /**
         * set dropdown daerah pasien berdasarkan
         * propinsi_id
         * kabupaten_id
         * kecamatan_id
         * kelurahan_id
         * pasien_id
         */
        public function actionSetDropdownDaerahPasien()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modPasien = new PPPasienM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

                $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
                $propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
                $propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($propinsis as $value=>$name)
                {
                    if($value==$propinsi_id)
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
//                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
                $kabupatens = CHtml::listData($kabupatens,'kabupaten_id','kabupaten_nama');
                $kabupatenOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kabupatens as $value=>$name)
                {
                    if($value==$kabupaten_id)
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
//                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
                $kecamatans = CHtml::listData($kecamatans,'kecamatan_id','kecamatan_nama');
                $kecamatanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kecamatans as $value=>$name)
                {
                    if($value==$kecamatan_id)
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
                $kelurahans = CHtml::listData($kelurahans,'kelurahan_id','kelurahan_nama');
                $kelurahanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kelurahans as $value=>$name)
                {
                    if($value==$kelurahan_id)
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                $dataList['listPropinsi'] = $propinsiOption;
                $dataList['listKabupaten'] = $kabupatenOption;
                $dataList['listKecamatan'] = $kecamatanOption;
                $dataList['listKelurahan'] = $kelurahanOption;

                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
        /**
         * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
         */
        public function actionSetTanggalLahir()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $data['tanggal_lahir'] = date("d/m/Y",strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));
				
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        /**
         * set umur dari tanggal lahir (date)
         */
        public function actionSetUmur()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $data['umur'] = null;
                if(isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])){
                    $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
                }
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        /**
         * set dropdown dokter
         */
        public function actionSetDropdownDokter()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $model = new PPPendaftaranT;
                $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(!empty($_POST['ruangan_id'])){
                    $data = $model->getDokterItems($_POST['ruangan_id']);
                    $data = CHtml::listData($data,'pegawai_id','NamaLengkap');
                    foreach($data as $value=>$name){
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                } 
                $dataList['listDokter'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
        
        /**
         * set dropdown jenis kasus penyakit
         */
        public function actionSetDropdownJeniskasuspenyakit()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $model = new PPPendaftaranT;
                $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(!empty($_POST['ruangan_id'])){
                    $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
                    $data = CHtml::listData($data,'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
                    foreach($data as $value=>$name){
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                } 
                $dataList['listKasuspenyakit'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
        /**
         * set dropdown penjamin pasien dari carabayar_id
         * @param type $encode
         * @param type $namaModel
         */
        public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
               if($encode)
               {
                    echo CJSON::encode($penjamin);
               } else {
                    if(empty($carabayar_id)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
                        if(count($penjamin) > 1)
                        {
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        }
                        $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                        foreach($penjamin as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
               }
            }
            Yii::app()->end();
        }

        /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
        public function actionSetDropdownKelasPelayanan($encode=false,$namaModel='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
                $kelasPelayanan = null;
                if($ruangan_id){
                    $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$ruangan_id.' and kelaspelayanan_aktif = true');
                    $kelasPelayanan=CHtml::listData($kelasPelayanan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
                }
                if(empty($kelasPelayanan)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($kelasPelayanan as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
            Yii::app()->end();
        }

        /**
         * set antrian ruangan
         */
        public function actionSetAntrianRuangan(){
            if(Yii::app()->request->isAjaxRequest) { 
                $ruangan_id = $_POST['ruangan_id'];
                $data = array();
                $data['maxantrianruangan'] = null;
                $data['no_urutantri'] = '001';
                if(!empty($ruangan_id)){
                    $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
                    $criteria=new CDbCriteria;
					$criteria->addCondition("ruangan_id = ".$ruangan_id);
                    $modJadwalBukaPoli= JadwalbukapoliM::model()->findAll($criteria);
                    $ruangan = RuanganM::model()->findByPk($ruangan_id);
                    if (count($modJadwalBukaPoli) > 0){
                        foreach($modJadwalBukaPoli as $key=>$antrian){
                            $data['maxantrianruangan'] = $antrian->maxantiranpoli;  
                            $data['jammulai'] = date('Y-m-d')." ".$antrian->jammulai;
                            $data['jamtutup'] = date('Y-m-d')." ".$antrian->jamtutup;
                            $data['jammulai_a'] = $antrian->jammulai;
                            $data['jamtutup_a'] = $antrian->jamtutup;
                            $data['nama_ruangan'] = $ruangan->ruangan_nama;
                        }
                    }
                }
                echo json_encode($data);
             Yii::app()->end();
            }
        }
        /**
         * set antrian dokter
         */
        public function actionSetAntrianDokter(){
            if(Yii::app()->request->isAjaxRequest) { 
                $ruangan_id = $_POST['ruangan_id'];
                $pegawai_id = $_POST['pegawai_id'];
                $data = array();
                $data['maxantriandokter'] = 0;
                if(!empty($ruangan_id) && !empty($pegawai_id)){
                    $criteria=new CDbCriteria;
					$criteria->addCondition("ruangan_id = ".$ruangan_id);
					$criteria->addCondition("pegawai_id = ".$pegawai_id);
                    $modJadwalDokter= JadwaldokterM::model()->findAll($criteria);
                    if (count($modJadwalDokter) > 0){
                        foreach($modJadwalDokter as $key=>$antrian){
                            $data['maxantriandokter'] = $antrian->maximumantrian;     
                        }

                    }
                }
                echo json_encode($data);
             Yii::app()->end();
            }
        }
        /**
         * menampilkan karcis
         */
        public function actionSetKarcis(){
            if(Yii::app()->request->isAjaxRequest) { 
                $format = new MyFormatter();
                $modTindakan = new PPTindakanPelayananT;
                $kelaspelayanan_id=$_POST['kelaspelayanan_id'];
                $ruangan_id = $_POST['ruangan_id'];
                $pasien_id = $_POST['pasien_id'];
                $no_rekam_medik = isset($_POST['no_rekam_medik'])?$_POST['no_rekam_medik']:"";
                $penjamin_id = $_POST['penjamin_id'];
                $form ='';
				
				$is_pasienbaru = 'true';
                if(!empty($ruangan_id)){
                    if(!empty($pasien_id)){
                        $modP = PendaftaranT::model()->findByAttributes(array(
                            'pasien_id'=>$pasien_id,
                        ), array(
                            'condition'=>'pasienbatalperiksa_id is null',
                        ));
                        $modPasien = PasienM::model()->findByPk($pasien_id);
                        if(isset($modPasien)){
                            $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF && !empty($modP)) ? 'false' : 'true';
                        }
                    } else if (trim($no_rekam_medik) != "") {
                        $is_pasienbaru = 'false';
                    }
                    $criteria = new CdbCriteria();
                    $criteria->addCondition("kelaspelayanan_id = ".$kelaspelayanan_id);
                    $criteria->addCondition("ruangan_id = ".$ruangan_id);
                    $criteria->addCondition("penjamin_id = ".$penjamin_id);
					if(Yii::app()->user->getState('karcisbarulama')){ //RND-7737
						$criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
					}
                    $modKarcisV=KarcisV::model()->findAll($criteria);
//					echo "<pre>";
//					print_r(count($modKarcisV));
//					exit;
					$form = $this->renderPartial($this->path_view.'_formKarcis',array('modKarcisV'=>$modKarcisV,'modTindakan'=>$modTindakan,'format'=>$format),true);
					$data['listKarcis']=$form;
					echo json_encode($data);
					Yii::app()->end();
                }
                $data['listKarcis']=$form;
                echo json_encode($data);
                Yii::app()->end();
            }
        }
		
		
        /**
         * set tabel riwayat kunjungan pasien
         */
        public function actionSetRiwayatKunjunganPasien(){
            if(Yii::app()->request->isAjaxRequest) { 
                $data['table'] = "";
                $modPasien = new PPPasienM;
                $modPasien->pasien_id = $_POST['pasien_id'];
                $data['table'] = $this->renderPartial($this->path_view.'_tableRiwayatPasien',array(
                                        'modPasien'=>$modPasien,
                                        ),true);
                echo json_encode($data);
                Yii::app()->end();
            }
        }
        
        /**
         * @param type $pendaftaran_id
         */
        public function actionPrintStatus($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modPenanggungjawab = array();
            if(!empty($modPendaftaran->penanggungjawab_id)){
                $modPenanggungjawab=PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
            }
            $karcis_id = null;
            $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
            $judul_print = 'Kunjungan Rawat Jalan';
            $this->render($this->path_view.'printStatus', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'modPenanggungjawab'=>$modPenanggungjawab,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakan'=>$modTindakan,
            ));
        }
        
         public function actionPrintSjp($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
          //  $modPenanggungjawab = array();
          //  if(!empty($modPendaftaran->penanggungjawab_id)){
            //    $modPenanggungjawab=PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
          //  }
           // $karcis_id = null;
          //  $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
          //  $judul_print = 'Kartu Papua Sehat';
            $this->render($this->path_view.'printSjp', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                //'modPenanggungjawab'=>$modPenanggungjawab,
                              //  'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                              //  'modTindakan'=>$modTindakan,
            ));
        }
        /**
         * @param type $pendaftaran_id
         */
        public function actionPrintKarcis($pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            $lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
            
            if (!empty($lp)) $modPegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
            else $modPegawai = new PegawaiM;

            $karcis_id = null;
            $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
            $judul_print = 'Karcis '.$modPendaftaran->ruangan->instalasi->instalasi_nama;
            $this->render($this->path_view.'printKarcis', array(
                                'format'=>$format,
                                'modPendaftaran'=>$modPendaftaran,
                                'judul_print'=>$judul_print,
                                'modPasien'=>$modPasien,
                                'modTindakan'=>$modTindakan,
                                'modPegawai'=>$modPegawai,
            ));
        } 
        /**
         * print kartu pasien
         * @param type $pasien_id
		 * RND-9125
         */
        public function actionPrintKartuPasien($pasien_id)
        {
            $this->layout='//layouts/printWindows';
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul_print = 'Kartu Pasien';
            $this->render($this->path_view.'printKartuPasienKen',
                array(
                    'modPasien'=>$modPasien,
                    'judul_print'=>$judul_print
                )
            );
        }
        
        /**
         * Catat print kartu
         * @param type $model PasienM data Pasien
         */
        public function catatPrintKartu($model) {
            $pk = new KartupasienR();
            $pk->pasien_id = $model->pasien_id;
            $pk->tglprintkartu = date('Y-m-d H:i:s');
            $pk->statusprintkartu = true;
            $pk->create_time = date('Y-m-d');
            $pk->create_loginpemakai_id = Yii::app()->user->id;
            
            if ($pk->validate()) {
                $pk->save();
            }
        }

        /**
         * @param type $sep_id
         */
        public function actionPrintSep($sep_id,$pendaftaran_id) 
        {
            $this->layout='//layouts/printWindows';
            $format = new MyFormatter;
            $modRujukanBpjs = new PPRujukanbpjsT;
            $modSep = PPSepT::model()->findByPk($sep_id);
            $bpjs = new Bpjs();
            $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta'=>$modSep->nokartuasuransi)); 
            $modJenisPeserta = PPJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
            if (isset($modSep->norujukan)) {
                $modRujukanBpjs = PPRujukanbpjsT::model()->findByAttributes(array('no_rujukan'=>$modSep->norujukan));
            }
            $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
            $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
            $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);
            
            
            $judul_print = 'SURAT ELIGIBILITAS PESERTA';
            $this->render($this->path_view.'printSep', array(
                                'format'=>$format,
                                'modSep'=>$modSep,
                                'judul_print'=>$judul_print,
                                'modAsuransiPasienBpjs'=>$modAsuransiPasienBpjs,
                                'modRujukanBpjs'=>$modRujukanBpjs,
                                'modPendaftaran'=>$modPendaftaran,
                                'modPasien'=>$modPasien,
                                'modJenisPeserta'=>$modJenisPeserta,
                                'modRujukan'=>$modRujukan,
            ));
        } 
        
        /**
         * action ketika tombol panggil di klik
         */
        public function actionPanggil($antrian_id,$ket=null){
            if(Yii::app()->request->isAjaxRequest)
            {
                $format = new MyFormatter();
                $data = array();
                $data['pesan']="";
                $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
                if(isset($modAntrian)){
                    if($modAntrian->panggil_flaq == true){
                        if($ket == "batal"){
                            $modAntrian->panggil_flaq = false;
                            if($modAntrian->update()){
        //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
                            }
                        }else{
                            $data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
                        }
                    }else{
                        $modAntrian->panggil_flaq = true;
                        if($modAntrian->update()){
        //                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
                        }
                    }
                }
                $attributes = $modAntrian->attributeNames();
                foreach($attributes as $i=>$attribute) {
                    $data["$attribute"] = $modAntrian->$attribute;
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

        /**
         * menampilkan form antrian dari request ajax
         * @param type $record
         * @param type $noantrian
         * @throws CHttpException
         */
        public function actionSetFormAntrian(){
            if(Yii::app()->request->isAjaxRequest)
            {
                $format = new MyFormatter();
                $data = array();
                $data['pesan'] = "";
                $record = (isset($_POST['record']) ? $_POST['record'] : "");
                $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
                $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
                if(empty($noantrian)){ //antrian baru
                    $criteria = new CDbCriteria();
                    $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                    $criteria->addCondition("pendaftaran_id IS NULL");
                    if($record == "reset"){
                        $criteria->addCondition("panggil_flaq = false");
                    }
					if(!empty($loket_id)){$criteria->addCondition("loket_id = ".$loket_id); }
                    $criteria->order = "noantrian ASC";
                    $criteria->limit = 1;
                    $modAntrian =  PPAntrianT::model()->find($criteria);
                }else{
                    $criteria = new CDbCriteria();
                    $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
                    $criteria->compare("noantrian",trim($noantrian));
					if(!empty($loket_id)){$criteria->addCondition("loket_id = ".$loket_id); }
                    $cari =  PPAntrianT::model()->find($criteria);
                    if($record == 'next'){
                        $cari->loket_id = $loket_id;
                        $modAntrian = $cari->AntrianBerikut;
                    }else if($record == 'prev'){
                        $cari->loket_id = $loket_id;
                        $modAntrian = $cari->AntrianSebelum;
                    }else{
                        $modAntrian = $cari;
                    }
                }

                if(!isset($modAntrian)){
                    $modAntrian = new PPAntrianT;
                    $data['pesan'] = "Antrian Habis !";
                }
                $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
                $data['form_antrian'] = $this->renderPartial($this->path_view.'_formPanggilAntrian',array('modAntrian'=>$modAntrian),true);
                echo CJSON::encode($data);
                Yii::app()->end();
            }
            else
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
        
         /**
         * untuk menampilkan data diagnosa dari autocomplete
         * 1. diagnosa_kode
         * 2. diagnosa_nama
         */
        public function actionAutocompleteDiagnosaRujukan()
    	{
                if(Yii::app()->request->isAjaxRequest) {
                    $returnVal = array();
                    $diagnosa_nama = isset($_GET['diagnosa_rujukan']) ? $_GET['diagnosa_rujukan'] : null;
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(diagnosa_nama)', strtolower($diagnosa_nama), true);
                    $criteria->order = 'diagnosa_nama';
                    $criteria->limit = 5;
                    $models = DiagnosaM::model()->findAll($criteria);
                    $data = array();
                    foreach ($models as $i => $model) {
                        $data[$i] = array('key'=>$model->diagnosa_kode,
                                          'value'=>$model->diagnosa_nama);
                    }

                    echo CJSON::encode($data);
                }else
                    throw new CHttpException(403,'Tidak dapat mengurai data');
                Yii::app()->end();
    	}


         /**
         * set bpjs Interface
         */
        public function actionBpjsInterface()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
                    die('param can\'not empty value');
                }else{
                    $param = $_GET['param'];
                }

//                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
//                    
//                }else{
//                    $server = 'http://'.$_GET['server'];
//                }

                $bpjs = new Bpjs();

                switch ($param) {
                    case '1':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_kartu($query) );
                        break;
                    case '2':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_nik($query) );
                        break;
                    case '3':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_rujukan_no_rujukan($query) );
                        break;
                    case '4':
                        $query = $_GET['query'];
                        print_r( $bpjs->search_rujukan_no_bpjs($query) );
                        break;
                    case '5':
                        $query = $_GET['query'];
                        $start = $_GET['start'];
                        $limit = $_GET['limit'];
                        print_r( $bpjs->list_rujukan_tanggal($query, $start, $limit) );
                        break;
                    case '6':
                        $nokartu = $_GET['no_kartu'];
                        $tglsep = $_GET['tgl_sep'];
                        $tglrujukan = $_GET['tgl_rujukan'];
                        $norujukan = $_GET['no_rujukan'];
                        $ppkrujukan = $_GET['ppk_rujukan'];
                        $ppkpelayanan = $_GET['ppk_pelayanan'];
                        $jnspelayanan = $_GET['jns_pelayanan'];
                        $catatan = $_GET['catatan'];
                        $diagawal = $_GET['diag_awal'];
                        $politujuan = $_GET['poli_tujuan'];
                        $klsrawat = $_GET['kls_rawat'];
                        $user = $_GET['user'];
                        $nomr = $_GET['no_mr'];
                        $notrans = $_GET['no_trans'];
                        print_r( $bpjs->create_sep($nokartu, $tglsep, $tglrujukan, $norujukan, $ppkrujukan, $ppkpelayanan, $jnspelayanan, $catatan, $diagawal, $politujuan, $klsrawat, $user, $nomr, $notrans) );
                        break;
                    case '7':
                        $nosep = $_GET['nosep'];
                        $tglpulang = $_GET['tglpulang'];
                        $ppkpelayanan = $_GET['ppkpelayanan'];
                        print_r( $bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan) );
                        break;
                    case '8':
                        $nosep = $_GET['nosep'];
                        $notrans = $_GET['notrans'];
                        $ppkpelayanan = $_GET['ppkpelayanan'];
                        print_r( $bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan) );
                        break;
                    case '9':
                        $nosep = $_GET['nosep'];
                        $ppkpelayanan = $_GET['ppkpelayanan'];
                        print_r( $bpjs->delete_transaksi($nosep, $ppkpelayanan) );
                        break;
                    case '10':
                        $nokartu = $_GET['nokartu'];
                        print_r( $bpjs->riwayat_terakhir($nokartu) );
                        break;
                    case '11':
                        $nosep = $_GET['nosep'];
                        print_r( $bpjs->detail_sep($nosep) );
                        break;
                    case '12':
                        $ppkpelayanan = $_GET['ppkrujukan'];
                        $start = $_GET['start'];
                        $limit = $_GET['limit'];
                        print_r( $bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit) );
                        break;
                    case '99':
                        $bpjs->identity_magic();
                        break;
                    case '100':
                        print_r( $bpjs->help() );
                        break;
                    default:
                        die('error number, please check your parameter option');
                        break;
                }
                Yii::app()->end();
            }
        }
		/**
		 * menampilkan data asuransi terakhir pasien
		 * @throws CHttpException
		 */
		public function actionSetAsuransiPasienLama(){
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$data = array();
				$criteria = new CDbCriteria();
				$criteria->addCondition("pasien_id = ".$_POST['pasien_id']);
				$criteria->order = 'asuransipasien_id DESC';
				$model = AsuransipasienM::model()->find($criteria);
				if(count($model)>0){
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$data["$attribute"] = $model->$attribute;
					}
					//if($model->carabayar_id == Params::CARABAYAR_ID_BADAK){
					//	$data["penjamin_nama"] = $model->carabayar->carabayar_nama;
					//}else{
						$data["penjamin_nama"] = $model->penjamin->penjamin_nama;
					//}
					$data['listPenjamin'] = "";
					$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$model->carabayar_id, 'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
					if(count($penjamin) > 1)
					{
						$data['listPenjamin'] .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
					foreach($penjamin as $value=>$name) {
						$data['listPenjamin'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}else{
					$data=null;
				}
				echo CJSON::encode($data);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
		}
		
		/**
         * untuk menampilkan data pegawai 
         */
		public function actionAutocompletePegawai()
		{
			if(Yii::app()->request->isAjaxRequest) {
				$returnVal = array();
				$nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
				$nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
				$criteria = new CDbCriteria();
				$criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
				$criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
				$criteria->order = 'nomorindukpegawai, nama_pegawai';
				$criteria->limit = 5;
				$models = PPPegawaiM::model()->findAll($criteria);
				if(count($models) > 0){
					foreach ($models as $i => $model) {
						$returnVal[$i] = $model->attributes;
						if(!empty($nomorindukpegawai)){
							$returnVal[$i]['label'] = $model->nomorindukpegawai.' - '.$model->nama_pegawai;
						}else{
							$returnVal[$i]['label'] = $model->nama_pegawai;
						}
						$returnVal[$i]['value'] = $model->pegawai_id;
						$returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
						$returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
					}
				}
				echo CJSON::encode($returnVal);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
		}
		
		/**
         * Cek keaktifan pegawai jika penjamin pt badak
         * @param type $encode
         * @param type $namaModel
         */
        public function actionCekCaraBayarBadak()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasien_id = $_POST['pasien_id'];
				$pegawai_id = $_POST['pegawai_id'];
				$pesan = '';
				$status = false;
				$modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
				if(count($modPegawai)>0){
					if($modPegawai->pegawai_aktif){
						$status = true;
					}else{
						$status = false;
						$pesan = 'Data Pegawai tidak aktif';
					}
				}else{
					$status = false;
					$pesan = 'Data tidak ditemukan';
				}
				echo CJSON::encode(array('status'=>$status,'pesan'=>$pesan));
            }
            Yii::app()->end();
        }
		
		/**
         * Cek kategori pegawai untuk menentukan asuransi pasien
         * @param type $encode
         * @param type $namaModel
         */
        public function actionCekValiditasPenjamin()
        {
            if(Yii::app()->request->isAjaxRequest) {
				$pasien_id = isset($_POST['pasien_id'])?$_POST['pasien_id']:'';
				$penjamin_id =  isset($_POST['penjamin_id'])?$_POST['penjamin_id']:'';
				$pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:'';
				$penj = '';
				$pesan = '';
				$status = '';
				$html = '';
				$data = null;
				switch ($_POST['type']) {     
					case "badak":
						
						$modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
						$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>Params::CARABAYAR_ID_BADAK,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
						$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
						$html .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						foreach($penjamin as $value=>$name) {
							$html .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
						}
						
						if(count($modPegawai)>0){
							if($modPegawai->kategoripegawai == ""){
								$status = "Empty";
								$pesan = 'Data Kategori pegawai penanggung jawab pasien tidak ditemukan!<br>Lakukan pengaturan kategori pegawai di modul kepegawaian';
							}else{
								if($penjamin_id == Params::PENJAMIN_ID_PISA){
									$penj = Params::PENJAMIN_ID_PISA;
									if($modPegawai->kategoripegawai == "Tidak Tetap"){
										$status = "Tidak Tetap";
										$pesan = 'Tidak dapat memilih penjamin PISA. <br> Karena pegawai penanggung jawab pasien adalah pegawai tidak tetap / telah pensiun';
									}
								}else if($penjamin_id == Params::PENJAMIN_ID_PROKESPEN){
									$penj = Params::PENJAMIN_ID_PROKESPEN;
								}
							}
						}else{
							$status = "Fail";
							$pesan = 'Data tidak ditemukan';
						}
						break;      
						
					case "departemen":        
						
						$modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
						$data['penjamin_nama'] = $modPenjamin->penjamin_nama;
						break;
				}
				
				echo CJSON::encode(array('status'=>$status,'pesan'=>$pesan, 'html'=>$html, 'penj'=>$penj,'data'=>$data));
            }
            Yii::app()->end();
        }
		
		/**
         * Ngeset data asuransi badak jika pasien telah memiliki data di asuransipasien_m
         * @param type $encode
         * @param type $namaModel
         */
        public function actionSetAsuransiBadak()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$data = array();
				
				if((!empty($_POST['pasien_id']))&&(!empty($_POST['penjamin_id']))){
					$criteria = new CDbCriteria();
					$criteria->addCondition("pasien_id = ".$_POST['pasien_id']);
					$criteria->addCondition("penjamin_id = ".$_POST['penjamin_id']);
					$criteria->order = 'asuransipasien_id DESC';
					$model = AsuransipasienM::model()->find($criteria);
					if(count($model)>0){
						$attributes = $model->attributeNames();
						foreach($attributes as $j=>$attribute) {
							$data["$attribute"] = $model->$attribute;
						}
						$data['listPenjamin'] = "";
						$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$model->carabayar_id, 'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
						if(count($penjamin) > 1)
						{
							$data['listPenjamin'] .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						}
						$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
						foreach($penjamin as $value=>$name) {
							$data['listPenjamin'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
						}
					}else{
						$data=null;
						$pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:'';
						if(!empty($pegawai_id)){
							$modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
							$data['nopeserta'] = $modPegawai->nomorindukpegawai;
							$data['namaperusahaan'] = $modPegawai->unit_perusahaan;
							$data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
							$data['namaperusahaan'] = 'PT. Badak LNG';
						}
					}
				}else{
					$pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:'';
					if(!empty($pegawai_id)){
						$modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
						$data['nopeserta'] = $modPegawai->nomorindukpegawai;
						$data['namaperusahaan'] = $modPegawai->unit_perusahaan;
						$data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
						$data['namaperusahaan'] = 'PT. Badak LNG';
					}
				}
				echo CJSON::encode($data);
			}else
				throw new CHttpException(403,'Tidak dapat mengurai data');
			Yii::app()->end();
        }
		
		/**
         * set dropdown jenis kasus penyakit
         */
        public function actionSetDropdownStatushubungankeluarga()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$penjamin_id = $_POST['penjamin_id'];
                $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
                $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(!empty($penjamin_id)){
					$data = $modAsuransiPasienBadak->getDropdownStatushubungankeluarga($penjamin_id);
                    $data = CHtml::listData($data,'lookup_value', 'lookup_name');
                    foreach($data as $value=>$name){
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                } 
                $dataList['statushubungankeluarga'] = $option;
                echo json_encode($dataList);
                Yii::app()->end();
            }
        }
		
		
		public function actionCekSEP() 
		{
			if(Yii::app()->getRequest()->getIsAjaxRequest()) {
				$nosep = $_POST['nosep'];
				$bpjs = new Bpjs();
				$res = CJSON::decode($bpjs->detail_sep($nosep));
				
				
				$res["rujukan"] = array(
					"rujukandari_id"=>"",
				);
				
				if ($res["metadata"]["code"] == "200" && !empty($res["response"]["provRujukan"])) {
					
					$rujukan = RujukandariM::model()->findByAttributes(array(
						"ppkrujukan"=>$res["response"]["provRujukan"]["kdProvider"]
					));
					if (!empty($rujukan)) {
						$rujukans = CHtml::listData(RujukandariM::model()->findAllByAttributes(array(
							"asalrujukan_id"=>$rujukan->asalrujukan_id,
						), array(
							"order"=>"namaperujuk"
						)), "rujukandari_id", "namaperujuk");
						
						$op = "";
						foreach ($rujukans as $idx=>$item) {
							$op .= '<option value="'.$idx.'">'.$item.'</option>';
						}
						
						$res["rujukan"]["rujukandari_id"] = $rujukan->rujukandari_id;
						$res["rujukan"]["asalrujukan_id"] = $rujukan->asalrujukan_id;
						$res["rujukan"]["listrujukandari_id"] = $op;
						
					}
				}
				
				print_r(CJSON::encode($res));
			}
		}
}
