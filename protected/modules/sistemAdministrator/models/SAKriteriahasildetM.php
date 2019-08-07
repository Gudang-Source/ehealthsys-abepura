<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAKriteriahasildetM extends KriteriahasildetM {
	
	public $kriteriahasil_nama,$diagnosakep_id,$aktif,$diagnosakep_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LabklinikrujukanM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kriteriahasildet_id' => 'ID',
			'kriteriahasil_id' => 'Kriteria Hasil',
			'kriteriahasildet_indikator' => 'Indikator',
			'kriteriahasildet_aktif' => 'Aktif',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->select = 'kriteriahasil.*,t.*,diagnosakep.*';
		$criteria->join = 'JOIN kriteriahasil_m AS kriteriahasil ON kriteriahasil.kriteriahasil_id = t.kriteriahasil_id';
		$criteria->join .= ' JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = kriteriahasil.diagnosakep_id';
		$criteria->compare('kriteriahasil.kriteriahasil_id',$this->kriteriahasil_id);		
                if (!empty($this->diagnosakep_id)){
                    $criteria->addCondition('kriteriahasil.diagnosakep_id ='.$this->diagnosakep_id);
                }
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(kriteriahasil.kriteriahasil_nama)',strtolower($this->kriteriahasil_nama),true);
		$criteria->compare('kriteriahasildet_id',$this->kriteriahasildet_id,true);
		$criteria->compare('LOWER(kriteriahasildet_indikator)',strtolower($this->kriteriahasildet_indikator),true);
		$criteria->compare('kriteriahasildet_aktif',isset($this->kriteriahasildet_aktif)?$this->kriteriahasildet_aktif:true);
		
		return $criteria;
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
?>
