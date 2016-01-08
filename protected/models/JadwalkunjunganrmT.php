<?php

/**
 * This is the model class for table "jadwalkunjunganrm_t".
 *
 * The followings are the available columns in table 'jadwalkunjunganrm_t':
 * @property integer $jadwalkunjunganrm_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pendaftaran_id
 * @property string $nojadwal
 * @property string $tglkunjunganrm
 * @property integer $nourutjadwal
 * @property string $tgljadwalrm
 * @property string $harijadwalrm
 * @property boolean $statusterapi
 * @property integer $lamaterapikunjungan
 * @property string $paramedis1_id
 * @property string $paramedis2_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class JadwalkunjunganrmT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalkunjunganrmT the static model class
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
		return 'jadwalkunjunganrm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, nourutjadwal, lamaterapikunjungan', 'required'),
			array('pegawai_id, pasien_id, pasienmasukpenunjang_id, pendaftaran_id, nourutjadwal, lamaterapikunjungan', 'numerical', 'integerOnly'=>true),
			array('nojadwal, harijadwalrm', 'length', 'max'=>20),
			array('tgljadwalrm, statusterapi, paramedis1_id, paramedis2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                    
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			
                        array('jadwalkunjunganrm_id, pegawai_id, pasien_id, pasienmasukpenunjang_id, pendaftaran_id, nojadwal, tglkunjunganrm, nourutjadwal, tgljadwalrm, harijadwalrm, statusterapi, lamaterapikunjungan, paramedis1_id, paramedis2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jadwalkunjunganrm_id' => 'Jadwalkunjunganrm',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pendaftaran_id' => 'Pendaftaran',
			'nojadwal' => 'Nojadwal',
			'tglkunjunganrm' => 'Tglkunjunganrm',
			'nourutjadwal' => 'Nourutjadwal',
			'tgljadwalrm' => 'Tgljadwalrm',
			'harijadwalrm' => 'Harijadwalrm',
			'statusterapi' => 'Statusterapi',
			'lamaterapikunjungan' => 'Lamaterapikunjungan',
			'paramedis1_id' => 'Paramedis1',
			'paramedis2_id' => 'Paramedis2',
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

		$criteria->compare('jadwalkunjunganrm_id',$this->jadwalkunjunganrm_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nojadwal)',strtolower($this->nojadwal),true);
		$criteria->compare('LOWER(tglkunjunganrm)',strtolower($this->tglkunjunganrm),true);
		$criteria->compare('nourutjadwal',$this->nourutjadwal);
		$criteria->compare('LOWER(tgljadwalrm)',strtolower($this->tgljadwalrm),true);
		$criteria->compare('LOWER(harijadwalrm)',strtolower($this->harijadwalrm),true);
		$criteria->compare('statusterapi',$this->statusterapi);
		$criteria->compare('lamaterapikunjungan',$this->lamaterapikunjungan);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
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
		$criteria->compare('jadwalkunjunganrm_id',$this->jadwalkunjunganrm_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nojadwal)',strtolower($this->nojadwal),true);
		$criteria->compare('LOWER(tglkunjunganrm)',strtolower($this->tglkunjunganrm),true);
		$criteria->compare('nourutjadwal',$this->nourutjadwal);
		$criteria->compare('LOWER(tgljadwalrm)',strtolower($this->tgljadwalrm),true);
		$criteria->compare('LOWER(harijadwalrm)',strtolower($this->harijadwalrm),true);
		$criteria->compare('statusterapi',$this->statusterapi);
		$criteria->compare('lamaterapikunjungan',$this->lamaterapikunjungan);
		$criteria->compare('LOWER(paramedis1_id)',strtolower($this->paramedis1_id),true);
		$criteria->compare('LOWER(paramedis2_id)',strtolower($this->paramedis2_id),true);
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

        protected function beforeSave() {  
            if($this->tglkunjunganrm===null || trim($this->tglkunjunganrm)==''){
	        $this->setAttribute('tglkunjunganrm', null);
            }
            return parent::beforeSave();
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
}