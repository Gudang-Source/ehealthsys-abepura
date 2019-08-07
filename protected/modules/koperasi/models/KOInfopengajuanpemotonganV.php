<?php

class KOInfopengajuanpemotonganV extends InfopengajuanpemotonganV
{
	public $tgl_awal;
        public $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
         public function searchInformasi() {
		$criteria = new CDbCriteria();
                $criteria->addBetweenCondition('tglpengajuanpemb', $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59');
                $criteria->compare('LOWER(nopengajuan)',  strtolower($this->nopengajuan),true);
                $criteria->compare('LOWER(nokeanggotaan)',  strtolower($this->nokeanggotaan),true);
                $criteria->compare('LOWER(nama_pegawai)',  strtolower($this->nama_pegawai),true);
                
                if (!empty($this->potongansumber_id)){
                    $criteria->addCondition("potongansumber_id = '".$this->potongansumber_id."' ");
                }
                        
		$criteria->select = $criteria->group =
		'nopengajuan, tglpengajuanpemb,namapotongan, nokeanggotaan, nama_pegawai,
		simpananwajib, simpanansukarela, jmlpokok_pengangs, jmljasaangs_pengangs, jmljasaangs_pengangs,
		jmlpengajuan_pengangsuran, jmlpengajuan_pengangsuran, pengajuanpembayaran_id, potongansumber_id, jmldendaangs_pengangs
		 ';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}