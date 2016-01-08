<?php

/**
 * This is the model class for table "jnspengeluaranrek_m".
 *
 * The followings are the available columns in table 'jnspengeluaranrek_m':
 * @property integer $jnspengeluaranrek_id
 * @property integer $rekening1_id
 * @property integer $jenispengeluaran_id
 * @property integer $rekening3_id
 * @property integer $rekening5_id
 * @property integer $rekening2_id
 * @property integer $rekening4_id
 * @property string $saldonormal
 */
class JnspengeluaranrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnspengeluaranrekM the static model class
	 */
        public $jnsNama, $rekDebit, $rekKredit, $jenispengeluaran_kode, $jenispengeluaran_namalain, $jenispengeluaran_nama, $jenispengeluaran_aktif,$rekening_debit, $rekeningKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jnspengeluaranrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispengeluaran_id', 'required'),
			array('jenispengeluaran_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnspengeluaranrek_id, jenispengeluaran_kode, rekening_debit, rekeningKredit, jenispengeluaran_nama, jenispengeluaran_namalain, jnsNama, rekDebit, rekKredit, jenispengeluaran_id, rekening5_id', 'safe', 'on'=>'search'),
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
                    'jenispengeluaran'=>array(self::BELONGS_TO,'JenispengeluaranM','jenispengeluaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jnspengeluaranrek_id' => 'ID Pengeluaran Rek',
			'jenispengeluaran_id' => 'Jenis Pengeluaran',
			'rekening5_id' => 'Rekening 5',
                        'jenispengeluaran_kode'=>'Kode',
                        'jenispengeluaran_nama'=>'Nama',
                        'jenispengeluaran_namalain'=>'Nama Lain',
                        'jenispengeluaran_aktif'=>'Aktif',
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

		$criteria->compare('jnspengeluaranrek_id',$this->jnspengeluaranrek_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
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
		$criteria->compare('jnspengeluaranrek_id',$this->jnspengeluaranrek_id);
		$criteria->compare('jenispengeluaran_id',$this->jenispengeluaran_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}