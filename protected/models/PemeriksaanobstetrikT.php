<?php

/**
 * This is the model class for table "pemeriksaanobstetrik_t".
 *
 * The followings are the available columns in table 'pemeriksaanobstetrik_t':
 * @property integer $pemeriksaanobstetrik_id
 * @property integer $persalinan_id
 * @property string $obs_fundusuteri
 * @property string $obs_posisijanin
 * @property string $obs_periksadalam
 * @property string $obs_portio
 * @property string $obs_konsistensigenitalia
 * @property string $obs_arah
 * @property string $obs_ketuban
 * @property string $obs_pemeriksa
 * @property string $obs_warnaketuban
 * @property string $obs_bagrendah
 * @property string $obs_hodge
 * @property string $obs_posisigenital
 * @property string $obs_fetopelvik
 * @property string $obs_presentasigenital
 * @property string $obs_frekuensi
 * @property string $obs_djj
 * @property string $obs_pemeriksaan
 * @property string $plasenta_lahir
 * @property string $plasenta_spontanitas
 * @property string $plasenta_kelengkapan
 * @property double $plasenta_berat
 * @property double $plasenta_diameter
 * @property string $pusar_insersi
 * @property double $pusar_panjang
 * @property string $pusar_kelengkapan
 * @property string $pusar_robekan
 * @property string $pusar_lainlain
 * @property string $luka_perineum
 * @property string $luka_vagina
 * @property string $luka_serviks
 * @property string $luka_episiotomi
 * @property string $luka_rupturaperinei
 * @property integer $kala3_darahcc
 * @property string $nifas_inveksi
 * @property string $nifas_laktasi
 * @property string $nifas_febris
 * @property string $nifas_lainlain
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property Pemeriksaankala4T[] $pemeriksaankala4Ts
 * @property PersalinanT $persalinan
 * @property PemeriksaanpartografT[] $pemeriksaanpartografTs
 */
