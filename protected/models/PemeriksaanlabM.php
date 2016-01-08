<?php

/**
 * This is the model class for table "pemeriksaanlab_m".
 *
 * The followings are the available columns in table 'pemeriksaanlab_m':
 * @property integer $pemeriksaanlab_id
 * @property integer $daftartindakan_id
 * @property integer $jenispemeriksaanlab_id
 * @property string $pemeriksaanlab_kode
 * @property integer $pemeriksaanlab_urutan
 * @property string $pemeriksaanlab_nama
 * @property string $pemeriksaanlab_namalainnya
 * @property boolean $pemeriksaanlab_aktif
 */
class PemeriksaanlabM extends CActiveRecord
{
        public $daftartindakan_nama;
        public $jenispemeriksaanlab_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabM the static model class
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
		return 'pemeriksaanlab_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, jenispemeriksaanlab_id, pemeriksaanlab_kode, pemeriksaanlab_nama', 'required'),
			array('daftartindakan_id, jenispemeriksaanlab_id, pemeriksaanlab_urutan', 'numerical', 'integerOnly'=>true),
			array('pemeriksaanlab_kode', 'length', 'max'=>10),
			array('pemeriksaanlab_nama, pemeriksaanlab_namalainnya', 'length', 'max'=>40),
			array('pemeriksaanlab_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanlab_id, daftartindakan_id, jenispemeriksaanlab_id, jenispemeriksaanlab_nama , pemeriksaanlab_kode, pemeriksaanlab_urutan, pemeriksaanlab_nama, pemeriksaanlab_namalainnya, pemeriksaanlab_aktif', 'safe', 'on'=>'search'),
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
                //                    'daftarTindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                //                    'jenispemeriksaanlab'=>array(self::BELONGS_TO,'JenisPemeriksaanlabM','jenispemeriksaanlab_id'),
                'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                'jenispemeriksaan'=>array(self::BELONGS_TO,'JenispemeriksaanlabM','jenispemeriksaanlab_id'),
                'nilairujukan'=>array(self::MANY_MANY,  'NilairujukanM', 'pemeriksaanlabdet_m(nilairujukan_id, pemeriksaanlab_id)'),
                'detailperiksa'=>array(self::HAS_MANY, 'PemeriksaanlabdetM', 'pemeriksaanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanlab_id' => 'ID',
			'daftartindakan_id' => 'Tindakan',
			'jenispemeriksaanlab_id' => 'Jenis Pemeriksaan Lab',
			'pemeriksaanlab_kode' => 'Kode',
			'pemeriksaanlab_urutan' => 'Urutan',
			'pemeriksaanlab_nama' => 'Nama Pemeriksaan',
			'pemeriksaanlab_namalainnya' => 'Nama Lainnya',
			'pemeriksaanlab_aktif' => 'Aktif',
                    
                                                'daftartindakan_nama'=>'Daftar tindakan',
                                                'jenispemeriksaanlab_nama'=>'Jenis Pemeriksaan Lab',

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

                $criteria->with = array('jenispemeriksaan','daftartindakan');
                $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
                $criteria->compare('LOWER(jenispemeriksaan.jenispemeriksaanlab_nama)',strtolower($this->jenispemeriksaanlab_nama),true);
                $criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
                $criteria->compare('daftartindakan.daftartindakan_id',$this->daftartindakan_id);
                $criteria->compare('jenispemeriksaan.jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
                $criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
                $criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
                $criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
                $criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);
                $criteria->compare('pemeriksaanlab_aktif',isset($this->pemeriksaanlab_aktif)?$this->pemeriksaanlab_aktif:true);
                $criteria->addCondition('pemeriksaanlab_aktif is true');
				$criteria->order = 'pemeriksaanlab_id';
				
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('LOWER(pemeriksaanlab_kode)',strtolower($this->pemeriksaanlab_kode),true);
		$criteria->compare('pemeriksaanlab_urutan',$this->pemeriksaanlab_urutan);
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('LOWER(pemeriksaanlab_namalainnya)',strtolower($this->pemeriksaanlab_namalainnya),true);
		//$criteria->compare('pemeriksaanlab_aktif',$this->pemeriksaanlab_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getDaftarTindakanItems()
        {
            return DaftartindakanM::model()->findAll('daftartindakan_aktif=TRUE ORDER BY daftartindakan_nama');
        }
        
        public function getJenispemeriksaanLABItems()
        {
            return JenispemeriksaanlabM::model()->findAll('jenispemeriksaanlab_aktif=TRUE ORDER BY jenispemeriksaanlab_nama');
        }
        public function getJenisPemeriksaanItems()
        {
            return JenispemeriksaanlabM::model()->findAll('jenispemeriksaanlab_aktif=TRUE ORDER BY jenispemeriksaanlab_nama');
        }
        public function getTindakanItems()
        {
            return DaftartindakanM::model()->findAll('daftartindakan_aktif=TRUE ORDER BY daftartindakan_nama');
        }

}