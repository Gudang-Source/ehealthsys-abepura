<?php
class FAInformasikasirinappulangV extends InformasikasirinappulangV
{
        public $ceklis, $tgl_awalAdmisi, $tgl_akhirAdmisi;
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRI()
	{

            $criteria=new CDbCriteria;

            if($this->ceklis==0){
                    $criteria->addBetweenCondition('DATE(t.tglpulang)',$this->tgl_awal,$this->tgl_akhir);	
            }else{
                    $criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awalAdmisi,$this->tgl_akhirAdmisi);	
            }

            $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
            $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);						
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);						
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);						
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);						
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);						
			}
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$this->propinsi_id);						
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);						
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);						
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);						
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);						
			}
            $criteria->order = 'tgladmisi DESC';
            //$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        public function getCombineTglPendaftaran()
        {
            $this->tgladmisi = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($this->tgladmisi, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');
            $this->tglpulang = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($this->tglpulang, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');
            return $this->tgladmisi.' <br> '.$this->tglpulang;
        }        

        public function getFarmasiStatus($id){
            $modPendaftaran = PendaftaranT::model()->findByPK($id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            
            $true = 'APPROVE';
            $false = 'VERIFIKASI';
            if($modAdmisi->statusfarmasi == true){
                $status = '<button id="green" class="btn btn-danger" name="yt1">'.$true.'</button>';
            }else{
                $status = '<button id="red" class="btn btn-primary" name="yt1" onclick="ubahStatusFarmasi('.$id.')">'.$false.'</button>';
            }
        return $status;
    }
	
}