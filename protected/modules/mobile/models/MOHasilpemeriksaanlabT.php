<?php

/**
 * This is the model class for table "hasilpemeriksaanlab_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanlab_t':
 * @property integer $hasilpemeriksaanlab_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $nohasilperiksalab
 * @property string $tglhasilpemeriksaanlab
 * @property string $tglpengambilanhasil
 * @property string $hasil_kelompokumur
 * @property string $hasil_jeniskelamin
 * @property string $statusperiksahasil
 * @property string $catatanlabklinik
 * @property boolean $printhasillab
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $kesimpulan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PendaftaranT $pendaftaran
 * @property DetailhasilpemeriksaanlabT[] $detailhasilpemeriksaanlabTs
 */
class MOHasilpemeriksaanlabT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOHasilpemeriksaanlabT the static model class
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
		return 'hasilpemeriksaanlab_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pasienmasukpenunjang_id, pendaftaran_id, nohasilperiksalab, tglhasilpemeriksaanlab, hasil_kelompokumur, hasil_jeniskelamin, statusperiksahasil, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('nohasilperiksalab', 'length', 'max'=>20),
			array('hasil_kelompokumur, hasil_jeniskelamin, statusperiksahasil', 'length', 'max'=>50),
			array('tglpengambilanhasil, catatanlabklinik, printhasillab, update_time, update_loginpemakai_id, kesimpulan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanlab_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id, nohasilperiksalab, tglhasilpemeriksaanlab, tglpengambilanhasil, hasil_kelompokumur, hasil_jeniskelamin, statusperiksahasil, catatanlabklinik, printhasillab, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kesimpulan', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'detailhasilpemeriksaanlabTs' => array(self::HAS_MANY, 'DetailhasilpemeriksaanlabT', 'hasilpemeriksaanlab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanlab_id' => 'Hasilpemeriksaanlab',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'nohasilperiksalab' => 'Nohasilperiksalab',
			'tglhasilpemeriksaanlab' => 'Tglhasilpemeriksaanlab',
			'tglpengambilanhasil' => 'Tglpengambilanhasil',
			'hasil_kelompokumur' => 'Hasil Kelompokumur',
			'hasil_jeniskelamin' => 'Hasil Jeniskelamin',
			'statusperiksahasil' => 'Statusperiksahasil',
			'catatanlabklinik' => 'Catatanlabklinik',
			'printhasillab' => 'Printhasillab',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'kesimpulan' => 'Kesimpulan',
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

		if(!empty($this->hasilpemeriksaanlab_id)){
			$criteria->addCondition('hasilpemeriksaanlab_id = '.$this->hasilpemeriksaanlab_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(nohasilperiksalab)',strtolower($this->nohasilperiksalab),true);
		$criteria->compare('LOWER(tglhasilpemeriksaanlab)',strtolower($this->tglhasilpemeriksaanlab),true);
		$criteria->compare('LOWER(tglpengambilanhasil)',strtolower($this->tglpengambilanhasil),true);
		$criteria->compare('LOWER(hasil_kelompokumur)',strtolower($this->hasil_kelompokumur),true);
		$criteria->compare('LOWER(hasil_jeniskelamin)',strtolower($this->hasil_jeniskelamin),true);
		$criteria->compare('LOWER(statusperiksahasil)',strtolower($this->statusperiksahasil),true);
		$criteria->compare('LOWER(catatanlabklinik)',strtolower($this->catatanlabklinik),true);
		$criteria->compare('printhasillab',$this->printhasillab);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(kesimpulan)',strtolower($this->kesimpulan),true);

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