<?php

/**
 * This is the model class for table "ruangan_m".
 *
 * The followings are the available columns in table 'ruangan_m':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 * @property string $ruangan_singkatan
 * @property integer $riwayatruangan_id
 * @property string $ruangan_fasilitas
 * @property string $ruangan_image
 */
class RuanganM extends CActiveRecord
{
        public $instalasi_nama;
        public $tgl_awal, $tgl_akhir,$bulan,$propinsi_id,$kabupaten_id,$pekerjaan_id,$carabayar_id,$penjamin_id,$pendidikan_id,$suku_id,$statuspasien,$ruangan;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganM the static model class
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
		return 'ruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_nama', 'required'),
			array('instalasi_id, riwayatruangan_id, modul_id', 'numerical', 'integerOnly'=>true),
			array('ruangan_nama, ruangan_namalainnya, ruangan_jenispelayanan, ruangan_lokasi', 'length', 'max'=>50),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('ruangan_image', 'length', 'max'=>100),
			array('ruangan_aktif, ruangan_fasilitas, modul_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruangan_id, instalasi_id, data , tick , jumlah, ruangan_nama, ruangan_namalainnya, bulan, tgl_awal, tgl_akhir,ruangan_jenispelayanan, ruangan_lokasi, ruangan_aktif, ruangan_singkatan, riwayatruangan_id, ruangan_fasilitas, ruangan_image', 'safe', 'on'=>'search'),
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
                    'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangan_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'ruangan_nama' => 'Ruangan ',
			'ruangan_namalainnya' => 'Nama Lainnya',
			'ruangan_jenispelayanan' => 'Jenis Pelayanan',
			'ruangan_lokasi' => 'Lokasi',
			'ruangan_aktif' => 'Aktif',
			'ruangan_singkatan' => 'Singkatan',
			'riwayatruangan_id' => 'Riwayat Ruangan',
			'ruangan_fasilitas' => 'Fasilitas',
			'ruangan_image' => 'Photo Image',
                        'modul_id' => 'Modul',
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
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
                $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_namalainnya)',strtolower($this->ruangan_namalainnya),true);
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
		$criteria->compare('ruangan_aktif',isset($this->ruangan_aktif)?$this->ruangan_aktif:true);
                //$criteria->order = "ruangan_nama ASC";
//                $criteria->addCondition('ruangan_aktif is true');

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
		$criteria->compare('LOWER(ruangan_jenispelayanan)',strtolower($this->ruangan_jenispelayanan),true);
		$criteria->compare('LOWER(ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('ruangan_aktif',$this->ruangan_aktif);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(ruangan_fasilitas)',strtolower($this->ruangan_fasilitas),true);
		$criteria->compare('LOWER(ruangan_image)',strtolower($this->ruangan_image),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            //$this->ruangan_nama = ucwords(strtolower($this->ruangan_nama));
            $this->ruangan_namalainnya = strtoupper($this->ruangan_namalainnya);
            $this->ruangan_singkatan = strtoupper($this->ruangan_singkatan);
            $this->ruangan_lokasi = ucwords(strtolower($this->ruangan_lokasi));
            return parent::beforeSave();
        }
        
        public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama');
            //return InstalasiM::model()->findAll('instalasi_adakamar=TRUE AND instalasi_aktif=TRUE ORDER BY instalasi_nama');
        }
        
        public static function getRuanganByInstalasi($instalasi='')
        {
            if(!empty($instalasi))
                return RuanganM::model()->findAll('instalasi_id = '.$instalasi.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
            else 
                return array();
        }
        
         public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
         public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }
         public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }
         public function getPekerjaanItems()
        {
            return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
        }
        
         public function getPendidikanItems()
        {
            return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
        }
        
         public function getSukuItems()
        {
            return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
        }
        
        public static function items()
        {
            $models = RuanganM::model()->findAll('
                instalasi_id IN (1,2,3,4,5,6,7) AND ruangan_aktif = TRUE ORDER BY ruangan_nama
            ');
            $items = array();
            foreach($models as $model)
            {
                $items[$model->ruangan_id]=$model->ruangan_nama;            
            }
            return $items;
        }   
        
        public function ruanganNamaById($id){
            $cek = $this->findByPk($id);
            
            if (empty($cek)):
                return null;
            else:
                return $cek->ruangan_nama;
            endif;
        }
}