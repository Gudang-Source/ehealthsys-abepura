<?php

/**
 * This is the model class for table "realisasirencanalembur_r".
 *
 * The followings are the available columns in table 'realisasirencanalembur_r':
 * @property integer $realisasirencanalembur_id
 * @property string $tanggal
 * @property integer $rencanalembur
 * @property integer $realisasilembur
 */
class SERealisasirencanalemburR extends RealisasirencanalemburR {

    public $jns_periode;
    public $periode, $jumlah_rencana, $jumlah_real;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RealisasirencanalemburR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'realisasirencanalembur_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rencanalembur, realisasilembur', 'numerical', 'integerOnly' => true),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('realisasirencanalembur_id, tanggal, rencanalembur, realisasilembur', 'safe', 'on' => 'search'),
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
            'realisasirencanalembur_id' => 'Realisasirencanalembur',
            'tanggal' => 'Tanggal',
            'rencanalembur' => 'Rencanalembur',
            'realisasilembur' => 'Realisasilembur',
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

        if (!empty($this->realisasirencanalembur_id)) {
            $criteria->addCondition('realisasirencanalembur_id = ' . $this->realisasirencanalembur_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->rencanalembur)) {
            $criteria->addCondition('rencanalembur = ' . $this->rencanalembur);
        }
        if (!empty($this->realisasilembur)) {
            $criteria->addCondition('realisasilembur = ' . $this->realisasilembur);
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
