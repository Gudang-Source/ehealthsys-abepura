<?php

class BKRinciantagihanpasienpenunjangV extends RinciantagihanpasienpenunjangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
        public $totaltagihan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRincianTagihan()
        {
            $criteria=new CDbCriteria;
            $criteria->group = 'tgl_pendaftaran,no_pendaftaran, pendaftaran_id, no_rekam_medik, nama_pasien, nama_bin ,pendaftaran_id, carabayar_nama, ruangan_nama, pembayaranpelayanan_id, instalasi_id, instalasi_nama';
            $criteria->select = $criteria->group.' , sum(tarif_tindakan) as totaltagihan';
            $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition("tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);					
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
            $criteria->compare('tarif_tindakan',$this->tarif_tindakan);
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);					
			}
			$ruangans = array();
			$criteria_ruangan = new CDbCriteria();
			$criteria_ruangan->addNotInCondition("instalasi_id",array(Params::INSTALASI_ID_RI, 
															Params::INSTALASI_ID_RJ, 
															Params::INSTALASI_ID_RD));
			$modRuangans = RuanganM::model()->findAll($criteria_ruangan);
			if(count($modRuangans) > 0){
				foreach($modRuangans AS $ruangan){
					$ruangans[$ruangan->ruangan_id] = $ruangan->ruangan_id;
				}
			}
			
            $criteria->addInCondition('ruanganpendaftaran_id', $ruangans);
            $criteria->addInCondition('ruanganpenunjang_id',  $ruangans);
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            if ($this->statusBayar == 'LUNAS'){
                $criteria->addCondition('pembayaranpelayanan_id is not null');
            }else if ($this->statusBayar == 'BELUM LUNAS'){
                $criteria->addCondition('pembayaranpelayanan_id is null');
            }
            $criteria->order = 'pendaftaran_id';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        public function getNamaNamaBIN()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getAlamatRTRW()
        {
            return $this->alamat_pasien.'<br>'.$this->rt.' / '.$this->rw;
        }
        
        public function getNoRMNoPend(){
            return $this->no_rekam_medik.'<br/>'.$this->no_pendaftaran;
        }
        
        public function getTglMasukNoPenunjang(){
            return $this->tglmasukpenunjang.'<br/>'.PHP_EOL.$this->no_masukpenunjang;
        }
        
        public function getJenisKelaminUmur(){
            return $this->jeniskelamin.'<br/>'.$this->umur;
        }
        public function getInstalasiRuangan(){
            return $this->instalasiasal_nama.'<br/>'.$this->ruanganasal_nama;
        }
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
}

?>
