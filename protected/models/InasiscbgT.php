<?php

/**
 * This is the model class for table "inasiscbg_t".
 *
 * The followings are the available columns in table 'inasiscbg_t':
 * @property integer $inasiscbg_id
 * @property integer $pendaftaran_id
 * @property integer $inacbg_id
 * @property string $inasiscbg_tgl
 * @property string $kodeprosedur
 * @property string $namaprosedur
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InasiscbgT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InasiscbgT the static model class
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
		return 'inasiscbg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, inasiscbg_tgl, kodeprosedur, namaprosedur, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, inacbg_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kodeprosedur', 'length', 'max'=>50),
			array('namaprosedur', 'length', 'max'=>200),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inasiscbg_id, pendaftaran_id, inacbg_id, inasiscbg_tgl, kodeprosedur, namaprosedur, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'inasiscbg_id' => 'Inasiscbg',
			'pendaftaran_id' => 'Pendaftaran',
			'inacbg_id' => 'Inacbg',
			'inasiscbg_tgl' => 'Inasiscbg Tgl',
			'kodeprosedur' => 'Kodeprosedur',
			'namaprosedur' => 'Namaprosedur',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->inasiscbg_id)){
			$criteria->addCondition('inasiscbg_id = '.$this->inasiscbg_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->inacbg_id)){
			$criteria->addCondition('inacbg_id = '.$this->inacbg_id);
		}
		$criteria->compare('LOWER(inasiscbg_tgl)',strtolower($this->inasiscbg_tgl),true);
		$criteria->compare('LOWER(kodeprosedur)',strtolower($this->kodeprosedur),true);
		$criteria->compare('LOWER(namaprosedur)',strtolower($this->namaprosedur),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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