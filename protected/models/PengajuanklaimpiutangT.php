<?php

/**
 * This is the model class for table "pengajuanklaimpiutang_t".
 *
 * The followings are the available columns in table 'pengajuanklaimpiutang_t':
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property double $totalsisapiutang
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengajuanklaimdetailT[] $pengajuanklaimdetailTs
 * @property PembayarklaimT[] $pembayarklaimTs
 * @property CarabayarM $carabayar
 * @property PenjaminpasienM $penjamin
 */
class PengajuanklaimpiutangT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanklaimpiutangT the static model class
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
		return 'pengajuanklaimpiutang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamin_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim', 'required'),
			array('carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalsisapiutang', 'numerical'),
			array('nopengajuanklaimanklaim', 'length', 'max'=>50),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanklaimpiutang_id, carabayar_id, penjamin_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, totalsisapiutang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pengajuanklaimdetailTs' => array(self::HAS_MANY, 'PengajuanklaimdetailT', 'pengajuanklaimpiutang_id'),
			'pembayarklaimTs' => array(self::HAS_MANY, 'PembayarklaimT', 'pengajuanklaimpiutang_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanklaimpiutang_id' => 'Pengajuanklaimpiutang',
			'carabayar_id' => 'Carabayar',
			'penjamin_id' => 'Penjamin',
			'tglpengajuanklaimanklaim' => 'Tglpengajuanklaimanklaim',
			'nopengajuanklaimanklaim' => 'Nopengajuanklaimanklaim',
			'totalpiutang' => 'Totalpiutang',
			'totalsisapiutang' => 'Totalsisapiutang',
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

		$criteria->compare('pengajuanklaimpiutang_id',$this->pengajuanklaimpiutang_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('tglpengajuanklaimanklaim',$this->tglpengajuanklaimanklaim,true);
		$criteria->compare('nopengajuanklaimanklaim',$this->nopengajuanklaimanklaim,true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}