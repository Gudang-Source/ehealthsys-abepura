<?php

/**
 * This is the model class for table "ruanganrehabmedis_v".
 *
 * The followings are the available columns in table 'ruanganrehabmedis_v':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_singkatan
 * @property boolean $ruangan_aktif
 * @property integer $riwayatruangan_id
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_fasilitas
 * @property string $ruangan_lokasi
 * @property string $ruangan_image
 * @property string $map_warna
 * @property string $map_kode_warna
 */
class RuanganrehabmedisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganrehabmedisV the static model class
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
		return 'ruanganrehabmedis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, instalasi_id, riwayatruangan_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi, map_warna', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image, map_kode_warna', 'length', 'max'=>100),
			array('ruangan_aktif, ruangan_fasilitas', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, ruangan_nama, ruangan_namalainnya, ruangan_singkatan, ruangan_aktif, riwayatruangan_id, ruangan_jenispelayanan, ruangan_fasilitas, ruangan_lokasi, ruangan_image, map_warna, map_kode_warna', 'safe', 'on'=>'search'),
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
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_namalainnya' => 'Ruangan Namalainnya',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'ruangan_aktif' => 'Ruangan Aktif',
			'riwayatruangan_id' => 'Riwayatruangan',
			'ruangan_jenispelayanan' => 'Ruangan Jenispelayanan',
			'ruangan_fasilitas' => 'Ruangan Fasilitas',
			'ruangan_lokasi' => 'Ruangan Lokasi',
			'ruangan_image' => 'Ruangan Image',
			'map_warna' => 'Map Warna',
			'map_kode_warna' => 'Map Kode Warna',
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

		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('LOWER(map_warna)',strtolower($this->map_warna),true);
		$criteria->compare('LOWER(map_kode_warna)',strtolower($this->map_kode_warna),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('LOWER(map_warna)',strtolower($this->map_warna),true);
		$criteria->compare('LOWER(map_kode_warna)',strtolower($this->map_kode_warna),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}