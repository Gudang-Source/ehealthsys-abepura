<?php

/**
 * This is the model class for table "carapembrek_m".
 *
 * The followings are the available columns in table 'carapembrek_m':
 * @property integer $carapembrek_id
 * @property integer $carabayar_id
 * @property integer $rekening2_id
 * @property integer $rekening4_id
 * @property integer $rekening3_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $saldonormal
 * @property string $carapembayaran
 */
class CarapembrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarapembrekM the static model class
	 */
	public $rekDebit, $rekKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'carapembrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('saldonormal', 'required'),
			array('rekening5_id', 'numerical', 'integerOnly'=>true),
//			array('saldonormal', 'length', 'max'=>10),
			array('carapembayaran', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carapembrek_id, rekening5_id, carapembayaran, debitkredit', 'safe', 'on'=>'search'),
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
			// 'carabayar' => array(self::BELONGS_TO,'CarabayarM','carabayar_id'),
			'rekening5' => array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carapembrek_id' => 'Carapembrek',
			// 'carabayar_id' => 'Carabayar',
			'rekening5_id' => 'Rekening5',
			'debitkredit' => 'Saldo Normal',
			'carapembayaran' => 'Carapembayaran',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($print)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		// $criteria->compare('carapembrek_id',$this->carapembrek_id);
		// // $criteria->compare('carabayar_id',$this->carabayar_id);
		// $criteria->compare('rekening2_id',$this->rekening2_id);
		// $criteria->compare('rekening4_id',$this->rekening4_id);
		// $criteria->compare('rekening3_id',$this->rekening3_id);
		 $criteria->compare('rekening5_id',$this->rekening5_id);
		// $criteria->compare('rekening1_id',$this->rekening1_id);
		 $criteria->compare('LOWER(debitkredit)',strtolower($this->debitkredit),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->select = 'carapembayaran';
		$criteria->group = 'carapembayaran';
        $criteria->order = 'carapembayaran';


        if(isset($this->rekDebit)){
            $debit = "D";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekDebit),true);
            $criteria_satu->compare('LOWER(debitkredit)',strtolower($debit),true);
            
            $record = CarapembrekM::model()->with("rekening5")->findAll($criteria_satu);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->carapembayaran;
            }
	
            if(count($data)>0){
                   $condition = "t.carapembayaran IN ('". implode("','", $data) ."')";
                   $criteria->addCondition($condition);
            }

         //    var_dump($criteria);
        	// exit;
        }

        if(isset($this->rekKredit)){
            $debit = "K";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekKredit),true);
            $criteria_satu->compare('LOWER(debitkredit)',strtolower($debit),true);
            
            $record = CarapembrekM::model()->with("rekening5")->findAll($criteria_satu);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->carapembayaran;
            }
	
            if(count($data)>0){
                   $condition = "t.carapembayaran IN ('". implode("','", $data) ."')";
                   $criteria->addCondition($condition);
            }

         //    var_dump($criteria);
        	// exit;
        }

		if($print=='print'){
        	return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        	));
        }else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
	}

	// untuk menampilkan daftar sumberdanarek group by sumberdana
	public function searchIndex()
	{
		$criteria=new CDbCriteria;

		$criteria->select = 'carabayar_id';
		$criteria->compare('carabayar_id',$this->carabayar_id);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('carapembrek_id',$this->carapembrek_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(debitkredit)',strtolower($this->saldonormal),true);
		$criteria->compare('LOWER(carapembayaran)',strtolower($this->carapembayaran),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}