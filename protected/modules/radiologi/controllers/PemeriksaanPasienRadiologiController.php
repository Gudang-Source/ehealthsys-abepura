<?php
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
class PemeriksaanPasienRadiologiController extends PendaftaranRadiologiController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
//    public $path_view = "radiologi.views.pemeriksaanPasienRadiologi."; << TIDAK DIGUNAKAN / INI AKAN BENTROK DENGAN YANG ADA DI PendaftaranRadiologiController
    public $path_view_pendaftaran = "radiologi.views.pendaftaranRadiologi.";

    /**
     * Tambah / Ubah Pemeriksaan Radiologi.
     */
	
    public function actionIndex($pasienmasukpenunjang_id=null)
    {
        $format = new MyFormatter();
        $modKunjungan=new ROPasienMasukPenunjangV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
		$modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
        $modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
        $modTindakan=new ROTindakanpelayananT;
        $dataTindakans = array(); 
        
        if(!empty($pasienmasukpenunjang_id)){
            $loadModKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id));
            if(isset($loadModKunjungan)){
                $modKunjungan = $loadModKunjungan;
				$modPasienMasukPenunjang->attributes = $loadModKunjungan->attributes;
				$modPasienMasukPenunjang->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
                $modPasienMasukPenunjang->perawat_id = $modPasienMasukPenunjang->getPerawatId();
            }
        }
        
        if(isset($_POST['pasienmasukpenunjang_id']))
        {
            $modKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']));
            $modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
            $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
            $transaction = Yii::app()->db->beginTransaction();
            try {
				if(isset($_POST['ROPasienmasukpenunjangT'])){
					$modPasienMasukPenunjang->pegawai_id = $_POST['ROPasienmasukpenunjangT']['pegawai_id'];
					$modPasienMasukPenunjang->perawat_id = $_POST['ROPasienmasukpenunjangT']['perawat_id'];
					$modPasienMasukPenunjang->save();
				}
                if(isset($_POST['ROTindakanpelayananT'])){
                    if(count($_POST['ROTindakanpelayananT']) > 0){
                        foreach($_POST['ROTindakanpelayananT'] AS $ii => $tindakan){
                            if(!empty($tindakan['tindakanpelayanan_id'])){
                                $dataTindakans[$ii] = ROTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                                $dataTindakans[$ii]->jeniskasuspenyakit_id = $modPasienMasukPenunjang->jeniskasuspenyakit_id;
								$dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                                $dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
								$dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                                $dataTindakans[$ii]->update();
                            }else{
                                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran,$modPasienMasukPenunjang,$tindakan);
                                $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                            }
                            $dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
                            $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];                       
                            $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);

                        }
                    }
                }
                   
                if($this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data pemeriksaan radiologi berhasil disimpan !");
                    $this->redirect(array('index','pasienmasukpenunjang_id'=>$modKunjungan->pasienmasukpenunjang_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data pemeriksaan radiologi gagal disimpan !");
//                        echo "-".$this->tindakanpelayanantersimpan."<br>";
//                        echo "-".$this->komponentindakantersimpan."<br>";
//                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
//                        exit;
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data pemeriksaan radiologi gagal disimpan !"." ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
        $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
        $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

        $this->render('index',array(
            'modKunjungan'=>$modKunjungan,
            'modPasienMasukPenunjang'=>$modPasienMasukPenunjang,
            'modPemeriksaanRad'=>$modPemeriksaanRad,
            'modTindakan'=>$modTindakan,
            'dataTindakans'=>$dataTindakans,
        ));
    }
    
    /**
    * untuk menampilkan data kunjungan dari autocomplete
    * - no_masukpenunjang
    * - no_pendaftaran
    * - no_rekam_medik
    * - nama_pasien
    */
    public function actionAutocompleteKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
            $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
            $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
            $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
            $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
            $criteria->addCondition('ruangan_id = '.$ruangan_id);
            $criteria->order = 'no_pendaftaran, no_masukpenunjang, no_rekam_medik, nama_pasien';
            $criteria->limit = 5;
            $models = ROPasienMasukPenunjangV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->no_pendaftaran."-".$model->no_masukpenunjang.'-'.$model->no_rekam_medik.'-'.$model->nama_pasien.(!empty($model->nama_bin) ? "(".$model->nama_bin.")" : "");
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    /**
     * Mengurai data kunjungan berdasarkan:
     * - pasienmasukpenunjang_id
     * @throws CHttpException
     */
    public function actionGetDataKunjungan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->addCondition('pasienmasukpenunjang_id = '.$_POST['pasienmasukpenunjang_id']);
            $criteria->addCondition('ruangan_id = '.$_POST['ruangan_id']);
            $model = ROPasienMasukPenunjangV::model()->find($criteria);
            
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
			$returnVal["perawat_id"] = $model->getPerawatId();
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    /**
     * set ROTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     */
    public function actionSetTindakanPelayanan(){
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $rows = "";
            $modTindakans = ROTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
            if(count($modTindakans) > 0){
                foreach($modTindakans AS $i => $modTindakan){
                    $modTindakan->pemeriksaanrad_id = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->pemeriksaanrad_id;
                    $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id'=>$modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
                    $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
                    $rows .= $this->renderPartial($this->path_view_pendaftaran."_rowTindakanPemeriksaan",array('i'=>0, 'modTindakan'=>$modTindakan), true);
                }
            }
            echo CJSON::encode(array(
                    'rows'=>$rows));
        }
        Yii::app()->end();
    }
    /**
     * hapus ROTindakanpelayananT yang sudah ada di database
     * @params pasienmasukpenunjang_id
     * @params daftartindakan_id
     */
    public function actionHapusTindakanPelayanan(){
        if(Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modTindakan = ROTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id'],'daftartindakan_id'=>$_POST['daftartindakan_id']));
                $modTindakan->hasilpemeriksaanrad_id = null;
                $modTindakan->update();
                $hapusTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id));
				$modHasilPemeriksaans = HasilpemeriksaanradT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$modTindakan->tindakanpelayanan_id));
				$hapusDetailHasilPemeriksaan = false;
				if(count($modHasilPemeriksaans) > 0){
					$hapusDetailHasilPemeriksaan = true;
					foreach($modHasilPemeriksaans AS $i => $hasil){
						//RND-8272
						$dataBroker = $hasil->getDataBroker();
						if(!empty($dataBroker)){
							CustomFunction::postHL7Broker("DEL",$dataBroker);
						}
						$hapusDetailHasilPemeriksaan &= $hasil->delete();
					}
				}
				$cekTindakan = TindakanpelayananT::model()->findByPk($modTindakan->tindakanpelayanan_id);
                if($cekTindakan->tindakansudahbayar_id){
                    $hapusTindakan = false;
                }else{
                    $hapusTindakan = TindakanpelayananT::model()->deleteByPk($modTindakan->tindakanpelayanan_id);
                }
                if($hapusTindakan){
                    $transaction->commit();
                    $data['pesan'] = "Tindakan berhasil dihapus!";
                    $data['sukses'] = 1;
                }else{
                    $transaction->rollback();
                    if(!$hapusDetailHasilPemeriksaan)
                        $data['pesan'] = "Detail Hasil Pemeriksaan gagal dihapus!";
                    if(!$hapusTindakanKomponen)
                        $data['pesan'] = "Tindakan komponen gagal dihapus!";
                    if(!$hapusTindakan)
                        $data['pesan'] = "Tindakan pelayanan gagal dihapus karena sudah dibayarkan!";
                    $data['sukses'] = 0;
                }    
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Tindakan gagal dihapus! :".MyExceptionMessage::getMessage($exc,true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
}
