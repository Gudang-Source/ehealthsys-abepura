<?php

/**
 * This is the model class for table "penjaminpasien_m".
 *
 * The followings are the available columns in table 'penjaminpasien_m':
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $penjamin_nama
 * @property string $penjamin_namalainnya
 * @property boolean $penjamin_aktif
 */
class PenjaminpasienM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjaminpasienM the static model class
	 */
         public $carabayar_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penjaminpasien_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamin_nama', 'required'),
			array('carabayar_id', 'numerical', 'integerOnly'=>true),
			array('penjamin_nama, penjamin_namalainnya', 'length', 'max'=>50),
			array('penjamin_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penjamin_id, carabayar_id, carabayar_nama, penjamin_nama, penjamin_namalainnya, penjamin_aktif', 'safe', 'on'=>'search'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			//'rekeningdebit' => array(self::BELONGS_TO, 'Rekening5M', 'rekeningdebit_id'),
			//'rekeningkredit' => array(self::BELONGS_TO, 'Rekening5M', 'rekeningkredit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Cara bayar',
			'penjamin_nama' => 'Nama Penjamin',
			'penjamin_namalainnya' => 'Nama Lain',
			'penjamin_aktif' => 'Penjamin Aktif',
                        'carabayar_nama'=>'Cara bayar',
                        //'rekeningdebit_id'=>'Rekening Debit',
                        //'rekeningkredit_id'=>'Rekening Kredit',
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

                
                $criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                //$criteria->compare('t.rekeningdebit_id',$this->rekeningdebit_id);
                //$criteria->compare('t.rekeningkredit_id',$this->rekeningkredit_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
//                $criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_id),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
//                $criteria->order = 't.penjamin_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                //$criteria->compare('t.rekeningdebit_id',$this->rekeningdebit_id);
                //$criteria->compare('t.rekeningkredit_id',$this->rekeningkredit_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
//                $criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_id),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
                $criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
//		$criteria->compare('penjamin_aktif',$this->penjamin_aktif);
                $criteria->limit=-1;
                $criteria->order='penjamin_id';
//                $criteria->with='carabayar';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
         public function getCarabayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=true ORDER BY carabayar_nama');
        }
        
         public function beforeSave() {
            $this->penjamin_nama = ucwords(strtolower($this->penjamin_nama));
            $this->penjamin_namalainnya = strtoupper($this->penjamin_namalainnya);
            return parent::beforeSave();
        }
        
         public function searchPenjamin()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                // $criteria->compare('t.rekeningdebit_id',$this->rekeningdebit_id);
                // $criteria->compare('t.rekeningkredit_id',$this->rekeningkredit_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
//                $criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_id),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
                $criteria->addCondition("penjamin_id not in(select penjamin_id from penjaminrek_m)");
		$criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
                $criteria->limit=-1;
                $criteria->order='penjamin_id';
//                $criteria->with='carabayar';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
    

    public function search_ekios()
	{

		$criteria=new CDbCriteria;

        $criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
        $criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->order = 't.penjamin_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		      'pageSize'=>12,
		    ),
		));
	}    
        
}