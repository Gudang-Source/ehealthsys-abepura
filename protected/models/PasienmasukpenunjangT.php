<?php

/**
 * This is the model class for table "pasienmasukpenunjang_t".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_t':
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienkirimkeunitlain_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property string $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienmasukpenunjangT extends CActiveRecord
{
        public $noRM;
        public $noPendaftaran;
        public $tgl_awal;
        public $tgl_akhir;
        public $namaPasien;
        public $namaBinPasien;
        public $no_rekam_medik, $nama_pasien ,$carabayar_nama;
        public $carabayar_id, $penjamin_id;
        public $statusperiksa_pendaftaran;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmasukpenunjangT the static model class
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
		return 'pasienmasukpenunjang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, jeniskasuspenyakit_id, kelaspelayanan_id, ruangan_id, no_masukpenunjang, tglmasukpenunjang, no_urutperiksa, kunjungan, statusperiksa, ruanganasal_id, pegawai_id', 'required'),
			array('pasienkirimkeunitlain_id, pasien_id, jeniskasuspenyakit_id, pendaftaran_id, pegawai_id, kelaspelayanan_id, ruangan_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('no_masukpenunjang', 'length', 'max'=>20),
			array('no_urutperiksa', 'length', 'max'=>3),
			array('kunjungan, statusperiksa', 'length', 'max'=>50),                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('namaPasien,namaBinPasien,noRM,noPendaftaran, statusBayar, Totaltagihan, no_pendaftaran,carabayar_nama, no_rekam_medik, nama_pasien, tgl_awal,tgl_akhir,pasienkirimkeunitlain_id,pasienmasukpenunjang_id, pasien_id, jeniskasuspenyakit_id, pendaftaran_id, pegawai_id, kelaspelayanan_id, ruangan_id, pasienadmisi_id, no_masukpenunjang, tglmasukpenunjang, no_urutperiksa, kunjungan, statusperiksa, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),

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
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'jeniskasuspenyakit'=>array(self::BELONGS_TO, 'JeniskasuspenyakitM','jeniskasuspenyakit_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
                    'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM','kelaspelayanan_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
                    'ruanganasal'=>array(self::BELONGS_TO, 'RuanganM','ruanganasal_id'),
                    'pasienadmisi'=>array(self::BELONGS_TO,'PasienadmisiT','pasienadmisi_id'),
                    'ruanganasal'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    'pasienkirimkeunitlain'=>array(self::BELONGS_TO,'PasienkirimkeunitlainT','pasienkirimkeunitlain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienmasukpenunjang_id' => 'ID',
			'pasien_id' => 'Pasien',
			'jeniskasuspenyakit_id' => 'Kasus Penyakit',
			'pendaftaran_id' => 'No. Pendaftaran',
			'pegawai_id' => 'Dokter',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'ruangan_id' => 'Ruangan Penunjang',
			'pasienadmisi_id' => 'Pasien Admisi',
			'no_masukpenunjang' => 'No. Masuk Penunjang',
			'tglmasukpenunjang' => 'Tanggal Masuk Penunjang',
			'no_urutperiksa' => 'No. Urut Periksa',
			'kunjungan' => 'Kunjungan',
			'statusperiksa' => 'Status Periksa',
			'ruanganasal_id' => 'Ruangan Asal',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'noRM'=>'No. Rekam Medik',
                        'noPendaftaran'=>'No. Pendaftaran',
                        'tgl_awal'=>'Tanggal Pendaftaran',
                        'tgl_akhir'=>'s/d',
                        'namaPasien'=>'Nama Pasien',
                        'namaBinPasien'=>'Bin',
                        'pasienkirimkeunitlain_id'=>'Pasien Kirim Ke Unit Lain',
                        'no_rekam_medik' => 'No. Rekam Medik',
                        'carabayar_id' => 'Cara Bayar',
                        'penjamin_id' => 'Penjamin',
                        'statusperiksa_pendaftaran' => 'Status Periksa',
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

		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(ruanganasal_id)',strtolower($this->ruanganasal_id),true);
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
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
		$criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(ruanganasal_id)',strtolower($this->ruanganasal_id),true);
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
        
           public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getNamaNamaBIN()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
//        public function getCaraBayarPenjamin()
//        {
//                return $this->carabayar_nama.' / '.$this->penjamin_nama;
//        }
        
        public function getRTRW()
        {
              $rt = PendaftaranT::model()->with('pasien')->findByPk($this->pendaftaran_id)->rt;
              $rw = PendaftaranT::model()->with('pasien')->findByPk($this->pendaftaran_id)->rw;
              return $rt.$rw;
//            return $this->rt.' / '.$this->rw;
        }
        
        public function getCaraBayarPenjamin()
        {
                $caraBayar=PendaftaranT::model()->with('carabayar')->findByPk($this->pendaftaran_id)->carabayar_nama;
                $penjamin=PendaftaranT::model()->with('penjamin')->findByPk($this->pendaftaran_id)->penjamin_nama;
                return $caraBayar.$penjamin;
        }
}