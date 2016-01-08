<?php

/**
 * This is the model class for table "suratketerangan_r".
 *
 * The followings are the available columns in table 'suratketerangan_r':
 * @property integer $suratketerangan_id
 * @property integer $pendaftaran_id
 * @property integer $jenissurat_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $profilrs_id
 * @property string $tglsurat
 * @property string $judulsurat
 * @property string $nourutsurat
 * @property string $nomorsurat
 * @property string $mengetahui_surat
 * @property integer $jmlprint_surat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class SuratketeranganR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SuratketeranganR the static model class
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
		return 'suratketerangan_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, jenissurat_id, pasien_id, ruangan_id, profilrs_id, tglsurat, judulsurat, nourutsurat, nomorsurat', 'required'),
			array('pendaftaran_id, jenissurat_id, pasien_id, ruangan_id, profilrs_id, jmlprint_surat', 'numerical', 'integerOnly'=>true),
			array('judulsurat', 'length', 'max'=>200),
			array('nomorsurat, mengetahui_surat', 'length', 'max'=>100),
			array('update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('suratketerangan_id, pendaftaran_id, jenissurat_id, pasien_id, ruangan_id, profilrs_id, tglsurat, judulsurat, nourutsurat, nomorsurat, mengetahui_surat, jmlprint_surat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'ygbertandatangan_id'),
			'supir' => array(self::BELONGS_TO, 'PegawaiM', 'supirambulans_id'),
			'dokterpersalinan' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_persalinan_id'),
			'mobil' => array(self::BELONGS_TO, 'MobilambulansM', 'mobilambulans_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratketerangan_id' => 'Suratketerangan',
			'pendaftaran_id' => 'Pendaftaran',
			'jenissurat_id' => 'Jenis Surat',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'profilrs_id' => 'Profilrs',
			'tglsurat' => 'Tanggal Surat',
			'judulsurat' => 'Judul Surat',
			'nourutsurat' => 'No. Urut Surat',
			'nomorsurat' => 'Nomor Surat',
			'mengetahui_surat' => 'Mengetahui Surat',
			'jmlprint_surat' => 'Jml Print Surat',
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

		$criteria->compare('suratketerangan_id',$this->suratketerangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(tglsurat)',strtolower($this->tglsurat),true);
		$criteria->compare('LOWER(judulsurat)',strtolower($this->judulsurat),true);
		$criteria->compare('LOWER(nourutsurat)',strtolower($this->nourutsurat),true);
		$criteria->compare('LOWER(nomorsurat)',strtolower($this->nomorsurat),true);
		$criteria->compare('LOWER(mengetahui_surat)',strtolower($this->mengetahui_surat),true);
		$criteria->compare('jmlprint_surat',$this->jmlprint_surat);
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
		$criteria->compare('suratketerangan_id',$this->suratketerangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(tglsurat)',strtolower($this->tglsurat),true);
		$criteria->compare('LOWER(judulsurat)',strtolower($this->judulsurat),true);
		$criteria->compare('LOWER(nourutsurat)',strtolower($this->nourutsurat),true);
		$criteria->compare('LOWER(nomorsurat)',strtolower($this->nomorsurat),true);
		$criteria->compare('LOWER(mengetahui_surat)',strtolower($this->mengetahui_surat),true);
		$criteria->compare('jmlprint_surat',$this->jmlprint_surat);
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
        
        public function getJenisSurat()
        {
            return JenissuratM::model()->findAll();
        }
        
        public function getNoUrut()
        {
            $sql = "SELECT MAX(nourutsurat) AS nourutsurat FROM suratketerangan_r WHERE ruangan_id=".Yii::app()->user->getState('ruangan_id');
            $result = Yii::app()->db->createCommand($sql)->queryScalar();
            
            $criteria = new CDbCriteria;
            $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            //$criteria->compare('jenissurat_id', 1);
            //$surat = self::model()->find
            $no = $result+1;
            return $no;
        }
        
        public function getNoSurat($noRekamMedik='')
        {
            $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
            $no = $this->nourutsurat.'/'.$noRekamMedik.'/'.$data->nama_rumahsakit.'/'.date('m').'/'.date('Y');
            return $no;
        }
        
        public function getMengetahuiItems()
        {
            return PegawaiM::model()->findAllByAttributes(array('pegawai_aktif'=>true));
        }
}