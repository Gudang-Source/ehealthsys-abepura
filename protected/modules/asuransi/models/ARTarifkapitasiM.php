<?php

/**
 * This is the model class for table "tarifkapitasi_m".
 *
 * The followings are the available columns in table 'tarifkapitasi_m':
 * @property integer $tarifkapitasi_id
 * @property string $tarifkapitasi_nama
 * @property string $tarifkapitasi_namalain
 * @property double $tarifkapitasi_nominal
 * @property string $tarifkapitasi_keterangan
 * @property boolean $tarifkapitasi_aktif
 */
class ARTarifkapitasiM extends TarifkapitasiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarifkapitasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
}