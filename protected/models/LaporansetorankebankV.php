<?php

/**
 * This is the model class for table "laporansetorankebank_v".
 *
 * The followings are the available columns in table 'laporansetorankebank_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasikasir_id
 * @property string $instalasikasir_nama
 * @property integer $ruangankasir_id
 * @property string $ruangankasir_nama
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $tglclosingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 * @property string $keterangan_closing
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $totalpenerimaan
 */
class LaporansetorankebankV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansetorankebankV the static model class
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
		return 'laporansetorankebank_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, instalasikasir_id, ruangankasir_id, shift_id, pegawai_id, kelaspelayanan_id, komponentarif_id', 'numerical', 'integerOnly'=>true),
			array('totalpenerimaan', 'numerical'),
			array('ruangan_nama, instalasikasir_nama, ruangankasir_nama, shift_nama, nama_pegawai, kelaspelayanan_nama', 'length', 'max'=>50),
			array('komponentarif_nama', 'length', 'max'=>25),
			array('instalasi_nama, tglclosingkasir, closingdari, sampaidengan, keterangan_closing', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, instalasikasir_id, instalasikasir_nama, ruangankasir_id, ruangankasir_nama, shift_id, shift_nama, pegawai_id, nama_pegawai, tglclosingkasir, closingdari, sampaidengan, keterangan_closing, kelaspelayanan_id, kelaspelayanan_nama, komponentarif_id, komponentarif_nama, totalpenerimaan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasikasir_id' => 'Instalasikasir',
			'instalasikasir_nama' => 'Instalasikasir Nama',
			'ruangankasir_id' => 'Ruangankasir',
			'ruangankasir_nama' => 'Ruangankasir Nama',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift Nama',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'tglclosingkasir' => 'Tglclosingkasir',
			'closingdari' => 'Closingdari',
			'sampaidengan' => 'Sampaidengan',
			'keterangan_closing' => 'Keterangan Closing',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'totalpenerimaan' => 'Totalpenerimaan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasikasir_id',$this->instalasikasir_id);
		$criteria->compare('LOWER(instalasikasir_nama)',strtolower($this->instalasikasir_nama),true);
		$criteria->compare('ruangankasir_id',$this->ruangankasir_id);
		$criteria->compare('LOWER(ruangankasir_nama)',strtolower($this->ruangankasir_nama),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(tglclosingkasir)',strtolower($this->tglclosingkasir),true);
		$criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('totalpenerimaan',$this->totalpenerimaan);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}