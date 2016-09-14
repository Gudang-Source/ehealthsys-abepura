<?php

/**
 * This is the model class for table "penjaminrek_m".
 *
 * The followings are the available columns in table 'penjaminrek_m':
 * @property integer $penjaminrek_id
 * @property integer $penjamin_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening2_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $saldonormal
 */
class PenjaminrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjaminrekM the static model class
	 */
        public $rekDebit, $rekKredit, $carabayar_id, $carabayar_nama, $penjamin_nama,$rekening_debit,$rekeningKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penjaminrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		
		return array(
//            array('penjamin_id, rekening5_id', 'cekdata'),
			array('penjamin_id', 'required'),
			array('penjamin_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			array('penjaminrek_id, penjamin_id, penjamin_nama, rekening_debit, rekeningKredit, carabayar_nama, rekDebit,carabayar_id, rekKredit, rekening5_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		
		return array(
                    'rekeningdebit'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'rekeningkredit'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'penjamin'=>array(self::BELONGS_TO,'PenjaminpasienM','penjamin_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjaminrek_id' => 'Penjaminrek',
			'penjamin_id' => 'Penjamin',
			'rekening5_id' => 'Rekening5',
			'carabayar_nama' => 'Cara Bayar',
			'penjamin_nama' => 'Penjamin',
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
	        
		$criteria->compare('penjaminrek_id',$this->penjaminrek_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
       
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penjaminrek_id',$this->penjaminrek_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }
        
        public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }

}