<?php
Yii::import('rawatDarurat.contollers.DaftarPasienController');
Yii::import('rawatDarurat.models.RDPendaftaranT');
Yii::import('rawatDarurat.views.daftarPasien.*');

class DaftarPasienController extends MyAuthController
{
    public $validRujukan = true;
    public $validPulang = false;
    
    public function actionIndex()
    {   
        $format = new MyFormatter();
        $this->pageTitle = Yii::app()->name." - Daftar Pasien";
        $model = new PSInfokunjunganpersalinanV;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if(isset ($_REQUEST['PSInfokunjunganpersalinanV'])){
            $model->attributes=$_REQUEST['PSInfokunjunganpersalinanV'];
            $model->kamarruangan_id = $_REQUEST['PSInfokunjunganpersalinanV']['kamarruangan_id'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_akhir']);
            // $model->ceklis = $_REQUEST['PSInfokunjunganpersalinanV']['ceklis'];
        }
        $this->render('index',array('model'=>$model,'format'=>$format));
    }
    
    protected function updatePendaftaran($modPendaftaran,$modelPulang)
    {
        $daftar = PendaftaranT::model()->updateByPk($modelPulang->pendaftaran_id, array('tglselesaiperiksa'=>date( 'Y-m-d H:i:s'), 'pasienpulang_id'=>$modelPulang->pasienpulang_id,'statusperiksa'=>'SUDAH PULANG'));
        if ($daftar){
            return $modPendaftaran;
        }
        else{
            throw new Exception('Data Pasien Pulang Gagal Diupdate');
        }
    }
    
    protected function updatePasienAdmisi($modPasienAdmisi,$modelPulang)
    {
        
        $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
        $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
//        $modPasienAdmisi->statuskeluar = 1;
        $modPasienAdmisi->save();
        return $modPasienAdmisi;
    }
    
    protected function updateMasukKamar($modMasukKamar,$attrMasukKamar)
    {
        $modMasukKamar->attributes = $attrMasukKamar;
        $modMasukKamar->save();
    }
    
    protected function hitungLamaDirawat($date)
    {echo $date;
        $today=date("Y-m-d");
        list($y,$m,$d)=explode('-',$date);
        list($ty,$tm,$td)=explode('-',$today);
        if($td-$d<0){
            $day=($td+30)-$d;
            $tm--;
        }
        else
        {
            $day=$td-$d;
        }
        return $day;
    }
    
    public function actionAddPasienPulang()
    {
        $validRujukan = true;
        $validPasienPulang = false;
        
        $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
        $pasien_id = Yii::app()->session['pasien_id'];
        $modelPulang = new PSPasienPulangT;
        $modRujukanKeluar = new PasiendirujukkeluarT;
        
        $modMasukKamar = '';
        
        $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
        $modelPulang->pendaftaran_id = $pendaftaran_id;
        $modelPulang->pasien_id = $pasien_id;
        
        if(Yii::app()->user->getState('instalasi_id')== Params::INSTALASI_ID_RD)
        {
            $modRD = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id));
        }
        else
        {
            $modRD = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasien_id'=>$pasien_id));
        }
        $modRujukanKeluar->pegawai_id = PendaftaranT::model()->findByPk($pendaftaran_id)->pegawai_id;
        $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id'); //ruangan asal itu diasumsikan ruangan terakhir dia dari mana
        
        $format = new MyFormatter();
        $date1 = $format->formatDateTimeForDb($modRD->tgl_pendaftaran);
        $date2 = date('Y-m-d H:i:s');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $hours   = floor(($diff)/3600); 
        
        $modelPulang->lamarawat = $hours;
        
        if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
        {
            $idMasukKamar = Yii::app()->session['idMasukKamar'];
            $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
            $pasienadmisi_id = $modMasukKamar->pasienadmisi_id;
            $modMasukKamar->tglkeluarkamar = date('Y-m-d H:i:s');
            $modMasukKamar->jamkeluarkamar = date('H:i:s');
            $sql = "select date(tglmasukkamar) as tglmasukkamar from masukkamar_t where masukkamar_id = $idMasukKamar";
            
            //menghitung lama rawat
            $tglMasukKamar = Yii::app()->db->createCommand($sql)->queryRow();
            $date1 = $tglMasukKamar['tglmasukkamar'];
            $modMasukKamar->lamadirawat_kamar = $this->hitungLamaDirawat($date1);
            
            $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
            
            $modelPulang->lamarawat = $modMasukKamar->lamadirawat_kamar;
            
        }
       

