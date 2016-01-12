<?php

/**
 * This is the model class for table "pasienpulang_t".
 *
 * The followings are the available columns in table 'pasienpulang_t':
 * @property integer $pasienpulang_id
 * @property integer $pasien_id
 * @property integer $pasienbatalpulang_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $carakeluar_id
 * @property integer $kondisikeluar_id
 * @property string $tglpasienpulang
 * @property string $ruanganakhir_id
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property string $satuanlamarawat
 * @property boolean $ismeninggal
 * @property string $keterangankeluar
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienbatalpulangT $pasienbatalpulang
 * @property CarakeluarM $carakeluar
 * @property KondisikeluarM $kondisikeluar
 */
class MOPasienpulangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPasienpulangT the static model class
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
		return 'pasienpulang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, carakeluar_id, kondisikeluar_id, tglpasienpulang, ruanganakhir_id, satuanlamarawat, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pasienbatalpulang_id, pendaftaran_id, pasienadmisi_id, carakeluar_id, kondisikeluar_id, lamarawat', 'numerical', 'integerOnly'=>true),
			array('penerimapasien', 'length', 'max'=>100),
			array('satuanlamarawat', 'length', 'max'=>50),
			array('ismeninggal, keterangankeluar, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienpulang_id, pasien_id, pasienbatalpulang_id, pendaftaran_id, pasienadmisi_id, carakeluar_id, kondisikeluar_id, tglpasienpulang, ruanganakhir_id, penerimapasien, lamarawat, satuanlamarawat, ismeninggal, keterangankeluar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienbatalpulang' => array(self::BELONGS_TO, 'PasienbatalpulangT', 'pasienbatalpulang_id'),
			'carakeluar' => array(self::BELONGS_TO, 'CarakeluarM', 'carakeluar_id'),
			'kondisikeluar' => array(self::BELONGS_TO, 'KondisikeluarM', 'kondisikeluar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienpulang_id' => 'Pasienpulang',
			'pasien_id' => 'Pasien',
			'pasienbatalpulang_id' => 'Pasienbatalpulang',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'carakeluar_id' => 'Carakeluar',
			'kondisikeluar_id' => 'Kondisikeluar',
			'tglpasienpulang' => 'Tglpasienpulang',
			'ruanganakhir_id' => 'Ruanganakhir',
			'penerimapasien' => 'Penerimapasien',
			'lamarawat' => 'Lamarawat',
			'satuanlamarawat' => 'Satuanlamarawat',
			'ismeninggal' => 'Ismeninggal',
			'keterangankeluar' => 'Keterangankeluar',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienbatalpulang_id',$this->pasienbatalpulang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('kondisikeluar_id',$this->kondisikeluar_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
		$criteria->compare('ismeninggal',$this->ismeninggal);
		$criteria->compare('LOWER(keterangankeluar)',strtolower($this->keterangankeluar),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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