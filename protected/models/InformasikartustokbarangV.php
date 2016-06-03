<?php

/**
 * This is the model class for table "informasikartustokbarang_v".
 *
 * The followings are the available columns in table 'informasikartustokbarang_v':
 * @property integer $barang_id
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_satuan
 * @property integer $invbarang_id
 * @property string $invbarang_tgl
 * @property integer $invbarangdet_id
 * @property double $harga_netto
 * @property double $jumlah
 * @property boolean $status
 * @property string $uraian
 */
class InformasikartustokbarangV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikartustokbarangV the static model class
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
		return 'informasikartustokbarang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, invbarang_id, invbarangdet_id', 'numerical', 'integerOnly'=>true),
			array('harga_netto, jumlah', 'numerical'),
			array('barang_kode, barang_satuan', 'length', 'max'=>50),
			array('barang_nama', 'length', 'max'=>100),
			array('invbarang_tgl, status, uraian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_id, barang_kode, barang_nama, barang_satuan, invbarang_id, invbarang_tgl, invbarangdet_id, harga_netto, jumlah, status, uraian', 'safe', 'on'=>'search'),
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
			'barang_id' => 'Barang',
			'barang_kode' => 'Barang Kode',
			'barang_nama' => 'Barang Nama',
			'barang_satuan' => 'Barang Satuan',
			'invbarang_id' => 'Invbarang',
			'invbarang_tgl' => 'Invbarang Tgl',
			'invbarangdet_id' => 'Invbarangdet',
			'harga_netto' => 'Harga Netto',
			'jumlah' => 'Jumlah',
			'status' => 'Status',
			'uraian' => 'Uraian',
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

		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('barang_kode',$this->barang_kode,true);
		$criteria->compare('barang_nama',$this->barang_nama,true);
		$criteria->compare('barang_satuan',$this->barang_satuan,true);
		$criteria->compare('invbarang_id',$this->invbarang_id);
		$criteria->compare('invbarang_tgl',$this->invbarang_tgl,true);
		$criteria->compare('invbarangdet_id',$this->invbarangdet_id);
		$criteria->compare('harga_netto',$this->harga_netto);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('status',$this->status);
		$criteria->compare('uraian',$this->uraian,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}