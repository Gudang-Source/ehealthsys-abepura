<?php

/**
 * This is the model class for table "pengajuanangsuran_v".
 *
 * The followings are the available columns in table 'pengajuanangsuran_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $alamat_pegawai
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $nokeanggotaan
 * @property string $tglpinjaman
 * @property string $jenispinjaman
 * @property string $no_pinjaman
 * @property double $jml_pinjaman
 * @property string $jatuh_tempo
 * @property integer $angsuran_ke
 * @property string $tglangsuran
 * @property string $tgljatuhtempoangs
 * @property double $jmlpokok_angsuran
 * @property double $jmljasa_angsuran
 * @property double $jmldenda_angsuran
 * @property integer $potongansumber_id
 * @property string $namapotongan
 * @property double $jumlahpotongan
 * @property integer $jmlangsuran_id
 * @property integer $pinjaman_id
 */
class PengajuanangsuranV extends CActiveRecord
{
        public $tglAwal;
        public $tglAkhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanangsuranV the static model class
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
		return 'pengajuanangsuran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, golonganpegawai_id, jabatan_id, keanggotaan_id, angsuran_ke, potongansumber_id, jmlangsuran_id, pinjaman_id', 'numerical', 'integerOnly'=>true),
			array('jml_pinjaman, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, jumlahpotongan', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, golonganpegawai_nama, nokeanggotaan, jenispinjaman, no_pinjaman', 'length', 'max'=>50),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskelamin', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama, namapotongan', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglpinjaman, jatuh_tempo, tglangsuran, tgljatuhtempoangs', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, alamat_pegawai, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, jabatan_id, jabatan_nama, keanggotaan_id, nokeanggotaan, tglpinjaman, jenispinjaman, no_pinjaman, jml_pinjaman, jatuh_tempo, angsuran_ke, tglangsuran, tgljatuhtempoangs, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, potongansumber_id, namapotongan, jumlahpotongan, jmlangsuran_id, pinjaman_id', 'safe', 'on'=>'search'),
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
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl Lahirpegawai',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golongan',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'nokeanggotaan' => 'Nokeanggotaan',
			'tglpinjaman' => 'Tglpinjaman',
			'jenispinjaman' => 'Jenispinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'jml_pinjaman' => 'Jml Pinjaman',
			'jatuh_tempo' => 'Jatuh Tempo',
			'angsuran_ke' => 'Angsuran Ke',
			'tglangsuran' => 'Tglangsuran',
			'tgljatuhtempoangs' => 'Tgljatuhtempoangs',
			'jmlpokok_angsuran' => 'Jmlpokok Angsuran',
			'jmljasa_angsuran' => 'Jmljasa Angsuran',
			'jmldenda_angsuran' => 'Jmldenda Angsuran',
			'potongansumber_id' => 'Sumber Potongan',
			'namapotongan' => 'Namapotongan',
			'jumlahpotongan' => 'Jumlahpotongan',
			'jmlangsuran_id' => 'Jmlangsuran',
			'pinjaman_id' => 'Pinjaman',
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

		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('tempatlahir_pegawai',$this->tempatlahir_pegawai,true);
		$criteria->compare('tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pegawai',$this->alamat_pegawai,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);
		$criteria->compare('golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('golonganpegawai_nama',$this->golonganpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nokeanggotaan',$this->nokeanggotaan,true);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('jenispinjaman',$this->jenispinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		$criteria->compare('tgljatuhtempoangs',$this->tgljatuhtempoangs,true);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('namapotongan',$this->namapotongan,true);
		$criteria->compare('jumlahpotongan',$this->jumlahpotongan);
		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPeminjamAngsuran() {
		$criteria = new CDbCriteria();
		//echo $this->tglAkhir; die;
		if (isset($this->tglAwal) && isset($this->tglAkhir)) {
			$criteria->addBetweenCondition('tglangsuran', $this->tglAwal, $this->tglAkhir);
			if(!empty($this->unit_id))$criteria->addCondition('unit_id = '.$this->unit_id);
			//$criteria->compare('unit_id', $this->unit_id);
			if(!empty($this->golonganpegawai_id))$criteria->addCondition('golonganpegawai_id = '.$this->golonganpegawai_id);
			//$criteria->compare('golonganpegawai_id', $this->golonganpegawai_id);
			if(!empty($this->potongansumber_id))$criteria->addCondition('potongansumber_id = '.$this->potongansumber_id);
                        else ($criteria->addCondition('potongansumber_id = 0'));
			//$criteria->compare('potongansumber_id', $this->potongansumber_id);
		} else $criteria->compare('nokeanggotaan', '-');

		$criteria->select = $criteria->group = 'jmlangsuran_id, t.tglangsuran,
                    potongansumber_id,
                    keanggotaan_id,
                    jmlpokok_angsuran,
                    jmljasa_angsuran,
                    tgljatuhtempoangs,
                    tglpinjaman,
                    no_pinjaman,
                    nokeanggotaan,
                    nama_pegawai,                    
                    namapotongan,
                    golonganpegawai_nama,
                    angsuran_ke,
                    golonganpegawai_id,
                    jumlahpotongan';
		$criteria->order = 'nama_pegawai, tglangsuran,no_pinjaman, angsuran_ke, potongansumber_id';

		return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>false));
	}
}