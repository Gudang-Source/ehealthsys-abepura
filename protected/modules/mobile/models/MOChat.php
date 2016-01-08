<?php

/**
 * This is the model class for table "chat".
 *
 * The followings are the available columns in table 'chat':
 * @property integer $chat_id
 * @property string $chat_from
 * @property string $chat_to
 * @property string $chat_message
 * @property string $chat_sent
 * @property integer $chat_recd
 */
class MOChat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOChat the static model class
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
		return 'chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chat_message', 'required'),
			array('chat_recd', 'numerical', 'integerOnly'=>true),
			array('chat_from, chat_to', 'length', 'max'=>255),
			array('chat_sent', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('chat_id, chat_from, chat_to, chat_message, chat_sent, chat_recd', 'safe', 'on'=>'search'),
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
			'chat_id' => 'Chat',
			'chat_from' => 'Chat From',
			'chat_to' => 'Chat To',
			'chat_message' => 'Chat Message',
			'chat_sent' => 'Chat Sent',
			'chat_recd' => 'Chat Recd',
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

		$criteria->compare('chat_id',$this->chat_id);
		$criteria->compare('LOWER(chat_from)',strtolower($this->chat_from),true);
		$criteria->compare('LOWER(chat_to)',strtolower($this->chat_to),true);
		$criteria->compare('LOWER(chat_message)',strtolower($this->chat_message),true);
		$criteria->compare('LOWER(chat_sent)',strtolower($this->chat_sent),true);
		$criteria->compare('chat_recd',$this->chat_recd);

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