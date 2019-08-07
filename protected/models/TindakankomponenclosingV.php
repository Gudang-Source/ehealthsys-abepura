<?php

/**
 * This is the model class for table "tindakankomponenclosing_v".
 *
 * The followings are the available columns in table 'tindakankomponenclosing_v':
 * @property integer $closingkasir_id
 * @property string $tglclosingkasir
 * @property integer $ruangan_id
 * @property string $ruangan_tindakan
 * @property integer $ruangandaftar_id
 * @property string $ruangan_daftar
 * @property integer $pasien_id
 * @property string $statuspasien
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponenunit_id
 * @property string $komponenunit_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property double $tarif_tindakankomp
 * @property double $iurbiayakomp
 */
class TindakankomponenclosingV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenclosingV the static model class
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
		return 'tindakankomponenclosing_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('closingkasir_id, ruangan_id, ruangandaftar_id, pasien_id, carabayar_id, penjamin_id, kelompoktindakan_id, komponenunit_id, kategoritindakan_id', 'numerical', 'integerOnly'=>true),
			array('tarif_tindakankomp, iurbiayakomp', 'numerical'),
			array('ruangan_tindakan, ruangan_daftar, statuspasien, kelompoktindakan_nama', 'length', 'max'=>50),
			array('komponenunit_nama', 'length', 'max'=>30),
			array('kategoritindakan_nama', 'length', 'max'=>150),
			array('tglclosingkasir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('closingkasir_id, tglclosingkasir, ruangan_id, ruangan_tindakan, ruangandaftar_id, ruangan_daftar, pasien_id, statuspasien, carabayar_id, penjamin_id, kelompoktindakan_id, kelompoktindakan_nama, komponenunit_id, komponenunit_nama, kategoritindakan_id, kategoritindakan_nama, tarif_tindakankomp, iurbiayakomp', 'safe', 'on'=>'search'),
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
			'closingkasir_id' => 'Closingkasir',
			'tglclosingkasir' => 'Tglclosingkasir',
			'ruangan_id' => 'Ruangan',
			'ruangan_tindakan' => 'Ruangan Tindakan',
			'ruangandaftar_id' => 'Ruangandaftar',
			'ruangan_daftar' => 'Ruangan Daftar',
			'pasien_id' => 'Pasien',
			'statuspasien' => 'Statuspasien',
			'carabayar_id' => 'Carabayar',
			'penjamin_id' => 'Penjamin',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'komponenunit_id' => 'Komponenunit',
			'komponenunit_nama' => 'Komponenunit Nama',
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'tarif_tindakankomp' => 'Tarif Tindakankomp',
			'iurbiayakomp' => 'Iurbiayakomp',
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

		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('tglclosingkasir',$this->tglclosingkasir,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_tindakan',$this->ruangan_tindakan,true);
		$criteria->compare('ruangandaftar_id',$this->ruangandaftar_id);
		$criteria->compare('ruangan_daftar',$this->ruangan_daftar,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('kelompoktindakan_nama',$this->kelompoktindakan_nama,true);
		$criteria->compare('komponenunit_id',$this->komponenunit_id);
		$criteria->compare('komponenunit_nama',$this->komponenunit_nama,true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('kategoritindakan_nama',$this->kategoritindakan_nama,true);
		$criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
		$criteria->compare('iurbiayakomp',$this->iurbiayakomp);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}