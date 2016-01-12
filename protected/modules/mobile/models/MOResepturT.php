<?php

/**
 * This is the model class for table "reseptur_t".
 *
 * The followings are the available columns in table 'reseptur_t':
 * @property integer $reseptur_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property integer $penjualanresep_id
 * @property string $tglreseptur
 * @property string $noresep
 * @property integer $ruanganreseptur_id
 * @property string $fileresep
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $unitdosis_id
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property PenjualanresepT $penjualanresep
 * @property RuanganM $ruangan
 * @property RuanganM $ruanganreseptur
 * @property PenjualanresepT[] $penjualanresepTs
 * @property ResepturdetailT[] $resepturdetailTs
 */
class MOResepturT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOResepturT the static model class
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
		return 'reseptur_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, pegawai_id, pendaftaran_id, tglreseptur, noresep, ruanganreseptur_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienadmisi_id, ruangan_id, pasien_id, pegawai_id, pendaftaran_id, penjualanresep_id, ruanganreseptur_id, unitdosis_id', 'numerical', 'integerOnly'=>true),
			array('noresep', 'length', 'max'=>50),
			array('fileresep', 'length', 'max'=>200),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reseptur_id, pasienadmisi_id, ruangan_id, pasien_id, pegawai_id, pendaftaran_id, penjualanresep_id, tglreseptur, noresep, ruanganreseptur_id, fileresep, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, unitdosis_id', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'penjualanresep' => array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'ruanganreseptur' => array(self::BELONGS_TO, 'RuanganM', 'ruanganreseptur_id'),
			'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'reseptur_id'),
			'resepturdetailTs' => array(self::HAS_MANY, 'ResepturdetailT', 'reseptur_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reseptur_id' => 'Reseptur',
			'pasienadmisi_id' => 'Pasienadmisi',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'penjualanresep_id' => 'Penjualanresep',
			'tglreseptur' => 'Tglreseptur',
			'noresep' => 'Noresep',
			'ruanganreseptur_id' => 'Ruanganreseptur',
			'fileresep' => 'Fileresep',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'unitdosis_id' => 'Unitdosis',
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

		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruanganreseptur_id',$this->ruanganreseptur_id);
		$criteria->compare('LOWER(fileresep)',strtolower($this->fileresep),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('unitdosis_id',$this->unitdosis_id);

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