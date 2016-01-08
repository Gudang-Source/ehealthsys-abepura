<?php

/**
 * This is the model class for table "bayarkesupplier_t".
 *
 * The followings are the available columns in table 'bayarkesupplier_t':
 * @property integer $bayarkesupplier_id
 * @property integer $uangmukabeli_id
 * @property integer $fakturpembelian_id
 * @property integer $tandabuktikeluar_id
 * @property integer $batalbayarsupplier_id
 * @property string $tglbayarkesupplier
 * @property double $totaltagihan
 * @property double $jmldibayarkan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BayarkesupplierT extends CActiveRecord
{
                public $tgl_awal, $tgl_akhir, $tgl_awalbayarkesupplier, $tgl_akhirbayarkesupplier, $nofaktur, $supplier_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BayarkesupplierT the static model class
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
		return 'bayarkesupplier_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglbayarkesupplier, totaltagihan, jmldibayarkan', 'required'),
			array('uangmukabeli_id, fakturpembelian_id, tandabuktikeluar_id, batalbayarsupplier_id', 'numerical', 'integerOnly'=>true),
			array('totaltagihan, jmldibayarkan', 'numerical'),
			array('update_time, update_loginpemakai_id', 'safe'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bayarkesupplier_id, uangmukabeli_id, fakturpembelian_id, tandabuktikeluar_id, batalbayarsupplier_id, tglbayarkesupplier, totaltagihan, jmldibayarkan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                                    'fakturpembelian'=>array(self::BELONGS_TO,'FakturpembelianT','fakturpembelian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bayarkesupplier_id' => 'Bayarkesupplier',
			'uangmukabeli_id' => 'Uangmukabeli',
			'fakturpembelian_id' => 'Fakturpembelian',
			'tandabuktikeluar_id' => 'Tandabuktikeluar',
			'batalbayarsupplier_id' => 'Batal bayar',
			'tglbayarkesupplier' => 'Tanggal Pembayaran',
			'totaltagihan' => 'Total Tagihan',
			'jmldibayarkan' => 'Jumlah Dibayarkan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                                                'nofaktur'=>'No. Faktur',
                                                'supplier_id'=>'Supplier',
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

		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('LOWER(tglbayarkesupplier)',strtolower($this->tglbayarkesupplier),true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                                $criteria->with = 'fakturpembelian';
                                $criteria->addBetweenCondition('tglfaktur',$this->tgl_awal,$this->tgl_akhir);
                                $criteria->compare('LOWER(nofaktur)',$this->nofaktur);
                                $criteria->compare('supplier_id',$this->supplier_id);
                                
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
//		$criteria->addBetweenCondition('tglbayarkesupplier',$this->tgl_awalbayarkesupplier,$this->tgl_akhirbayarkesupplier);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
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
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('LOWER(tglbayarkesupplier)',strtolower($this->tglbayarkesupplier),true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
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
        
        public function getSupplierItems()
        {
            return SupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama');
        }
}