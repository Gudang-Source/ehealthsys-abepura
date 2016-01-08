<?php

/**
 * This is the model class for table "hasilpemeriksaanrm_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanrm_t':
 * @property integer $hasilpemeriksaanrm_id
 * @property integer $tindakanrm_id
 * @property integer $ruangan_id
 * @property integer $jenistindakanrm_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $jadwalkunjunganrm_id
 * @property integer $pegawai_id
 * @property string $tglpemeriksaanrm
 * @property string $nohasilrm
 * @property integer $kunjunganke
 * @property string $hasilpemeriksaanrm
 * @property string $keteranganhasilrm
 * @property string $peralatandigunakan
 * @property string $paramedis1_id
 * @property string $paramedis2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class HasilpemeriksaanrmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanrmT the static model class
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
		return 'hasilpemeriksaanrm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tindakanrm_id, ruangan_id, jenistindakanrm_id, pendaftaran_id, pasien_id, pasienmasukpenunjang_id, tglpemeriksaanrm, nohasilrm, kunjunganke, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tindakanrm_id, ruangan_id, jenistindakanrm_id, tindakanpelayanan_id, pendaftaran_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, jadwalkunjunganrm_id, pegawai_id, kunjunganke', 'numerical', 'integerOnly'=>true),
			array('nohasilrm', 'length', 'max'=>20),
			array('hasilpemeriksaanrm, keteranganhasilrm', 'length', 'max'=>500),
			array('peralatandigunakan', 'length', 'max'=>100),
			array('paramedis1_id, paramedis2_id, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanrm_id, tindakanrm_id, ruangan_id, jenistindakanrm_id, tindakanpelayanan_id, pendaftaran_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, jadwalkunjunganrm_id, pegawai_id, tglpemeriksaanrm, nohasilrm, kunjunganke, hasilpemeriksaanrm, keteranganhasilrm, peralatandigunakan, paramedis1_id, paramedis2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'tindakanrm'=>array(self::BELONGS_TO,'TindakanrmM','tindakanrm_id'),
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                    'pasienmasukpenunjang'=>array(self::BELONGS_TO,'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanrm_id' => 'Hasilpemeriksaanrm',
			'tindakanrm_id' => 'Tindakanrm',
			'ruangan_id' => 'Ruangan',
			'jenistindakanrm_id' => 'Jenistindakanrm',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'jadwalkunjunganrm_id' => 'Jadwalkunjunganrm',
			'pegawai_id' => 'Pegawai',
			'tglpemeriksaanrm' => 'Tglpemeriksaanrm',
			'nohasilrm' => 'Nohasilrm',
			'kunjunganke' => 'Kunjunganke',
			'hasilpemeriksaanrm' => 'Hasilpemeriksaanrm',
			'keteranganhasilrm' => 'Keteranganhasilrm',
			'peralatandigunakan' => 'Peralatandigunakan',
			'paramedis1_id' => 'Paramedis1',
			'paramedis2_id' => 'Paramedis2',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('hasilpemeriksaanrm_id',$this->hasilpemeriksaanrm_id);
		$criteria->compare('tindakanrm_id',$this->tindakanrm_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenistindakanrm_id',$this->jenistindakanrm_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('jadwalkunjunganrm_id',$this->jadwalkunjunganrm_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglpemeriksaanrm)',strtolower($this->tglpemeriksaanrm),true);
		$criteria->compare('LOWER(nohasilrm)',strtolower($this->nohasilrm),true);
		$criteria->compare('kunjunganke',$this->kunjunganke);
		$criteria->compare('LOWER(hasilpemeriksaanrm)',strtolower($this->hasilpemeriksaanrm),true);
		$criteria->compare('LOWER(keteranganhasilrm)',strtolower($this->keteranganhasilrm),true);
		$criteria->compare('LOWER(peralatandigunakan)',strtolower($this->peralatandigunakan),true);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('hasilpemeriksaanrm_id',$this->hasilpemeriksaanrm_id);
		$criteria->compare('tindakanrm_id',$this->tindakanrm_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenistindakanrm_id',$this->jenistindakanrm_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('jadwalkunjunganrm_id',$this->jadwalkunjunganrm_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglpemeriksaanrm)',strtolower($this->tglpemeriksaanrm),true);
		$criteria->compare('LOWER(nohasilrm)',strtolower($this->nohasilrm),true);
		$criteria->compare('kunjunganke',$this->kunjunganke);
		$criteria->compare('LOWER(hasilpemeriksaanrm)',strtolower($this->hasilpemeriksaanrm),true);
		$criteria->compare('LOWER(keteranganhasilrm)',strtolower($this->keteranganhasilrm),true);
		$criteria->compare('LOWER(peralatandigunakan)',strtolower($this->peralatandigunakan),true);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}