        if(isset($_POST['PSPasienPulangT'])) 
        {   
            $transaction = Yii::app()->db->beginTransaction();
            try{
                if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
                {   
                    $modelPulang = $this->savePasienPulang($modelPulang,$_POST['PSPasienPulangT'],$pasienadmisi_id);
                }
                else
                {
                    $modelPulang = $this->savePasienPulang($modelPulang,$_POST['PSPasienPulangT']);
                }

                if(isset($_POST['pakeRujukan']))
                {
                    $modelPulang->pakeRujukan = true;
                    $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar,$modelPulang,$_POST['PasiendirujukkeluarT']);
                }

                if(isset($_POST['isDead']))
                {
                    $modPasien = PasienM::model()->findByPk(Yii::app()->session['pasien_id']);
                    $modPasien->tgl_meninggal = $_POST['PSPasienPulangT']['tgl_meninggal'];
                    $modPasien->save();
                }
                if($this->validPulang && $this->validRujukan)
                {   
                    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                    $this->updatePendaftaran($modPendaftaran,$modelPulang);

                    if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) //kondisi apabila dari rawat inap, maka akan update ke masukkamar_t
                    {
                        $idMasukKamar = Yii::app()->session['idMasukKamar'];
                        
                        $modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
                        
                        $this->updateMasukKamar($modMasukKamar,$_POST['MasukkamarT']);
                        
                        $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                        
                        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);

                    }
                    
