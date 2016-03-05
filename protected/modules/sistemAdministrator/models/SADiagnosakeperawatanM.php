<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SADiagnosakeperawatanM extends DiagnosakeperawatanM
{
    public $diagnosa_nama;
    public $diagnosakeperawatan_kode;
    public $kriteriahasil_nama;
    public $kriteriahasil_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosatindakanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /*        public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->diagnosakeperawatan_id)){
			$criteria->addCondition("t.diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id); 	
		}
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("t.diagnosa_id = ".$this->diagnosa_id); 	
		}
                $criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(t.diagnosakeperawatan_kode)',strtolower($this->diagnosakeperawatan_kode),true);
		$criteria->compare('LOWER(t.diagnosa_medis)',strtolower($this->diagnosa_medis),true);
		$criteria->compare('LOWER(t.diagnosa_keperawatan)',strtolower($this->diagnosa_keperawatan),true);
		$criteria->compare('LOWER(t.diagnosa_tujuan)',strtolower($this->diagnosa_tujuan),true);
               // $criteria->compare('diagnosa_keperawatan_aktif)',$this->diagnosa_keperawatan_aktif);
                                $criteria->with=array('diagnosa');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'diagnosa_nama' => array(
                                    'asc' => 'diagnosa.diagnosa_nama ASC',
                                    'desc' => 'diagnosa.diagnosa_nama DESC',
                                    ),
                                    '*',
                            )
                        )
		));
	}*/
        
}

?>
