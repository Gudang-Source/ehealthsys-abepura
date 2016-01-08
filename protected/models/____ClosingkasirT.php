<?php

/**
 * This is the model class for table "closingkasir_t".
 *
 * The followings are the available columns in table 'closingkasir_t':
 * @property integer $closingkasir_id
 * @property integer $tandabuktibayar_id
 * @property integer $shift_id
 * @property string $tglclosingkasir
 * @property string $closingdari
 * @property string $sampaidengan
 * @property double $nilaiclosingtrans
 * @property double $closingsaldoawal
 * @property double $jmluanglogam
 * @property double $jmluangkertas
 * @property integer $tottransaksi
 * @property string $keterangan_closing
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ClosingkasirT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ClosingkasirT the static model class
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
		return 'closingkasir_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglclosingkasir, closingdari, sampaidengan, nilaiclosingtrans, closingsaldoawal, jmluanglogam, jmluangkertas, tottransaksi, create_time, update_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tandabuktibayar_id, shift_id, tottransaksi', 'numerical', 'integerOnly'=>true),
			array('nilaiclosingtrans, closingsaldoawal, jmluanglogam, jmluangkertas', 'numerical'),
			array('keterangan_closing, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('closingkasir_id, tandabuktibayar_id, shift_id, tglclosingkasir, closingdari, sampaidengan, nilaiclosingtrans, closingsaldoawal, jmluanglogam, jmluangkertas, tottransaksi, keterangan_closing, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'closingkasir_id' => 'Closing Kasir',
			'tandabuktibayar_id' => 'Tanda Bukti Bayar',
			'shift_id' => 'Shift',
			'tglclosingkasir' => 'Tanggal Closing Kasir',
			'closingdari' => 'Closingdari',
			'sampaidengan' => 'Sampai Dengan',
			'nilaiclosingtrans' => 'Nilai Closing Trans',
			'closingsaldoawal' => 'Closing Saldo Awal',
			'jmluanglogam' => 'Jml Uang Logam',
			'jmluangkertas' => 'Jml Uang Kertas',
			'tottransaksi' => 'Tot Transaksi',
			'keterangan_closing' => 'Keterangan Closing',
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

		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(tglclosingkasir)',strtolower($this->tglclosingkasir),true);
		$criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
		$criteria->compare('closingsaldoawal',$this->closingsaldoawal);
		$criteria->compare('jmluanglogam',$this->jmluanglogam);
		$criteria->compare('jmluangkertas',$this->jmluangkertas);
		$criteria->compare('tottransaksi',$this->tottransaksi);
		$criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
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
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(tglclosingkasir)',strtolower($this->tglclosingkasir),true);
		$criteria->compare('LOWER(closingdari)',strtolower($this->closingdari),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
		$criteria->compare('closingsaldoawal',$this->closingsaldoawal);
		$criteria->compare('jmluanglogam',$this->jmluanglogam);
		$criteria->compare('jmluangkertas',$this->jmluangkertas);
		$criteria->compare('tottransaksi',$this->tottransaksi);
		$criteria->compare('LOWER(keterangan_closing)',strtolower($this->keterangan_closing),true);
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
}