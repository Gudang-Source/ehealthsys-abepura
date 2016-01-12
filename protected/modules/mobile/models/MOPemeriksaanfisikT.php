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
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property double $meanarteripressure
 * @property integer $detaknadi
 * @property integer $heartindex_i1
 * @property integer $heartindex_i2
 * @property integer $heartindex_i3
 * @property string $suhutubuh
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property double $bb_ideal
 * @property string $pernapasan
 * @property string $paramedis_nama
 * @property string $kelainanpadabagtubuh
 * @property boolean $jn_paten
 * @property boolean $jn_obstruktifpartial
 * @property boolean $jn_obstruktifnormal
 * @property boolean $jn_stridor
 * @property boolean $pgd_simetri
 * @property boolean $pgd_asimetri
 * @property boolean $pgp_normal
 * @property boolean $pgp_kussmaul
 * @property boolean $pgp_takipnea
 * @property boolean $pgp_retraktif
 * @property boolean $pgp_dangkal
 * @property integer $sirkulasi_nadicarotis
 * @property integer $sirkulasi_nadiradialis
 * @property boolean $cfr_kecil_2
 * @property boolean $cfr_besar_2
 * @property boolean $jn_gargling
 * @property boolean $kulit_normal
 * @property boolean $kulit_jaundice
 * @property boolean $kulit_cyanosis
 * @property boolean $kulit_pucat
 * @property boolean $kulit_berkeringat
 * @property string $akral
 * @property integer $gcs_eye
 * @property integer $gcs_verbal
 * @property integer $gcs_motorik
 * @property double $lila
 * @property double $lingkarpinggang
 * @property double $lingkarpinggul
 * @property double $teballemak
 * @property double $tinggilutut
 * @property string $denyutjantung
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property double $lingkarperut_cm
 * @property string $bentukbadan
 * @property string $mata_persepsiwarna
 * @property double $mata_visus_od
 * @property double $mata_visus_os
 * @property string $mata_penglihatanjauh
 * @property string $mata_kelainan
 * @property integer $klasifikasitekanandarah_id
 *
 * The followings are the available model relations:
 * @property GcsM $gcs
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property KlasifikasitekanadarahM $klasifikasitekanandarah
 */
