<?php

class SATujuanM extends TujuanM {

	public $diagnosakep_nama, $aktif;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->with = array('diagnosakep');
		$criteria->compare('t.tujuan_id', $this->tujuan_id);
		$criteria->compare('t.diagnosakep_id', $this->diagnosakep_id, true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
		$criteria->compare('LOWER(t.tujuan_nama)', strtolower($this->tujuan_nama), true);
		if (isset($this->tujuan_aktif)) {
			if ($this->tujuan_aktif == 1) {
				$criteria->addCondition('t.tujuan_aktif = TRUE');
			} else {
				$criteria->addCondition('t.tujuan_aktif = FALSE');
			}
		}
		
		if (!empty($this->aktif)) {
			if ($this->aktif == 1) {
				$criteria->addCondition('t.tujuan_aktif = TRUE');
			}
			if ($this->aktif == 0) {
				$criteria->addCondition('t.tujuan_aktif = FALSE');
			} 
		}


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
