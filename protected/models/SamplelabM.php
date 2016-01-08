<?php

/**
 * This is the model class for table "samplelab_m".
 *
 * The followings are the available columns in table 'samplelab_m':
 * @property integer $samplelab_id
 * @property string $samplelab_nama
 * @property string $samplelab_namalainnya
 * @property boolean $samplelab_aktif
 */
class SamplelabM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SamplelabM the static model class
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
		return 'samplelab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('samplelab_nama', 'required'),
			array('samplelab_nama, samplelab_namalainnya', 'length', 'max'=>50),
			array('samplelab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('samplelab_id, samplelab_nama, samplelab_namalainnya, samplelab_aktif', 'safe', 'on'=>'search'),
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
			'samplelab_id' => 'Sampel Lab',
			'samplelab_nama' => 'Nama Sample',
			'samplelab_namalainnya' => 'Nama Lainnya',
			'samplelab_aktif' => 'Aktif',
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

		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('LOWER(samplelab_nama)',strtolower($this->samplelab_nama),true);
		$criteria->compare('LOWER(samplelab_namalainnya)',strtolower($this->samplelab_namalainnya),true);
		$criteria->compare('samplelab_aktif',isset($this->samplelab_aktif)?$this->samplelab_aktif:true);
                //$criteria->addCondition('samplelab_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('samplelab_id',$this->samplelab_id);
		$criteria->compare('LOWER(samplelab_nama)',strtolower($this->samplelab_nama),true);
		$criteria->compare('LOWER(samplelab_namalainnya)',strtolower($this->samplelab_namalainnya),true);
		//$criteria->compare('samplelab_aktif',$this->samplelab_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() 
        {
            $this->samplelab_nama = ucwords(strtolower($this->samplelab_nama));
            $this->samplelab_namalainnya = strtoupper($this->samplelab_namalainnya);
            return parent::beforeSave();
        }
}