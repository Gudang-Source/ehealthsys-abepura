<?php

/**
 * This is the model class for table "pengajuanbahanmkn_t".
 *
 * The followings are the available columns in table 'pengajuanbahanmkn_t':
 * @property integer $pengajuanbahanmkn_id
 * @property integer $terimabahanmakan_id
 * @property integer $ruangan_id
 * @property integer $supplier_id
 * @property string $nopengajuan
 * @property string $tglpengajuanbahan
 * @property string $sumberdanabhn
 * @property string $alamatpengiriman
 * @property integer $idpegawai_mengetahui
 * @property integer $idpegawai_mengajukan
 * @property string $keterangan_bahan
 * @property double $totalharganetto
 * @property string $tglmintadikirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class PengajuanbahanmknT extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanbahanmknT the static model class
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
		return 'pengajuanbahanmkn_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, nopengajuan, tglpengajuanbahan, sumberdanabhn, alamatpengiriman, totalharganetto', 'required'),
			array('terimabahanmakan_id, ruangan_id, supplier_id, idpegawai_mengetahui, idpegawai_mengajukan', 'numerical', 'integerOnly'=>true),
			array('totalharganetto', 'numerical'),
			array('nopengajuan, sumberdanabhn', 'length', 'max'=>50),
			array('status_persetujuan, keterangan_bahan, create_time, create_loginpemakai_id, idpegawai_menyetujui', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
//                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('status_persetujuan, tgl_awal, tgl_akhir, pengajuanbahanmkn_id, terimabahanmakan_id, ruangan_id, supplier_id, nopengajuan, tglpengajuanbahan, sumberdanabhn, alamatpengiriman, idpegawai_mengetahui, idpegawai_mengajukan, keterangan_bahan, totalharganetto, tglmintadikirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'supplier'=>array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
                    'mengajukan'=>array(self::BELONGS_TO, 'PegawaiM', 'idpegawai_mengajukan'),
                    'mengetahui'=>array(self::BELONGS_TO, 'PegawaiM', 'idpegawai_mengetahui'),
                    'menyetujui'=>array(self::BELONGS_TO, 'PegawaiM', 'idpegawai_menyetujui'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanbahanmkn_id' => 'Pengajuan Bahan Makan',
			'terimabahanmakan_id' => 'Terima Bahan Makan',
			'ruangan_id' => 'Ruangan',
			'supplier_id' => 'Supplier',
			'nopengajuan' => 'No. Pengajuan',
			'tglpengajuanbahan' => 'Tanggal Pengajuan Bahan',
			'sumberdanabhn' => 'Sumber Dana Bahan',
			'alamatpengiriman' => 'Alamat Pengiriman',
			'idpegawai_mengetahui' => 'Pegawai Mengetahui',
			'idpegawai_mengajukan' => 'Pegawai Mengajukan',
			'idpegawai_menyetujui' => 'Pegawai Menyetujui',
			'keterangan_bahan' => 'Keterangan Bahan',
			'totalharganetto' => 'Total Harga Netto',
			'tglmintadikirim' => 'Tanggal Minta Dikirim',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(nopengajuan)',strtolower($this->nopengajuan),true);
		$criteria->compare('LOWER(tglpengajuanbahan)',strtolower($this->tglpengajuanbahan),true);
		$criteria->compare('LOWER(sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(alamatpengiriman)',strtolower($this->alamatpengiriman),true);
		$criteria->compare('idpegawai_mengetahui',$this->idpegawai_mengetahui);
		$criteria->compare('idpegawai_mengajukan',$this->idpegawai_mengajukan);
		$criteria->compare('LOWER(keterangan_bahan)',strtolower($this->keterangan_bahan),true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(nopengajuan)',strtolower($this->nopengajuan),true);
		$criteria->compare('LOWER(tglpengajuanbahan)',strtolower($this->tglpengajuanbahan),true);
		$criteria->compare('LOWER(sumberdanabhn)',strtolower($this->sumberdanabhn),true);
		$criteria->compare('LOWER(alamatpengiriman)',strtolower($this->alamatpengiriman),true);
		$criteria->compare('idpegawai_mengetahui',$this->idpegawai_mengetahui);
		$criteria->compare('idpegawai_mengajukan',$this->idpegawai_mengajukan);
		$criteria->compare('LOWER(keterangan_bahan)',strtolower($this->keterangan_bahan),true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('LOWER(tglmintadikirim)',strtolower($this->tglmintadikirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function getNamaPegawai($id){
            return PegawaiM::model()->findByPk($id)->nama_pegawai;
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglmintadikirim===null || trim($this->tglmintadikirim)==''){
	        $this->setAttribute('tglmintadikirim', null);
            }
            if($this->tglpengajuanbahan===null || trim($this->tglpengajuanbahan)==''){
	        $this->setAttribute('tglpengajuanbahan', null);
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
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
}