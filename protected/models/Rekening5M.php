<?php

/**
 * This is the model class for table "rekening5_m".
 *
 * The followings are the available columns in table 'rekening5_m':
 * @property integer $rekening5_id
 * @property integer $rekening4_id
 * @property integer $tiperekening_id
 * @property integer $rekening2_id
 * @property integer $rekening3_id
 * @property integer $rekening1_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $nmrekeninglain5
 * @property string $rekening5_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property boolean $rekening5_aktif
 * @property string $kelompokrek
 * @property boolean $sak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class Rekening5M extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rekening5M the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'rekening5_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening4_id, kdrekening5, nmrekening5, nmrekeninglain5, rekening5_nb, nourutrek, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('rekening4_id, tiperekening_id,nourutrek', 'numerical', 'integerOnly' => true),
			array('kdrekening5', 'length', 'max' => 5),
			array('nmrekening5, nmrekeninglain5', 'length', 'max' => 500),
			array('rekening5_nb', 'length', 'max' => 1),
			array('kelompokrek', 'length', 'max' => 20),
			array('create_time,update_time', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => false, 'on' => 'insert'),
			array('update_time', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => false, 'on' => 'update'),
			array('keterangan, rekening5_aktif, sak, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening5_id, rekening4_id, tiperekening_id, kdrekening5, nmrekening5, nmrekeninglain5, rekening5_nb, keterangan, nourutrek, rekening5_aktif, kelompokrek, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'rekening5_id' => 'Rekening ID 5',
			'rekening4_id' => 'Rekening ID 4',
			'tiperekening_id' => 'Tipe Rekening',
			'kdrekening5' => 'Kode Rekening',
			'nmrekening5' => 'Nama Rekening',
			'nmrekeninglain5' => 'Nama Lain',
			'rekening5_nb' => 'Jenis Rekening',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'No. Urut',
			'rekening5_aktif' => 'Status',
			'kelompokrek' => 'Kelompok Rekening',
			'sak' => 'Sak',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('rekening5_id', $this->rekening5_id);
		$criteria->compare('rekening4_id', $this->rekening4_id);
		$criteria->compare('tiperekening_id', $this->tiperekening_id);
		$criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
		$criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
		$criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
		$criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
		$criteria->compare('nourutrek', $this->nourutrek);
		$criteria->compare('rekening5_aktif', $this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
		$criteria->compare('sak', $this->sak);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare('rekening5_id', $this->rekening5_id);
		$criteria->compare('rekening4_id', $this->rekening4_id);
		$criteria->compare('tiperekening_id', $this->tiperekening_id);
		$criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
		$criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
		$criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
		$criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
		$criteria->compare('nourutrek', $this->nourutrek);
		$criteria->compare('rekening5_aktif', $this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
		$criteria->compare('sak', $this->sak);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

}