                    $transaction->commit();

                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
                            ));
                        exit;               
                    }
                }  
            }
            catch(Exception $exc){
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'div'=>$this->renderPartial('_formPasienPulang', 
                        array('modelPulang'=>$modelPulang,
                              'modRujukanKeluar'=>$modRujukanKeluar,
                              'modMasukKamar'=>$modMasukKamar,
                              'modRD'=>$modRD), true)));
            exit;               
        }
    }
    
    protected function savePasienPulang($modPasienPulang,$attrPasienPulang,$pasienadmisi_id='')
    {
        $modelPulangNew = new PSPasienPulangT;
        $modelPulangNew->attributes = $attrPasienPulang;
        $modelPulangNew->satuanlamarawat = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? Params::SATUAN_LAMARAWAT_RD : Params::SATUAN_LAMARAWAT_RI;
        $modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_time = date( 'Y-m-d H:i:s');
        $modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
        $modelPulangNew->pasienadmisi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RD) ? null : $pasienadmisi_id;

        if($modelPulangNew->save())
        {
            $this->validPulang = true;
        }
        
        return $modelPulangNew;
    }
    
    protected function saveRujukanKeluar($modRujukanKeluar,$modelPulang,$attrRujukanKeluar)
    {
        $modRujukanKeluarNew = new PasiendirujukkeluarT;
        $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
        $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
        $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
        $modRujukanKeluarNew->create_time = date( 'Y-m-d H:i:s');
//        $modRujukanKeluarNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
        if($modRujukanKeluarNew->save())
        {
            'benar';
        }
        else
        {
            $this->validRujukan = false;
        }
        return $modRujukanKeluarNew;
    }

    public function actionRincian($id){
            $this->layout = '//layouts/iframe';
            $data['judulLaporan'] = 'Rincian Tagihan Pasien';
            $modPendaftaran = PSPendaftaranT::model()->findByPk($id);
            $modRincian = PSRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order'=>'ruangan_id'));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
//            $modRincian->pendaftaran_id = $id;
            $this->render('/rinciantagihanpasienV/rincian', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
        }
        
        public function actionAjaxJumlahPersalinan(){
            if (Yii::app()->request->isAjaxRequest){
                $pendaftaran_id = $_POST['pendaftaran_id'];
            }
            
        }

        public function actionGetRiwayatPasien($id){
            $this->layout='//layouts/iframe';
            $criteria = new CDbCriteria(array(
                    //'condition' => 't.pasien_id = '.$id.' and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
                    'condition' => 't.pasien_id = '.$id,
                    'order'=>'tgl_pendaftaran DESC',
                ));

            $pages = new CPagination(PSPendaftaranT::model()->count($criteria));
            $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
            $pages->applyLimit($criteria);
            
            $modKunjungan = PSPendaftaranT::model()->with('hasilpemeriksaanlab','anamnesa','pemeriksaanfisik','pasienmasukpenunjang','diagnosa')->
                    findAll($criteria);
            
           
            $this->render('/_periksaDataPasien/_riwayatPasien', array(
                    'pages'=>$pages,
                    'modKunjungan'=>$modKunjungan,
            ));
        }
	
        
        
        public function actionDetailTindakan($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = PSPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modTindakan = PSTindakanPelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modTindakanSearch = new PSTindakanPelayananT('search');
            $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_tindakan', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTindakan'=>$modTindakan,
                        'modTindakanSearch'=>$modTindakanSearch,
                        'modPasien'=>$modPasien));
        }
        
        public function actionDetailTerapi($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = PSPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modTerapi = PSPenjualanresepT::model()->with('reseptur')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modDetailTerapi = new PSPenjualanresepT();
            $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_terapi', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modTerapi'=>$modTerapi,
                        'modDetailTerapi'=>$modDetailTerapi,
                        'modPasien'=>$modPasien));
        }
        
        public function actionDetailPemakaianBahan($id){
            $this->layout='//layouts/iframe';
            $modPendaftaran = PSPendaftaranT::model()->with('carabayar','penjamin')->findByPk($id);
            $modBahan = PSObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id'=>$id));
            $format = new MyFormatter;
            $modPemakaianBahan = new PSObatalkesPasienT;
            $modPasien = PSPasienM::model()->findByPK($modPendaftaran->pasien_id);
            $this->render('/_periksaDataPasien/_pemakaianBahan', 
                    array('modPendaftaran'=>$modPendaftaran, 
                        'modBahan'=>$modBahan,
                        'modPemakaianBahan'=>$modPemakaianBahan,
                        'modPasien'=>$modPasien));
        }
        /**
         * Pasien RI rujuk / pulang
         */
        public function actionPasienRujukRI()
        {
              if(Yii::app()->request->isAjaxRequest) {
                  $pendaftaran_id=$_POST['pendaftaran_id'];
                  $pasien_id=  PendaftaranT::model()->find('pendaftaran_id='.$pendaftaran_id.'')->pasien_id;
                    $modPasienPulang = new PSPasienPulangT;
                    $modPasienPulang->pendaftaran_id=$pendaftaran_id;
                    $modPasienPulang->pasien_id=$pasien_id;
                    $modPasienPulang->tglpasienpulang=date('Y-m-d H:i:s');
                    $modPasienPulang->carakeluar_id=Params::CARAKELUAR_ID_RAWATINAP;
                    $modPasienPulang->kondisikeluar_id=Params::KONDISIKELUAR_ID_RAWATINAP;
                    $modPasienPulang->ruanganakhir_id=Yii::app()->user->getState('ruangan_id');
                    $modPasienPulang->lamarawat=0;
                    $modPasienPulang->satuanlamarawat='lamarawat';
    //                echo $modPasienPulang->ruanganakhir_id;exit;
                    if($modPasienPulang->save()){
                        PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienpulang_id'=>$modPasienPulang->pasienpulang_id,'statusperiksa'=>'SEDANG DIRAWAT INAP'));
                        $data['pesan']='Berhasil';
                    }else{
                        $data['pesan']='Gagal';
                    }
                  echo json_encode($data);
             Yii::app()->end();
            }
        }
        
    /**
     * Mengatur dropdown kabupaten
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropDownKondisiKeluar($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new PSPasienPulangT();
            $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
            if(!empty($_POST['carakeluar_id'])){
                $data = $model->getKondisikeluarItems($_POST['carakeluar_id']);
                $data = CHtml::listData($data,'kondisikeluar_id','kondisikeluar_nama');
                foreach($data as $value=>$name){
                        $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
            } 
            $dataList['kondisikeluar'] = $option;
            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
	
	public function actionBuatSessionPendaftaranPasien()
    {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pasien_id = $_POST['pasien_id'];
        
        Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
        Yii::app()->session['pasien_id'] = $pasien_id;
        
        echo CJSON::encode(array(
                'pendaftaran_id'=>Yii::app()->session['pendaftaran_id'], 
                'pasien_id'=>Yii::app()->session['pasien_id']));
        
    }
    
   public function actionUbahDokterPeriksa()
   {
	   $model = new PSPendaftaranT();           
	   $modAdmisi = new PSPasienAdmisiT();
	   $modUbahDokter = new PSUbahdokterR;
	   $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
	   if(isset($_POST['PSPendaftaranT']))
	   {
		   if($_POST['PSPendaftaranT']['pegawai_id'] != "")
		   {
                       
				$model->attributes = $_POST['PSPendaftaranT'];
				$modUbahDokter->attributes = $_POST['PSUbahdokterR'];
				$modUbahDokter->pendaftaran_id = $_POST['PSPendaftaranT']['pendaftaran_id'];
				$modUbahDokter->dokterbaru_id = $_POST['PSPendaftaranT']['pegawai_id'];
				$modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
				$modUbahDokter->create_time = date('Y-m-d H:i:s');
				$modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
				$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
			   $transaction = Yii::app()->db->beginTransaction();
			   try {
				    $attributes = array('pegawai_id' => $_POST['PSPendaftaranT']['pegawai_id']);
                                    $cekPersalinan = PSPersalinanT::model()->find(" pendaftaran_id = '".$_POST['PSPendaftaranT']['pendaftaran_id']."' ");
                                  
                                    if (count($cekPersalinan)>1){
                                        $save = PSPendaftaranT::model()->updateByPk($_POST['PSPendaftaranT']['pendaftaran_id'], $attributes);
                                        $savePersalinan = PSPersalinanT::model()->updateByPk($cekPersalinan->persalinan_id, $attributes);
                                    }else{                                        
                                        $save = PSPendaftaranT::model()->updateByPk($_POST['PSPendaftaranT']['pendaftaran_id'], $attributes);
                                    }

                                    if ($save) {                                        
                                        $modUbahDokter->save();
                                        $transaction->commit();
                                        echo CJSON::encode(array(
                                            'status' => 'proses_form',
                                            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
                                        ));
                                    } else {
                                        echo CJSON::encode(array(
                                            'status' => 'proses_form',
                                            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                                        ));
                                    }				   
				   exit;
			   }catch(Exception $exc) {
				   $transaction->rollback();
			   }                
		   }else{
			   echo CJSON::encode(
				   array(
					   'status'=>'proses_form',
					   'div'=>"<div class='flash-error'>Data gagal disimpan, dokter baru belum dipilih.</div>",
				   )
			   );
			   exit;
		   }
	   }

	   if (Yii::app()->request->isAjaxRequest)
	   {
		   echo CJSON::encode(array(
			   'status'=>'create_form', 
			   'div'=>$this->renderPartial('_formUbahDokterPeriksa', array('model'=>$model,'modAdmisi'=>$modAdmisi,'modUbahDokter'=>$modUbahDokter,'menu'=>$menu), true)));
		   exit;               
	   }
   }
   
   public function actionGetDataPendaftaranPS()
   {
	   if (Yii::app()->request->isAjaxRequest){
		   $id_pendaftaran = $_POST['pendaftaran_id'];                   
                   $persalinan_id = PersalinanT::model()->find(" pendaftaran_id = '".$id_pendaftaran."' ");                   
		   $pasienadmisi_id = !empty($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
                   
                   if (count($persalinan_id)>0){
                       $modPasienAdmisi = PendaftaranT::model()->findByPk($id_pendaftaran);       
                   }else{
                       $modPasienAdmisi = PendaftaranT::model()->findByPk($id_pendaftaran);       
                   }
                   
                   /*if (!empty($pasienadmisi_id)){
                        $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran,'pasienadmisi_id'=>$pasienadmisi_id));
                        $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                   }else{                       
                        $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id'=>$id_pendaftaran));
                        $modPasienAdmisi = PendaftaranT::model()->findByPk($id_pendaftaran);                        
                   }*/
		 //  var_dump($modPasienAdmisi->pegawai_id);
		   $attributes = $modPasienAdmisi->attributeNames();
		   foreach($attributes as $j=>$attribute) {
			   $returnVal["$attribute"] = $modPasienAdmisi->$attribute;
			   $returnVal["gelarbelakang_nama"] = isset($modPasienAdmisi->pegawai->gelarbelakang->gelarbelakang_nama) ? $modPasienAdmisi->pegawai->gelarbelakang->gelarbelakang_nama : "";
			   $returnVal["gelardepan"] = isset($modPasienAdmisi->pegawai->gelardepan) ? $modPasienAdmisi->pegawai->gelardepan : "";
			   $returnVal["pegawai_id"] = isset($modPasienAdmisi->pegawai_id) ? $modPasienAdmisi->pegawai_id : null;
                           $returnVal["nama_pasien"] = $modPasienAdmisi->pasien->namadepan.' '.$modPasienAdmisi->pasien->nama_pasien;
                           $returnVal["nama_pegawai"] = $modPasienAdmisi->pegawai->nama_pegawai;
		   }
                   $returnVal['pesan'] = 0;
		   echo json_encode($returnVal);
		   Yii::app()->end();
	   }
   }
   
    public function actionListDokterRuangan()
    {
	   if(Yii::app()->getRequest()->getIsAjaxRequest()) {
		   if(!empty($_POST['idRuangan'])){
			   $idRuangan = $_POST['idRuangan'];
			   $data = DokterV::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'nama_pegawai'));
			   $data = CHtml::listData($data,'pegawai_id','namaLengkap');

			   if(empty($data)){
				   $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($data as $value=>$name) {
						   $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
				   }
			   }

			   $dataList['listDokter'] = $option;
		   } else {
			   $dataList['listDokter'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
		   }
                   $dataList['pesan'] = 0;
		   echo json_encode($dataList);
		   Yii::app()->end();
	   }
    }
   
}