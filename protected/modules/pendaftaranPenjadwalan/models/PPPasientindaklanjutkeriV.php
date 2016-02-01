<?php

class PPPasientindaklanjutkeriV extends PasientindaklanjutkeriV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasientindaklanjutkeriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * menampilkan data kunjungan pasien untuk transaksi pendaftaran rawat inap (dari RJ / RD)
         * model & criteria hampir sama dengan PendaftaranRawatInapDariRJRDController/AutocompletePasienRJRD
         * @return \CActiveDataProvider
         */
        public function searchDialogUntukPendaftaranRI(){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
			
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
			}
            $criteria->compare('DATE(tanggal_lahir)',$format->formatDateTimeForDb($this->tanggal_lahir));
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
            $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
            $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
            $criteria->compare('kecamatan_id', $this->kecamatan_id);
            $criteria->compare('kelurahan_id', $this->kelurahan_id);
            $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->order = 'tgl_pendaftaran DESC';
            // $criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
?>
