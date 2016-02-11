<?php
class ARLaporansepR extends LaporansepR
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $jumlah, $data;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansepR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$bln_awal = explode('-',$this->bln_awal);
        $bln_akhir = explode('-',$this->bln_akhir);
		
		if($this->jns_periode == "hari"){
			$criteria->addBetweenCondition('DATE(laporansep_tgl)',$this->tgl_awal,$this->tgl_akhir);
		}
		if($this->jns_periode == "bulan"){
			$criteria->addBetweenCondition("date_part('month',laporansep_tgl)",$bln_awal[1],$bln_akhir[1]);
			$criteria->addBetweenCondition("date_part('year',laporansep_tgl)",$this->thn_awal,$this->thn_akhir);
		}
		if($this->jns_periode == "tahun"){
			$criteria->addBetweenCondition("date_part('year',laporansep_tgl)",$this->thn_awal,$this->thn_akhir);
		}
		if(!empty($this->laporansep_id)){
			$criteria->addCondition('laporansep_id = '.$this->laporansep_id);
		}
		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->sep_id)){
			$criteria->addCondition('sep_id = '.$this->sep_id);
		}
//		$criteria->compare('LOWER(laporansep_tgl)',strtolower($this->laporansep_tgl),true);
		$criteria->compare('LOWER(kdinacbg)',strtolower($this->kdinacbg),true);
		$criteria->compare('LOWER(kdseverity)',strtolower($this->kdseverity),true);
		$criteria->compare('LOWER(nminacbg)',strtolower($this->nminacbg),true);
		$criteria->compare('bytagihan',$this->bytagihan);
		$criteria->compare('bytarifgruper',$this->bytarifgruper);
		$criteria->compare('bytarifrs',$this->bytarifrs);
		$criteria->compare('bytopup',$this->bytopup);
		$criteria->compare('LOWER(jnspelayanan)',strtolower($this->jnspelayanan),true);
		$criteria->compare('LOWER(nomr)',strtolower($this->nomr),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('LOWER(nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(kdstatsep)',strtolower($this->kdstatsep),true);
		$criteria->compare('LOWER(nmstatsep)',strtolower($this->nmstatsep),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(tglsep)',strtolower($this->tglsep),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->login_pemakai_id)){
			$criteria->addCondition('login_pemakai_id = '.$this->login_pemakai_id);
		}
		if(!empty($this->update_pemakai_id)){
			$criteria->addCondition('update_pemakai_id = '.$this->update_pemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
	
	public function searchLaporan()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

		$criteria=$this->criteriaSearchLaporan();
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchLaporanPrint()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

		$criteria=$this->criteriaSearchLaporan();
		$criteria->limit=-1;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function searchGrafik()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.
	   
		$criteria=$this->criteriaSearchLaporan();
		
		$criteria->select='count(pendaftaran_id) as jumlah, nokartu as data';
		$criteria->group ='nokartu';
		$criteria->order ='nokartu';

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

}