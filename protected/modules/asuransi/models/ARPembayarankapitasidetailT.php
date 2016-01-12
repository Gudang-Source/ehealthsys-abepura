<?php

/**
 * This is the model class for table "pembayarankapitasidetail_t".
 *
 * The followings are the available columns in table 'pembayarankapitasidetail_t':
 * @property integer $pembayarankapitasidetail_id
 * @property integer $pembayarankapitasi_id
 * @property integer $pendaftaran_id
 * @property double $pembayarankapitasidetail_totalpembayaran
 *
 * The followings are the available model relations:
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property TandabuktibayarT[] $tandabuktibayarTs
 * @property PembayarankapitasiT $pembayarankapitasi
 * @property PendaftaranT $pendaftaran
 */
class ARPembayarankapitasidetailT extends PembayarankapitasidetailT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayarankapitasidetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}