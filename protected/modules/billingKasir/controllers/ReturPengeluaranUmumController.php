<?php

class ReturPengeluaranUmumController extends MyAuthController
{
    protected $successSave = true;
    public function actionIndex()
    {
        if(!empty($_GET['frame']) && !empty($_GET['idPenerimaan']))
        {
            $this->layout = 'iframe';
            $idPenerimaan = $_GET['idPenerimaan'];
            
            $modPenerimaan = BKPengeluaranumumT::model()->findByPk($idPenerimaan);
            $modBuktiBayar = BKTandabuktikeluarT::model()->findByPk($modPenerimaan->tandabuktikeluar_id);

            $modBuktiKeluar = new BKTandabuktikeluarT;
            $modBuktiKeluar->tahun = date('Y');
            $modBuktiKeluar->namapenerima = $modBuktiBayar->darinama_bkm;
            $modBuktiKeluar->alamatpenerima = $modBuktiBayar->alamat_bkm;
            $modBuktiKeluar->untukpembayaran = 'Retur Tagihan Pasien';
            $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
            $modBuktiKeluar->jmlkaskeluar = $modPenerimaan->totalharga;
            
            $modRetur = new BKReturPenerimaanUmumT;
            $modRetur->pengeluaranumum_id = $modPenerimaan->pengeluaranumum_id;
            $modRetur->tandabuktikeluar_id = $modPenerimaan->tandabuktikeluar_id;
        } else {
            $modPenerimaan = new BKPenerimaanUmumT;
            $modBuktiBayar = new BKTandabuktibayarT;
        }

        if(isset($_POST['BKReturPenerimaanUmumT']))
        {
            $idPenerimaan = $_POST['BKReturPenerimaanUmumT']['penerimaanumum_id'];
            $modPenerimaan = BKPenerimaanUmumT::model()->findByPk($idPenerimaan);
            $modBuktiBayar = BKTandabuktibayarT::model()->findByPk($modPenerimaan->tandabuktibayar_id);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $modRetur = $this->saveReturPenerimaan($_POST['BKReturPenerimaanUmumT']);
                $modBuktiKeluar = $this->saveBuktiKeluar($_POST['BKTandabuktikeluarT'],$modRetur);
                $this->updateTandaBuktiBayar($modPenerimaan->tandabuktibayar_id,$modRetur);

                $successSave = $this->successSave;
                if($successSave){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }

        $this->render('index',
            array(
                'modPenerimaan'=>$modPenerimaan,
                'modBuktiBayar'=>$modBuktiBayar,
                'modBuktiKeluar'=>$modBuktiKeluar,
                'modRetur'=>$modRetur
            )
        );
    }
        
    protected function saveReturPenerimaan($postRetur)
    {
        $modRetur = new BKReturPenerimaanUmumT;
        $modRetur->attributes = $postRetur;
        $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
        if($modRetur->validate()){
            $modRetur->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modRetur;
    }

    protected function saveBuktiKeluar($postBuktiKeluar,$modRetur)
    {
        $modBuktiKeluar = new BKTandabuktikeluarT;
        $modBuktiKeluar->attributes = $postBuktiKeluar;
        $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modBuktiKeluar->tglkaskeluar = $modRetur->tglreturumum;
        if($modBuktiKeluar->validate()){
            $modBuktiKeluar->save();
            $this->successSave = $this->successSave && true;
        } else {
            $this->successSave = false;
        }

        return $modBuktiKeluar;
    }
        
    protected function updateTandaBuktiBayar($idBuktiBayar,$modRetur)
    {
        BKTandabuktibayarT::model()->updateByPk($idBuktiBayar, array('returpenerimaanumum_id'=>$modRetur->returpenerimaanumum_id));
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

        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}