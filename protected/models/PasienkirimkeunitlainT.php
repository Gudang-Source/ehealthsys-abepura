<?php

/**
 * This is the model class for table "pasienkirimkeunitlain_t".
 *
 * The followings are the available columns in table 'pasienkirimkeunitlain_t':
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $kelaspelayanan_id
 * @property integer $instalasi_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $nourut
 * @property string $tgl_kirimpasien
 * @property string $catatandokterpengirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienkirimkeunitlainT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkirimkeunitlainT the static model class
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
		return 'pasienkirimkeunitlain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id, instalasi_id, pasien_id, ruangan_id, pegawai_id, pendaftaran_id, nourut, tgl_kirimpasien, isbayarkekasirpenunjang', 'required'),
			array('kelaspelayanan_id, instalasi_id, pasien_id, pasienmasukpenunjang_id, ruangan_id, pegawai_id, pendaftaran_id, ahligizi', 'numerical', 'integerOnly'=>true),
			array('nourut', 'length', 'max'=>3),
			array('catatandokterpengirim, update_time, create_loginpemakai_id', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                    
//                        NILAI BERIKUT DIATUR DI CONTROLLER / BUGS KETIKA DIGUNAKAN DI MOBILE (BRIDGING)
//                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
//                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
//                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienkirimkeunitlain_id, kelaspelayanan_id, instalasi_id, pasien_id, pasienmasukpenunjang_id, ruangan_id, pegawai_id, pendaftaran_id, nourut, tgl_kirimpasien, catatandokterpengirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, isbayarkekasirpenunjang', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO,  'PendaftaranT', 'pendaftaran_id'),
                    'pasien'=>array(self::BELONGS_TO,  'PasienM', 'pasien_id'),
                    'instalasi'=>array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    'kelaspelayanan'=>array(self::BELONGS_TO,'KelaspelayananM','kelaspelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'instalasi_id' => 'Instalasi',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Dokter Perujuk',
			'pendaftaran_id' => 'Pendaftaran',
			'nourut' => 'Nourut',
			'tgl_kirimpasien' => 'Tanggal Kirim Pasien',
			'catatandokterpengirim' => 'Catatan Dokter',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'ahligizi' => 'Ahli Gizi',
			'isbayarkekasirpenunjang' => 'Bayar Ke Kasir',
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

		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
//        FUNGSI YANG SUDAH TIDAK DIGUNAKAN
//        protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date'){
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }elseif ($column->dbType == 'timestamp without time zone'){
//                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {          
//            return parent::beforeSave();
//        }
//                
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//        }
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems($ruangan_id=null){
//            tampilkan semua dokter
//            if (Yii::app()->user->getState('dokterruangan')==true){
//				if(empty($ruangan_id))
//					$ruangan_id = Yii::app()->user->getState('ruangan_id');
//                if(!empty($ruangan_id))
//                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
//                else
//                    return array();
//            }else{
//              DATA YANG DILOAD TERLALU BANYAK (BERAT) >>  return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true),array('order'=>'nama_pegawai'));
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('t.kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("t.pegawai_aktif = TRUE");
                                $criteria->join = "join ruanganpegawai_m r on r.pegawai_id = t.pegawai_id";
                                if (!empty($ruangan_id)) {
                                    $criteria->compare('r.ruangan_id', $ruangan_id);
                                } else {
                                    $criteria->compare('r.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                                }
                                
				$criteria->order = 't.nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
//            }
        }
        
        /**
         * Mengambil daftar semua ruangan gizi
         * @return CActiveDataProvider 
         */
        public function getRuanganGiziItems()
        {
            return RuanganinstalasigiziV::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama ASC'));
        }
        public function getAhliGiziItems()
        {
			return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_AHLI_GIZI), array('order'=>'nama_pegawai ASC'));
            //return DokterV::model()->findAll();
        }
}