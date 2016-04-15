<?php

/**
 * This is the model class for table "masterakunrekening_v".
 *
 * The followings are the available columns in table 'masterakunrekening_v':
 * @property integer $akun
 * @property integer $id
 * @property string $kode
 * @property string $nama
 * @property string $saldo_normal
 * @property boolean $aktif
 * @property string $keterangan
 */
class MasterakunrekeningV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MasterakunrekeningV the static model class
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
		return 'masterakunrekening_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('akun, id', 'numerical', 'integerOnly'=>true),
			array('kode, nama, saldo_normal, aktif, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('akun, id, kode, nama, saldo_normal, aktif, keterangan', 'safe', 'on'=>'search'),
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
			'akun' => 'Akun',
			'id' => 'ID',
			'kode' => 'Kode',
			'nama' => 'Nama',
			'saldo_normal' => 'Saldo Normal',
			'aktif' => 'Aktif',
			'keterangan' => 'Keterangan',
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

		$criteria->compare('akun',$this->akun);
		$criteria->compare('id',$this->id);
		$criteria->compare('kode',$this->kode,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('saldo_normal',$this->saldo_normal,true);
		$criteria->compare('aktif',$this->aktif);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint() {
                $provider = $this->search();
                $provider->criteria->limit = -1;
                $provider->pagination = false;
                
                return $provider;
        }
}