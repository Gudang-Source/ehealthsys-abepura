<?php

/**
 * This is the model class for table "inventarisasiruangan_t".
 *
 * The followings are the available columns in table 'inventarisasiruangan_t':
 * @property integer $inventarisasi_id
 * @property integer $terimapersdetail_id
 * @property integer $mutasibrgdetail_id
 * @property integer $barang_id
 * @property integer $ruangan_id
 * @property integer $batalmutasibrg_id
 * @property string $tgltransaksi
 * @property string $inventarisasi_kode
 * @property double $inventarisasi_hargabeli
 * @property double $inventarisasi_hargasatuan
 * @property double $inventarisasi_qty_in
 * @property double $inventarisasi_qty_out
 * @property double $inventarisasi_qty_skrg
 * @property double $inventarisasi_jmlmin
 * @property string $inventarisasi_keadaan
 * @property string $inventarisasi_keterangan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InventarisasiruanganT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InventarisasiruanganT the static model class
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
		return 'inventarisasiruangan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, ruangan_id, tgltransaksi, inventarisasi_kode, inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_keadaan', 'required'),
			array('terimapersdetail_id, mutasibrgdetail_id, barang_id, ruangan_id, batalmutasibrg_id', 'numerical', 'integerOnly'=>true),
			array('inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_jmlmin', 'numerical'),
			array('inventarisasi_kode, inventarisasi_keadaan', 'length', 'max'=>50),
			array('inventarisasi_keterangan, update_time, update_loginpemakai_id', 'safe'),
                        array('create_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_time', 'default','value'=>date('Y-m-d H:i:s', time()), 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false, 'on'=>'insert, update'),
                        array('create_ruangan', 'default','value'=>Yii::app()->user->getState('ruangan_id'), 'setOnEmpty'=>false, 'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inventarisasi_id, terimapersdetail_id, mutasibrgdetail_id, barang_id, ruangan_id, batalmutasibrg_id, tgltransaksi, inventarisasi_kode, inventarisasi_hargabeli, inventarisasi_hargasatuan, inventarisasi_qty_in, inventarisasi_qty_out, inventarisasi_qty_skrg, inventarisasi_jmlmin, inventarisasi_keadaan, inventarisasi_keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'inventarisasi_id' => 'Inventarisasi',
			'terimapersdetail_id' => 'Terimapersdetail',
			'mutasibrgdetail_id' => 'Mutasibrgdetail',
			'barang_id' => 'Barang',
			'ruangan_id' => 'Ruangan',
			'batalmutasibrg_id' => 'Batalmutasibrg',
			'tgltransaksi' => 'Tgltransaksi',
			'inventarisasi_kode' => 'Inventarisasi Kode',
			'inventarisasi_hargabeli' => 'Inventarisasi Hargabeli',
			'inventarisasi_hargasatuan' => 'Inventarisasi Hargasatuan',
			'inventarisasi_qty_in' => 'Inventarisasi Jumlah In',
			'inventarisasi_qty_out' => 'Inventarisasi Jumlah Out',
			'inventarisasi_qty_skrg' => 'Inventarisasi Jumlah Skrg',
			'inventarisasi_jmlmin' => 'Inventarisasi Jmlmin',
			'inventarisasi_keadaan' => 'Inventarisasi Keadaan',
			'inventarisasi_keterangan' => 'Inventarisasi Keterangan',
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

		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('LOWER(inventarisasi_kode)',strtolower($this->inventarisasi_kode),true);
		$criteria->compare('inventarisasi_hargabeli',$this->inventarisasi_hargabeli);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_jmlmin',$this->inventarisasi_jmlmin);
		$criteria->compare('LOWER(inventarisasi_keadaan)',strtolower($this->inventarisasi_keadaan),true);
		$criteria->compare('LOWER(inventarisasi_keterangan)',strtolower($this->inventarisasi_keterangan),true);
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
		$criteria->compare('inventarisasi_id',$this->inventarisasi_id);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('mutasibrgdetail_id',$this->mutasibrgdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('batalmutasibrg_id',$this->batalmutasibrg_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('LOWER(inventarisasi_kode)',strtolower($this->inventarisasi_kode),true);
		$criteria->compare('inventarisasi_hargabeli',$this->inventarisasi_hargabeli);
		$criteria->compare('inventarisasi_hargasatuan',$this->inventarisasi_hargasatuan);
		$criteria->compare('inventarisasi_qty_in',$this->inventarisasi_qty_in);
		$criteria->compare('inventarisasi_qty_out',$this->inventarisasi_qty_out);
		$criteria->compare('inventarisasi_qty_skrg',$this->inventarisasi_qty_skrg);
		$criteria->compare('inventarisasi_jmlmin',$this->inventarisasi_jmlmin);
		$criteria->compare('LOWER(inventarisasi_keadaan)',strtolower($this->inventarisasi_keadaan),true);
		$criteria->compare('LOWER(inventarisasi_keterangan)',strtolower($this->inventarisasi_keterangan),true);
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
        
        public static function validasiStok($qty, $id){
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            $hasil = true;
            $out = 0;
            $in = 0;
            if (count($stoks) == 0){
                $hasil = false;
            }
            foreach ($stoks as $i => $stok) {
                  $in += $stok['inventarisasi_qty_in'];
                  $out += $stok['inventarisasi_qty_out'];
            }
            $selisih = $in - $out;
            $selisih = $selisih-$qty;

            if ($selisih < 0){
                $hasil = false;
            } else {
                $hasil = true;
            }

            return $hasil;
        }
        
        public static function kurangiStok($qty, $id) {
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_skrg']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] - $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] + $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_skrg'];
                    $stok_current = 0;
                    $stok_out = $stok['inventarisasi_qty_out'] + $stok['inventarisasi_qty_skrg'];
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }
        
        public static function kembalikanStok($qty, $id){
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE barang_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_out']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] + $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] - $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_out'];
                    $stok_current = $stok['inventarisasi_qty_out'];
                    $stok_out = 0;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }
        
        public static function kurangiStokBerdasarkanInventaris($qty, $id) {
            $sql = "SELECT inventarisasi_id,inventarisasi_qty_in,inventarisasi_qty_out,inventarisasi_qty_skrg FROM inventarisasiruangan_t WHERE inventarisasi_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            foreach ($stoks as $i => $stok) {
                if ($qty <= $stok['inventarisasi_qty_skrg']) {
                    $stok_current = $stok['inventarisasi_qty_skrg'] - $qty;
                    $stok_out = $stok['inventarisasi_qty_out'] + $qty;
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                    $selesai = true;
                    break;
                } else {
                    $qty = $qty - $stok['inventarisasi_qty_skrg'];
                    $stok_current = 0;
                    $stok_out = $stok['inventarisasi_qty_out'] + $stok['inventarisasi_qty_skrg'];
                    InventarisasiruanganT::model()->updateByPk($stok['inventarisasi_id'], array('inventarisasi_qty_skrg' => $stok_current, 'inventarisasi_qty_out' => $stok_out));
                }
            }
        }

}