<?php

class BKTandabuktibayarT extends TandabuktibayarT {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktibayarT the static model class
	 */
	public $tgl_awal;
	public $tgl_akhir;
	public $is_menggunakankartu;
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'ruangan_id' => 'Ruangan',
			'pembatalanuangmuka_id' => 'Pembatalanuangmuka',
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'closingkasir_id' => 'Closingkasir',
			'returpenerimaanumum_id' => 'Returpenerimaanumum',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'returbayarpelayanan_id' => 'Returbayarpelayanan',
			'shift_id' => 'Shift',
			'nourutkasir' => 'No Urut Kasir',
			'nobuktibayar' => 'No Bukti Bayar',
			'tglbuktibayar' => 'Tanggal Bukti Bayar',
			'carapembayaran' => 'Cara Pembayaran',
			'dengankartu' => 'Kartu / Transfer',
			'bankkartu' => 'Nama Bank',
			'nokartu' => 'No. Kartu / No. Rekening Pengirim',
			'nostrukkartu' => 'No. Struk / No. Transfer',
			'darinama_bkm' => 'Dari Nama',
			'alamat_bkm' => 'Alamat',
			'sebagaipembayaran_bkm' => 'Sebagai Pembayaran',
			'jmlpembulatan' => 'Jumlah Pembulatan',
			'jmlpembayaran' => 'Jumlah Pembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biaya Materai',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uang Kembalian',
			'keterangan_pembayaran' => 'Keterangan Pembayaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'isprint' => 'Isprint',
			'pembayarankapitasidetail_id' => 'Pembayarankapitasidetail',
			'bank_id' => 'Bank',
		);
	}
	
	public function searchTable() {
		$criteria = new CDbCriteria;

                $criteria->join .= "left join loginpemakai_k p on p.loginpemakai_id = t.create_loginpemakai_id";
                
		if (!empty($this->shift_id)) {
			$criteria->addCondition("t.shift_id = " . $this->shift_id);
		}
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition("t.ruangan_id = " . $this->ruangan_id);
		}
                if (!empty($this->create_loginpemakai_id)) {
			$criteria->addCondition("p.pegawai_id = " . $this->create_loginpemakai_id);
		}
                
		$criteria->addBetweenCondition('DATE(t.tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('t.closingkasir_id IS NULL AND t.pembatalanuangmuka_id IS NULL');
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function getRuanganKasir() {
		return RuanganM::model()->findAllByAttributes(array('instalasi_id' => Params::INSTALASI_ID_KASIR));
	}

}
