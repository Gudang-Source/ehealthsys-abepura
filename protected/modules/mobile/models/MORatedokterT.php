<?php

/**
 * This is the model class for table "ratedokter_t".
 *
 * The followings are the available columns in table 'ratedokter_t':
 * @property integer $ratedokter_id
 * @property integer $pasien_id
 * @property string $tglratedokter
 * @property double $ratedokter
 * @property integer $pegawai_id
 */
class MORatedokterT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MORatedokterT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ratedokter_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglratedokter, ratedokter, pegawai_id', 'required'),
			array('pasien_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('ratedokter', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ratedokter_id, pasien_id, tglratedokter, ratedokter, pegawai_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ratedokter_id' => 'Ratedokter',
			'pasien_id' => 'Pasien',
			'tglratedokter' => 'Tglratedokter',
			'ratedokter' => 'Ratedokter',
			'pegawai_id' => 'Pegawai',
		);
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

		$criteria->compare('ratedokter_id',$this->ratedokter_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglratedokter)',strtolower($this->tglratedokter),true);
		$criteria->compare('ratedokter',$this->ratedokter);
		$criteria->compare('pegawai_id',$this->pegawai_id);

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
		
		/**
         * menampilkan nama lengkap dokter
         */
        public function getNamaDokter(){
            if(!empty($this->pegawai_id)){
                $modPegawai = PegawaiM::model()->findByPk($this->pegawai_id);
                return $modPegawai->gelardepan." ".$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? " ".$modPegawai->gelarbelakang->gelarbelakang_nama : "");
            }else{
                return null;
            }
        }
}