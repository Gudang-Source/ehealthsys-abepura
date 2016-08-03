<?php

class KOInformasipermohonanpinjamanV extends InformasipermohonanpinjamanV
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		/**
		 * digunakan di modul Kepegawaian pelmar file kontrakPelamar.php
		 */
	public function criteriaSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
			$criteria->addBetweenCondition('t.tglpermohonanpinjaman', $this->tglAwal, $this->tglAkhir);
		}

		if(!empty($this->pegawai_id))$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		//$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		//$criteria->compare('LOWER(t.gelarbelakang)',strtolower($this->gelarbelakang),true);
		$criteria->compare('LOWER(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('t.tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('t.jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('t.statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		if(!empty($this->kelurahan_id))$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		//$criteria->compare('t.kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('t.kode_pos',$this->kode_pos,true);
		$criteria->compare('LOWER(t.kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('t.golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('LOWER(t.golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		if(!empty($this->pangkat_id))$criteria->addCondition('t.pangkat_id = '.$this->pangkat_id);
		//$criteria->compare('t.pangkat_id',$this->pangkat_id);
		$criteria->compare('LOWER(t.pangkat_nama)',strtolower($this->pangkat_nama),true);
		if(!empty($this->jabatan_id))$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
		//$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->compare('LOWER(t.jabatan_nama)',strtolower($this->jabatan_nama),true);
		if(!empty($this->unit_id))$criteria->addCondition('t.unit_id = '.$this->unit_id);
		//$criteria->compare('t.unit_id',$this->unit_id);
		//$criteria->compare('LOWER(t.namaunit)',strtolower($this->namaunit),true);
		if(!empty($this->keanggotaan_id))$criteria->addCondition('t.keanggotaan_id = '.$this->keanggotaan_id);
		//$criteria->compare('t.keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('t.nokeanggotaan',$this->nokeanggotaan,true);
		if(!empty($this->permohonanpinjaman_id))$criteria->addCondition('t.permohonanpinjaman_id = '.$this->permohonanpinjaman_id);
		//$criteria->compare('t.permohonanpinjaman_id',$this->permohonanpinjaman_id);
		//$criteria->compare('t.tglpermohonanpinjaman',$this->tglpermohonanpinjaman,true);
		$criteria->compare('t.nopermohonan',$this->nopermohonan,true);
		$criteria->compare('LOWER(t.jenispinjaman_permohonan)',strtolower($this->jenispinjaman_permohonan),true);
		// $criteria->compare('potongansumber_id',$this->potongansumber_id);
		// $criteria->compare('LOWER(namapotongan)',strtolower($this->namapotongan),true);
		$criteria->compare('jmlpinjaman',$this->jmlpinjaman);
		$criteria->compare('jangkawaktu_pinj_bln',$this->jangkawaktu_pinj_bln);
		$criteria->compare('jasapinjaman_bln',$this->jasapinjaman_bln);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('jmlinsentif',$this->jmlinsentif);
		$criteria->compare('jmlsimpanan',$this->jmlsimpanan);
		$criteria->compare('jmlpenghasilanlain',$this->jmlpenghasilanlain);
		$criteria->compare('jmltunggakanuangpinj',$this->jmltunggakanuangpinj);
		$criteria->compare('jmltunggakanbrgpinj',$this->jmltunggakanbrgpinj);
		$criteria->compare('batasplafon',$this->batasplafon);
		if(!empty($this->petugas_id))$criteria->addCondition('petugas_id = '.$this->petugas_id);
		//$criteria->compare('petugas_id',$this->petugas_id);
		if(!empty($this->approval_id))$criteria->addCondition('approval_id = '.$this->approval_id);
		//$criteria->compare('approval_id',$this->approval_id);
		$criteria->compare('tglapproval',$this->tglapproval,true);
		$criteria->compare('keteranganapproval',$this->keteranganapproval,true);
		if(!empty($this->appr_diperiksaoleh_id))$criteria->addCondition('appr_diperiksaoleh_id = '.$this->appr_diperiksaoleh_id);
		//$criteria->compare('appr_diperiksaoleh_id',$this->appr_diperiksaoleh_id);
		$criteria->compare('appr_tgldiperiksa',$this->appr_tgldiperiksa,true);
		if(!empty($this->appr_disetujuioleh_id))$criteria->addCondition('appr_disetujuioleh_id = '.$this->appr_disetujuioleh_id);
		//$criteria->compare('appr_disetujuioleh_id',$this->appr_disetujuioleh_id);
		$criteria->compare('appr_tgldisetujui',$this->appr_tgldisetujui,true);
		//$criteria->compare('status_disetujui',$this->status_disetujui);
		//$criteria->compare('per_create_time',$this->per_create_time,true);
		//$criteria->compare('per_update_time',$this->per_update_time,true);
		//$criteria->compare('per_create_login',$this->per_create_login);
		//$criteria->compare('per_update_login',$this->per_update_login);
		//$criteria->order='t.tglpermohonanpinjaman DESC';
		//var_dump($this->status_disetujui); die;

		if ($this->status_disetujui == 3) $criteria->addCondition('approval_id is null');
		else if ($this->status_disetujui == 1) $criteria->addCondition('status_disetujui = true');
		else if ($this->status_disetujui == 2) $criteria->addCondition('status_disetujui = false');

		//if ($this->cair == 1) $criteria->addCondition('pinjaman_id is not null');
		//else if ($this->cair == 2) $criteria->addCondition('pinjaman_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,			
		));
	}

	public function searchTableDash(){
		$provider=$this->criteriaSearch();
		$provider->criteria->limit = 5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$provider->criteria,
			'sort'=>array(
				'defaultOrder'=>'t.tglpermohonanpinjaman DESC',
			),'Pagination'=>FALSE
		));
	} 
}