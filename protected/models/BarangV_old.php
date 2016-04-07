<?php

/**
 * This is the model class for table "barang_v".
 *
 * The followings are the available columns in table 'barang_v':
 * @property integer $golongan_id
 * @property string $golongan_kode
 * @property string $golongan_nama
 * @property integer $kelompok_id
 * @property string $kelompok_kode
 * @property string $kelompok_nama
 * @property integer $subkelompok_id
 * @property string $subkelompok_kode
 * @property string $subkelompok_nama
 * @property integer $bidang_id
 * @property string $bidang_kode
 * @property string $bidang_nama
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_namalainnya
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property string $barang_image
 * @property boolean $barang_aktif
 */
class BarangV extends CActiveRecord
{
    public $invtanah_namabrg;
    public $subsubkelompok_id;
    public $subsubkelompok_nama;
    public $subsubkelompok_kode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarangV the static model class
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
		return 'barang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('golongan_id, kelompok_id, subkelompok_id, bidang_id, barang_id, barang_ekonomis_thn, barang_jmldlmkemasan', 'numerical', 'integerOnly'=>true),
			array('golongan_kode, kelompok_kode, subkelompok_kode, bidang_kode, barang_type, barang_kode, barang_merk, barang_warna, barang_satuan', 'length', 'max'=>50),
			array('golongan_nama, kelompok_nama, subkelompok_nama, bidang_nama, barang_nama, barang_namalainnya', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('barang_statusregister, barang_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subsubkelompok_id,subsubkelompok_nama,subsubkelompok_kode, golongan_id, golongan_kode, golongan_nama, kelompok_id, kelompok_kode, kelompok_nama, subkelompok_id, subkelompok_kode, subkelompok_nama, bidang_id, bidang_kode, bidang_nama, barang_id, barang_type, barang_kode, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_aktif', 'safe', 'on'=>'search'),
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
			'golongan_id' => 'ID Golongan',
			'golongan_kode' => 'Kode Golongan',
			'golongan_nama' => 'Golongan',
			'kelompok_id' => 'ID Kelompok',
			'kelompok_kode' => 'Kode Kelompok',
			'kelompok_nama' => 'Kelompok',
			'subkelompok_id' => 'ID Subkelompok',
			'subkelompok_kode' => 'Kode Subkelompok',
			'subkelompok_nama' => 'Sub Kelompok',
                        'subsubkelompok_id' => 'ID Subsubkelompok',
			'subsubkelompok_kode' => 'Kode Subsubkelompok',
			'subsubkelompok_nama' => 'Sub Sub Kelompok',
			'bidang_id' => 'ID Bidang',
			'bidang_kode' => 'Kode Bidang',
			'bidang_nama' => 'Bidang',
			'barang_id' => 'Barang',
			'barang_type' => 'Barang Type',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Nama Barang',
			'barang_namalainnya' => 'Barang Namalainnya',
			'barang_merk' => 'Barang Merk',
			'barang_noseri' => 'Barang Noseri',
			'barang_ukuran' => 'Barang Ukuran',
			'barang_bahan' => 'Barang Bahan',
			'barang_thnbeli' => 'Barang Thnbeli',
			'barang_warna' => 'Barang Warna',
			'barang_statusregister' => 'Barang Statusregister',
			'barang_ekonomis_thn' => 'Barang Ekonomis Thn',
			'barang_satuan' => 'Barang Satuan',
			'barang_jmldlmkemasan' => 'Barang Jmldlmkemasan',
			'barang_image' => 'Barang Image',
			'barang_aktif' => 'Barang Aktif',
			'umurekonomis'=> 'Umur Ekonomis',
			'invgedung_namabrg'=> 'Inv. Gedung',
			'invjalan_namabrg'=> 'Inv. Jalan',
			'invperalatan_namabrg'=> 'Inv. Peralatan',
			'invtanah_namabrg'=> 'Inv. Tanah',
			'invasetlain_namabrg'=> 'Inv. Aset Lain',
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

		$criteria->compare('golongan_id',$this->golongan_id);
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('golongan_id',$this->golongan_id);
		$criteria->compare('LOWER(golongan_kode)',strtolower($this->golongan_kode),true);
		$criteria->compare('LOWER(golongan_nama)',strtolower($this->golongan_nama),true);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(kelompok_kode)',strtolower($this->kelompok_kode),true);
		$criteria->compare('LOWER(kelompok_nama)',strtolower($this->kelompok_nama),true);
		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		$criteria->compare('bidang_id',$this->bidang_id);
		$criteria->compare('LOWER(bidang_kode)',strtolower($this->bidang_kode),true);
		$criteria->compare('LOWER(bidang_nama)',strtolower($this->bidang_nama),true);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('LOWER(barang_image)',strtolower($this->barang_image),true);
		$criteria->compare('barang_aktif',$this->barang_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
}