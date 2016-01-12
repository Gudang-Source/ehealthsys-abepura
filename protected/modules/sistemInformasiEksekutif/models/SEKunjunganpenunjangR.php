<?php

/**
 * This is the model class for table "kunjunganpenunjang_r".
 *
 * The followings are the available columns in table 'kunjunganpenunjang_r':
 * @property integer $kunjunganpenunjang_id
 * @property string $tanggal
 * @property integer $radiologi
 * @property integer $laboratorium
 */
class SEKunjunganpenunjangR extends CActiveRecord {

	public $jns_periode;
	public $periode, $jumlah_lab, $jumlah_radio;
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
	public $data, $data_2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KunjunganpenunjangR the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'kunjunganpenunjang_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('radiologi, laboratorium', 'numerical', 'integerOnly' => true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kunjunganpenunjang_id, tanggal, radiologi, laboratorium', 'safe', 'on' => 'search'),
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
			'kunjunganpenunjang_id' => 'Kunjunganpenunjang',
			'tanggal' => 'Tanggal',
			'radiologi' => 'Radiologi',
			'laboratorium' => 'Laboratorium',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->kunjunganpenunjang_id)) {
			$criteria->addCondition('kunjunganpenunjang_id = ' . $this->kunjunganpenunjang_id);
		}
		$criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
		if (!empty($this->radiologi)) {
			$criteria->addCondition('radiologi = ' . $this->radiologi);
		}
		if (!empty($this->laboratorium)) {
			$criteria->addCondition('laboratorium = ' . $this->laboratorium);
		}

		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

}
