<?php

/**
 * This is the model class for table "ruangan_m".
 *
 * The followings are the available columns in table 'ruangan_m':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_jenispelayanan
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 * @property string $ruangan_singkatan
 * @property integer $riwayatruangan_id
 * @property string $ruangan_fasilitas
 * @property string $ruangan_image
 */
class ANRuanganM extends RuanganM
{
       /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}