<?php

class BKRinciantagihanpasienpenunjangV extends RinciantagihanpasienpenunjangV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakankomponenT the static model class
	 */
        public $totaltagihan;
        public $is_sudahbayar;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRincianTagihan()
        {
            $criteria=new CDbCriteria;
            
            $str_bayar = '(case when t.tindakansudahbayar_id is null then true else false end)';
            
            $criteria->group = 't.tgl_pendaftaran,t.no_pendaftaran, t.pendaftaran_id, t.no_rekam_medik, t.nama_pasien, t.nama_bin ,t.pendaftaran_id, t.carabayar_nama, t.penjamin_nama, t.ruangan_nama, t.pembayaranpelayanan_id, t.instalasi_id, t.instalasi_nama, '
                    . $str_bayar;
            $criteria->select = $criteria->group.' , sum(case when t.tindakansudahbayar_id is null then t.tarif_tindakan else 0 end) as totaltagihan, '
                    . $str_bayar;
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('date(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            }
            $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);					
			}
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition("t.tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);					
			}
            $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);					
			}
            $criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
            $criteria->compare('t.tarif_tindakan',$this->tarif_tindakan);
            $criteria->compare('p.pegawai_id', $this->pegawai_id);
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("t.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);					
			}
                        /*
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
			} */
			
            //$criteria->addInCondition('ruanganpendaftaran_id', $ruangans);
            //$criteria->addInCondition('ruanganpenunjang_id',  $ruangans);
            $criteria->compare('t.ruangan_id', $this->ruangan_id);
            $criteria->compare('r.instalasi_id', $this->instalasi_id);
            $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            
            $criteria->join = "join ruangan_m r on r.ruangan_id = t.ruangan_id "
                    . "left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
            
            if ($this->statusBayar == 'LUNAS'){
                $criteria->addCondition($str_bayar.' = false');
            }else if ($this->statusBayar == 'BELUM LUNAS'){
                $criteria->addCondition($str_bayar.' = true');
            }
            $criteria->order = 't.pendaftaran_id';
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
