<?php
Yii::import('ambulans.controllers.PemakaianAmbulanPasienRSController');
class PemakaianAmbulanPasienLuarController extends PemakaianAmbulanPasienRSController
{
   public $path_view_luar = 'ambulans.views.pemakaianAmbulanPasienLuar.';
   public $path_view = 'ambulans.views.pemakaianAmbulanPasienRS.';
   
   public function actionIndex($pemakaian_id = '', $pendaftaran_id='', $pemesanan_id='')
    {
        $format = new MyFormatter();        
        $modPasien = new PasienM;
        $modKunjungan=new AMInfokunjunganrjV;
        $modObatAlkesPasien = new AMObatalkesPasienT;
        $modPemakaian = new AMPemakaianambulansT;
        $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
        $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif'=>true),array('order'=>'instalasi_nama'));
        $instalasi = Yii::app()->user->getState('instalasi_id');
        $modPemakaian->ruangan_id = Yii::app()->user->getState('ruangan_id');
//        $instalasi = '';
        $tarif = array();
        $tarif['tarifAmbulans'][] = null;

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
        
        if(!empty($pemesanan_id)){
            $modPemakaian = $this->setDataPemakaianFromPemesanan($pemesanan_id);
            $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
        }

        if(!empty($pendaftaran_id)){
            $modKunjungan->pendaftaran_id = $pendaftaran_id;
            if(isset($_GET['instalasi_id'])){
                $modKunjungan->instalasi_id = $_GET['instalasi_id'];
            }
            $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
                if(!empty($modPemakaian->ruangan_id)){
                    $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
                }else{
                    $instalasi = null;
                }
        }
        
        if(!empty($pemakaian_id)){
            $modPemakaian = $this->setDataPemakaianFromPemakaian($pemakaian_id);
            $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;            
            $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1_id) ? $modPemakaian->paramedis1->NamaLengkap : "";
            $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2_id) ? $modPemakaian->paramedis2->NamaLengkap : "";
        }

        if(isset($_POST['AMPemakaianambulansT'])){

            if(isset($_POST['tarif'])){
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    foreach($_POST['tarif']['tarifAmbulans'] as $i=>$tarifAmbulans){
                        $tarif['tarifAmbulans'][$i] = $tarifAmbulans;
                        $tarif['tarifKM'][$i] = $_POST['tarif']['tarifKM'][$i];
                        $tarif['jmlKM'][$i] = $_POST['tarif']['jmlKM'][$i];
                        $tarif['kelurahan'][$i] = $_POST['tarif']['kelurahan'][$i];
                        $tarif['kecamatan'][$i] = $_POST['tarif']['kecamatan'][$i];
                        $tarif['kabupaten'][$i] = $_POST['tarif']['kabupaten'][$i];
                        $tarif['propinsi'][$i] = $_POST['tarif']['propinsi'][$i];
                        $tarif['daftartindakanId'][$i] = $_POST['tarif']['daftartindakanId'][$i];
                        //=== set attribute pemakaian ambulans ===//
                        $save = true;
                        $modPemakaian = new AMPemakaianambulansT;
                        $modPemakaian->attributes = $_POST['AMPemakaianambulansT'];
                        $modPemakaian->pelaksana_id = empty($modPemakaian->pelaksana_id)?null:$modPemakaian->pelaksana_id;
                        $modPemakaian->paramedis1_id = empty($modPemakaian->paramedis1_id)?null:$modPemakaian->paramedis1_id;
                        $modPemakaian->paramedis2_id = empty($modPemakaian->paramedis2_id)?null:$modPemakaian->paramedis2_id;
                        $modPemakaian->rt_rw = $_POST['AMPemakaianambulansT']['rt'].'/'.$_POST['AMPemakaianambulansT']['rw'];
                        $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
                        $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
                        $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
                        $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
                        $modPemakaian->create_time = date('Y-m-d H:i:s');
                        $modPemakaian->create_loginpemakai_id = Yii::app()->user->id;
                        $modPemakaian->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        $modPemakaian->noidentitas = Yii::app()->user->getState('ruangan_id');
                        $instalasi = $_POST['instalasi'];
                        $format = new MyFormatter();
                        $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglpemakaianambulans']);
                        $modPemakaian->tglkembaliambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglkembaliambulans']);

                        //=== save pemakaian ambulans ===//
                        if($modPemakaian->validate()){
                            $save = $save && $modPemakaian->save();
                            if(!empty($pemesanan_id)){
                                AMPesanambulansT::model()->updateByPk($pemesanan_id, array('pemakaianambulans_id'=>$modPemakaian->pemakaianambulans_id));
                            }
                        } else {
                            $save = false;
                        }
                    }
                    //=== simpan pemakaian obat alkes ===//
                    if(!empty($modPemakaian->pendaftaran_id)){
                        $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                        if(isset($_POST['AMObatalkesPasienT'])){
                            if(count($_POST['AMObatalkesPasienT']) > 0){
                                foreach($_POST['AMObatalkesPasienT'] AS $ii => $postOa){
                                    $dataOas[$ii] = $this->simpanObatAlkesPasien($modPendaftaran,$postOa);
                                }
                            }
                        }                        
                    }                   
                    //=== commit or rollback ===//
                    if($save && $this->obatalkespasientersimpan && $this->tindakanpelayanantersimpan){
                        // SMS GATEWAY
                        $sms = new Sms();
                        $smspasien = 1;
                        foreach ($modSmsgateway as $i => $smsgateway) {
                            $isiPesan = $smsgateway->templatesms;
                            $attributes = $modPemakaian->getAttributes();
                            foreach($attributes as $attributes => $value){
                                $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                            }
                            $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modPemakaian->tglpemakaianambulans),$isiPesan);
                            $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                            
                            if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                if(!empty($modPemakaian->nomobile)){
                                    $sms->kirim($modPemakaian->nomobile,$isiPesan);
                                }else{
                                    $smspasien = 0;
                                }
                            }
                            
                        }
                        // END SMS GATEWAY
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
                        $sukses = 1;
                        $modPemakaian->isNewRecord = FALSE;
                        $this->redirect(array('index','pemakaian_id'=>$modPemakaian->pemakaianambulans_id,'pendaftaran_id'=>$modPemakaian->pendaftaran_id,'sukses'=>$sukses, 'smspasien'=>$smspasien));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data Gagal disimpan");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
                }
            }else{
               Yii::app()->user->setFlash('error',"Pilih terlebih dahulu tarif ambulans !"); 
            }
        }

		$modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
		$latitude = $modPropinsi->latitude;
		$longitude = $modPropinsi->longitude;
		
        $this->render($this->path_view_luar.'index',array('modPemakaian'=>$modPemakaian,
                                        'modPasien'=>$modPasien,
                                        'modInstalasi'=>$modInstalasi,
                                        'instalasi'=>$instalasi,
                                        'tarif'=>$tarif,
                                        'modKunjungan'=>$modKunjungan,
                                        'format'=>$format,
                                        'modObatAlkesPasien'=>$modObatAlkesPasien,
										'latitude'=>$latitude,
										'longitude'=>$longitude));
    }

    public function actionPrintStatusAmbulans($pemakaianambulans_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaianambulans_id);
        $judul_print = 'Pemakaian Ambulance Pasien Luar';
        $this->render($this->path_view_luar.'printStatusAmbulan', array(
                            'format'=>$format,
                            'modPemakaian'=>$modPemakaian,
                            'judul_print'=>$judul_print,
        ));
    } 

}