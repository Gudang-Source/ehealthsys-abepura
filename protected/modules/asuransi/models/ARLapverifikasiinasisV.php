<?php
class ARLapverifikasiinasisV extends LapverifikasiinasisV
{
	public $tgl_awal,$tgl_akhir,$ceklis_tglmasuk,$ceklis_tglkeluar;
	public $verifikasiinasis_tglmasuk_sampaidengan,$verifikasiinasis_tglkeluar_sampaidengan;
	public $verifikasi_bytagihan_sampaidengan,$verifikasi_bytarifgruper_sampaidengan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapverifikasiinasisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->verifikasiinasis_tglmasuk)){
			$criteria->addBetweenCondition('DATE(verifikasiinasis_tglmasuk)', $this->verifikasiinasis_tglmasuk, $this->verifikasiinasis_tglmasuk_sampaidengan);
		}
		if(!empty($this->verifikasiinasis_keluar)){
			$criteria->addBetweenCondition('DATE(verifikasiinasis_keluar)', $this->verifikasiinasis_tglkeluar, $this->verifikasiinasis_tglkeluar_sampaidengan);
		}
		if(!empty($this->verifikasiinasis_id)){
			$criteria->addCondition('verifikasiinasis_id = '.$this->verifikasiinasis_id);
		}
		if(!empty($this->verifikasi_bytagihan)){
			$criteria->addCondition('verifikasi_bytagihan BETWEEN '.$this->verifikasi_bytagihan.' AND '.$this->verifikasi_bytagihan_sampaidengan);
		}
		if(!empty($this->verifikasi_bytarifgruper)){
			$criteria->addCondition('verifikasi_bytarifgruper BETWEEN '.$this->verifikasi_bytarifgruper.' AND '.$this->verifikasi_bytarifgruper_sampaidengan);
		}
		$criteria->compare('LOWER(verifikasiinasis_jnspelayanan)',strtolower($this->verifikasiinasis_jnspelayanan),true);
		$criteria->compare('LOWER(verifikasiinasis_kelaspelayanan)',strtolower($this->verifikasiinasis_kelaspelayanan),true);
		$criteria->compare('LOWER(verifikasiinasis_status)',strtolower($this->verifikasiinasis_status),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->sep_id)){
			$criteria->addCondition('sep_id = '.$this->sep_id);
		}
		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(kodeinacbg)',strtolower($this->kodeinacbg),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if(!empty($this->verifikasiklaiminasis_id)){
			$criteria->addCondition('verifikasiklaiminasis_id = '.$this->verifikasiklaiminasis_id);
		}
		$criteria->compare('LOWER(verifikasi_jnspelayanan)',strtolower($this->verifikasi_jnspelayanan),true);
		$criteria->compare('verifikasi_bytopup',$this->verifikasi_bytopup);
		$criteria->compare('verifikasi_bytarifgruper',$this->verifikasi_bytarifgruper);
		$criteria->compare('verifikasi_bytagihan',$this->verifikasi_bytagihan);
		$criteria->compare('LOWER(verifikasi_tglsep)',strtolower($this->verifikasi_tglsep),true);
		$criteria->compare('LOWER(verifikasi_tglpulang)',strtolower($this->verifikasi_tglpulang),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(verifikasi_nminacbg)',strtolower($this->verifikasi_nminacbg),true);
		$criteria->compare('LOWER(verifikasi_kdinacbg)',strtolower($this->verifikasi_kdinacbg),true);
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchLaporanPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->verifikasiinasis_tglmasuk)){
			$criteria->addBetweenCondition('DATE(verifikasiinasis_tglmasuk)', $this->verifikasiinasis_tglmasuk, $this->verifikasiinasis_tglmasuk_sampaidengan);
		}
		if(!empty($this->verifikasiinasis_keluar)){
			$criteria->addBetweenCondition('DATE(verifikasiinasis_keluar)', $this->verifikasiinasis_tglkeluar, $this->verifikasiinasis_tglkeluar_sampaidengan);
		}
		if(!empty($this->verifikasiinasis_id)){
			$criteria->addCondition('verifikasiinasis_id = '.$this->verifikasiinasis_id);
		}
		$criteria->compare('LOWER(verifikasiinasis_jnspelayanan)',strtolower($this->verifikasiinasis_jnspelayanan),true);
		$criteria->compare('LOWER(verifikasiinasis_kelaspelayanan)',strtolower($this->verifikasiinasis_kelaspelayanan),true);
		$criteria->compare('LOWER(verifikasiinasis_status)',strtolower($this->verifikasiinasis_status),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->sep_id)){
			$criteria->addCondition('sep_id = '.$this->sep_id);
		}
		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(kodeinacbg)',strtolower($this->kodeinacbg),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if(!empty($this->verifikasiklaiminasis_id)){
			$criteria->addCondition('verifikasiklaiminasis_id = '.$this->verifikasiklaiminasis_id);
		}
		$criteria->compare('LOWER(verifikasi_jnspelayanan)',strtolower($this->verifikasi_jnspelayanan),true);
		$criteria->compare('verifikasi_bytopup',$this->verifikasi_bytopup);
		$criteria->compare('verifikasi_bytarifgruper',$this->verifikasi_bytarifgruper);
		$criteria->compare('verifikasi_bytagihan',$this->verifikasi_bytagihan);
		$criteria->compare('LOWER(verifikasi_tglsep)',strtolower($this->verifikasi_tglsep),true);
		$criteria->compare('LOWER(verifikasi_tglpulang)',strtolower($this->verifikasi_tglpulang),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(verifikasi_nminacbg)',strtolower($this->verifikasi_nminacbg),true);
		$criteria->compare('LOWER(verifikasi_kdinacbg)',strtolower($this->verifikasi_kdinacbg),true);
		
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}