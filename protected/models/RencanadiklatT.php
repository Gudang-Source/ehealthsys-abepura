<?php

/**
 * This is the model class for table "rencanadiklat_t".
 *
 * The followings are the available columns in table 'rencanadiklat_t':
 * @property integer $rencanadiklat_id
 * @property integer $pegawai_id
 * @property integer $jenisdiklat_id
 * @property string $norencanadiklat
 * @property string $tglrencanadiklat
 * @property string $rencanadiklat_periode
 * @property string $rencanadiklat_sampaidgn
 * @property integer $lamadiklat
 * @property string $satuan_lama
 * @property string $tempat_diklat
 * @property string $alamat_diklat
 * @property integer $pemberitugas_id
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property string $tglmengetahui
 * @property string $tglmenyetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $namadiklat
 * @property string $keterangan_diklat
 *
 * The followings are the available model relations:
 * @property PegawaidiklatT[] $pegawaidiklatTs
 */
class RencanadiklatT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanadiklatT the static model class
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
		return 'rencanadiklat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, jenisdiklat_id, norencanadiklat, tglrencanadiklat, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, jenisdiklat_id, lamadiklat, pemberitugas_id, mengetahui_id, menyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('norencanadiklat', 'length', 'max'=>50),
			array('satuan_lama', 'length', 'max'=>20),
			array('tempat_diklat, namadiklat', 'length', 'max'=>100),
			array('alamat_diklat, keterangan_diklat', 'length', 'max'=>500),
			array('rencanadiklat_periode, rencanadiklat_sampaidgn, tglmengetahui, tglmenyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanadiklat_id, pegawai_id, jenisdiklat_id, norencanadiklat, tglrencanadiklat, rencanadiklat_periode, rencanadiklat_sampaidgn, lamadiklat, satuan_lama, tempat_diklat, alamat_diklat, pemberitugas_id, mengetahui_id, menyetujui_id, tglmengetahui, tglmenyetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, namadiklat, keterangan_diklat', 'safe', 'on'=>'search'),
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
			'pegawaidiklatTs' => array(self::HAS_MANY, 'PegawaidiklatT', 'rencanadiklat_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'jenisdiklat' => array(self::BELONGS_TO, 'JenisdiklatM', 'jenisdiklat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanadiklat_id' => 'Rencanadiklat',
			'pegawai_id' => 'Pegawai',
			'jenisdiklat_id' => 'Jenisdiklat',
			'norencanadiklat' => 'No. Rencana',
			'tglrencanadiklat' => 'Tanggal Rencana',
			'rencanadiklat_periode' => 'Rencanadiklat Periode',
			'rencanadiklat_sampaidgn' => 'Rencanadiklat Sampaidgn',
			'lamadiklat' => 'Lamadiklat',
			'satuan_lama' => 'Satuan Lama',
			'tempat_diklat' => 'Tempat Diklat',
			'alamat_diklat' => 'Alamat Diklat',
			'pemberitugas_id' => 'Pemberi Tugas',
			'mengetahui_id' => 'Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'tglmengetahui' => 'Tanggal Mengetahui',
			'tglmenyetujui' => 'Tanggal Menyetujui',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'namadiklat' => 'Namadiklat',
			'keterangan_diklat' => 'Keterangan',
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

		if(!empty($this->rencanadiklat_id)){
			$criteria->addCondition('rencanadiklat_id = '.$this->rencanadiklat_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->jenisdiklat_id)){
			$criteria->addCondition('jenisdiklat_id = '.$this->jenisdiklat_id);
		}
		$criteria->compare('LOWER(norencanadiklat)',strtolower($this->norencanadiklat),true);
		$criteria->compare('LOWER(tglrencanadiklat)',strtolower($this->tglrencanadiklat),true);
		$criteria->compare('LOWER(rencanadiklat_periode)',strtolower($this->rencanadiklat_periode),true);
		$criteria->compare('LOWER(rencanadiklat_sampaidgn)',strtolower($this->rencanadiklat_sampaidgn),true);
		if(!empty($this->lamadiklat)){
			$criteria->addCondition('lamadiklat = '.$this->lamadiklat);
		}
		$criteria->compare('LOWER(satuan_lama)',strtolower($this->satuan_lama),true);
		$criteria->compare('LOWER(tempat_diklat)',strtolower($this->tempat_diklat),true);
		$criteria->compare('LOWER(alamat_diklat)',strtolower($this->alamat_diklat),true);
		if(!empty($this->pemberitugas_id)){
			$criteria->addCondition('pemberitugas_id = '.$this->pemberitugas_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		$criteria->compare('LOWER(tglmengetahui)',strtolower($this->tglmengetahui),true);
		$criteria->compare('LOWER(tglmenyetujui)',strtolower($this->tglmenyetujui),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('LOWER(namadiklat)',strtolower($this->namadiklat),true);
		$criteria->compare('LOWER(keterangan_diklat)',strtolower($this->keterangan_diklat),true);

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