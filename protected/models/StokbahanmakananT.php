<?php

/**
 * This is the model class for table "stokbahanmakanan_t".
 *
 * The followings are the available columns in table 'stokbahanmakanan_t':
 * @property integer $stokbahanmakanan_id
 * @property integer $terimabahandetail_id
 * @property integer $bahanmakanan_id
 * @property string $tgltransaksi
 * @property double $qty_masuk
 * @property double $qty_keluar
 * @property string $keterangan_makanan
 */
class StokbahanmakananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StokbahanmakananT the static model class
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
		return 'stokbahanmakanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanmakanan_id, tgltransaksi, qty_masuk, qty_keluar', 'required'),
			array('terimabahandetail_id, bahanmakanan_id', 'numerical', 'integerOnly'=>true),
			array('qty_masuk, qty_keluar, qty_current', 'numerical'),
			array('keterangan_makanan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('stokbahanmakanan_id, terimabahandetail_id, bahanmakanan_id, tgltransaksi, qty_masuk, qty_keluar, keterangan_makanan', 'safe', 'on'=>'search'),
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
			'stokbahanmakanan_id' => 'Stok Bahan Makanan',
			'terimabahandetail_id' => 'Terima Bahan Detail',
			'bahanmakanan_id' => 'Bahan Makanan',
			'tgltransaksi' => 'Tanggal Transaksi',
			'qty_masuk' => 'Jumlah Masuk',
			'qty_keluar' => 'Jumlah Keluar',
			'keterangan_makanan' => 'Keterangan Makanan',
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

		$criteria->compare('stokbahanmakanan_id',$this->stokbahanmakanan_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('qty_masuk',$this->qty_masuk);
		$criteria->compare('qty_keluar',$this->qty_keluar);
		$criteria->compare('LOWER(keterangan_makanan)',strtolower($this->keterangan_makanan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('stokbahanmakanan_id',$this->stokbahanmakanan_id);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('LOWER(tgltransaksi)',strtolower($this->tgltransaksi),true);
		$criteria->compare('qty_masuk',$this->qty_masuk);
		$criteria->compare('qty_keluar',$this->qty_keluar);
		$criteria->compare('LOWER(keterangan_makanan)',strtolower($this->keterangan_makanan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function validasiStok($qty, $id) {
            $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar FROM stokbahanmakanan_t WHERE bahanmakanan_id = $id ORDER BY tgltransaksi";
            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
            $selesai = false;
            $hasil = true;
            $out = 0;
            $in = 0;
            
            if (count($stoks) == 0){
                $hasil = false;
            }
            foreach ($stoks as $i => $stok) {
                  $in += $stok['qty_masuk'];
                  $out += $stok['qty_keluar'];
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
        
        public static function kurangiStokMenu($qty, $id) { //id = $menudiet_id; $qty = jumlahkirim
            $bahanMakanan = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$id));
            if (count($bahanMakanan) > 0){
                foreach ($bahanMakanan as $row){
                    $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar, qty_current FROM stokbahanmakanan_t WHERE bahanmakanan_id = $row->bahanmakanan_id ORDER BY tgltransaksi";
                    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
                    $selesai = false;
                    $qty = $qty*$row->jmlbahan;
                    foreach ($stoks as $i => $stok) {                        
                        if ($qty <= $stok['qty_current']) {
                            $stok_current = $stok['qty_current'] - $qty;
                            $stok_out = $stok['qty_keluar'] + $qty;
                            StokbahanmakananT::model()->updateByPk($stok['stokbahanmakanan_id'], array('qty_current' => $stok_current, 'qty_keluar' => $stok_out));
                            $selesai = true;
                            break;
                        } else {
                            $qty = $qty - $stok['qty_current'];
                            $stok_current = 0;
                            $stok_out = $stok['qty_keluar'] + $stok['qty_current'];
                            StokbahanmakananT::model()->updateByPk($stok['stokbahanmakanan_id'], array('qty_current' => $stok_current, 'qty_keluar' => $stok_out));
                        }
                    }
                }
            }
            else{
                return false;
            }
        }
        
        public static function validasiStokMenu($qty, $id) { // id = menudiet_id
            $hasil = "";
            $bahanMakanan = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id'=>$id));
            if (count($bahanMakanan) > 0){
                foreach ($bahanMakanan as $row){
                    $sql = "SELECT stokbahanmakanan_id,qty_masuk,qty_keluar FROM stokbahanmakanan_t WHERE bahanmakanan_id = $row->bahanmakanan_id ORDER BY tgltransaksi";
                    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
                    $selesai = false;
                    $hasil = true;
                    $out = 0;
                    $in = 0;
                    $qty = $qty*$row->jmlbahan;
                    if (count($stoks) == 0){
                        $hasil = false;
                    }
                    foreach ($stoks as $i => $stok) {
                          $in += $stok['qty_masuk'];
                          $out += $stok['qty_keluar'];
                    }
                    $selisih = $in - $out;
                    $selisih = $selisih-$qty;

                    if ($selisih < 0){
                        $hasil = false;
                    } else {
                        $hasil = true;
                    }
                }
            }

            return $hasil;
        }
}