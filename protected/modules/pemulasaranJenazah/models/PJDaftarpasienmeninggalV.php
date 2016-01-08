<?php

class PJDaftarpasienmeninggalV extends DaftarpasienmeninggalV
{
        public $tgl_awal,$tgl_akhir;
        public $pasienmasukpenunjang_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                if($this->ceklis){
                    $criteria->addBetweenCondition ('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
                }
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
//                $criteria->addCondition('pasienmasukpenunjang_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}