<?php

/**
 * This is the model class for table "kegoperasi_r".
 *
 * The followings are the available columns in table 'kegoperasi_r':
 * @property integer $kegoperasi_id
 * @property string $tanggal
 * @property integer $kegiatanoperasi_id
 * @property string $kegiatanoperasi_nama
 * @property integer $jumlah
 */
class SEKegoperasiR extends KegoperasiR {

    public $jns_periode;
    public $periode, $jumlah, $jenis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KegoperasiR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kegoperasi_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kegiatanoperasi_id, jumlah', 'numerical', 'integerOnly' => true),
            array('kegiatanoperasi_nama', 'length', 'max' => 100),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kegoperasi_id, tanggal, kegiatanoperasi_id, kegiatanoperasi_nama, jumlah', 'safe', 'on' => 'search'),
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
            'kegoperasi_id' => 'Kegoperasi',
            'tanggal' => 'Tanggal',
            'kegiatanoperasi_id' => 'Kegiatanoperasi',
            'kegiatanoperasi_nama' => 'Kegiatanoperasi Nama',
            'jumlah' => 'Jumlah',
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

        if (!empty($this->kegoperasi_id)) {
            $criteria->addCondition('kegoperasi_id = ' . $this->kegoperasi_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->kegiatanoperasi_id)) {
            $criteria->addCondition('kegiatanoperasi_id = ' . $this->kegiatanoperasi_id);
        }
        $criteria->compare('LOWER(kegiatanoperasi_nama)', strtolower($this->kegiatanoperasi_nama), true);
        if (!empty($this->jumlah)) {
            $criteria->addCondition('jumlah = ' . $this->jumlah);
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
