<?php

/**
 * This is the model class for table "instalasi_m".
 *
 * The followings are the available columns in table 'instalasi_m':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $instalasi_namalainnya
 * @property string $instalasi_singkatan
 * @property string $instalasi_lokasi
 * @property boolean $instalasi_aktif
 *
 * The followings are the available model relations:
 * @property RuanganM[] $ruanganMs
 */
class InstalasiM extends CActiveRecord
{
                public $instalasi_nonaktif;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasiM the static model class
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
		return 'instalasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_nama, instalasi_singkatan', 'required'),
			array('instalasi_nama, instalasi_namalainnya, instalasi_lokasi,instalasirujukaninternal,', 'length', 'max'=>50),
			array('instalasi_singkatan', 'length', 'max'=>2),
			array('instalasi_aktif, revenuecenter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, instalasi_namalainnya,instalasirujukaninternal,riwayatruangan_id,instalasi_adakamar,instalasi_image,instalasi_singkatan, instalasi_lokasi, instalasi_aktif', 'safe', 'on'=>'search'),
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
			'ruanganMs' => array(self::HAS_MANY, 'RuanganM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Nama Instalasi',
			'instalasi_namalainnya' => 'Nama Lainnya',
			'instalasi_singkatan' => 'Singkatan',
			'instalasi_lokasi' => 'Lokasi Instalasi',
			'instalasi_aktif' => 'Aktif',
                        'instalasirujukaninternal'=>'Rujukan Internal',
                        'revenuecenter' => 'Pusat Pendapatan',
                        'riwayatruangan_id'=>'Riwayat Ruangan ID',
                        'instalasi_adakamar'=>'Ada Kamar ?',
                        'instalasi_image'=>'Photo',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(instalasi_namalainnya)',strtolower($this->instalasi_namalainnya),true);
		$criteria->compare('LOWER(instalasi_singkatan)',strtolower($this->instalasi_singkatan),true);
		$criteria->compare('LOWER(instalasi_lokasi)',strtolower($this->instalasi_lokasi),true);
		$criteria->compare('instalasi_aktif',isset($this->instalasi_aktif)?$this->instalasi_aktif:true);
                $criteria->compare('instalasirujukaninternal',$this->instalasirujukaninternal);
                $criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
                $criteria->compare('instalasi_adakamar',$this->instalasi_adakamar);
//                $criteria->addCondition('instalasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(instalasi_namalainnya)',strtolower($this->instalasi_namalainnya),true);
		$criteria->compare('LOWER(instalasi_singkatan)',strtolower($this->instalasi_singkatan),true);
		$criteria->compare('LOWER(instalasi_lokasi)',strtolower($this->instalasi_lokasi),true);
                $criteria->compare('instalasirujukaninternal',$this->instalasirujukaninternal);
                $criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
                $criteria->compare('instalasi_adakamar',$this->instalasi_adakamar);
//		$criteria->compare('instalasi_aktif',$this->instalasi_aktif);
                $criteria->limit=-1;
                $criteria->order='instalasi_nama';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
        public function beforeSave() {
            $this->instalasi_nama = ucwords(strtolower($this->instalasi_nama));
            $this->instalasi_namalainnya = strtoupper($this->instalasi_namalainnya);
            $this->instalasi_singkatan = strtoupper($this->instalasi_singkatan);
            return parent::beforeSave();
        }
}