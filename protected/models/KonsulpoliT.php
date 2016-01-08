<?php

/**
 * This is the model class for table "konsulpoli_t".
 *
 * The followings are the available columns in table 'konsulpoli_t':
 * @property integer $konsulpoli_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $tglkonsulpoli
 * @property string $asalpoliklinikkonsul_id
 * @property string $statusperiksa
 * @property string $catatan_dokter_konsul
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class KonsulpoliT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KonsulpoliT the static model class
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
			array('ruangan_id, pasien_id, pendaftaran_id, tglkonsulpoli, asalpoliklinikkonsul_id, statusperiksa', 'required'),
			array('ruangan_id, pasien_id, pendaftaran_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('statusperiksa', 'length', 'max'=>50),
			array('catatan_dokter_konsul, update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('konsulpoli_id, ruangan_id, pasien_id, pendaftaran_id, pegawai_id, tglkonsulpoli, asalpoliklinikkonsul_id, statusperiksa, catatan_dokter_konsul, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'poliasal'=>array(self::BELONGS_TO,'RuanganM','asalpoliklinikkonsul_id'),
                    'politujuan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konsulpoli_id' => 'Konsulpoli',
			'ruangan_id' => 'Poliklinik Tujuan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Dokter Konsul',
			'tglkonsulpoli' => 'Tanggal Konsul',
			'asalpoliklinikkonsul_id' => 'Poliklinik Asal',
			'statusperiksa' => 'Statusperiksa',
			'catatan_dokter_konsul' => 'Catatan Dokter',
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

		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglkonsulpoli)',strtolower($this->tglkonsulpoli),true);
		$criteria->compare('LOWER(asalpoliklinikkonsul_id)',strtolower($this->asalpoliklinikkonsul_id),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(catatan_dokter_konsul)',strtolower($this->catatan_dokter_konsul),true);
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
		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglkonsulpoli)',strtolower($this->tglkonsulpoli),true);
		$criteria->compare('LOWER(asalpoliklinikkonsul_id)',strtolower($this->asalpoliklinikkonsul_id),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(catatan_dokter_konsul)',strtolower($this->catatan_dokter_konsul),true);
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
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {          
            return parent::beforeSave();
        }
                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
        
        /**
         * Mengambil daftar semua ruangan dari instalasi
         * @return CActiveDataProvider 
         */
        public function getRuanganInstalasiItems($idInstalasi,$kecuali=false,$idRuangan='')
        {
            $criteria = new CDbCriteria();
            if($kecuali)
                $criteria->addCondition('ruangan_id !='.Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'ruangan_nama';
            
            if(!empty($idRuangan))
                $idInstalasi = RuanganM::model()->findByPk($idRuangan)->instalasi_id;
            
            if(!empty($idInstalasi))
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$idInstalasi,'ruangan_aktif'=>true),$criteria);
            else
                return RuanganM::model()->findAllByAttributes(array('ruangan_id'=>$this->asalpoliklinikkonsul_id));
        }
}