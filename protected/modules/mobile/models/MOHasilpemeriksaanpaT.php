<?php

/**
 * This is the model class for table "hasilpemeriksaanpa_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanpa_t':
 * @property integer $hasilpemeriksaanpa_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pemeriksaanlab_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property string $nosediaanpa
 * @property string $tglperiksapa
 * @property string $makroskopis
 * @property string $mikroskopis
 * @property string $kesimpulanpa
 * @property string $saranpa
 * @property string $catatanpa
 * @property boolean $printhasilpa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PemeriksaanlabM $pemeriksaanlab
 * @property PendaftaranT $pendaftaran
 * @property TindakanpelayananT $tindakanpelayanan
 */
class MOHasilpemeriksaanpaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOHasilpemeriksaanpaT the static model class
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
		return 'hasilpemeriksaanpa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pemeriksaanlab_id, pasienmasukpenunjang_id, pasien_id, nosediaanpa, tglperiksapa, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pemeriksaanlab_id, pasienmasukpenunjang_id, tindakanpelayanan_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('nosediaanpa', 'length', 'max'=>50),
			array('makroskopis, mikroskopis, kesimpulanpa, saranpa, catatanpa, printhasilpa, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanpa_id, pendaftaran_id, pasienadmisi_id, pemeriksaanlab_id, pasienmasukpenunjang_id, tindakanpelayanan_id, pasien_id, nosediaanpa, tglperiksapa, makroskopis, mikroskopis, kesimpulanpa, saranpa, catatanpa, printhasilpa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'hasilpemeriksaanpa_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanpa_id' => 'Hasilpemeriksaanpa',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'nosediaanpa' => 'Nosediaanpa',
			'tglperiksapa' => 'Tglperiksapa',
			'makroskopis' => 'Makroskopis',
			'mikroskopis' => 'Mikroskopis',
			'kesimpulanpa' => 'Kesimpulanpa',
			'saranpa' => 'Saranpa',
			'catatanpa' => 'Catatanpa',
			'printhasilpa' => 'Printhasilpa',
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

		if(!empty($this->hasilpemeriksaanpa_id)){
			$criteria->addCondition('hasilpemeriksaanpa_id = '.$this->hasilpemeriksaanpa_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(nosediaanpa)',strtolower($this->nosediaanpa),true);
		$criteria->compare('LOWER(tglperiksapa)',strtolower($this->tglperiksapa),true);
		$criteria->compare('LOWER(makroskopis)',strtolower($this->makroskopis),true);
		$criteria->compare('LOWER(mikroskopis)',strtolower($this->mikroskopis),true);
		$criteria->compare('LOWER(kesimpulanpa)',strtolower($this->kesimpulanpa),true);
		$criteria->compare('LOWER(saranpa)',strtolower($this->saranpa),true);
		$criteria->compare('LOWER(catatanpa)',strtolower($this->catatanpa),true);
		$criteria->compare('printhasilpa',$this->printhasilpa);
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