<?php

/**
 * This is the model class for table "approverenanggpen_t".
 *
 * The followings are the available columns in table 'approverenanggpen_t':
 * @property integer $approverenanggpen_id
 * @property string $tglapproverenanggaran
 * @property integer $menyetujui_id
 * @property integer $mengetahui_id
 * @property string $tglmengetahuiappr
 * @property string $tglmenyetujappr
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class ApproverenanggpenT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApproverenanggpenT the static model class
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
		return 'approverenanggpen_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglapproverenanggaran, menyetujui_id, mengetahui_id, tglmengetahuiappr, tglmenyetujappr, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('menyetujui_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('approverenanggpen_id, tglapproverenanggaran, menyetujui_id, mengetahui_id, tglmengetahuiappr, tglmenyetujappr, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'approverenanggpen_id' => 'Approverenanggpen',
			'tglapproverenanggaran' => 'Tglapproverenanggaran',
			'menyetujui_id' => 'Menyetujui',
			'mengetahui_id' => 'Mengetahui',
			'tglmengetahuiappr' => 'Tglmengetahuiappr',
			'tglmenyetujappr' => 'Tglmenyetujappr',
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

		if(!empty($this->approverenanggpen_id)){
			$criteria->addCondition('approverenanggpen_id = '.$this->approverenanggpen_id);
		}
		$criteria->compare('LOWER(tglapproverenanggaran)',strtolower($this->tglapproverenanggaran),true);
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglmengetahuiappr)',strtolower($this->tglmengetahuiappr),true);
		$criteria->compare('LOWER(tglmenyetujappr)',strtolower($this->tglmenyetujappr),true);
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