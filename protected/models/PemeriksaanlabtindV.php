<?php

/**
 * This is the model class for table "pemeriksaanlabtind_v".
 *
 * The followings are the available columns in table 'pemeriksaanlabtind_v':
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $daftartindakan_namalainnya
 * @property string $daftartindakan_katakunci
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property integer $tariftindakan_id
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $kelaspelayanan_namalainnya
 * @property integer $daftartindakan_id
 * @property integer $pemeriksaanlab_id
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_kode
 * @property integer $jenispemeriksaanlab_urutan
 * @property string $jenispemeriksaanlab_nama
 * @property string $pemeriksaanlab_kode
 * @property integer $pemeriksaanlab_urutan
 * @property string $pemeriksaanlab_nama
 */
class PemeriksaanlabtindV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabtindV the static model class
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
		return 'pemeriksaanlabtind_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kategoritindakan_id, kelompoktindakan_id, perdatarif_id, jenistarif_id, tariftindakan_id, komponentarif_id, persendiskon_tind, persencyto_tind, jeniskelas_id, kelaspelayanan_id, daftartindakan_id, pemeriksaanlab_id, jenispemeriksaanlab_id, jenispemeriksaanlab_urutan, pemeriksaanlab_urutan', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan, hargadiskon_tind', 'numerical'),
			array('kategoritindakan_nama, daftartindakan_katakunci, ditetapkanoleh, tempatditetapkan, jenispemeriksaanlab_nama', 'length', 'max'=>30),
			array('kelompoktindakan_nama, kelaspelayanan_nama, kelaspelayanan_namalainnya', 'length', 'max'=>50),
			array('daftartindakan_kode, noperda', 'length', 'max'=>20),
			array('daftartindakan_nama, daftartindakan_namalainnya, perdanama_sk', 'length', 'max'=>200),
			array('jenistarif_nama, komponentarif_nama, jeniskelas_nama', 'length', 'max'=>25),
			array('jenispemeriksaanlab_kode, pemeriksaanlab_kode', 'length', 'max'=>10),
			array('pemeriksaanlab_nama', 'length', 'max'=>500),
			array('tglperda, perdatentang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kategoritindakan_id, kategoritindakan_nama, kelompoktindakan_id, kelompoktindakan_nama, daftartindakan_kode, daftartindakan_nama, daftartindakan_namalainnya, daftartindakan_katakunci, perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, jenistarif_id, jenistarif_nama, tariftindakan_id, komponentarif_id, komponentarif_nama, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind, jeniskelas_id, jeniskelas_nama, kelaspelayanan_id, kelaspelayanan_nama, kelaspelayanan_namalainnya, daftartindakan_id, pemeriksaanlab_id, jenispemeriksaanlab_id, jenispemeriksaanlab_kode, jenispemeriksaanlab_urutan, jenispemeriksaanlab_nama, pemeriksaanlab_kode, pemeriksaanlab_urutan, pemeriksaanlab_nama', 'safe', 'on'=>'search'),
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
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Nama Kategori Tindakan',
			'kelompoktindakan_id' => 'Kelompok Tindakan',
			'kelompoktindakan_nama' => 'Nama Kelompok Tindakan',
			'daftartindakan_kode' => 'Kode Daftar Tindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'daftartindakan_namalainnya' => 'Daftartindakan Namalainnya',
			'daftartindakan_katakunci' => 'Daftartindakan Katakunci',
			'perdatarif_id' => 'Perda Tarif',
			'perdanama_sk' => 'Perdanama Sk',
			'noperda' => 'No. Perda',
			'tglperda' => 'Tanggal Perda',
			'perdatentang' => 'Perda Tentang',
			'ditetapkanoleh' => 'Ditetapkan Oleh',
			'tempatditetapkan' => 'Tempat Ditetapkan',
			'jenistarif_id' => 'Jenis Tarif',
			'jenistarif_nama' => 'Jenis Tarif Nama',
			'tariftindakan_id' => 'Tarif Tindakan',
			'komponentarif_id' => 'Komponen Tarif',
			'komponentarif_nama' => 'Komponen Tarif ',
			'harga_tariftindakan' => 'Harga Tariftindakan',
			'persendiskon_tind' => 'Persendiskon Tind',
			'hargadiskon_tind' => 'Hargadiskon Tind',
			'persencyto_tind' => 'Persencyto Tind',
			'jeniskelas_id' => 'Jeniskelas',
			'jeniskelas_nama' => 'Jeniskelas Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kelaspelayanan_namalainnya' => 'Kelaspelayanan Namalainnya',
			'daftartindakan_id' => 'Daftartindakan',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_kode' => 'Jenispemeriksaanlab Kode',
			'jenispemeriksaanlab_urutan' => 'Jenispemeriksaanlab Urutan',
			'jenispemeriksaanlab_nama' => 'Jenis Pemeriksaan Lab ',
			'pemeriksaanlab_kode' => 'Pemeriksaanlab Kode',
			'pemeriksaanlab_urutan' => 'Pemeriksaanlab Urutan',
			'pemeriksaanlab_nama' => 'Nama Pemeriksaan Lab',
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

		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPeriksaLabIsNull()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addCondition('pemeriksaanlab_id IS NULL');
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPeriksaLabIsNotNull()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addCondition('pemeriksaanlab_id IS NOT NULL');
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('tariftindakan_id',$this->tariftindakan_id);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(kelaspelayanan_namalainnya)',strtolower($this->kelaspelayanan_namalainnya),true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(jenispemeriksaanlab_kode)',strtolower($this->jenispemeriksaanlab_kode),true);
		$criteria->compare('jenispemeriksaanlab_urutan',$this->jenispemeriksaanlab_urutan);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
                $criteria->order = 'pemeriksaanlab_nama ';
               
                 $criteria->group ='pemeriksaanlab_nama,daftartindakan_nama,kategoritindakan_nama,kelompoktindakan_nama,jenispemeriksaanlab_nama'; 
                $criteria->select=$criteria->group;
//               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>