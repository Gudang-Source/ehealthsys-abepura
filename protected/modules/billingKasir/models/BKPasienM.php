<?php

class BKPasienM extends PasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
        public $idInstalasi, $ruangan_nama, $carabayar_nama, $tgl_pendaftaran_cari, $instalasi_nama, $no_pendaftaran;
        public $cari_no_rekam_medik, $cari_nama_pasien;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPembayaranKlaim()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);					
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition("pekerjaan_id = ".$this->pekerjaan_id);					
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);					
		}
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition("pendidikan_id = ".$this->pendidikan_id);					
		}
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);					
		}
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);					
		}
		if(!empty($this->suku_id)){
			$criteria->addCondition("suku_id = ".$this->suku_id);					
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("profilrs_id = ".$this->profilrs_id);					
		}
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);					
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id);					
		}
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
                $criteria->with=array('pendaftaran');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function searchPasienRumahsakitV(){
            $format = new MyFormatter;
            $model = null;
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            if(!empty($this->tgl_pendaftaran_cari)){
                $this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
                $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_pendaftaran_cari." 00:00:00", $this->tgl_pendaftaran_cari." 23:59:59");
            }
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
			if(!empty($this->idInstalasi)){
				$criteria->addCondition("instalasi_id = ".$this->idInstalasi);					
			}
//            $criteria->compare('LOWER(instalasi_nama)', strtolower($this->namaInstalasi), true);
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->limit = 50;
            $criteria->order = 'tgl_pendaftaran DESC';
            //kembalikan format
            $this->tgl_pendaftaran_cari = empty($this->tgl_pendaftaran_cari) ? null : date('d M Y',strtotime($this->tgl_pendaftaran_cari));
            if($this->idInstalasi == Params::INSTALASI_ID_RD){
                $model = new BKInfokunjunganrdV;
            }else if($this->idInstalasi == Params::INSTALASI_ID_RJ){
                $model = new BKInfokunjunganrjV;
            }else{
                $model = new BKInfopasienmasukkamarV; //default
            }
            return new CActiveDataProvider($model, array(
                        'criteria'=>$criteria,
                ));
        }
        
        
        public $tglpembayaran, $nopembayaran, $pembayaran_id, $nobuktibayar;
        public function searchPasienSudahBayar() {
            $provider = $this->searchPasienRumahsakitV(false);
            $criteria = $provider->criteria;
            $criteria->join = ' join pembayaranpelayanan_t p on t.pendaftaran_id = p.pendaftaran_id '
                    . 'join tandabuktibayar_t k on k.pembayaranpelayanan_id = p.pembayaranpelayanan_id';
            $criteria->select = 't.*, p.tglpembayaran, p.nopembayaran, p.pembayaranpelayanan_id as pembayaran_id,'
                    . 'k.nobuktibayar';
            
            $criteria->compare('lower(p.nopembayaran)', strtolower($this->nopembayaran), true);
            $criteria->compare('lower(k.nobuktibayar)', strtolower($this->nobuktibayar), true);
            
            
            $criteria->order = null;
            
            $provider->criteria = $criteria;
            $provider->sort->defaultOrder = 'p.tglpembayaran desc';
            $provider->sort->attributes = array(
                'tglpembayaran' => array(
                    'asc'=>'p.tglpembayaran',
                    'desc'=>'p.tglpembayaran desc',
                ),
                '*',
            );
            return $provider;
        }
        
}