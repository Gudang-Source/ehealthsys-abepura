<?php

/**
 * This is the model class for table "ubahdokter_r".
 *
 * The followings are the available columns in table 'ubahdokter_r':
 * @property integer $ubahdokter_id
 * @property integer $dokterlama_id
 * @property integer $dokterbaru_id
 * @property string $tglubahdokter
 * @property string $alasanperubahandokter
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pendaftaran_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $dokterlama
 * @property PegawaiM $dokterbaru
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 * @property PendaftaranT $pendaftaran
 */
class UbahdokterR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UbahdokterR the static model class
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
		return 'ubahdokter_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dokterlama_id, dokterbaru_id, tglubahdokter, alasanperubahandokter, create_time, create_loginpemakai_id, create_ruangan, pendaftaran_id', 'required'),
			array('dokterlama_id, dokterbaru_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('alasanperubahandokter', 'length', 'max'=>200),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ubahdokter_id, dokterlama_id, dokterbaru_id, tglubahdokter, alasanperubahandokter, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pendaftaran_id', 'safe', 'on'=>'search'),
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
			'dokterlama' => array(self::BELONGS_TO, 'PegawaiM', 'dokterlama_id'),
			'dokterbaru' => array(self::BELONGS_TO, 'PegawaiM', 'dokterbaru_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ubahdokter_id' => 'Ubah Dokter',
			'dokterlama_id' => 'Dokter Lama',
			'dokterbaru_id' => 'Dokter Baru',
			'tglubahdokter' => 'Tgl. Ubah Dokter',
			'alasanperubahandokter' => 'Alasan Perubahan',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
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

		if(!empty($this->ubahdokter_id)){
			$criteria->addCondition('ubahdokter_id = '.$this->ubahdokter_id);
		}
		if(!empty($this->dokterlama_id)){
			$criteria->addCondition('dokterlama_id = '.$this->dokterlama_id);
		}
		if(!empty($this->dokterbaru_id)){
			$criteria->addCondition('dokterbaru_id = '.$this->dokterbaru_id);
		}
		$criteria->compare('LOWER(tglubahdokter)',strtolower($this->tglubahdokter),true);
		$criteria->compare('LOWER(alasanperubahandokter)',strtolower($this->alasanperubahandokter),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}

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