<?php

class SAIndikatorimplkepdetM extends IndikatorimplkepdetM
{
	public $diagnosakep_nama,$diagnosakep_id,$diagnosakep,$aktif;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
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
			'indikatorimplkepdet_id' => 'ID',
			'implementasikep_id' => 'Implementasi Keperawatan',
			'indikatorimplkepdet_indikator' => 'Indikator',
			'indikatorimplkepdet_aktif' => 'Aktif',
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
		$criteria->select = 'implementasikep.*,t.*,diagnosakep.diagnosakep_nama';
//		$criteria->with = array('implementasikep');
		$criteria->join = 'JOIN implementasikep_m AS implementasikep ON implementasikep.implementasikep_id = t.implementasikep_id
						   JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = implementasikep.diagnosakep_id';
		$criteria->compare('implementasikep.implementasikep_id',$this->implementasikep_id);
                if ($this->diagnosakep_id){
                    $criteria->addCondition(" implementasikep.diagnosakep_id = '".$this->diagnosakep_id."' ");
                }
		$criteria->compare('implementasikep.diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('indikatorimplkepdet_id',$this->indikatorimplkepdet_id,true);
		$criteria->compare('LOWER(diagnosakep.diagnosakep_nama)',strtolower($this->diagnosakep_nama),true);
		$criteria->compare('LOWER(indikatorimplkepdet_indikator)',strtolower($this->indikatorimplkepdet_indikator),true);
		$criteria->compare('indikatorimplkepdet_aktif',isset($this->indikatorimplkepdet_aktif)?$this->indikatorimplkepdet_aktif:true);
		/*if ($this->aktif != NULL) {
			if ($this->aktif == 1) {
				$criteria->addCondition('t.indikatorimplkepdet_aktif = TRUE');
			}
			if ($this->aktif == 0) {
				$criteria->addCondition('t.indikatorimplkepdet_aktif = FALSE');
			} 
		}*/
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
