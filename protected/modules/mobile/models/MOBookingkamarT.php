<?php

/**
 * This is the model class for table "bookingkamar_t".
 *
 * The followings are the available columns in table 'bookingkamar_t':
 * @property integer $bookingkamar_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property string $bookingkamar_no
 * @property string $tgltransaksibooking
 * @property string $tglbookingkamar
 * @property string $statusbooking
 * @property string $keteranganbooking
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $statuskonfirmasi
 *
 * The followings are the available model relations:
 * @property PasienadmisiT[] $pasienadmisiTs
 * @property MasukkamarT[] $masukkamarTs
 * @property KamarruanganM $kamarruangan
 * @property KelaspelayananM $kelaspelayanan
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 */
class MOBookingkamarT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOBookingkamarT the static model class
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
		return 'bookingkamar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, kelaspelayanan_id, bookingkamar_no, tgltransaksibooking, tglbookingkamar, statusbooking, create_time, create_loginpemakai_id', 'required'),
			array('ruangan_id, pasien_id, pasienadmisi_id, pendaftaran_id, kamarruangan_id, kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('bookingkamar_no', 'length', 'max'=>20),
			array('statusbooking', 'length', 'max'=>10),
			array('statuskonfirmasi', 'length', 'max'=>50),
			array('keteranganbooking, update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bookingkamar_id, ruangan_id, pasien_id, pasienadmisi_id, pendaftaran_id, kamarruangan_id, kelaspelayanan_id, bookingkamar_no, tgltransaksibooking, tglbookingkamar, statusbooking, keteranganbooking, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, statuskonfirmasi', 'safe', 'on'=>'search'),
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
			'pasienadmisiTs' => array(self::HAS_MANY, 'PasienadmisiT', 'bookingkamar_id'),
			'masukkamarTs' => array(self::HAS_MANY, 'MasukkamarT', 'bookingkamar_id'),
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bookingkamar_id' => 'Bookingkamar',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'kamarruangan_id' => 'Kamarruangan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'bookingkamar_no' => 'Bookingkamar No',
			'tgltransaksibooking' => 'Tgltransaksibooking',
			'tglbookingkamar' => 'Tglbookingkamar',
			'statusbooking' => 'Statusbooking',
			'keteranganbooking' => 'Keteranganbooking',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'statuskonfirmasi' => 'Statuskonfirmasi',
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

		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(bookingkamar_no)',strtolower($this->bookingkamar_no),true);
		$criteria->compare('LOWER(tgltransaksibooking)',strtolower($this->tgltransaksibooking),true);
		$criteria->compare('LOWER(tglbookingkamar)',strtolower($this->tglbookingkamar),true);
		$criteria->compare('LOWER(statusbooking)',strtolower($this->statusbooking),true);
		$criteria->compare('LOWER(keteranganbooking)',strtolower($this->keteranganbooking),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(statuskonfirmasi)',strtolower($this->statuskonfirmasi),true);

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