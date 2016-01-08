<?php

/**
 * This is the model class for table "returresep_t".
 *
 * The followings are the available columns in table 'returresep_t':
 * @property integer $returresep_id
 * @property integer $ruangan_id
 * @property integer $penjualanresep_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property string $tglretur
 * @property string $noreturresep
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property integer $mengetahui_id
 * @property integer $pegretur_id
 * @property double $totalretur
 */
class ReturresepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturresepT the static model class
	 */
        public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'returresep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, tglretur, noreturresep, alasanretur, pegretur_id, totalretur', 'required'),
			array('ruangan_id, penjualanresep_id, pendaftaran_id, pasien_id, pasienadmisi_id, mengetahui_id, pegretur_id', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noreturresep', 'length', 'max'=>50),
			array('alasanretur', 'length', 'max'=>200),
			array('keteranganretur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returresep_id, ruangan_id, penjualanresep_id, tgl_awal, tgl_akhir, pendaftaran_id, pasien_id, pasienadmisi_id, tglretur, noreturresep, alasanretur, keteranganretur, mengetahui_id, pegretur_id, totalretur', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','mengetahui_id'),
                    'pegawairetur'=>array(self::BELONGS_TO, 'PegawaiM','pegretur_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'penjualanresep'=>array(self::BELONGS_TO,'PenjualanresepT','penjualanresep_id'),
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasienadmisi'=>array(self::BELONGS_TO,'PasienadmisiT','pasienadmisi_id'),
					'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'returresep_id' => 'Retur Resep Id',
			'ruangan_id' => 'Ruangan',
			'penjualanresep_id' => 'No. Penjualan Resep',
			'pendaftaran_id' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasien Admisi',
			'tglretur' => 'Tanggal Retur',
			'noreturresep' => 'No. Retur',
			'alasanretur' => 'Alasan Retur',
			'keteranganretur' => 'Keterangan Retur',
			'mengetahui_id' => 'Mengetahui',
			'pegretur_id' => 'Pegawai Retur',
			'totalretur' => 'Total Retur',
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

		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('totalretur',$this->totalretur);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchReturPenjualan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addBetweenCondition('DATE(tglretur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->order='tglretur DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('returresep_id',$this->returresep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('pegretur_id',$this->pegretur_id);
		$criteria->compare('totalretur',$this->totalretur);
		$criteria->order='tglretur DESC';
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
}