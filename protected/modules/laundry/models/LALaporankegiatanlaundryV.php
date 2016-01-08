<?php

/**
 * This is the model class for table "laporankegiatanlaundry_v".
 *
 * The followings are the available columns in table 'laporankegiatanlaundry_v':
 * @property string $tglpenerimaanlinen
 * @property integer $penerimaanlinen_id
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $beratlinen
 * @property string $dekontaminasi
 * @property string $perbaikan
 * @property string $pencucian
 */
class LALaporankegiatanlaundryV extends LaporankegiatanlaundryV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankegiatanlaundryV the static model class
	 */
	public $tgl_awal, $tgl_akhir, $jml_tampil;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->addBetweenCondition('DATE(tglpenerimaanlinen)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
		}
		$criteria->compare('LOWER(dekontaminasi)',strtolower($this->dekontaminasi),true);
		$criteria->compare('LOWER(perbaikan)',strtolower($this->perbaikan),true);
		$criteria->compare('LOWER(pencucian)',strtolower($this->pencucian),true);

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
            $criteria->limit=$this->jml_tampil;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
					'pagination'=>false,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}