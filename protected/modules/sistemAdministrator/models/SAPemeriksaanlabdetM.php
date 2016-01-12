<?php

class SAPemeriksaanlabdetM extends PemeriksaanlabdetM{
	public $pemeriksaanlab_nama; //untuk pencarian
	public $kelompokdet; //untuk pencarian
	public $namapemeriksaandet; //untuk pencarian
	public $nilairujukan_jeniskelamin; //untuk pencarian
	public $nilairujukan_nama; //untuk pencarian
	public $nilairujukan_min; //untuk pencarian
	public $nilairujukan_max; //untuk pencarian
	public $nilairujukan_satuan; //untuk pencarian
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabM the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pemeriksaanlab','nilairujukan');
		$criteria->compare('pemeriksaanlabdet_nourut', $this->pemeriksaanlabdet_nourut);
		$criteria->compare('LOWER(pemeriksaanlab.pemeriksaanlab_nama)', strtolower($this->pemeriksaanlab_nama), true);
		$criteria->compare('LOWER(nilairujukan.kelompokdet)', strtolower($this->kelompokdet), true);
		$criteria->compare('LOWER(nilairujukan.namapemeriksaandet)', strtolower($this->namapemeriksaandet), true);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_jeniskelamin)', strtolower($this->nilairujukan_jeniskelamin), true);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_nama)', strtolower($this->nilairujukan_nama), true);
		$criteria->compare('nilairujukan.nilairujukan_min', $this->nilairujukan_min);
		$criteria->compare('nilairujukan.nilairujukan_max', $this->nilairujukan_max);
		$criteria->compare('LOWER(nilairujukan.nilairujukan_satuan)', strtolower($this->nilairujukan_satuan), true);

		return $criteria;
	}
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=10;
		$criteria->order = 't.pemeriksaanlab_id, kelompokdet, namapemeriksaandet, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut ASC';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=$this->criteriaSearch();
		$criteria->limit=-1; 
		$criteria->order = 't.pemeriksaanlab_id, kelompokdet, namapemeriksaandet, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut ASC';

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	public function getKelompokDet($pemeriksaanlabdet_id)
	{
		$mod = PemeriksaanlabdetV::model()->findByAttributes(array('pemeriksaanlabdet_id'=>$pemeriksaanlabdet_id));
		if(count($mod)>0)
			$ret = $mod['namapemeriksaandet'];
		else
			$ret = "-";
		return $ret;
	}
	public function getNamaPemeriksaanDet($pemeriksaanlabdet_id)
	{
		$mod = PemeriksaanlabdetV::model()->findByAttributes(array('pemeriksaanlabdet_id'=>$pemeriksaanlabdet_id));
		if(count($mod)>0)
			$ret = $mod['namapemeriksaandet'];
		else
			$ret = "-";
		return $ret;
	}
	/**
	 * nilai yang sudah ada converting symbol
	 */
	public function getNilaiRujukan(){
		return CustomFunction::symbolsConverter($this->nilairujukan->nilairujukan_nama);
	}
}
