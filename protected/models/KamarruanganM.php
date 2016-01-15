<?php

/**
 * This is the model class for table "kamarruangan_m".
 *
 * The followings are the available columns in table 'kamarruangan_m':
 * @property integer $kamarruangan_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property string $kamarruangan_nokamar
 * @property integer $kamarruangan_jmlbed
 * @property string $kamarruangan_nobed
 * @property boolean $kamarruangan_status
 * @property boolean $kamarruangan_aktif
 * @property integer $riwayatruangan_id
 * @property string $kamarruangan_image
 * @property strin $keterangan_kamar
 */
class KamarruanganM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KamarruanganM the static model class
	 */
        public $kelaspelayanan_nama;
        public $ruangan_nama;
        public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kamarruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kamarruangan_nokamar, kamarruangan_jmlbed, kamarruangan_nobed', 'required'),
			array('kelaspelayanan_id, ruangan_id, kamarruangan_jmlbed, riwayatruangan_id', 'numerical', 'integerOnly'=>true),
			array('kamarruangan_nokamar, kamarruangan_nobed', 'length', 'max'=>100),
			array('kamarruangan_image', 'length', 'max'=>100),
			array('kamarruangan_status, kamarruangan_aktif, keterangan_kamar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelaspelayanan_nama, kamarruangan_id, kelaspelayanan_id, keterangan_kamar, ruangan_id, kamarruangan_nokamar, kamarruangan_jmlbed, kamarruangan_nobed, kamarruangan_status, kamarruangan_aktif, riwayatruangan_id, kamarruangan_image', 'safe', 'on'=>'search'),
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
                     'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                    'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kamarruangan_id' => 'Kamar Ruangan',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'ruangan_id' => 'Ruangan',
			'kamarruangan_nokamar' => 'Nama Kamar',
			'kamarruangan_jmlbed' => 'Jumlah Bed',
			'kamarruangan_nobed' => 'No. Bed',
			'kamarruangan_status' => 'Terpakai',
			'kamarruangan_aktif' => 'Aktif',
			'riwayatruangan_id' => 'Riwayat Ruangan Id',
			'kamarruangan_image' => 'Photo',
                        'keterangan_kamar'=>'Keterangan Kamar',
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

		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('kamarruangan_jmlbed',$this->kamarruangan_jmlbed);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('kamarruangan_status',$this->kamarruangan_status);
		$criteria->compare('kamarruangan_aktif',isset($this->kamarruangan_aktif)?$this->kamarruangan_aktif:true);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(kamarruangan_image)',strtolower($this->kamarruangan_image),true);
                $criteria->compare('LOWER(keterangan_kamar)',strtolower($this->keterangan_kamar),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('kamarruangan_jmlbed',$this->kamarruangan_jmlbed);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('kamarruangan_status',$this->kamarruangan_status);
		$criteria->compare('riwayatruangan_id',$this->riwayatruangan_id);
		$criteria->compare('LOWER(kamarruangan_image)',strtolower($this->kamarruangan_image),true);
                $criteria->compare('LOWER(keterangan_kamar)',strtolower($this->keterangan_kamar),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kamarruangan_nokamar = (strtolower($this->kamarruangan_nokamar));
            $this->kamarruangan_nobed = strtoupper($this->kamarruangan_nobed);

            return parent::beforeSave();
        }
        
        public function getKelasPelayananItems()
        {
            return SAKelasPelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
        }
        
        public function getKelasRuanganItems()
        {
            return KelasruanganM::model()->with('ruangan')->findAll('kelaspelayanan_id='.$this->kelaspelayanan_id.'');
          
        }  
        
        public function getRuanganItems($instalasi=null)
        {
            if($instalasi != null)
            {
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            }
            else{
                return RuanganM::model()->findAll(array('order'=>'ruangan_nama'));
            }
        }  
        
        public function getKamarDanTempatTidur()
        {
        	if(empty($this->keterangan_kamar)){
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed;	
        	}else{
        		return 'Kamar: '.$this->kamarruangan_nokamar.' - Bed: '.$this->kamarruangan_nobed.' ('.strtoupper($this->keterangan_kamar).')';	
        	}
            
        }
}