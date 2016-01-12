<?php

/**
 * This is the model class for table "informasijadwalpegawai_v".
 *
 * The followings are the available columns in table 'informasijadwalpegawai_v':
 * @property string $no_pembuatanjadwal
 * @property string $tglbuatjadwal
 * @property integer $shift_id
 * @property string $shift_jamawal
 * @property string $shift_jamakhir
 * @property string $shift_nama
 * @property string $shift_kode
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $nama_pegawai
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property string $periodebuatjadwal
 * @property string $sampaidengan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $mengetahui_id
 * @property integer $menyetujiu_id
 * @property string $keterangan_penjadwalan
 */
class InformasijadwalpegawaiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasijadwalpegawaiV the static model class
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
		return 'informasijadwalpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shift_id, ruangan_id, kelompokpegawai_id, instalasi_id, mengetahui_id, menyetujiu_id', 'numerical', 'integerOnly'=>true),
			array('no_pembuatanjadwal', 'length', 'max'=>100),
			array('shift_nama, ruangan_nama, nama_pegawai, instalasi_nama', 'length', 'max'=>50),
			array('shift_kode', 'length', 'max'=>1),
			array('kelompokpegawai_nama', 'length', 'max'=>30),
			array('tglbuatjadwal, shift_jamawal, shift_jamakhir, periodebuatjadwal, sampaidengan, keterangan_penjadwalan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_pembuatanjadwal, tglbuatjadwal, shift_id, shift_jamawal, shift_jamakhir, shift_nama, shift_kode, ruangan_id, ruangan_nama, nama_pegawai, kelompokpegawai_id, kelompokpegawai_nama, periodebuatjadwal, sampaidengan, instalasi_id, instalasi_nama, mengetahui_id, menyetujiu_id, keterangan_penjadwalan', 'safe', 'on'=>'search'),
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
			'no_pembuatanjadwal' => 'No Pembuatanjadwal',
			'tglbuatjadwal' => 'Tglbuatjadwal',
			'shift_id' => 'Shift',
			'shift_jamawal' => 'Shift Jamawal',
			'shift_jamakhir' => 'Shift Jamakhir',
			'shift_nama' => 'Shift Nama',
			'shift_kode' => 'Shift Kode',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'nama_pegawai' => 'Nama Pegawai',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'kelompokpegawai_nama' => 'Kelompokpegawai Nama',
			'periodebuatjadwal' => 'Periodebuatjadwal',
			'sampaidengan' => 'Sampaidengan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'mengetahui_id' => 'Mengetahui',
			'menyetujiu_id' => 'Menyetujiu',
			'keterangan_penjadwalan' => 'Keterangan Penjadwalan',
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

		$criteria->compare('LOWER(no_pembuatanjadwal)',strtolower($this->no_pembuatanjadwal),true);
		$criteria->compare('LOWER(tglbuatjadwal)',strtolower($this->tglbuatjadwal),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('LOWER(shift_jamawal)',strtolower($this->shift_jamawal),true);
		$criteria->compare('LOWER(shift_jamakhir)',strtolower($this->shift_jamakhir),true);
		$criteria->compare('LOWER(shift_nama)',strtolower($this->shift_nama),true);
		$criteria->compare('LOWER(shift_kode)',strtolower($this->shift_kode),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition('kelompokpegawai_id = '.$this->kelompokpegawai_id);
		}
		$criteria->compare('LOWER(kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		$criteria->compare('LOWER(periodebuatjadwal)',strtolower($this->periodebuatjadwal),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->menyetujiu_id)){
			$criteria->addCondition('menyetujiu_id = '.$this->menyetujiu_id);
		}
		$criteria->compare('LOWER(keterangan_penjadwalan)',strtolower($this->keterangan_penjadwalan),true);

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