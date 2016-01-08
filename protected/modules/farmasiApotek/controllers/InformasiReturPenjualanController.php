<?php

class InformasiReturPenjualanController extends MyAuthController
{
	public function actionIndex()
	{
            $format = new MyFormatter();
            $modInfoReturPenjualan = new FAReturresepT();
            $modInfoReturPenjualan->unsetAttributes();
            $modInfoReturPenjualan->tgl_awal = date('Y-m-d');
            $modInfoReturPenjualan->tgl_akhir = date('Y-m-d');
            if(isset($_GET['FAReturresepT'])){                
                $modInfoReturPenjualan->attributes = $_GET['FAReturresepT'];
                $modInfoReturPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAReturresepT']['tgl_awal']);
                $modInfoReturPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAReturresepT']['tgl_akhir']);
            }
		
            $this->render('index',array('format'=>$format,'modInfoReturPenjualan'=>$modInfoReturPenjualan));
        }
        
        public function actionDetailReturPenjualan($id) {
        $this->layout = '//layouts/iframe';
        
            $modRetur = ReturresepT::model()->findByPk($id);
            $detail = ReturresepdetT::model()->findAll('returresep_id = '.$modRetur->returresep_id);
            $modPenjualanResep = PenjualanresepT::model()->findByPk($modRetur->penjualanresep_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualanResep->pendaftaran_id);
            if (count($detail) > 0){
                $details = array();
                foreach ($detail as $key => $value) {
                    $obatalkes = ObatalkespasienT::model()->findByPk($value->obatalkespasien_id);
                    $details[0]['uraian'] = "Obatalkes";
                    $details[0]['harga'] += ($obatalkes->hargajual_oa + $obatalkes->biayaadministrasi + $obatalkes->biayakonseling + $obatalkes->biayaservice + $obatalkes->jasadokterresep);
                    $details[0]['diskon'] += ($obatalkes->hargasatuan_oa*$obatalkes->discount)/100;
                    $details[0]['qty'] = 1;
                }
            }

        $this->render('view', array('model'=>$model,'details'=>$details, 'modRetur'=>$modRetur, 'modPenjualanResep'=>$modPenjualanResep,
                                    'modPendaftaran'=>$modPendaftaran, 'judulKwitansi'=>$judulKwitansi, 'caraPrint'=>$caraPrint, 
                                    ));
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