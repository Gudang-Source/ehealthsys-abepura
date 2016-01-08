<?php

/**
 * This is the model class for table "pegawaicuti_t".
 *
 * The followings are the available columns in table 'pegawaicuti_t':
 * @property integer $pegawaicuti_id
 * @property integer $jeniscuti_id
 * @property integer $pegawai_id
 * @property string $tglmulaicuti
 * @property string $tglakhircuti
 * @property string $lamacuti
 * @property string $noskcuti
 * @property string $tglditetapkanskcuti
 * @property string $keterangan
 * @property string $keperluancuti
 * @property string $pejabatmenyetujui
 * @property string $pejabatmengetahui
 */
class PegawaicutiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaicutiT the static model class
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
		return 'pegawaicuti_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniscuti_id, pegawai_id, tglmulaicuti', 'required'),
			array('jeniscuti_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('lamacuti, noskcuti, tglditetapkanskcuti', 'length', 'max'=>10),
			array('pejabatmenyetujui, pejabatmengetahui', 'length', 'max'=>100),
			array('tglakhircuti, keterangan, keperluancuti', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaicuti_id, jeniscuti_id, pegawai_id, tglmulaicuti, tglakhircuti, lamacuti, noskcuti, tglditetapkanskcuti, keterangan, keperluancuti, pejabatmenyetujui, pejabatmengetahui', 'safe', 'on'=>'search'),
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
			'jeniscuti'=>array(self::BELONGS_TO,'jeniscutiM','jeniscuti_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawaicuti_id' => 'ID',
			'jeniscuti_id' => 'Jenis cuti',
			'pegawai_id' => 'Pegawai',
			'tglmulaicuti' => 'Tanggal mulai',
			'tglakhircuti' => 'Sampai dengan',
			'lamacuti' => 'Lama cuti',
			'noskcuti' => 'No. SK',
			'tglditetapkanskcuti' => 'Tanggal SK',
			'keterangan' => 'Keterangan',
			'keperluancuti' => 'Keperluan',
			'pejabatmenyetujui' => 'Pejabat menyetujui',
			'pejabatmengetahui' => 'Pejabat mengetahui',
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

		$criteria->compare('pegawaicuti_id',$this->pegawaicuti_id);
		$criteria->compare('jeniscuti_id',$this->jeniscuti_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglmulaicuti)',strtolower($this->tglmulaicuti),true);
		$criteria->compare('LOWER(tglakhircuti)',strtolower($this->tglakhircuti),true);
		$criteria->compare('LOWER(lamacuti)',strtolower($this->lamacuti),true);
		$criteria->compare('LOWER(noskcuti)',strtolower($this->noskcuti),true);
		$criteria->compare('LOWER(tglditetapkanskcuti)',strtolower($this->tglditetapkanskcuti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(keperluancuti)',strtolower($this->keperluancuti),true);
		$criteria->compare('LOWER(pejabatmenyetujui)',strtolower($this->pejabatmenyetujui),true);
		$criteria->compare('LOWER(pejabatmengetahui)',strtolower($this->pejabatmengetahui),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pegawaicuti_id',$this->pegawaicuti_id);
		$criteria->compare('jeniscuti_id',$this->jeniscuti_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglmulaicuti)',strtolower($this->tglmulaicuti),true);
		$criteria->compare('LOWER(tglakhircuti)',strtolower($this->tglakhircuti),true);
		$criteria->compare('LOWER(lamacuti)',strtolower($this->lamacuti),true);
		$criteria->compare('LOWER(noskcuti)',strtolower($this->noskcuti),true);
		$criteria->compare('LOWER(tglditetapkanskcuti)',strtolower($this->tglditetapkanskcuti),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(keperluancuti)',strtolower($this->keperluancuti),true);
		$criteria->compare('LOWER(pejabatmenyetujui)',strtolower($this->pejabatmenyetujui),true);
		$criteria->compare('LOWER(pejabatmengetahui)',strtolower($this->pejabatmengetahui),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJeniscutiItems() {
            return jeniscutiM::model()->findAll('jeniscuti_aktif=TRUE ORDER BY jeniscuti_nama');
        }
        
        public function getPegawaiItems() {
            return PegawaiM::model()->findAll('pegawai_aktif=TRUE ORDER BY nama_pegawai');
        }
//		RND-8362    
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                if (!strlen($this->$columnName)) continue;
//                if ($column->dbType == 'date'){
//                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                }elseif ($column->dbType == 'timestamp without time zone'){
//                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                            CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                }
//            }
//            return true;
//        }       

}