class PemeriksaanobstetrikT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanobstetrikT the static model class
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
		return 'pemeriksaanobstetrik_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persalinan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('persalinan_id, kala3_darahcc, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('plasenta_berat, plasenta_diameter, pusar_panjang', 'numerical'),
			array('obs_fundusuteri, obs_posisijanin, obs_portio, obs_konsistensigenitalia, obs_arah, obs_ketuban, obs_pemeriksa, obs_warnaketuban, obs_bagrendah, obs_hodge, obs_posisigenital, obs_fetopelvik, obs_presentasigenital, obs_frekuensi, obs_djj, obs_pemeriksaan, plasenta_spontanitas, plasenta_kelengkapan, pusar_insersi, pusar_kelengkapan, pusar_robekan, pusar_lainlain, luka_perineum, luka_vagina, luka_serviks, luka_episiotomi, luka_rupturaperinei, nifas_inveksi, nifas_laktasi, nifas_febris, nifas_lainlain', 'length', 'max'=>100),
			array('obs_periksadalam, plasenta_lahir, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanobstetrik_id, persalinan_id, obs_fundusuteri, obs_posisijanin, obs_periksadalam, obs_portio, obs_konsistensigenitalia, obs_arah, obs_ketuban, obs_pemeriksa, obs_warnaketuban, obs_bagrendah, obs_hodge, obs_posisigenital, obs_fetopelvik, obs_presentasigenital, obs_frekuensi, obs_djj, obs_pemeriksaan, plasenta_lahir, plasenta_spontanitas, plasenta_kelengkapan, plasenta_berat, plasenta_diameter, pusar_insersi, pusar_panjang, pusar_kelengkapan, pusar_robekan, pusar_lainlain, luka_perineum, luka_vagina, luka_serviks, luka_episiotomi, luka_rupturaperinei, kala3_darahcc, nifas_inveksi, nifas_laktasi, nifas_febris, nifas_lainlain, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemeriksaankala4Ts' => array(self::HAS_MANY, 'Pemeriksaankala4T', 'pemeriksaanobstetrik_id'),
			'persalinan' => array(self::BELONGS_TO, 'PersalinanT', 'persalinan_id'),
			'pemeriksaanpartografTs' => array(self::HAS_MANY, 'PemeriksaanpartografT', 'pemeriksaanobstetrik_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanobstetrik_id' => 'Pemeriksaanobstetrik',
			'persalinan_id' => 'Persalinan',
			'obs_fundusuteri' => 'Fundus Uteri',
			'obs_posisijanin' => 'Letak Janin',
			'obs_periksadalam' => 'Pemeriksaan Dalam',
			'obs_portio' => 'Portio',
			'obs_konsistensigenitalia' => 'Konsistensi',
			'obs_arah' => 'Arah',
			'obs_ketuban' => 'Ketuban',
			'obs_pemeriksa' => 'Pemeriksa',
			'obs_warnaketuban' => 'Warna Ketuban',
			'obs_bagrendah' => 'Bagian Terendah',
			'obs_hodge' => 'Hodge',
			'obs_posisigenital' => 'Posisi',
			'obs_fetopelvik' => 'Imbang Fetopelvik',
			'obs_presentasigenital' => 'Presentasi',
			'obs_frekuensi' => 'Frekuensi',
			'obs_djj' => 'DJJ',
			'obs_pemeriksaan' => 'Pemeriksaan',
			'plasenta_lahir' => 'Lahir',
			'plasenta_spontanitas' => 'Spontanitas',
			'plasenta_kelengkapan' => 'Kelengkapan',
			'plasenta_berat' => 'Berat',
			'plasenta_diameter' => 'Diameter',
			'pusar_insersi' => 'Insersi',
			'pusar_panjang' => 'Panjang',
			'pusar_kelengkapan' => 'Kelengkapan',
			'pusar_robekan' => 'Robekan',
			'pusar_lainlain' => 'Lain lain',
			'luka_perineum' => 'Luka Perineum',
			'luka_vagina' => 'Luka Vagina',
			'luka_serviks' => 'Luka Serviks',
			'luka_episiotomi' => 'Episiotomi',
			'luka_rupturaperinei' => 'Ruptura Perinei',
			'kala3_darahcc' => 'Kala III',
			'nifas_inveksi' => 'Inveksi',
			'nifas_laktasi' => 'Laktasi',
			'nifas_febris' => 'Febris Puerperalis',
			'nifas_lainlain' => 'Lain Lain',
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

		$criteria->compare('pemeriksaanobstetrik_id',$this->pemeriksaanobstetrik_id);
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('obs_fundusuteri',$this->obs_fundusuteri,true);
		$criteria->compare('obs_posisijanin',$this->obs_posisijanin,true);
		$criteria->compare('obs_periksadalam',$this->obs_periksadalam,true);
		$criteria->compare('obs_portio',$this->obs_portio,true);
		$criteria->compare('obs_konsistensigenitalia',$this->obs_konsistensigenitalia,true);
		$criteria->compare('obs_arah',$this->obs_arah,true);
		$criteria->compare('obs_ketuban',$this->obs_ketuban,true);
		$criteria->compare('obs_pemeriksa',$this->obs_pemeriksa,true);
		$criteria->compare('obs_warnaketuban',$this->obs_warnaketuban,true);
		$criteria->compare('obs_bagrendah',$this->obs_bagrendah,true);
		$criteria->compare('obs_hodge',$this->obs_hodge,true);
		$criteria->compare('obs_posisigenital',$this->obs_posisigenital,true);
		$criteria->compare('obs_fetopelvik',$this->obs_fetopelvik,true);
		$criteria->compare('obs_presentasigenital',$this->obs_presentasigenital,true);
		$criteria->compare('obs_frekuensi',$this->obs_frekuensi,true);
		$criteria->compare('obs_djj',$this->obs_djj,true);
		$criteria->compare('obs_pemeriksaan',$this->obs_pemeriksaan,true);
		$criteria->compare('plasenta_lahir',$this->plasenta_lahir,true);
		$criteria->compare('plasenta_spontanitas',$this->plasenta_spontanitas,true);
		$criteria->compare('plasenta_kelengkapan',$this->plasenta_kelengkapan,true);
		$criteria->compare('plasenta_berat',$this->plasenta_berat);
		$criteria->compare('plasenta_diameter',$this->plasenta_diameter);
		$criteria->compare('pusar_insersi',$this->pusar_insersi,true);
		$criteria->compare('pusar_panjang',$this->pusar_panjang);
		$criteria->compare('pusar_kelengkapan',$this->pusar_kelengkapan,true);
		$criteria->compare('pusar_robekan',$this->pusar_robekan,true);
		$criteria->compare('pusar_lainlain',$this->pusar_lainlain,true);
		$criteria->compare('luka_perineum',$this->luka_perineum,true);
		$criteria->compare('luka_vagina',$this->luka_vagina,true);
		$criteria->compare('luka_serviks',$this->luka_serviks,true);
		$criteria->compare('luka_episiotomi',$this->luka_episiotomi,true);
		$criteria->compare('luka_rupturaperinei',$this->luka_rupturaperinei,true);
		$criteria->compare('kala3_darahcc',$this->kala3_darahcc);
		$criteria->compare('nifas_inveksi',$this->nifas_inveksi,true);
		$criteria->compare('nifas_laktasi',$this->nifas_laktasi,true);
		$criteria->compare('nifas_febris',$this->nifas_febris,true);
		$criteria->compare('nifas_lainlain',$this->nifas_lainlain,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}