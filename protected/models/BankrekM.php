<?php

/**
 * This is the model class for table "bankrek_m".
 *
 * The followings are the available columns in table 'bankrek_m':
 * @property integer $bankrek_id
 * @property integer $rekening4_id
 * @property integer $rekening3_id
 * @property integer $rekening2_id
 * @property integer $bank_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $saldonormal
 */
class BankrekM extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankrekM the static model class
	 */
	public $namaBank, $rekKredit, $rekDebit, $propinsi_id, $kabupaten_id, $kodepos, $website,
			$faxbank, $negara, $matauang_id, $namabank, $alamatbank, $norekening, $telpbank1,
			$telpbank2, $emailbank, $cabangdari, $bank_aktif, $nmrekening5, $nmrekening5_lain;
	public $propinsi_nama, $matauang, $kabupaten_nama;
	public $rekening_debit, $rekeningKredit;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'bankrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_id', 'required'),
			array('bank_id, rekening5_id', 'numerical', 'integerOnly' => true),
//			array('saldonormal', 'length', 'max' => 10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bankrek_id, rekening_debit, rekeningKredit, propinsi_nama, matauang, kabupaten_nama, propinsi_id, kabupaten_id, kodepos, nmrekening5, nmrekening5_lain, website, faxbank, negara, matauang_id, namabank, alamatbank, norekening, telpbank1, telpbank2, emailbank, cabangdari, bank_aktif, namaBank,rekKredit,rekDebit, bank_id, rekening5_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'rekeningdebit' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'rekeningkredit' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'bank' => array(self::BELONGS_TO, 'BankM', 'bank_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'bankrek_id' => 'Bankrek',
			'bank_id' => 'Bank',
			'rekening5_id' => 'Rekening5',
//			'saldonormal' => 'Saldonormal',
			'propinsi_id' => 'Propinsi',
			'kabupaten_id' => 'Kabupaten',
			'telpbank1' => 'Telp Bank 1',
			'telpbank2' => 'Telp Bank 2',
			'website' => 'Website',
			'matauang_id' => 'Mata Uang',
			'kodepos' => 'Kode Pos',
			'faxbank' => 'Fax Bank',
			'namabank' => 'Nama Bank',
			'alamatbank' => 'Alamat Bank',
			'norekening' => 'No. Rekening',
			'emailbank' => 'Email Bank',
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

		$criteria->compare('bankrek_id',$this->bankrek_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare('bankrek_id', $this->bankrek_id);
		$criteria->compare('bank_id', $this->bank_id);
		$criteria->compare('rekening5_id', $this->rekening5_id);
//		$criteria->compare('LOWER(saldonormal)', strtolower($this->saldonormal), true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function getPropinsiItems() {
		return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif' => true), array('order' => 'propinsi_nama'));
	}

	/**
	 * Mengambil daftar semua kabupaten berdasarkan propinsi
	 * @return CActiveDataProvider 
	 */
	public function getKabupatenItems($propinsi_id = null) {
		if (!empty($propinsi_id))
			return KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $propinsi_id, 'kabupaten_aktif' => true), array('order' => 'kabupaten_nama'));
		else {
			return array();
		}
	}

}
