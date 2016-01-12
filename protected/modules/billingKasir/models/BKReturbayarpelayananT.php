<?php

/**
 * This is the model class for table "returbayarpelayanan_t".
 *
 * The followings are the available columns in table 'returbayarpelayanan_t':
 * @property integer $returbayarpelayanan_id
 * @property integer $tandabuktikeluar_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property double $totaltindakanretur
 * @property double $totalbiayaretur
 * @property double $biayaadministrasi
 * @property string $keteranganretur
 * @property integer $user_nm_otorisasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BKReturbayarpelayananT extends ReturbayarpelayananT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturbayarpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}