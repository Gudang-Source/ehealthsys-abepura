<?php

/**
 * This is the model class for table "sep_t".
 *
 * The followings are the available columns in table 'sep_t':
 * @property integer $sep_id
 * @property string $tglsep
 * @property string $nosep
 * @property string $nokartuasuransi
 * @property string $tglrujukan
 * @property string $norujukan
 * @property string $ppkrujukan
 * @property string $ppkpelayanan
 * @property integer $jnspelayanan
 * @property string $catatansep
 * @property string $diagnosaawal
 * @property string $politujuan
 * @property integer $klsrawat
 * @property string $tglpulang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $upate_loginpemakai_id
 * @property integer $create_ruangan
 */
class SepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SepT the static model class
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
		return 'sep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglsep, nosep, nokartuasuransi, tglrujukan, norujukan, ppkrujukan, ppkpelayanan, jnspelayanan, catatansep, diagnosaawal, politujuan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jnspelayanan, klsrawat, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nosep, politujuan', 'length', 'max'=>100),
			array('nokartuasuransi, norujukan, ppkrujukan, ppkpelayanan', 'length', 'max'=>50),
			array('tglpulang, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sep_id, tglsep, nosep, nokartuasuransi, tglrujukan, norujukan, ppkrujukan, ppkpelayanan, jnspelayanan, catatansep, diagnosaawal, politujuan, klsrawat, tglpulang, create_time, update_time, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','politujuan'),
			'kelasrawat' => array(self::BELONGS_TO, 'KelaspelayananM', 'klsrawat'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sep_id' => 'Sep',
			'tglsep' => 'Tanggal SEP',
			'nosep' => 'No. Sep',
			'nokartuasuransi' => 'No. Kartu Asuransi',
			'tglrujukan' => 'Tanggal Rujukan',
			'norujukan' => 'No. Rujukan',
			'ppkrujukan' => 'PPK Rujukan',
			'ppkpelayanan' => 'PPK Pelayanan',
			'jnspelayanan' => 'Jenis Pelayanan',
			'catatansep' => 'Catatan SEP',
			'diagnosaawal' => 'Diagnosa Awal',
			'politujuan' => 'Poli Tujuan',
			'klsrawat' => 'Kelas Rawat',
			'tglpulang' => 'Tanggal Pulang',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'upate_loginpemakai_id' => 'Upate Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('LOWER(tglsep)',strtolower($this->tglsep),true);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(tglrujukan)',strtolower($this->tglrujukan),true);
		$criteria->compare('LOWER(norujukan)',strtolower($this->norujukan),true);
		$criteria->compare('LOWER(ppkrujukan)',strtolower($this->ppkrujukan),true);
		$criteria->compare('LOWER(ppkpelayanan)',strtolower($this->ppkpelayanan),true);
		$criteria->compare('jnspelayanan',$this->jnspelayanan);
		$criteria->compare('LOWER(catatansep)',strtolower($this->catatansep),true);
		$criteria->compare('LOWER(diagnosaawal)',strtolower($this->diagnosaawal),true);
		$criteria->compare('LOWER(politujuan)',strtolower($this->politujuan),true);
		$criteria->compare('klsrawat',$this->klsrawat);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('upate_loginpemakai_id',$this->upate_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

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
}