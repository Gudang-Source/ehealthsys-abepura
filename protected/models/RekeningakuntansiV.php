<?php

/**
 * This is the model class for table "rekeningakuntansi_v".
 *
 * The followings are the available columns in table 'rekeningakuntansi_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property string $nmrekeninglain1
 * @property string $rekening1_nb
 * @property boolean $rekening1_aktif
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property string $nmrekeninglain2
 * @property string $rekening2_nb
 * @property boolean $rekening2_aktif
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property string $nmrekeninglain3
 * @property string $rekening3_nb
 * @property boolean $rekening3_aktif
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property string $nmrekeninglain4
 * @property string $rekening4_nb
 * @property boolean $rekening4_aktif
 * @property integer $rekening5_id
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
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property boolean $kelrekening_aktif
 */
class RekeningakuntansiV extends CActiveRecord {

    public $rekDebit, $rekKredit, $namaRekening, $saldokredit, $saldodebit, $saldonormal;
    public $kelrekening_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RekeningakuntansiV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rekeningakuntansi_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek, kelrekening_id', 'numerical', 'integerOnly' => true),
            array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max' => 5),
            array('nmrekening1, nmrekeninglain1, namakelrekening', 'length', 'max' => 100),
            array('rekening5_nb', 'length', 'max' => 1),
            array('nmrekening2, nmrekeninglain2', 'length', 'max' => 200),
            array('nmrekening3, nmrekeninglain3', 'length', 'max' => 300),
            array('nmrekening4, nmrekeninglain4', 'length', 'max' => 400),
            array('nmrekening5, nmrekeninglain5', 'length', 'max' => 500),
            array('kelompokrek', 'length', 'max' => 20),
            array('koderekeningkel', 'length', 'max' => 50),
            array('rekening1_aktif, rekening2_aktif, rekening3_aktif, rekening4_aktif, keterangan, rekening5_aktif, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kelrekening_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rekening1_id, kdrekening1, nmrekening1, nmrekeninglain1, rekening1_aktif, rekening2_id, kdrekening2, nmrekening2, nmrekeninglain2, rekening2_aktif, rekening3_id, kdrekening3, nmrekening3, nmrekeninglain3, rekening3_aktif, rekening4_id, kdrekening4, nmrekening4, nmrekeninglain4, rekening4_aktif, rekening5_id, kdrekening5, nmrekening5, nmrekeninglain5, rekening5_nb, keterangan, nourutrek, rekening5_aktif, kelompokrek, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kelrekening_id, koderekeningkel, namakelrekening, kelrekening_aktif', 'safe', 'on' => 'search'),
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
            'rekening1_id' => 'Rek. 1',
            'kdrekening1' => 'Kode Rek. 1',
            'nmrekening1' => 'Nama Rek. 1',
            'nmrekeninglain1' => 'Nama Lain Rek. 1',
//            'rekening1_nb' => 'Rekening1 Nb',
            'rekening1_aktif' => 'Rek. 1 Aktif',
            'rekening2_id' => 'Rek. 2',
            'kdrekening2' => 'Kode Rek. 2',
            'nmrekening2' => 'Nama Rek. 2',
            'nmrekeninglain2' => 'Nama Lain Rek. 2',
            'rekening2_aktif' => 'Rek. 2 Aktif',
            'rekening3_id' => 'Rek. 3',
            'kdrekening3' => 'Kode Rek. 3',
            'nmrekening3' => 'Nama Rek. 3',
            'nmrekeninglain3' => 'Nama Lain Rek. 3',
            'rekening3_aktif' => 'Rek. 3 Aktif',
            'rekening4_id' => 'Rek. 4',
            'kdrekening4' => 'Kode Rek. 4',
            'nmrekening4' => 'Nama Rek. 4',
            'nmrekeninglain4' => 'Nama Lain Rek. 4',
            'rekening4_aktif' => 'Rek. 4 Aktif',
            'rekening5_id' => 'Rek. 5',
            'kdrekening5' => 'Kode Rek. 5',
            'nmrekening5' => 'Nama Rek. 5',
            'nmrekeninglain5' => 'Nama Lain Rek. 5',
            'rekening5_nb' => 'Saldo Normal',
            'keterangan' => 'Keterangan',
            'nourutrek' => 'No. Urut',
            'rekening5_aktif' => 'Rek. 5 Aktif',
            'kelompokrek' => 'Kelompok Rekening',
            'sak' => 'Sak',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'kelrekening_id' => 'Kelompok Rekening',
            'koderekeningkel' => 'Kode Rek. Kelompok',
            'namakelrekening' => 'Nama Kelompok Rek.',
            'kelrekening_aktif' => 'Kelompok Rek. Aktif',
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

