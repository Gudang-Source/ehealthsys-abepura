<?php

/**
 * This is the model class for table "permintaankepenunjang_t".
 *
 * The followings are the available columns in table 'permintaankepenunjang_t':
 * @property integer $permintaankepenunjang_id
 * @property integer $daftartindakan_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $tindakanrm_id
 * @property integer $pemeriksaanrad_id
 * @property integer $pemeriksaanlab_id
 * @property integer $operasi_id
 * @property string $noperminatanpenujang
 * @property string $tglpermintaankepenunjang
 * @property integer $qtypermintaan
 * @property double $tarif_pelayananan
 *
 * The followings are the available model relations:
 * @property DaftartindakanM $daftartindakan
 * @property OperasiM $operasi
 * @property PasienkirimkeunitlainT $pasienkirimkeunitlain
 * @property PemeriksaanradM $pemeriksaanrad
 * @property PemeriksaanlabM $pemeriksaanlab
 * @property TindakanrmM $tindakanrm
 */
class MOPermintaankepenunjangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPermintaankepenunjangT the static model class
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
		return 'permintaankepenunjang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienkirimkeunitlain_id, noperminatanpenujang, tglpermintaankepenunjang, tarif_pelayananan', 'required'),
			array('daftartindakan_id, pasienkirimkeunitlain_id, tindakanrm_id, pemeriksaanrad_id, pemeriksaanlab_id, operasi_id, qtypermintaan', 'numerical', 'integerOnly'=>true),
			array('tarif_pelayananan', 'numerical'),
			array('noperminatanpenujang', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permintaankepenunjang_id, daftartindakan_id, pasienkirimkeunitlain_id, tindakanrm_id, pemeriksaanrad_id, pemeriksaanlab_id, operasi_id, noperminatanpenujang, tglpermintaankepenunjang, qtypermintaan, tarif_pelayananan', 'safe', 'on'=>'search'),
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
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'operasi' => array(self::BELONGS_TO, 'OperasiM', 'operasi_id'),
			'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
			'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
			'pemeriksaanlab' => array(self::BELONGS_TO, 'PemeriksaanlabM', 'pemeriksaanlab_id'),
			'tindakanrm' => array(self::BELONGS_TO, 'TindakanrmM', 'tindakanrm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaankepenunjang_id' => 'Permintaankepenunjang',
			'daftartindakan_id' => 'Daftartindakan',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'tindakanrm_id' => 'Tindakanrm',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'operasi_id' => 'Operasi',
			'noperminatanpenujang' => 'Noperminatanpenujang',
			'tglpermintaankepenunjang' => 'Tglpermintaankepenunjang',
			'qtypermintaan' => 'Qtypermintaan',
			'tarif_pelayananan' => 'Tarif Pelayananan',
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

		$criteria->compare('permintaankepenunjang_id',$this->permintaankepenunjang_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('tindakanrm_id',$this->tindakanrm_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
		$criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);
		$criteria->compare('qtypermintaan',$this->qtypermintaan);
		$criteria->compare('tarif_pelayananan',$this->tarif_pelayananan);

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