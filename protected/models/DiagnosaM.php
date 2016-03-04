<?php

/**
 * This is the model class for table "diagnosa_m".
 *
 * The followings are the available columns in table 'diagnosa_m':
 * @property integer $diagnosa_id
 * @property string $diagnosa_kode
 * @property string $diagnosa_nama
 * @property string $diagnosa_namalainnya
 * @property string $diagnosa_katakunci
 * @property integer $diagnosa_nourut
 * @property boolean $diagnosa_imunisasi
 * @property boolean $diagnosa_aktif
 * @property integer $klasifikasidiagnosa_id
 */
class DiagnosaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaM the static model class
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
		return 'diagnosa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosa_nama, diagnosa_kode, diagnosa_nama', 'required'),
			array('diagnosa_nourut', 'numerical', 'integerOnly'=>true),
			array('diagnosa_kode', 'length', 'max'=>10),                        
			// array('diagnosa_nama, diagnosa_namalainnya, diagnosa_katakunci', 'length', 'max'=>50),
			array('diagnosa_imunisasi, diagnosa_aktif,klasifikasidiagnosa_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya, diagnosa_katakunci, diagnosa_nourut, diagnosa_imunisasi, diagnosa_aktif, klasifikasidiagnosa_id, dtd_id', 'safe', 'on'=>'search'),
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
			'klasifikasidiagnosa'=>array(self::BELONGS_TO,'KlasifikasidiagnosaM','klasifikasidiagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diagnosa_id' => 'ID',
			'diagnosa_kode' => 'Kode',
			'diagnosa_nama' => 'Nama',
			'diagnosa_namalainnya' => 'Nama Lain',
			'diagnosa_katakunci' => 'Kata Kunci',
			'diagnosa_nourut' => 'No. Urut',
			'diagnosa_imunisasi' => 'Imunisasi',
			'diagnosa_aktif' => 'Aktif',
			'klasifikasidiagnosa_id'=>'Klasifikasi Diagnosa',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('klasifikasidiagnosa_id',$this->klasifikasidiagnosa_id);
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',isset($this->diagnosa_imunisasi)?$this->diagnosa_imunisasi:false);
		$criteria->compare('diagnosa_aktif',isset($this->diagnosa_aktif)?$this->diagnosa_aktif:true);
                //$criteria->addCondition('diagnosa_aktif is true');
		if(!empty($this->dtd_id)){
			$criteria->addCondition("dtd_id = ".$this->dtd_id);				
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>false,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('diagnosa_id',$this->diagnosa_id);
			$criteria->compare('klasifikasidiagnosa_id',$this->klasifikasidiagnosa_id);
			$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
			$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
			$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
			$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
			$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
	//		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
			$criteria->compare('diagnosa_aktif',$this->diagnosa_aktif);
					// Klo limit lebih kecil dari nol itu berarti ga ada limit 
			$criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->diagnosa_nama = ucwords(strtolower($this->diagnosa_nama));
            $this->diagnosa_namalainnya = strtoupper($this->diagnosa_namalainnya);
            $this->diagnosa_kode = strtoupper($this->diagnosa_kode);
            $this->diagnosa_katakunci = strtoupper($this->diagnosa_katakunci);

            return parent::beforeSave();
        }
        
        public function getDiagnosaItems()
        {
            return DiagnosaM::model()->findAll(array('order'=>'diagnosa_nama'));
        }
}