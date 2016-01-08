<?php

/**
 * This is the model class for table "jurnaldetail_t".
 *
 * The followings are the available columns in table 'jurnaldetail_t':
 * @property integer $jurnaldetail_id
 * @property integer $jurnalposting_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening2_id
 * @property integer $rekperiod_id
 * @property integer $rekening5_id
 * @property integer $jurnalrekening_id
 * @property integer $rekening1_id
 * @property string $nourut
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property boolean $koreksi
 * @property string $catatan
 */
class JurnaldetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JurnaldetailT the static model class
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
		return 'jurnaldetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id, jurnalrekening_id, nourut, uraiantransaksi, saldodebit, saldokredit', 'required'),
			array('jurnalposting_id, rekperiod_id, rekening5_id, jurnalrekening_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit', 'numerical'),
			array('nourut', 'length', 'max'=>3),
			array('uraiantransaksi', 'length', 'max'=>200),
			array('koreksi, catatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jurnaldetail_id, jurnalposting_id, rekperiod_id, rekening5_id, jurnalrekening_id, nourut, uraiantransaksi, saldodebit, saldokredit, koreksi, catatan', 'safe', 'on'=>'search'),
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
                    'jurnalPosting'=>array(self::BELONGS_TO,'JurnalpostingT','jurnalposting_id'),
                    'jurnalRekening'=>array(self::BELONGS_TO,'JurnalrekeningT','jurnalrekening_id'),
                    'rekening5'=>array(self::BELONGS_TO,'Rekening5M','rekening5_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jurnaldetail_id' => 'Jurnal Detail',
			'jurnalposting_id' => 'Jurnal Posting',
			'rekperiod_id' => 'Rekperiod',
			'rekening5_id' => 'Rekening5',
			'jurnalrekening_id' => 'Jurnal Rekening',
			'nourut' => 'No. Urut',
			'uraiantransaksi' => 'Uraian Transaksi',
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'koreksi' => 'Koreksi',
			'catatan' => 'Catatan',
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

		$criteria->compare('jurnaldetail_id',$this->jurnaldetail_id);
		$criteria->compare('jurnalposting_id',$this->jurnalposting_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jurnaldetail_id',$this->jurnaldetail_id);
		$criteria->compare('jurnalposting_id',$this->jurnalposting_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}