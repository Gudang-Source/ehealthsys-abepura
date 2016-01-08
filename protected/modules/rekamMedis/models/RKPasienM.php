<?php

class RKPasienM extends PasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return 
	 */
    public $tgl_rekam_medik_akhir;
    public $instalasi_id;
    public $ruangan_id;
    public $tgl_pendaftaran_cari;
    public $no_pendaftaran;
    public $instalasi_nama;
    public $ruangan_nama;
    public $carabayar_nama;
    public $tgl_pendaftaran;
    public $umur;
    public $jeniskasuspenyakit_nama;
    public $pendaftaran_id;
    public $carabayar_id;
    public $penjamin_id;
    public $kelaspelayanan_id;
    public $pasienadmisi_id;
    public $penjamin_nama;
	public $caramasuk_id;
	public $cari_kelurahan_nama, $cari_kecamatan_nama; //filter pencarian
	public $nomorindukpegawai;
    

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);			
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if (!empty($this->tgl_rekam_medik_akhir)){
            $criteria->addBetweenCondition('date(t.tgl_rekam_medik)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
        }
        else{
            $criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
        }
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id);			
		}
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir);
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
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->addCondition('dokrekammedis_id is NULL AND ispasienluar=FALSE');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchDialogBadak()
	{
		$criteria=$this->criteriaSearch();
		$criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
									 JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id
									 LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',  strtolower($this->nomorindukpegawai), true);
				if($this->ispasienluar){
					$criteria->addCondition('ispasienluar = TRUE');
				}else{
					$criteria->addCondition('ispasienluar = FALSE');
				}
		$criteria->limit=5;
				return new CActiveDataProvider($this, array(
						'criteria'=>$criteria,
						'pagination'=>false,
				));
	}

}