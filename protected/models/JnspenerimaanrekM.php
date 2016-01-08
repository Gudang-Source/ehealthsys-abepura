<?php

/**
 * This is the model class for table "jnspenerimaanrek_m".
 *
 * The followings are the available columns in table 'jnspenerimaanrek_m':
 * @property integer $jnspenerimaanrek_id
 * @property integer $rekening5_id
 * @property integer $rekening4_id
 * @property integer $rekening3_id
 * @property integer $rekening2_id
 * @property integer $rekening1_id
 * @property integer $jenispenerimaan_id
 * @property string $saldonormal
 */
class JnspenerimaanrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnspenerimaanrekM the static model class
	 */
        public $jnsNama, $rekDebit, $rekKredit, $jenispenerimaan_kode, $jenispenerimaan_nama, $jenispenerimaan_namalain,$jenispenerimaan_aktif,$rekening_debit, $rekeningKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jnspenerimaanrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispenerimaan_id', 'required'),
			array('rekening5_id, jenispenerimaan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnspenerimaanrek_id, rekening5_id, rekening_debit, rekeningKredit, jenispenerimaan_kode, jenispenerimaan_nama, jenispenerimaan_namalain, jenispenerimaan_aktif, jnsNama, rekDebit, rekKredit, jenispenerimaan_id', 'safe', 'on'=>'search'),
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
                    'rekeningdebit'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'rekeningkredit'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
                    'jenispenerimaan'=>array(self::BELONGS_TO,'JenispenerimaanM','jenispenerimaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jnspenerimaanrek_id' => 'ID Jenis Penerimaan Rek',
			'rekening5_id' => 'Rekening 5',
			
			'jenispenerimaan_id' => 'Jenis Penerimaan',
                        'jenispenerimaan_kode'=>'Kode',
                        'jenispenerimaan_nama'=>'Nama',
                        'jenispenerimaan_namalain'=>'Nama Lain',
                        'jenispenerimaan_aktif'=>'Aktif',
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

		$criteria->compare('jnspenerimaanrek_id',$this->jnspenerimaanrek_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jnspenerimaanrek_id',$this->jnspenerimaanrek_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('jenispenerimaan_id',$this->jenispenerimaan_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}