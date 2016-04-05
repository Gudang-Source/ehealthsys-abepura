<?php

/**
 * This is the model class for table "pembayaranjasa_t".
 *
 * The followings are the available columns in table 'pembayaranjasa_t':
 * @property integer $pembayaranjasa_id
 * @property integer $tandabuktikeluar_id
 * @property integer $rujukandari_id
 * @property integer $pegawai_id
 * @property string $tglbayarjasa
 * @property string $nobayarjasa
 * @property string $periodejasa
 * @property string $sampaidgn
 * @property double $totaltarif
 * @property double $totaljasa
 * @property double $totalbayarjasa
 * @property double $totalsisajasa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 *
 * The followings are the available model relations:
 * @property TindakankomponenT[] $tindakankomponenTs
 * @property PembjasadetailT[] $pembjasadetailTs
 * @property PegawaiM $pegawai
 * @property RujukandariM $rujukandari
 * @property TandabuktikeluarT $tandabuktikeluar
 * @property CarabayarM $carabayar
 * @property PenjaminpasienM $penjamin
 */
class PembayaranjasaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranjasaT the static model class
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
		return 'pembayaranjasa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglbayarjasa, nobayarjasa, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tandabuktikeluar_id, rujukandari_id, pegawai_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('totaltarif, totaljasa, totalbayarjasa, totalsisajasa', 'numerical'),
			array('nobayarjasa', 'length', 'max'=>10),
			array('periodejasa, sampaidgn, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayaranjasa_id, tandabuktikeluar_id, rujukandari_id, pegawai_id, tglbayarjasa, nobayarjasa, periodejasa, sampaidgn, totaltarif, totaljasa, totalbayarjasa, totalsisajasa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, carabayar_id, penjamin_id', 'safe', 'on'=>'search'),
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
			'tindakankomponenTs' => array(self::HAS_MANY, 'TindakankomponenT', 'pembayaranjasa_id'),
			'pembjasadetailTs' => array(self::HAS_MANY, 'PembjasadetailT', 'pembayaranjasa_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'rujukandari' => array(self::BELONGS_TO, 'RujukandariM', 'rujukandari_id'),
			'tandabuktikeluar' => array(self::BELONGS_TO, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembayaranjasa_id' => 'Pembayaran Jasa',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'rujukandari_id' => 'Rujukan Dari',
			'pegawai_id' => 'Pegawai',
			'tglbayarjasa' => 'Tgl. Bayar Jasa',
			'nobayarjasa' => 'No. Bayar Jasa',
			'periodejasa' => 'Periode Jasa',
			'sampaidgn' => 'Sampai Dengan',
			'totaltarif' => 'Total Tarif',
			'totaljasa' => 'Total Jasa',
			'totalbayarjasa' => 'Total Bayar Jasa',
			'totalsisajasa' => 'Total Sisa Jasa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Cara Bayar',
			'penjamin_id' => 'Penjamin',
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

		if(!empty($this->pembayaranjasa_id)){
			$criteria->addCondition('pembayaranjasa_id = '.$this->pembayaranjasa_id);
		}
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		if(!empty($this->rujukandari_id)){
			$criteria->addCondition('rujukandari_id = '.$this->rujukandari_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tglbayarjasa)',strtolower($this->tglbayarjasa),true);
		$criteria->compare('LOWER(nobayarjasa)',strtolower($this->nobayarjasa),true);
		$criteria->compare('LOWER(periodejasa)',strtolower($this->periodejasa),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('totaltarif',$this->totaltarif);
		$criteria->compare('totaljasa',$this->totaljasa);
		$criteria->compare('totalbayarjasa',$this->totalbayarjasa);
		$criteria->compare('totalsisajasa',$this->totalsisajasa);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
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