        if (!empty($this->rekening1_id)) {
            $criteria->addCondition('rekening1_id = ' . $this->rekening1_id);
        }
        $criteria->compare('LOWER(kdrekening1)', strtolower($this->kdrekening1), true);
        $criteria->compare('LOWER(nmrekening1)', strtolower($this->nmrekening1), true);
        $criteria->compare('LOWER(nmrekeninglain1)', strtolower($this->nmrekeninglain1), true);
//        $criteria->compare('LOWER(rekening1_nb)', strtolower($this->rekening1_nb), true);
        $criteria->compare('rekening1_aktif', $this->rekening1_aktif);
        if (!empty($this->rekening2_id)) {
            $criteria->addCondition('rekening2_id = ' . $this->rekening2_id);
        }
        $criteria->compare('LOWER(kdrekening2)', strtolower($this->kdrekening2), true);
        $criteria->compare('LOWER(nmrekening2)', strtolower($this->nmrekening2), true);
        $criteria->compare('LOWER(nmrekeninglain2)', strtolower($this->nmrekeninglain2), true);
        $criteria->compare('rekening2_aktif', $this->rekening2_aktif);
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition('rekening3_id = ' . $this->rekening3_id);
        }
        $criteria->compare('LOWER(kdrekening3)', strtolower($this->kdrekening3), true);
        $criteria->compare('LOWER(nmrekening3)', strtolower($this->nmrekening3), true);
        $criteria->compare('LOWER(nmrekeninglain3)', strtolower($this->nmrekeninglain3), true);
        $criteria->compare('rekening3_aktif', $this->rekening3_aktif);
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition('rekening4_id = ' . $this->rekening4_id);
        }
        $criteria->compare('LOWER(kdrekening4)', strtolower($this->kdrekening4), true);
        $criteria->compare('LOWER(nmrekening4)', strtolower($this->nmrekening4), true);
        $criteria->compare('LOWER(nmrekeninglain4)', strtolower($this->nmrekeninglain4), true);
        $criteria->compare('rekening4_aktif', $this->rekening4_aktif);
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
        }
        $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
        $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
        $criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
        $criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
        if (!empty($this->nourutrek)) {
            $criteria->addCondition('nourutrek = ' . $this->nourutrek);
        }
        $criteria->compare('rekening5_aktif', $this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
        $criteria->compare('sak', $this->sak);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if (!empty($this->kelrekening_id)) {
            $criteria->addCondition('kelrekening_id = ' . $this->kelrekening_id);
        }
        $criteria->compare('LOWER(koderekeningkel)', strtolower($this->koderekeningkel), true);
        $criteria->compare('LOWER(namakelrekening)', strtolower($this->namakelrekening), true);
        $criteria->compare('kelrekening_aktif', $this->kelrekening_aktif);

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
	
    // 11-06-2013 
    // v.1
    public function searchAccounts() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->rekening1_id)) {
            $criteria->addCondition('rekening1_id = ' . $this->rekening1_id);
        }
        $criteria->compare('LOWER(kdrekening1)', strtolower($this->kdrekening1), true);
        $criteria->compare('LOWER(nmrekening1)', strtolower($this->nmrekening1), true);
        $criteria->compare('LOWER(nmrekeninglain1)', strtolower($this->nmrekeninglain1), true);
//        $criteria->compare('LOWER(rekening1_nb)', strtolower($this->rekening1_nb), true);
        $criteria->compare('rekening1_aktif', $this->rekening1_aktif);
        if (!empty($this->rekening2_id)) {
            $criteria->addCondition('rekening2_id = ' . $this->rekening2_id);
        }
        $criteria->compare('LOWER(kdrekening2)', strtolower($this->kdrekening2), true);
        $criteria->compare('LOWER(nmrekening2)', strtolower($this->nmrekening2), true);
        $criteria->compare('LOWER(nmrekeninglain2)', strtolower($this->nmrekeninglain2), true);
        $criteria->compare('rekening2_aktif', $this->rekening2_aktif);
        if (!empty($this->rekening3_id)) {
            $criteria->addCondition('rekening3_id = ' . $this->rekening3_id);
        }
        $criteria->compare('LOWER(kdrekening3)', strtolower($this->kdrekening3), true);
        $criteria->compare('LOWER(nmrekening3)', strtolower($this->nmrekening3), true);
        $criteria->compare('LOWER(nmrekeninglain3)', strtolower($this->nmrekeninglain3), true);
        $criteria->compare('rekening3_aktif', $this->rekening3_aktif);
        if (!empty($this->rekening4_id)) {
            $criteria->addCondition('rekening4_id = ' . $this->rekening4_id);
        }
        $criteria->compare('LOWER(kdrekening4)', strtolower($this->kdrekening4), true);
        $criteria->compare('LOWER(nmrekening4)', strtolower($this->nmrekening4), true);
        $criteria->compare('LOWER(nmrekeninglain4)', strtolower($this->nmrekeninglain4), true);
        $criteria->compare('rekening4_aktif', $this->rekening4_aktif);
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
        }
        $criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
        $criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
        $criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
        $criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
		
        $criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
        if (!empty($this->nourutrek)) {
            $criteria->addCondition('nourutrek = ' . $this->nourutrek);
        }
        $criteria->compare('rekening5_aktif', $this->rekening5_aktif);
        $criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
        $criteria->compare('sak', $this->sak);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if (!empty($this->kelrekening_id)) {
            $criteria->addCondition('kelrekening_id = ' . $this->kelrekening_id);
        }
        $criteria->compare('LOWER(koderekeningkel)', strtolower($this->koderekeningkel), true);
        $criteria->compare('LOWER(namakelrekening)', strtolower($this->namakelrekening), true);
        $criteria->compare('kelrekening_aktif', $this->kelrekening_aktif);

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
	
	public function searchDebit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition("rekening5_nb = 'D'");

        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchKredit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->addCondition("rekening5_nb = 'K'");

        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
