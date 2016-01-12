<?php

/**
 * This is the model class for table "konsulpoli_t".
 *
 * The followings are the available columns in table 'konsulpoli_t':
 * @property integer $konsulpoli_id
 * @property integer $ruangan_id
 * @property integer $daftartindakan_id
 * @property integer $pegawai_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tglkonsulpoli
 * @property string $asalpoliklinikkonsul_id
 * @property string $statusperiksa
 * @property string $catatan_dokter_konsul
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $no_antriankonsul
 *
 * The followings are the available model relations:
 * @property RuanganM $asalpoliklinikkonsul
 * @property DaftartindakanM $daftartindakan
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 * @property TindakanpelayananT $tindakanpelayanan
 * @property TindakanpelayananT[] $tindakanpelayananTs
 */
class MOKonsulpoliT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOKonsulpoliT the static model class
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
		return 'konsulpoli_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pendaftaran_id, pasien_id, tglkonsulpoli, asalpoliklinikkonsul_id, statusperiksa, create_time, create_loginpemakai_id', 'required'),
			array('ruangan_id, daftartindakan_id, pegawai_id, tindakanpelayanan_id, pendaftaran_id, pasienadmisi_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('statusperiksa', 'length', 'max'=>50),
			array('no_antriankonsul', 'length', 'max'=>6),
			array('catatan_dokter_konsul, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('konsulpoli_id, ruangan_id, daftartindakan_id, pegawai_id, tindakanpelayanan_id, pendaftaran_id, pasienadmisi_id, pasien_id, tglkonsulpoli, asalpoliklinikkonsul_id, statusperiksa, catatan_dokter_konsul, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, no_antriankonsul', 'safe', 'on'=>'search'),
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
			'asalpoliklinikkonsul' => array(self::BELONGS_TO, 'RuanganM', 'asalpoliklinikkonsul_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'tindakanpelayanan' => array(self::BELONGS_TO, 'TindakanpelayananT', 'tindakanpelayanan_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'konsulpoli_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konsulpoli_id' => 'Konsulpoli',
			'ruangan_id' => 'Ruangan',
			'daftartindakan_id' => 'Daftartindakan',
			'pegawai_id' => 'Pegawai',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'tglkonsulpoli' => 'Tglkonsulpoli',
			'asalpoliklinikkonsul_id' => 'Asalpoliklinikkonsul',
			'statusperiksa' => 'Statusperiksa',
			'catatan_dokter_konsul' => 'Catatan Dokter Konsul',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_antriankonsul' => 'No. Antriankonsul',
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

		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglkonsulpoli)',strtolower($this->tglkonsulpoli),true);
		$criteria->compare('LOWER(asalpoliklinikkonsul_id)',strtolower($this->asalpoliklinikkonsul_id),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(catatan_dokter_konsul)',strtolower($this->catatan_dokter_konsul),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(no_antriankonsul)',strtolower($this->no_antriankonsul),true);

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