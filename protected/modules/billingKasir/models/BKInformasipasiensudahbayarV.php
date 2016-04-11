<?php

class BKInformasipasiensudahbayarV extends InformasipasiensudahbayarV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $tgl_bkm_awal;
    public $tgl_bkm_akhir;
    public $ceklis;
    public $pendaftaran;
  
   
    

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchInformasi()
    {
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('date(tglbuktibayar)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(instalasi)',strtolower($this->instalasi),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
                $criteria->compare('petugasadministrasi_id',$this->petugasadministrasi_id);
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		if(!empty($this->returbayarpelayanan_id)){
			$criteria->addCondition('returbayarpelayanan_id = '.$this->returbayarpelayanan_id);
		}
		if(!empty($this->closingkasir_id)){
                    if ($this->closingkasir_id == 1):
                        $criteria->addCondition('closingkasir_id is not null ');                                        
                    elseif ($this->closingkasir_id == 2):
                        $criteria->addCondition('closingkasir_id is null ');
                    endif;
		}
              //  else
              //  {
                  //  $criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
              //  }
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->addCondition('ruangankasir_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruangankasir_nama)',strtolower($this->ruangankasir_nama),true);
		$criteria->order = "tglbuktibayar DESC"; 
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
    public function getRuanganItems()
        {
          return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>'TRUE','instalasi_id'=>array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_REHAB)),array('order'=>'ruangan_nama'));
            
        }
	
	public function actionCekLoginBatalBayar($task='BatalBayar') 
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
        
        public function getNamaSapaan($no_rekam_medik)
        {
            $sapaan = PasienM::model()->findAllByAttributes(array('no_rekam_medik'=>$no_rekam_medik));
            
            $data = "";
            if($sapaan == null):
                $data = "";
            else:
                foreach($sapaan as $sapaan):
                    $data =  $sapaan->namadepan;
                endforeach;
            endif;
                        
            return $data;
        }
        
        
}