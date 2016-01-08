<?php

/**
 * This is the model class for table "laporanpemeriksaanrujukanrs_v".
 *
 * The followings are the available columns in table 'laporanpemeriksaanrujukanrs_v':
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_katakunci
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property double $tarif_satuan
 * @property integer $qty_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $tindakansudahbayar_id
 * @property string $tgl_tindakan
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $instalasi_nama
 * @property string $nourut
 * @property string $nama_pegawai
 * @property string $tglmasukpenunjang
 */
class LaporanpemeriksaanrujukanrsV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpemeriksaanrujukanrsV the static model class
	 */
        public $tgl_awal, $tgl_akhir, $bulan, $tahun, $hari;
        public $jumlah, $data, $tick;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpemeriksaanrujukanrs_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanpelayanan_id, daftartindakan_id, pasienmasukpenunjang_id, qty_tindakan, tindakansudahbayar_id, pendaftaran_id, pasienkirimkeunitlain_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('tarif_satuan', 'numerical'),
			array('daftartindakan_kode, no_masukpenunjang, no_pendaftaran', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('daftartindakan_katakunci', 'length', 'max'=>30),
			array('ruangan_nama, instalasi_nama, nama_pegawai', 'length', 'max'=>50),
			array('nourut', 'length', 'max'=>3),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_tindakan, tglmasukpenunjang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanpelayanan_id, daftartindakan_id, tgl_awal, tgl_akhir, bulan, tahun, hari, daftartindakan_kode, daftartindakan_nama, daftartindakan_katakunci, pasienmasukpenunjang_id, no_masukpenunjang, tarif_satuan, qty_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tindakansudahbayar_id, tgl_tindakan, pendaftaran_id, no_pendaftaran, pasienkirimkeunitlain_id, ruangan_id, ruangan_nama, instalasi_nama, nourut, nama_pegawai, tglmasukpenunjang', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::HAS_MANY,'PendaftaranT','pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'no_masukpenunjang' => 'No. Masukpenunjang',
			'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'nourut' => 'Nourut',
			'nama_pegawai' => 'Nama Pegawai',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
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

		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('tindakansudahbayar_id',$this->tindakansudahbayar_id);
		$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}