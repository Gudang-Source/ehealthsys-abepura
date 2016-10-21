<?php

/**
 * This is the model class for table "pemeriksaanfisik_t".
 *
 * The followings are the available columns in table 'pemeriksaanfisik_t':
 * @property integer $pemeriksaanfisik_id
 * @property integer $gcs_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tglperiksafisik
 * @property string $keadaanumum
 * @property string $inspeksi
 * @property string $palpasi
 * @property string $perkusi
 * @property string $auskultasi
 * @property string $tekanandarah
 * @property string $detaknadi
 * @property string $suhutubuh
 * @property string $beratbadan_kg
 * @property string $tinggibadan_cm
 * @property string $pernapasan
 * @property string $paramedis_nama
 * @property string $kelainanpadabagtubuh
 * @property string $kulit
 * @property string $kepala
 * @property string $mata
 * @property string $telinga
 * @property string $hidung
 * @property string $leher
 * @property string $tenggorokan
 * @property string $jantung
 * @property string $payudara
 * @property string $abdomen
 * @property integer $gcs_eye
 * @property integer $gcs_verbal
 * @property integer $gcs_motorik
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PemeriksaanfisikT extends CActiveRecord
{
        public $tekanandarah_text;
        public $posisijanin;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikT the static model class
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
		return 'pemeriksaanfisik_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pegawai_id, pasien_id, tglperiksafisik, create_loginpemakai_id, create_time, create_ruangan', 'required'),
			array('gcs_id, pendaftaran_id, pegawai_id, pasienadmisi_id, pasien_id, gcs_eye, gcs_verbal, gcs_motorik', 'numerical', 'integerOnly'=>true),
			array('keadaanumum', 'length', 'max'=>200),
			array('inspeksi, palpasi, perkusi, auskultasi, paramedis_nama', 'length', 'max'=>100),
			array('tekanandarah', 'length', 'max'=>20),
			array('detaknadi, kelainanpadabagtubuh', 'length', 'max'=>30),
			array('suhutubuh, beratbadan_kg, tinggibadan_cm, pernapasan', 'length', 'max'=>10),
			array('portio_genitalia, tekanandarah_text, meanarteripressure, td_systolic, td_diastolic, bb_ideal, kulit, mata, telinga, hidung, leher, tenggorokan, jantung, payudara, abdomen, update_time, update_loginpemakai_id,Lila, LingkarPinggang, LingkarPinggul, TebalLemak, TinggiLutut, denyutjantung_janin, tinggifundus_uteri', 'safe'),
			
//                        DI NON-AKTIFKAN AGAR BRIDGING UNTUK MOBILE DOKTER BISA BERJALAN
//                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
//                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
//                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
//                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
//                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// Please remove those attributes that should not be searched.
			array('pemeriksaanfisik_id, gcs_id, pendaftaran_id, Lila, LingkarPinggang, LingkarPinggul, TebalLemak, TinggiLutut, pegawai_id, pasienadmisi_id, pasien_id, tglperiksafisik, keadaanumum, inspeksi, palpasi, perkusi, auskultasi, tekanandarah, detaknadi, suhutubuh, beratbadan_kg, tinggibadan_cm, pernapasan, paramedis_nama, kelainanpadabagtubuh, kulit, mata, telinga, hidung, leher, tenggorokan, jantung, payudara, abdomen, gcs_eye, gcs_verbal, gcs_motorik, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
				'gcs'=>array(self::BELONGS_TO, 'GcsM','gcs_id'),
				'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
				'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
				'klasifikasitekanandarah'=>array(self::BELONGS_TO, 'KlasifikasitekanadarahM','klasifikasitekanandarah_id'),
				'metodegcseye'=>array(self::BELONGS_TO, 'MetodegcsM','gcs_eye'),
				'metodegcsverbal'=>array(self::BELONGS_TO, 'MetodegcsM','gcs_verbal'),
				'metodegcsmotorik'=>array(self::BELONGS_TO, 'MetodegcsM','gcs_motorik'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanfisik_id' => 'ID',
			'gcs_id' => 'GCS',
			'pendaftaran_id' => 'No. Pendaftaran',
			'pegawai_id' => 'Dokter',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Nama Pasien',
			'tglperiksafisik' => 'Tanggal Periksa',
			'keadaanumum' => 'Keadaan Umum',
			'inspeksi' => 'Inspeksi',
			'palpasi' => 'Palpasi',
			'perkusi' => 'Perkusi',
			'auskultasi' => 'Auskultasi',
			'tekanandarah' => 'Tekanan Darah',
			'detaknadi' => 'Detak Nadi',
                        'denyutjantung' => 'Denyut Jantung',
			'suhutubuh' => 'Suhu Tubuh',
			'beratbadan_kg' => 'Berat Badan',
			'tinggibadan_cm' => 'Tinggi Badan/',
			'pernapasan' => 'Pernapasan',
			'paramedis_nama' => 'Paramedis',
			'kelainanpadabagtubuh' => 'Kelainan Pada Bag. Tubuh',
			'kulit' => 'Kulit',
			'mata' => 'Mata',
			'telinga' => 'Telinga',
			'hidung' => 'Hidung',
			'leher' => 'Leher',
			'tenggorokan' => 'Tenggorokan',
			'jantung' => 'Jantung',
			'payudara' => 'Payudara',
			'abdomen' => 'Abdomen',
			'gcs_eye' => 'GCS Eye',
			'gcs_verbal' => 'GCS Verbal',
			'gcs_motorik' => 'GCS Motorik',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'Lila'=>'Lila',
			'LingkarPinggang'=>'Lingkar Pinggang',
			'LingkarPinggul'=>'Lingkar Pinggul',
			'TebalLemak'=>'Tebal Lemak',
			'TinggiLutut'=>'Tinggi Lutut',
			'bb_ideal'=>'Berat Badan Ideal',
			'jn_paten'=>'Paten',
			'jn_obstruktifpartial'=>'Obstruktif Partial',
			'jn_obstruktifnormal'=>'Obstruktif Total',
			'jn_stridor'=>'Stridor',
			'jn_gargling'=>'Gargling',
			'pgp_normal'=>'Normal',
			'pgp_kussmaul'=>'Kussmaul',
			'pgp_takipnea'=>'Takipnea',
			'pgp_retraktif'=>'Retraktif',
			'pgp_dangkal'=>'Dangkal',
			'pgd_simetri'=>'Simetri',
			'pgd_asimetri'=>'Asimetri',
			'sirkulasi_nadicarotis'=>'Nadi Carotis',
			'sirkulasi_nadiradialis'=>'Nadi Radialis',
			'cfr_kecil_2'=>'CFR',
			'cfr_besar_2'=>'CFR',
			'kulit_normal'=>'Normal',
			'kulit_jaundice'=>'Jaundice',
			'kulit_cyanosis'=>'Cyanosis',
			'kulit_pucat'=>'Pucat',
			'kulit_berkeringat'=>'Berkeringat',
			'akral'=>'Akral',
			'namaGCS'=>'Nilai GCS',
                        'denyutjantung_janin'=>'Denyut Jantung Janin',
                        'tinggifundus_uteri'=>'Tinggi Fundus Uteri',
                        'portio_genitalia' => 'Portio'
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

		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('gcs_id',$this->gcs_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglperiksafisik)',strtolower($this->tglperiksafisik),true);
		$criteria->compare('LOWER(keadaanumum)',strtolower($this->keadaanumum),true);
		$criteria->compare('LOWER(inspeksi)',strtolower($this->inspeksi),true);
		$criteria->compare('LOWER(palpasi)',strtolower($this->palpasi),true);
		$criteria->compare('LOWER(perkusi)',strtolower($this->perkusi),true);
		$criteria->compare('LOWER(auskultasi)',strtolower($this->auskultasi),true);
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
		$criteria->compare('LOWER(detaknadi)',strtolower($this->detaknadi),true);
                $criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
		$criteria->compare('LOWER(suhutubuh)',strtolower($this->suhutubuh),true);
		$criteria->compare('LOWER(beratbadan_kg)',strtolower($this->beratbadan_kg),true);
		$criteria->compare('LOWER(tinggibadan_cm)',strtolower($this->tinggibadan_cm),true);
		$criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(kelainanpadabagtubuh)',strtolower($this->kelainanpadabagtubuh),true);
		$criteria->compare('LOWER(kulit)',strtolower($this->kulit),true);
		$criteria->compare('LOWER(mata)',strtolower($this->mata),true);
		$criteria->compare('LOWER(telinga)',strtolower($this->telinga),true);
		$criteria->compare('LOWER(hidung)',strtolower($this->hidung),true);
		$criteria->compare('LOWER(leher)',strtolower($this->leher),true);
		$criteria->compare('LOWER(tenggorokan)',strtolower($this->tenggorokan),true);
		$criteria->compare('LOWER(jantung)',strtolower($this->jantung),true);
		$criteria->compare('LOWER(payudara)',strtolower($this->payudara),true);
		$criteria->compare('LOWER(abdomen)',strtolower($this->abdomen),true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('Lila',$this->Lila);
                $criteria->compare('LingkarPinggang',$this->LingkarPinggang);
                $criteria->compare('LingkarPinggul',$this->LingkarPinggul);
                $criteria->compare('TebalLemak',$this->TebalLemak);
                $criteria->compare('TinggiLutut',$this->TinggiLutut);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('gcs_id',$this->gcs_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglperiksafisik)',strtolower($this->tglperiksafisik),true);
		$criteria->compare('LOWER(keadaanumum)',strtolower($this->keadaanumum),true);
		$criteria->compare('LOWER(inspeksi)',strtolower($this->inspeksi),true);
		$criteria->compare('LOWER(palpasi)',strtolower($this->palpasi),true);
		$criteria->compare('LOWER(perkusi)',strtolower($this->perkusi),true);
		$criteria->compare('LOWER(auskultasi)',strtolower($this->auskultasi),true);
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
		$criteria->compare('LOWER(detaknadi)',strtolower($this->detaknadi),true);
                $criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
		$criteria->compare('LOWER(suhutubuh)',strtolower($this->suhutubuh),true);
		$criteria->compare('LOWER(beratbadan_kg)',strtolower($this->beratbadan_kg),true);
		$criteria->compare('LOWER(tinggibadan_cm)',strtolower($this->tinggibadan_cm),true);
		$criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(kelainanpadabagtubuh)',strtolower($this->kelainanpadabagtubuh),true);
		$criteria->compare('LOWER(kulit)',strtolower($this->kulit),true);
		$criteria->compare('LOWER(mata)',strtolower($this->mata),true);
		$criteria->compare('LOWER(telinga)',strtolower($this->telinga),true);
		$criteria->compare('LOWER(hidung)',strtolower($this->hidung),true);
		$criteria->compare('LOWER(leher)',strtolower($this->leher),true);
		$criteria->compare('LOWER(tenggorokan)',strtolower($this->tenggorokan),true);
		$criteria->compare('LOWER(jantung)',strtolower($this->jantung),true);
		$criteria->compare('LOWER(payudara)',strtolower($this->payudara),true);
		$criteria->compare('LOWER(abdomen)',strtolower($this->abdomen),true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('Lila',$this->Lila);
                $criteria->compare('LingkarPinggang',$this->LingkarPinggang);
                $criteria->compare('LingkarPinggul',$this->LingkarPinggul);
                $criteria->compare('TebalLemak',$this->TebalLemak);
                $criteria->compare('TinggiLutut',$this->TinggiLutut);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
//       FUNGSI beforeValidate() dan beforeSave() TIDAK DIGUNAKAN, NILAI DITENTUKAN DICONTROLLER
//             protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//                    else if ( $column->dbType == 'timestamp without time zone')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {         
//            if($this->tglperiksafisik===null || trim($this->tglperiksafisik)==''){
//	        $this->setAttribute('tglperiksafisik', null);
//            }
//            return parent::beforeSave();
//        }

        // protected function afterFind(){
        //     foreach($this->metadata->tableSchema->columns as $columnName => $column){

        //         if (!strlen($this->$columnName)) continue;

        //         if ($column->dbType == 'date'){                         
        //                 $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
        //                                 CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
        //                 }elseif ($column->dbType == 'timestamp without time zone'){
        //                         $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
        //                                 CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
        //                 }
        //     }
        //     return true;
        // }
               
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
        
        public function getAhliGiziItems()
        {
			return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>16));
            //return DokterV::model()->findAll();
        }
}