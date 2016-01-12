<?php

/**
 * This is the model class for table "pembayarankapitasi_t".
 *
 * The followings are the available columns in table 'pembayarankapitasi_t':
 * @property integer $pembayarankapitasi_id
 * @property string $pembayarankapitasi_no
 * @property string $pembayarankapitasi_tgl
 * @property double $pembayarankapitasi_totaltarifkapitasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PembayarankapitasidetailT[] $pembayarankapitasidetailTs
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class ARPembayarankapitasiT extends PembayarankapitasiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayarankapitasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function getPendaftaran($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, $no_pendaftaran){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_awal, $tgl_akhir,true);
		if(isset($no_pendaftaran)){
			$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($no_pendaftaran),true);
		}
		if(!empty($carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$carabayar_id);
		}
		if(!empty($penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$penjamin_id);
		}
		$criteria->join = 'JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';
		$modPendaftarans = ARPendaftaranT::model()->findAll($criteria);
		
		return $modPendaftarans;
	}

}