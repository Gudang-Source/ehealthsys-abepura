<?php

/**
 * This is the model class for table "penggajianpeg_t".
 *
 * The followings are the available columns in table 'penggajianpeg_t':
 * @property integer $penggajianpeg_id
 * @property integer $pegawai_id
 * @property string $tglpenggajian
 * @property string $nopenggajian
 * @property string $keterangan
 * @property string $mengetahui
 * @property string $menyetujui
 * @property double $totalterima
 * @property double $totalpajak
 * @property double $totalpotongan
 * @property double $penerimaanbersih
 */
class PenggajianpegT extends CActiveRecord
{
        public $nomorindukpegawai, $gelardepan, $nama_pegawai, $nama_keluarga, $tempatlahir_pegawai, $tgl_lahirpegawai, $jeniskelamin, $statusperkawinan;
        public $alamat_pegawai, $agama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenggajianpegT the static model class
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
		return 'penggajianpeg_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('pegawai_id, tglpenggajian, nopenggajian, totalterima, totalpajak, totalpotongan, penerimaanbersih', 'required'),
            array('pengeluaranumum_id, pegawai_id, persentasepph21', 'numerical', 'integerOnly'=>true),
            array('totalterima, totalpajak, totalpotongan, penerimaanbersih, gajipertahun, biayajabatan, potonganpensiun, ptkppertahun, penerimaanbersihpertahun, pkp, pph21pertahun, pph21perbulan', 'numerical'),
            array('nopenggajian', 'length', 'max'=>50),
            array('mengetahui, menyetujui', 'length', 'max'=>100),
            array('kodeptkp', 'length', 'max'=>5),
            array('keterangan, periodegaji', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('penggajianpeg_id, pengeluaranumum_id, pegawai_id, tglpenggajian, nopenggajian, keterangan, mengetahui, menyetujui, totalterima, totalpajak, totalpotongan, penerimaanbersih, periodegaji, gajipertahun, biayajabatan, potonganpensiun, kodeptkp, ptkppertahun, penerimaanbersihpertahun, pkp, persentasepph21, pph21pertahun, pph21perbulan', 'safe', 'on'=>'search'),
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
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pengeluaranumum' => array(self::BELONGS_TO, 'PengeluaranumumT', 'pengeluaranumum_id'),
            'penggajiankompTs' => array(self::HAS_MANY, 'PenggajiankompT', 'penggajianpeg_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penggajianpeg_id' => 'Penggajian Pegawai',
			'pegawai_id' => 'Pegawai',
			'tglpenggajian' => 'Tanggal Penggajian',
			'nopenggajian' => 'No. Penggajian',
			'keterangan' => 'Keterangan',
			'mengetahui' => 'Mengetahui',
			'menyetujui' => 'Menyetujui',
			'totalterima' => 'Total Terima',
			'totalpajak' => 'Total Pajak',
			'totalpotongan' => 'Total Potongan',
			'penerimaanbersih' => 'Penerimaan Bersih',
                        'nomorindukpegawai'=>'NIP',
                        'pengeluaranumum_id' => 'Pengeluaran Umum',
                        'periodegaji' => 'Periode Gaji',
                        'gajipertahun' => 'Gaji Pertahun',
                        'biayajabatan' => 'Biaya Jabatan',
                        'potonganpensiun' => 'Potongan Pensiun',
                        'kodeptkp' => 'Kode Ptkp',
                        'ptkppertahun' => 'Ptkp Pertahun',
                        'penerimaanbersihpertahun' => 'Penerimaan Persih Pertahun',
                        'pkp' => 'Pkp',
                        'persentasepph21' => 'Persentase Pph21',
                        'pph21pertahun' => 'Pph21 Pertahun',
                        'pph21perbulan' => 'Pph21 Perbulan',
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

        if(!empty($this->penggajianpeg_id)){
            $criteria->addCondition('penggajianpeg_id = '.$this->penggajianpeg_id);
        }
        if(!empty($this->pengeluaranumum_id)){
            $criteria->addCondition('pengeluaranumum_id = '.$this->pengeluaranumum_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        $criteria->compare('LOWER(tglpenggajian)',strtolower($this->tglpenggajian),true);
        $criteria->compare('LOWER(nopenggajian)',strtolower($this->nopenggajian),true);
        $criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
        $criteria->compare('LOWER(mengetahui)',strtolower($this->mengetahui),true);
        $criteria->compare('LOWER(menyetujui)',strtolower($this->menyetujui),true);
        $criteria->compare('totalterima',$this->totalterima);
        $criteria->compare('totalpajak',$this->totalpajak);
        $criteria->compare('totalpotongan',$this->totalpotongan);
        $criteria->compare('penerimaanbersih',$this->penerimaanbersih);
        $criteria->compare('LOWER(periodegaji)',strtolower($this->periodegaji),true);
        $criteria->compare('gajipertahun',$this->gajipertahun);
        $criteria->compare('biayajabatan',$this->biayajabatan);
        $criteria->compare('potonganpensiun',$this->potonganpensiun);
        $criteria->compare('LOWER(kodeptkp)',strtolower($this->kodeptkp),true);
        $criteria->compare('ptkppertahun',$this->ptkppertahun);
        $criteria->compare('penerimaanbersihpertahun',$this->penerimaanbersihpertahun);
        $criteria->compare('pkp',$this->pkp);
        if(!empty($this->persentasepph21)){
            $criteria->addCondition('persentasepph21 = '.$this->persentasepph21);
        }
        $criteria->compare('pph21pertahun',$this->pph21pertahun);
        $criteria->compare('pph21perbulan',$this->pph21perbulan);

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