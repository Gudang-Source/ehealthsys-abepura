<?php

/**
 * This is the model class for table "pemeriksaankala4_t".
 *
 * The followings are the available columns in table 'pemeriksaankala4_t':
 * @property integer $pemeriksaankala4_id
 * @property integer $pemeriksaanobstetrik_id
 * @property string $kala4_tanggal
 * @property string $kala4_waktu
 * @property integer $kala4_darahcc
 * @property string $kala4_anemia
 * @property string $kala4_tekanandarah
 * @property integer $kala4_systolic
 * @property integer $kala4_diastolic
 * @property double $kala4_meanarteripressure
 * @property integer $kala4_detaknadi
 * @property string $kala4_pernapasan
 * @property string $kala4_tinggifundus
 * @property string $kala4_kontraksi
 * @property string $kala4_kandungkemih
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PemeriksaanobstetrikT $pemeriksaanobstetrik
 */
class Pemeriksaankala4T extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pemeriksaankala4T the static model class
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
		return 'pemeriksaankala4_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanobstetrik_id, kala4_tanggal, kala4_waktu, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemeriksaanobstetrik_id, kala4_darahcc, kala4_systolic, kala4_diastolic, kala4_detaknadi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kala4_meanarteripressure', 'numerical'),
			array('kala4_anemia, kala4_pernapasan, kala4_tinggifundus, kala4_kontraksi, kala4_kandungkemih', 'length', 'max'=>100),
			array('kala4_tekanandarah', 'length', 'max'=>20),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaankala4_id, pemeriksaanobstetrik_id, kala4_tanggal, kala4_waktu, kala4_darahcc, kala4_anemia, kala4_tekanandarah, kala4_systolic, kala4_diastolic, kala4_meanarteripressure, kala4_detaknadi, kala4_pernapasan, kala4_tinggifundus, kala4_kontraksi, kala4_kandungkemih, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pemeriksaankala4_id' => 'Pemeriksaankala4',
			'pemeriksaanobstetrik_id' => 'Pemeriksaanobstetrik',
			'kala4_tanggal' => 'Tanggal',
			'kala4_waktu' => 'Waktu',
			'kala4_darahcc' => 'Pendarahan',
			'kala4_anemia' => 'Anemia',
			'kala4_tekanandarah' => 'Tekanandarah',
			'kala4_systolic' => 'Systolic',
			'kala4_diastolic' => 'Diastolic',
			'kala4_meanarteripressure' => 'Mean Arteri Pressure',
			'kala4_detaknadi' => 'Denyut Nadi',
			'kala4_pernapasan' => 'Pernapasan',
			'kala4_tinggifundus' => 'Tinggi Fundus Uteri',
			'kala4_kontraksi' => 'Kontraksi',
			'kala4_kandungkemih' => 'Kandung Kemih',
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

		$criteria->compare('pemeriksaankala4_id',$this->pemeriksaankala4_id);
		$criteria->compare('pemeriksaanobstetrik_id',$this->pemeriksaanobstetrik_id);
		$criteria->compare('kala4_tanggal',$this->kala4_tanggal,true);
		$criteria->compare('kala4_waktu',$this->kala4_waktu,true);
		$criteria->compare('kala4_darahcc',$this->kala4_darahcc);
		$criteria->compare('kala4_anemia',$this->kala4_anemia,true);
		$criteria->compare('kala4_tekanandarah',$this->kala4_tekanandarah,true);
		$criteria->compare('kala4_systolic',$this->kala4_systolic);
		$criteria->compare('kala4_diastolic',$this->kala4_diastolic);
		$criteria->compare('kala4_meanarteripressure',$this->kala4_meanarteripressure);
		$criteria->compare('kala4_detaknadi',$this->kala4_detaknadi);
		$criteria->compare('kala4_pernapasan',$this->kala4_pernapasan,true);
		$criteria->compare('kala4_tinggifundus',$this->kala4_tinggifundus,true);
		$criteria->compare('kala4_kontraksi',$this->kala4_kontraksi,true);
		$criteria->compare('kala4_kandungkemih',$this->kala4_kandungkemih,true);
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