class MOPemeriksaanfisikT extends CActiveRecord
{
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
            array('pendaftaran_id, pegawai_id, pasien_id, tglperiksafisik, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('gcs_id, pendaftaran_id, pegawai_id, pasienadmisi_id, pasien_id, td_systolic, td_diastolic, detaknadi, heartindex_i1, heartindex_i2, heartindex_i3, sirkulasi_nadicarotis, sirkulasi_nadiradialis, gcs_eye, gcs_verbal, gcs_motorik, klasifikasitekanandarah_id', 'numerical', 'integerOnly'=>true),
            array('meanarteripressure, beratbadan_kg, tinggibadan_cm, bb_ideal, lila, lingkarpinggang, lingkarpinggul, teballemak, tinggilutut, lingkarperut_cm, mata_visus_od, mata_visus_os', 'numerical'),
            array('keadaanumum, inspeksi, palpasi, perkusi, auskultasi, paramedis_nama', 'length', 'max'=>500),
            array('tekanandarah', 'length', 'max'=>20),
            array('suhutubuh', 'length', 'max'=>10),
            array('kelainanpadabagtubuh', 'length', 'max'=>30),
            array('akral', 'length', 'max'=>200),
            array('denyutjantung, mata_kelainan', 'length', 'max'=>100),
            array('bentukbadan, mata_persepsiwarna, mata_penglihatanjauh', 'length', 'max'=>50),
            array('pernapasan, jn_paten, jn_obstruktifpartial, jn_obstruktifnormal, jn_stridor, pgd_simetri, pgd_asimetri, pgp_normal, pgp_kussmaul, pgp_takipnea, pgp_retraktif, pgp_dangkal, cfr_kecil_2, cfr_besar_2, jn_gargling, kulit_normal, kulit_jaundice, kulit_cyanosis, kulit_pucat, kulit_berkeringat, update_time, update_loginpemakai_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pemeriksaanfisik_id, gcs_id, pendaftaran_id, pegawai_id, pasienadmisi_id, pasien_id, tglperiksafisik, keadaanumum, inspeksi, palpasi, perkusi, auskultasi, tekanandarah, td_systolic, td_diastolic, meanarteripressure, detaknadi, heartindex_i1, heartindex_i2, heartindex_i3, suhutubuh, beratbadan_kg, tinggibadan_cm, bb_ideal, pernapasan, paramedis_nama, kelainanpadabagtubuh, jn_paten, jn_obstruktifpartial, jn_obstruktifnormal, jn_stridor, pgd_simetri, pgd_asimetri, pgp_normal, pgp_kussmaul, pgp_takipnea, pgp_retraktif, pgp_dangkal, sirkulasi_nadicarotis, sirkulasi_nadiradialis, cfr_kecil_2, cfr_besar_2, jn_gargling, kulit_normal, kulit_jaundice, kulit_cyanosis, kulit_pucat, kulit_berkeringat, akral, gcs_eye, gcs_verbal, gcs_motorik, lila, lingkarpinggang, lingkarpinggul, teballemak, tinggilutut, denyutjantung, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lingkarperut_cm, bentukbadan, mata_persepsiwarna, mata_visus_od, mata_visus_os, mata_penglihatanjauh, mata_kelainan, klasifikasitekanandarah_id', 'safe', 'on'=>'search'),
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
            'gcs' => array(self::BELONGS_TO, 'GcsM', 'gcs_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'klasifikasitekanandarah' => array(self::BELONGS_TO, 'KlasifikasitekanadarahM', 'klasifikasitekanandarah_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
            'gcs_id' => 'Gcs',
            'pendaftaran_id' => 'Pendaftaran',
            'pegawai_id' => 'Pegawai',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pasien_id' => 'Pasien',
            'tglperiksafisik' => 'Tglperiksafisik',
            'keadaanumum' => 'Keadaanumum',
            'inspeksi' => 'Inspeksi',
            'palpasi' => 'Palpasi',
            'perkusi' => 'Perkusi',
            'auskultasi' => 'Auskultasi',
            'tekanandarah' => 'Tekanandarah',
            'td_systolic' => 'Td Systolic',
            'td_diastolic' => 'Td Diastolic',
            'meanarteripressure' => 'Meanarteripressure',
            'detaknadi' => 'Detaknadi',
            'heartindex_i1' => 'Heartindex I1',
            'heartindex_i2' => 'Heartindex I2',
            'heartindex_i3' => 'Heartindex I3',
            'suhutubuh' => 'Suhutubuh',
            'beratbadan_kg' => 'Beratbadan Kg',
            'tinggibadan_cm' => 'Tinggibadan Cm',
            'bb_ideal' => 'Bb Ideal',
            'pernapasan' => 'Pernapasan',
            'paramedis_nama' => 'Paramedis Nama',
            'kelainanpadabagtubuh' => 'Kelainanpadabagtubuh',
            'jn_paten' => 'Jn Paten',
            'jn_obstruktifpartial' => 'Jn Obstruktifpartial',
            'jn_obstruktifnormal' => 'Jn Obstruktifnormal',
            'jn_stridor' => 'Jn Stridor',
            'pgd_simetri' => 'Pgd Simetri',
            'pgd_asimetri' => 'Pgd Asimetri',
            'pgp_normal' => 'Pgp Normal',
            'pgp_kussmaul' => 'Pgp Kussmaul',
            'pgp_takipnea' => 'Pgp Takipnea',
            'pgp_retraktif' => 'Pgp Retraktif',
            'pgp_dangkal' => 'Pgp Dangkal',
            'sirkulasi_nadicarotis' => 'Sirkulasi Nadicarotis',
            'sirkulasi_nadiradialis' => 'Sirkulasi Nadiradialis',
            'cfr_kecil_2' => 'Cfr Kecil 2',
            'cfr_besar_2' => 'Cfr Besar 2',
            'jn_gargling' => 'Jn Gargling',
            'kulit_normal' => 'Kulit Normal',
            'kulit_jaundice' => 'Kulit Jaundice',
            'kulit_cyanosis' => 'Kulit Cyanosis',
            'kulit_pucat' => 'Kulit Pucat',
            'kulit_berkeringat' => 'Kulit Berkeringat',
            'akral' => 'Akral',
            'gcs_eye' => 'Gcs Eye',
            'gcs_verbal' => 'Gcs Verbal',
            'gcs_motorik' => 'Gcs Motorik',
            'lila' => 'Lila',
            'lingkarpinggang' => 'Lingkarpinggang',
            'lingkarpinggul' => 'Lingkarpinggul',
            'teballemak' => 'Teballemak',
            'tinggilutut' => 'Tinggilutut',
            'denyutjantung' => 'Denyutjantung',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
            'lingkarperut_cm' => 'Lingkarperut Cm',
            'bentukbadan' => 'Bentukbadan',
            'mata_persepsiwarna' => 'Mata Persepsiwarna',
            'mata_visus_od' => 'Mata Visus Od',
            'mata_visus_os' => 'Mata Visus Os',
            'mata_penglihatanjauh' => 'Mata Penglihatanjauh',
            'mata_kelainan' => 'Mata Kelainan',
            'klasifikasitekanandarah_id' => 'Klasifikasitekanandarah',
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

        if(!empty($this->pemeriksaanfisik_id)){
            $criteria->addCondition('pemeriksaanfisik_id = '.$this->pemeriksaanfisik_id);
        }
        if(!empty($this->gcs_id)){
            $criteria->addCondition('gcs_id = '.$this->gcs_id);
        }
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
        }
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        if(!empty($this->pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
        }
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
        }
        $criteria->compare('LOWER(tglperiksafisik)',strtolower($this->tglperiksafisik),true);
        $criteria->compare('LOWER(keadaanumum)',strtolower($this->keadaanumum),true);
        $criteria->compare('LOWER(inspeksi)',strtolower($this->inspeksi),true);
        $criteria->compare('LOWER(palpasi)',strtolower($this->palpasi),true);
        $criteria->compare('LOWER(perkusi)',strtolower($this->perkusi),true);
        $criteria->compare('LOWER(auskultasi)',strtolower($this->auskultasi),true);
        $criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
        if(!empty($this->td_systolic)){
            $criteria->addCondition('td_systolic = '.$this->td_systolic);
        }
        if(!empty($this->td_diastolic)){
            $criteria->addCondition('td_diastolic = '.$this->td_diastolic);
        }
        $criteria->compare('meanarteripressure',$this->meanarteripressure);
        if(!empty($this->detaknadi)){
            $criteria->addCondition('detaknadi = '.$this->detaknadi);
        }
        if(!empty($this->heartindex_i1)){
            $criteria->addCondition('heartindex_i1 = '.$this->heartindex_i1);
        }
        if(!empty($this->heartindex_i2)){
            $criteria->addCondition('heartindex_i2 = '.$this->heartindex_i2);
        }
        if(!empty($this->heartindex_i3)){
            $criteria->addCondition('heartindex_i3 = '.$this->heartindex_i3);
        }
        $criteria->compare('LOWER(suhutubuh)',strtolower($this->suhutubuh),true);
        $criteria->compare('beratbadan_kg',$this->beratbadan_kg);
        $criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
        $criteria->compare('bb_ideal',$this->bb_ideal);
        $criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
        $criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
        $criteria->compare('LOWER(kelainanpadabagtubuh)',strtolower($this->kelainanpadabagtubuh),true);
        $criteria->compare('jn_paten',$this->jn_paten);
        $criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
        $criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
        $criteria->compare('jn_stridor',$this->jn_stridor);
        $criteria->compare('pgd_simetri',$this->pgd_simetri);
        $criteria->compare('pgd_asimetri',$this->pgd_asimetri);
        $criteria->compare('pgp_normal',$this->pgp_normal);
        $criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
        $criteria->compare('pgp_takipnea',$this->pgp_takipnea);
        $criteria->compare('pgp_retraktif',$this->pgp_retraktif);
        $criteria->compare('pgp_dangkal',$this->pgp_dangkal);
        if(!empty($this->sirkulasi_nadicarotis)){
            $criteria->addCondition('sirkulasi_nadicarotis = '.$this->sirkulasi_nadicarotis);
        }
        if(!empty($this->sirkulasi_nadiradialis)){
            $criteria->addCondition('sirkulasi_nadiradialis = '.$this->sirkulasi_nadiradialis);
        }
        $criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
        $criteria->compare('cfr_besar_2',$this->cfr_besar_2);
        $criteria->compare('jn_gargling',$this->jn_gargling);
        $criteria->compare('kulit_normal',$this->kulit_normal);
        $criteria->compare('kulit_jaundice',$this->kulit_jaundice);
        $criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
        $criteria->compare('kulit_pucat',$this->kulit_pucat);
        $criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
        $criteria->compare('LOWER(akral)',strtolower($this->akral),true);
        if(!empty($this->gcs_eye)){
            $criteria->addCondition('gcs_eye = '.$this->gcs_eye);
        }
        if(!empty($this->gcs_verbal)){
            $criteria->addCondition('gcs_verbal = '.$this->gcs_verbal);
        }
        if(!empty($this->gcs_motorik)){
            $criteria->addCondition('gcs_motorik = '.$this->gcs_motorik);
        }
        $criteria->compare('lila',$this->lila);
        $criteria->compare('lingkarpinggang',$this->lingkarpinggang);
        $criteria->compare('lingkarpinggul',$this->lingkarpinggul);
        $criteria->compare('teballemak',$this->teballemak);
        $criteria->compare('tinggilutut',$this->tinggilutut);
        $criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->compare('lingkarperut_cm',$this->lingkarperut_cm);
        $criteria->compare('LOWER(bentukbadan)',strtolower($this->bentukbadan),true);
        $criteria->compare('LOWER(mata_persepsiwarna)',strtolower($this->mata_persepsiwarna),true);
        $criteria->compare('mata_visus_od',$this->mata_visus_od);
        $criteria->compare('mata_visus_os',$this->mata_visus_os);
        $criteria->compare('LOWER(mata_penglihatanjauh)',strtolower($this->mata_penglihatanjauh),true);
        $criteria->compare('LOWER(mata_kelainan)',strtolower($this->mata_kelainan),true);
        if(!empty($this->klasifikasitekanandarah_id)){
            $criteria->addCondition('klasifikasitekanandarah_id = '.$this->klasifikasitekanandarah_id);
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