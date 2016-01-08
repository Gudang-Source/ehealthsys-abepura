<?php

class ReturObatAlkesPasienController extends MyAuthController
{
    
   protected $successSave = true;

    public function actionIndex($returresep_id = null,$returbayarpelayanan_id = null)
    {
        if(!empty($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        }
        
        $modPendaftaran = new BKPendaftaranT;
        $modPasien = new BKPasienM;
        $modReturResep = new BKReturresepT;
        $modBuktiKeluar = new BKTandabuktikeluarT;
        $modBuktiKeluar->tahun = date('Y');
        $modBuktiKeluar->untukpembayaran = 'Retur Obat Alkes Pasien';
        $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();

        $modRetur = new BKReturbayarpelayananT;
        $modRetur->noreturbayar = MyGenerator::noReturBayarPelayanan();
        $modRetur->biayaadministrasi = 0;
        $modRetur->totaltindakanretur = 0;
        $modRetur->totalbiayaretur = 0;
        $modRetur->totaloaretur = 0;

        // pengecekan jika request dari iframe

        $url_batal = Yii::app()->createAbsoluteUrl(
            Yii::app()->controller->module->id.'/' .Yii::app()->controller->id
        );

        if(!empty($returresep_id) && !isset($_POST['BKReturresepT'])){
            $modReturResep = BKReturresepT::model()->findByPk($returresep_id);
            $modPasien = BKPasienM::model()->findByPk($modReturResep->pasien_id);

//          RETUR OBAT YG SUDAH BAYAR SAJA   $modRetur->totaloaretur = MyFormatter::formatNumberForUser($modReturResep->totalretur);
            $modRetur->totaloaretur = MyFormatter::formatNumberForUser($modReturResep->TotalOaSudahBayar);
            $modRetur->totalbiayaretur = MyFormatter::formatNumberForUser($modRetur->totaloaretur);

            $modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
            $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
            
            $modPendaftaran->pasien_id = $modPasien->pasien_id;
            $url_batal = Yii::app()->createAbsoluteUrl(
                Yii::app()->controller->module->id.'/' .Yii::app()->controller->id,
                array(
                    'returresep_id'=>$_GET['returresep_id'],
                    'frame'=>1
                )
            );
        }
        
        if(!empty($returbayarpelayanan_id) && !empty($_GET['sukses'])){
            $modRetur = BKReturbayarpelayananT::model()->findByPk($returbayarpelayanan_id);
            $modReturResep = BKReturresepT::model()->findByPk($modRetur->returresep_id);
            $modPasien = BKPasienM::model()->findByPk($modReturResep->pasien_id);

            $modRetur->totaloaretur = MyFormatter::formatNumberForUser($modReturResep->TotalOaSudahBayar);
            $modRetur->totalbiayaretur = MyFormatter::formatNumberForUser($modRetur->totaloaretur);

            $modBuktiKeluar->namapenerima = $modPasien->nama_pasien;
            $modBuktiKeluar->alamatpenerima = $modPasien->alamat_pasien;
            
            $modPendaftaran->pasien_id = $modPasien->pasien_id;
        }
        
        if(isset($_POST['BKReturbayarpelayananT']) && !empty($_POST['BKReturresepT']['pasien_id'])){
            $modPasien = BKPasienM::model()->findByPk($_POST['BKReturresepT']['pasien_id']);

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modRetur = $this->saveReturBayarPelayanan($_POST['BKReturbayarpelayananT'],$_POST['BKReturresepT']);
                $modBuktiKeluar = $this->saveTandaBuktiKeluar($modRetur, $_POST['BKTandabuktikeluarT'],$modReturResep);

                if($this->successSave){
                    Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                    $transaction->commit();
                    $modRetur->isNewRecord = FALSE;
                    $this->redirect(array('index','returbayarpelayanan_id'=>$modRetur->returbayarpelayanan_id, 'frame'=>1,'sukses'=>1));
                } else {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                $transaction->rollback();
            }
        }
                
        
        $this->render('index',
            array(
                'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'modBuktiKeluar'=>$modBuktiKeluar,
                'modRetur'=>$modRetur,
                'modReturResep'=>$modReturResep,
                'url_batal'=>$url_batal
            )
        );
    }
    
    protected function saveReturBayarPelayanan($postRetur,$modReturResep)
    {
        $format = new MyFormatter();
        $modRetur = new BKReturbayarpelayananT;
        $modRetur->attributes = $postRetur;
        $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modRetur->tglreturpelayanan = $format->formatDateTimeForDb($postRetur['tglreturpelayanan']);
        $modRetur->create_time = date('Y-m-d H:i:s');
        $modRetur->create_loginpemakai_id =  Yii::app()->user->id;
        $modRetur->create_ruangan =   Yii::app()->user->getState('ruangan_id');
        $modRetur->returresep_id =$modReturResep['returresep_id'];
        
        if($modRetur->validate())
        {
            $modRetur->save();
//            TandabuktibayarT::model()->updateByPk(
//                $modRetur->tandabuktibayar_id,
//                array(
//                    'returbayarpelayanan_id'=>$modRetur->returbayarpelayanan_id
//                )
//            );
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modRetur;
    }
        
    protected function saveTandaBuktiKeluar($modRetur,$postBuktiKeluar,$modReturResep)
    {
        $modBuktiKeluar = new BKTandabuktikeluarT;
        $modBuktiKeluar->tglkaskeluar = $modRetur->tglreturpelayanan;
        $modBuktiKeluar->jmlkaskeluar = $modRetur->totalbiayaretur;
        $modBuktiKeluar->biayaadministrasi = $modRetur->biayaadministrasi;
        $modBuktiKeluar->keterangan_pengeluaran = $modRetur->keteranganretur;
        $modBuktiKeluar->attributes = $postBuktiKeluar;
        $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modBuktiKeluar->returbayarpelayanan_id = $modRetur->returbayarpelayanan_id;
        $modBuktiKeluar->tahun = date('Y');
        $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
        $modBuktiKeluar->create_loginpemakai_id =  Yii::app()->user->id;
        $modBuktiKeluar->create_ruangan =   Yii::app()->user->getState('ruangan_id');

        if($modBuktiKeluar->validate())
        {
            $modBuktiKeluar->save();
            $this->successSave = $this->successSave && true;
            BKReturbayarpelayananT::model()->updateByPk(
                $modRetur->returbayarpelayanan_id,
                array(
                    'tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id
                )
            );
        } else {
            $this->successSave = false;
        }

        return $modBuktiKeluar;
    }
    
    public function actionPrintRetur($returbayarpelayanan_id)
    {
        if (!empty($returbayarpelayanan_id))
        {
            $this->layout='//layouts/printWindows';

            $attributes = array(
                'returpembayaranpelayanan_id'=>$returbayarpelayanan_id
            );
            $judulLaporan = '';
            $return = BKReturbayarpelayananT::model()->findByPk($returbayarpelayanan_id);
            $model_tandabuktibayar = BKTandabuktikeluarT::model()->findByAttributes(array('tandabuktikeluar_id'=>$return->tandabuktikeluar_id));
            $judulLaporan = 'Tanda Bukti Retur Obat Alkes Pasien';
            $this->render('kwitansiReturTagihan',
                array(
                    'model' => $return,
                    'tandabuktibayar'=>$model_tandabuktibayar,
                    'judulLaporan'=>$judulLaporan,
                )
            );
        }
    }
    
	public function actionCekLogin($task='Retur') 
    {
        if(Yii::app()->request->isAjaxRequest){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $idRuangan = Yii::app()->user->getState('ruangan_id');
            
            $user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
                                                                   'loginpemakai_aktif' =>TRUE));
            if ($user === null) {
                $data['error'] = "Login Pemakai salah!";
                $data['cssError'] = 'username';
                $data['status'] = 'Gagal Login';
            } else {
                // cek password
                if ($user->katakunci_pemakai !== $user->encrypt($password)) {
                    $data['error'] = 'password salah!';
                    $data['cssError'] = 'password';
                    $data['status'] = 'Gagal Login';
                } else {
                    // cek ruangan
                    $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$user->loginpemakai_id,
                                                                                     'ruangan_id'=> $idRuangan));
                    if($ruangan_user===null) {
                        $data['error'] = 'ruangan salah!';
                        $data['status'] = 'Gagal Login';
                    } else {
                        $data['error'] = '';
						$cek = $this->checkAccess(array('loginpemakai_id'=>$user->loginpemakai_id)); //dari MyAuthController
                        if($cek){
                            $data['status'] = 'success';
                            $data['userid'] = $user->loginpemakai_id;
                            $data['username'] = $user->nama_pemakai;
                        } else {
                            $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
                        }
                    }
                }
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
    }
}
