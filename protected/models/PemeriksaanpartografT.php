<?php

/**
 * This is the model class for table "pemeriksaanpartograf_t".
 *
 * The followings are the available columns in table 'pemeriksaanpartograf_t':
 * @property integer $pemeriksaanpartograf_id
 * @property integer $pemeriksaanobstetrik_id
 * @property string $pto_tglperiksa
 * @property string $pto_ketubanpecah
 * @property string $pto_mules
 * @property integer $pto_djj_menit
 * @property string $pto_airketuban
 * @property string $pto_penyusupan
 * @property integer $pto_pembukaan
 * @property integer $pto_penutupan
 * @property integer $kontraksi_jml
 * @property integer $kontraksi_lama_detik
 * @property integer $kontraksi_oksitosin_unit
 * @property integer $kontraksi_tetes_menit
 * @property string $pto_tekanandarah
 * @property integer $pto_systolic
 * @property integer $pto_diastolic
 * @property string $urine_protein
 * @property string $urine_aseton
 * @property integer $urine_volumen
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PemeriksaanobstetrikT $pemeriksaanobstetrik
 */
class PemeriksaanpartografT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanpartografT the static model class
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
		return 'pemeriksaanpartograf_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanobstetrik_id, pto_tglperiksa, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemeriksaanobstetrik_id, pto_djj_menit, pto_pembukaan, pto_penutupan, kontraksi_jml, kontraksi_lama_detik, kontraksi_oksitosin_unit, kontraksi_tetes_menit, pto_systolic, pto_diastolic, urine_volumen, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pto_airketuban, pto_penyusupan, urine_protein, urine_aseton', 'length', 'max'=>100),
			array('pto_tekanandarah', 'length', 'max'=>20),
			array('pto_ketubanpecah, pto_mules, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanpartograf_id, pemeriksaanobstetrik_id, pto_tglperiksa, pto_ketubanpecah, pto_mules, pto_djj_menit, pto_airketuban, pto_penyusupan, pto_pembukaan, pto_penutupan, kontraksi_jml, kontraksi_lama_detik, kontraksi_oksitosin_unit, kontraksi_tetes_menit, pto_tekanandarah, pto_systolic, pto_diastolic, urine_protein, urine_aseton, urine_volumen, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemeriksaanobstetrik' => array(self::BELONGS_TO, 'PemeriksaanobstetrikT', 'pemeriksaanobstetrik_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanpartograf_id' => 'Pemeriksaanpartograf',
			'pemeriksaanobstetrik_id' => 'Pemeriksaanobstetrik',
			'pto_tglperiksa' => 'Pto Tglperiksa',
			'pto_ketubanpecah' => 'Pto Ketubanpecah',
			'pto_mules' => 'Pto Mules',
			'pto_djj_menit' => 'Pto Djj Menit',
			'pto_airketuban' => 'Pto Airketuban',
			'pto_penyusupan' => 'Pto Penyusupan',
			'pto_pembukaan' => 'Pto Pembukaan',
			'pto_penutupan' => 'Pto Penutupan',
			'kontraksi_jml' => 'Kontraksi Jml',
			'kontraksi_lama_detik' => 'Kontraksi Lama Detik',
			'kontraksi_oksitosin_unit' => 'Kontraksi Oksitosin Unit',
			'kontraksi_tetes_menit' => 'Kontraksi Tetes Menit',
			'pto_tekanandarah' => 'Pto Tekanandarah',
			'pto_systolic' => 'Pto Systolic',
			'pto_diastolic' => 'Pto Diastolic',
			'urine_protein' => 'Urine Protein',
			'urine_aseton' => 'Urine Aseton',
			'urine_volumen' => 'Urine Volumen',
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

		$criteria->compare('pemeriksaanpartograf_id',$this->pemeriksaanpartograf_id);
		$criteria->compare('pemeriksaanobstetrik_id',$this->pemeriksaanobstetrik_id);
		$criteria->compare('pto_tglperiksa',$this->pto_tglperiksa,true);
		$criteria->compare('pto_ketubanpecah',$this->pto_ketubanpecah,true);
		$criteria->compare('pto_mules',$this->pto_mules,true);
		$criteria->compare('pto_djj_menit',$this->pto_djj_menit);
		$criteria->compare('pto_airketuban',$this->pto_airketuban,true);
		$criteria->compare('pto_penyusupan',$this->pto_penyusupan,true);
		$criteria->compare('pto_pembukaan',$this->pto_pembukaan);
		$criteria->compare('pto_penutupan',$this->pto_penutupan);
		$criteria->compare('kontraksi_jml',$this->kontraksi_jml);
		$criteria->compare('kontraksi_lama_detik',$this->kontraksi_lama_detik);
		$criteria->compare('kontraksi_oksitosin_unit',$this->kontraksi_oksitosin_unit);
		$criteria->compare('kontraksi_tetes_menit',$this->kontraksi_tetes_menit);
		$criteria->compare('pto_tekanandarah',$this->pto_tekanandarah,true);
		$criteria->compare('pto_systolic',$this->pto_systolic);
		$criteria->compare('pto_diastolic',$this->pto_diastolic);
		$criteria->compare('urine_protein',$this->urine_protein,true);
		$criteria->compare('urine_aseton',$this->urine_aseton,true);
		$criteria->compare('urine_volumen',$this->urine_volumen);
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