<?php

/**
 * This is the model class for table "barang_m".
 *
 * The followings are the available columns in table 'barang_m':
 * @property integer $barang_id
 * @property integer $bidang_id
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
 * @property double $barang_harganetto
 * @property boolean $barang_aktif
 * @property double $barang_persendiskon
 * @property double $barang_ppn
 * @property double $barang_hpp
 * @property double $barang_hargajual
 *
 * The followings are the available model relations:
 * @property TerimapersdetailT[] $terimapersdetailTs
 * @property PesanbarangdetailT[] $pesanbarangdetailTs
 * @property MutasibrgdetailT[] $mutasibrgdetailTs
 * @property InvtanahT[] $invtanahTs
 * @property InvperalatanT[] $invperalatanTs
 * @property InvjalanT[] $invjalanTs
 * @property InvgedungT[] $invgedungTs
 * @property InventarisasiruanganT[] $inventarisasiruanganTs
 * @property InvasetlainT[] $invasetlainTs
 * @property BidangM $bidang
 * @property BatalmutasibrgT[] $batalmutasibrgTs
 * @property PemakaianbrgdetailT[] $pemakaianbrgdetailTs
 * @property BelibrgdetailT[] $belibrgdetailTs
 */
class BarangM extends CActiveRecord
{
	public $barang;
        public $golongan_id;
	public $golongan_nama;
	public $kelompok_nama;
	public $subkelompok_nama;
        public $subsubkelompok_nama;
	public $bidang_nama;                
        public $kelompok_id;
        public $bidang_id;
        public $subkelompok_id;
        public $nomorregister;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BarangM the static model class
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
		return 'barang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_type, barang_kode, barang_nama, barang_harganetto', 'required'),                       
                       // array('golongan_id, bidang_id, kelompok_id, subkelompok_id, subsubkelompok_id', 'required', 'on'=>'cekTipeBarang'),
			array('barang_ekonomis_thn, barang_jmldlmkemasan', 'numerical', 'integerOnly'=>true),
			array('barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual', 'numerical'),
			array('barang_type, barang_kode, barang_merk, barang_warna, barang_satuan', 'length', 'max'=>50),
			array('barang_nama, barang_namalainnya', 'length', 'max'=>100),
			array('barang_noseri, barang_ukuran, barang_bahan', 'length', 'max'=>20),
			array('barang_thnbeli', 'length', 'max'=>5),
			array('barang_image', 'length', 'max'=>200),
			array('nomorregister, barang_statusregister, barang_aktif, subsubkelompok_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subsubkelompok_id, nomorregister, subsubkelompok_nama, subkelompok_id, kelompok_id, bidang_id, golongan_id, barang_id, barang_type, barang_kode, barang_nama, barang_namalainnya, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_image, barang_harganetto, barang_aktif, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual', 'safe', 'on'=>'search'),
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
			'terimapersdetailTs' => array(self::HAS_MANY, 'TerimapersdetailT', 'barang_id'),
			'pesanbarangdetailTs' => array(self::HAS_MANY, 'PesanbarangdetailT', 'barang_id'),
			'mutasibrgdetailTs' => array(self::HAS_MANY, 'MutasibrgdetailT', 'barang_id'),
			'invtanahTs' => array(self::HAS_MANY, 'InvtanahT', 'barang_id'),
			'invperalatanTs' => array(self::HAS_MANY, 'InvperalatanT', 'barang_id'),
			'invjalanTs' => array(self::HAS_MANY, 'InvjalanT', 'barang_id'),
			'invgedungTs' => array(self::HAS_MANY, 'InvgedungT', 'barang_id'),
			'inventarisasiruanganTs' => array(self::HAS_MANY, 'InventarisasiruanganT', 'barang_id'),
			'invasetlainTs' => array(self::HAS_MANY, 'InvasetlainT', 'barang_id'),
			'subsubkelompok' => array(self::BELONGS_TO, 'SubsubkelompokM', 'subsubkelompok_id'),
			'batalmutasibrgTs' => array(self::HAS_MANY, 'BatalmutasibrgT', 'barang_id'),
			'pemakaianbrgdetailTs' => array(self::HAS_MANY, 'PemakaianbrgdetailT', 'barang_id'),
			'belibrgdetailTs' => array(self::HAS_MANY, 'BelibrgdetailT', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'barang_id' => 'Barang',                    
			'bidang_id' => 'Bidang',
			'barang_type' => 'Tipe Barang',
			'barang_kode' => 'Kode Barang',
			'barang_nama' => 'Nama Barang',
			'barang_namalainnya' => 'Nama Lain',
			'barang_merk' => 'Merk',
			'barang_noseri' => 'No. Seri',
			'barang_ukuran' => 'Ukuran',
			'barang_bahan' => 'Bahan Barang',
			'barang_thnbeli' => 'Tahun Beli',
			'barang_warna' => 'Warna',
			'barang_statusregister' => 'Status Register',
			'barang_ekonomis_thn' => 'Tahun Ekonomis',
			'barang_satuan' => 'Satuan Barang',
			'barang_jmldlmkemasan' => 'Jumlah Kemasan',
			'barang_image' => 'Gambar Barang',
			'barang_harganetto' => 'Harga Netto',
			'barang_aktif' => 'Aktif',
			'barang_persendiskon' => 'Diskon (%)',
			'barang_ppn' => 'PPN',
			'barang_hpp' => 'HPP',
			'barang_hargajual' => 'Harga Jual',
                        'golongan_id' => 'Golongan',
                        'kelompok_id' => 'Kelompok',
                        'subkelompok_id' => 'Sub Kelompok',    
                        'subsubkelompok_id' => 'Sub Sub Kelompok',
                        'subsubkelompok_nama' => 'Sub Sub Kelompok',
                        'nomorregister' => 'Nomor Register',
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

		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('subsubkelompok_id',$this->subsubkelompok_id);
		$criteria->compare('barang_type',$this->barang_type,true);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_namalainnya',$this->barang_namalainnya,true);
		$criteria->compare('barang_merk',$this->barang_merk,true);
		$criteria->compare('barang_noseri',$this->barang_noseri,true);
		$criteria->compare('barang_ukuran',$this->barang_ukuran,true);
		$criteria->compare('barang_bahan',$this->barang_bahan,true);
		$criteria->compare('barang_thnbeli',$this->barang_thnbeli,true);
		$criteria->compare('barang_warna',$this->barang_warna,true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		$criteria->compare('barang_ekonomis_thn',$this->barang_ekonomis_thn);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('barang_jmldlmkemasan',$this->barang_jmldlmkemasan);
		$criteria->compare('barang_image',$this->barang_image,true);
		$criteria->compare('barang_harganetto',$this->barang_harganetto);		
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
                $criteria->compare('subsubkelompok_nama',$this->subsubkelompok_nama);
                $criteria->compare('barang_aktif',isset($this->barang_aktif)?$this->barang_aktif:true);                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getBidangItems()
	{
		return BidangM::model()->findAll('bidang_aktif=true ORDER BY bidang_nama');
	}
	public function getGolonganItems()
	{
		return GolonganM::model()->findAll('golongan_aktif=true ORDER BY golongan_nama');
	}
	public function getKelompokItems()
	{
		return KelompokM::model()->findAll('kelompok_aktif=true ORDER BY kelompok_nama');
	}
	public function getSubKelompokItems()
	{
		return SubkelompokM::model()->findAll('subkelompok_aktif=true ORDER BY subkelompok_nama');
	}
        
        public function getSubSubKelompokItems()
	{
		return SubsubkelompokM::model()->findAll('subsubkelompok_aktif=true ORDER BY subsubkelompok_nama');
	}
        
        public function getSubKelompokId($subsubkelompok_id)
        {
            $subkelompokid = SubsubkelompokM::model()->findAllByAttributes(array('subsubkelompok_id'=> $subsubkelompok_id));
            
            if ($subkelompokid == null):
                $data = '';
            else:
                foreach($subkelompokid as $id):
                    $data = $id->subkelompok_id;
                endforeach;    
            endif;
            
            return $data;
                
        }
        
        public function getKelompokId($subkelompok_id)
        {
            $kelompokid = SubkelompokM::model()->findAllByAttributes(array('subkelompok_id'=> $subkelompok_id));
            
            if ($kelompokid == null):
                $data = '';
            else:
                foreach($kelompokid as $id):
                    $data = $id->kelompok_id;
                endforeach;    
            endif;
            
            return $data;
        }
        
        public function getBidangId($kelompok_id)
        {
            $bidangid = KelompokM::model()->findAllByAttributes(array('kelompok_id'=> $kelompok_id));
            
            if ($bidangid == null):
                $data = '';
            else:
                foreach($bidangid as $id):
                    $data = $id->bidang_id;
                endforeach;    
            endif;
            
            return $data;
        }
        
        public function getGolonganId($bidang_id)
        {
            $golonganid = BidangM::model()->findAllByAttributes(array('bidang_id'=> $bidang_id));
            
             if ($golonganid == null):
                $data = '';
            else:
                foreach($golonganid as $id):
                    $data = $id->golongan_id;
                endforeach;    
            endif;
            
            return $data;
        }
        
        public function getNomorReg($subsubkelompok_id)
        {
            $subsubkelid = SubsubkelompokM::model()->findAllByAttributes(array('subsubkelompok_id'=> $subsubkelompok_id));
            
             if ($subsubkelid == null):
                $data = '';
            else:
                foreach($subsubkelid as $id):
                    $data = $id->subsubkelompok_kode;
                endforeach;    
            endif;
            
            return $data;
        }
       // public function beforeValidate()
       // {
         //   if ($this->barang_type != 'Habis Pakai'):
              //   $this->setScenario('cekTipeBarang');
          //  endif;
            
          //  return parent::beforeValidate();
       // }
        
         
}