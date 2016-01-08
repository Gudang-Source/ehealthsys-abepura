<?php

/**
 * This is the model class for table "prestasikerja_r".
 *
 * The followings are the available columns in table 'prestasikerja_r':
 * @property integer $prestasikerja_id
 * @property integer $pegawai_id
 * @property string $tglprestasidiperoleh
 * @property integer $nourutprestasi
 * @property string $instansipemberi
 * @property string $pejabatpemberi
 * @property string $namapenghargaan
 * @property string $keteranganprestasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PrestasikerjaR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrestasikerjaR the static model class
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
		return 'prestasikerja_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglprestasidiperoleh, nourutprestasi', 'required'),
			array('pegawai_id, nourutprestasi', 'numerical', 'integerOnly'=>true),
			array('instansipemberi, pejabatpemberi, namapenghargaan', 'length', 'max'=>100),
			array('keteranganprestasi,create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('prestasikerja_id, pegawai_id, tglprestasidiperoleh, nourutprestasi, instansipemberi, pejabatpemberi, namapenghargaan, keteranganprestasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prestasikerja_id' => 'Prestasi Kerja',
			'pegawai_id' => 'Pegawai',
			'tglprestasidiperoleh' => 'Tanggal Prestasi Diperoleh',
			'nourutprestasi' => 'No. Urut Prestasi',
			'instansipemberi' => 'Intansi Pemberi',
			'pejabatpemberi' => 'Pejabat Pemberi',
			'namapenghargaan' => 'Nama Penghargaan',
			'keteranganprestasi' => 'Keterangan Prestasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('prestasikerja_id',$this->prestasikerja_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglprestasidiperoleh)',strtolower($this->tglprestasidiperoleh),true);
		$criteria->compare('nourutprestasi',$this->nourutprestasi);
		$criteria->compare('LOWER(instansipemberi)',strtolower($this->instansipemberi),true);
		$criteria->compare('LOWER(pejabatpemberi)',strtolower($this->pejabatpemberi),true);
		$criteria->compare('LOWER(namapenghargaan)',strtolower($this->namapenghargaan),true);
		$criteria->compare('LOWER(keteranganprestasi)',strtolower($this->keteranganprestasi),true);
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
		$criteria->compare('prestasikerja_id',$this->prestasikerja_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglprestasidiperoleh)',strtolower($this->tglprestasidiperoleh),true);
		$criteria->compare('nourutprestasi',$this->nourutprestasi);
		$criteria->compare('LOWER(instansipemberi)',strtolower($this->instansipemberi),true);
		$criteria->compare('LOWER(pejabatpemberi)',strtolower($this->pejabatpemberi),true);
		$criteria->compare('LOWER(namapenghargaan)',strtolower($this->namapenghargaan),true);
		$criteria->compare('LOWER(keteranganprestasi)',strtolower($this->keteranganprestasi),true);
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

//  RND-8362 
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//    }
    protected function beforeSave() {  
            if($this->tglprestasidiperoleh===null || trim($this->tglprestasidiperoleh)==''){
	        $this->setAttribute('tglprestasidiperoleh', null);
            }
            
            return parent::beforeSave();
        }

}