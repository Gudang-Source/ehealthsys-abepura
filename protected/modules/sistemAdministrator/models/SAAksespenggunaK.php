<?php

class SAAksespenggunaK extends AksespenggunaK
{
	public $nama_pemakai; //untuk form pencarian & filter
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
		$criteria->with = array('loginpemakai');
		$criteria->compare('LOWER(loginpemakai.nama_pemakai)',strtolower($this->nama_pemakai),true);
		if(!empty($this->peranpengguna_id)){
			$criteria->addCondition('peranpengguna_id = '.$this->peranpengguna_id);
		}
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id = '.$this->modul_id);
		}

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

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}