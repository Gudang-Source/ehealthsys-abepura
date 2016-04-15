<?php

class FAInformasipenjualanresepV extends InformasipenjualanaresepV
{
        public $tgl_awal;
        public $tgl_akhir;
        public $umur;
        public $returresep_id;
        public $jenispenjualan;
        public $jenisPenjualan;
        public $ruanganasalobat;
        public $alasanretur;
        public $namaDokter;
        public $tgl_pendaftaran;
        public $no_pendaftaran;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        public function searchInfoJualResep()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = array('t.gelardepan, t.gelarbelakang_nama, t.racikanantrian_singkatan, t.carabayar_nama, t.penjamin_nama, t.noantrian, t.panggilantrian, t.antrianlewat, t.pendaftaran_id, penjualanresep_t.jenispenjualan','penjualanresep_t.returresep_id',' t.jenispenjualan','t.penjualanresep_id','t.pasien_id','t.pegawai_id', 't.nama_pegawai','t.alamat_pasien','t.no_rekam_medik','t.namadepan','t.nama_pasien','t.nama_bin','t.tanggal_lahir',
                                          't.noresep','t.totharganetto','t.totalhargajual','t.instalasiasal_nama','t.ruanganasal_nama','t.reseptur_id',
                                          't.tglpenjualan','(pendaftaran_t.umur) as umur','t.jeniskelamin','t.tglresep, t.create_ruangan,t.antrianfarmasi_id');
                $criteria->group = 't.gelardepan, t.gelarbelakang_nama, t.racikanantrian_singkatan, t.carabayar_nama, t.penjamin_nama, t.noantrian, t.panggilantrian, t.antrianlewat, t.pendaftaran_id, penjualanresep_t.jenispenjualan, penjualanresep_t.returresep_id, t.jenispenjualan, t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.tanggal_lahir, t.noresep, t.totharganetto,
                                    t.totalhargajual, t.instalasiasal_nama, t.ruanganasal_nama, t.penjualanresep_id, t.reseptur_id, t.pegawai_id, t.nama_pegawai, t.tglpenjualan, t.pasien_id,pendaftaran_t.umur, t.jeniskelamin, t.alamat_pasien, t.tglresep, t.create_ruangan,t.antrianfarmasi_id';
                $criteria->join = 'LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id LEFT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id';
                //HARUSNYA JANGAN ADA JOIN DI MODEL YANG MEMANGGIL VIEW TABLE (DB), JIKA ADA YG PERLU DI TAMBAHKAN HUBUNGI ANALIS
                $criteria->order = 't.tglpenjualan, t.noantrian ASC';
                $criteria->addBetweenCondition('DATE(t.tglpenjualan)',  $this->tgl_awal, $this->tgl_akhir);
		if(empty($this->jenispenjualan))
                   $criteria->addInCondition ('LOWER(t.jenispenjualan)', array('penjualan resep', 'penjualan resep luar', 'penjualan bebas'));
                else
                    $criteria->compare('LOWER(t.jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
		$criteria->compare('t.totharganetto',$this->totharganetto);
		$criteria->compare('t.totalhargajual',$this->totalhargajual);
                $criteria->compare('t.carabayar_id', $this->carabayar_id);
                $criteria->compare('t.penjamin_id', $this->penjamin_id);
                $criteria->compare('t.pegawai_id', $this->pegawai_id);
                $criteria->compare('lower(pendaftaran_t.statusperiksa)', strtolower($this->statusperiksa));
		$criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("t.reseptur_id = ".$this->reseptur_id);						
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id);						
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);						
		}
		$criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//                $criteria->addCondition('penjualanresep_t.returresep_id IS NULL'); // DI NONAKTIFKAN KARENA ADA KASUS RETUR SEBAGIAN OBAT 
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        /**
         * searchInfoResepPasien digunakan untuk menampilkan semua resep pasien RS
         */
        public function searchInfoResepPasien()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                //HARUSNYA JANGAN ADA JOIN DI MODEL YANG MEMANGGIL VIEW TABLE (DB), JIKA ADA YG PERLU DI TAMBAHKAN HUBUNGI ANALIS
                $criteria->group = 't.racikanantrian_singkatan, t.noantrian, t.panggilantrian, t.antrianlewat, t.pendaftaran_id, penjualanresep_t.jenispenjualan, penjualanresep_t.returresep_id, t.jenispenjualan, t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.tanggal_lahir, t.noresep, t.totharganetto,
                                    t.totalhargajual, t.instalasiasal_nama, t.ruanganasal_nama, t.penjualanresep_id, t.reseptur_id, t.pegawai_id, t.nama_pegawai, t.tglpenjualan, t.pasien_id,pendaftaran_t.umur, t.jeniskelamin, t.alamat_pasien, t.tglresep, t.create_ruangan';
                $criteria->select = $criteria->group.", sum(t.totharganetto) as totalharganetto, sum(t.totalhargajual) as totalhargajual";
                $criteria->order = 't.tglpenjualan, t.noantrian ASC';
                //HARUSNYA JANGAN ADA JOIN DI MODEL YANG MEMANGGIL VIEW TABLE (DB), JIKA ADA YG PERLU DI TAMBAHKAN HUBUNGI ANALIS
                $criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id LEFT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id';
                $criteria->addBetweenCondition('DATE(t.tglpenjualan)',  $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.jenispenjualan)',strtolower(Params::JENISPENJUALAN_RESEP),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
		$criteria->compare('t.totharganetto',$this->totharganetto);
		$criteria->compare('t.totalhargajual',$this->totalhargajual);
		$criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("t.reseptur_id = ".$this->reseptur_id);						
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id);						
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);						
		}
		if(!empty($this->ruanganasalobat)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruanganasalobat);						
		}
//                $criteria->addCondition('penjualanresep_t.returresep_id IS NULL');
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
         public function searchInfoJualDokter()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $jenisPenjualan = Params::JENISPENJUALAN_DOKTER;
                $criteria->select = array('t.pasienpegawai_id,  t.pasienprofilrs_id, t.pasieninstalasiunit_id, t.pendaftaran_id, penjualanresep_t.jenispenjualan','penjualanresep_t.returresep_id',' t.jenispenjualan','t.penjualanresep_id','t.pasien_id','t.pegawai_id', 't.nama_pegawai','t.gelardepan', 't.gelarbelakang_nama','t.alamat_pasien','t.no_rekam_medik','t.namadepan','t.nama_pasien','t.nama_bin','t.tanggal_lahir',
                                          't.noresep','t.totharganetto','t.totalhargajual','t.instalasiasal_nama','t.ruanganasal_nama','t.reseptur_id',
                                          't.tglpenjualan','(pendaftaran_t.umur) as umur','t.jeniskelamin','t.tglresep');
                $criteria->group = 't.pasienpegawai_id,  t.pasienprofilrs_id, t.pasieninstalasiunit_id, t.pendaftaran_id, penjualanresep_t.jenispenjualan, penjualanresep_t.returresep_id, t.jenispenjualan, t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.tanggal_lahir, t.noresep, t.totharganetto,
                                    t.totalhargajual, t.instalasiasal_nama, t.ruanganasal_nama, t.penjualanresep_id, t.reseptur_id, t.pegawai_id, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama, t.tglpenjualan, t.pasien_id,pendaftaran_t.umur, t.jeniskelamin, t.alamat_pasien, t.tglresep';
                $criteria->order = 't.reseptur_id DESC';
                //HARUSNYA JANGAN ADA JOIN DI MODEL YANG MEMANGGIL VIEW TABLE (DB), JIKA ADA YG PERLU DI TAMBAHKAN HUBUNGI ANALIS
                $criteria->join = 'LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id LEFT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id';
                $criteria->addBetweenCondition('DATE(t.tglpenjualan)',  $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.jenispenjualan)',strtolower($jenisPenjualan),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
		$criteria->compare('t.totharganetto',$this->totharganetto);
		$criteria->compare('t.totalhargajual',$this->totalhargajual);
		$criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("t.reseptur_id = ".$this->reseptur_id);						
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id);						
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);						
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
		} 
		if(!empty($this->pasienpegawai_id)){
			$criteria->addCondition("t.pasienpegawai_id = ".$this->pasienpegawai_id);						
		}
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function searchInfoJualKaryawan()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $jenisPenjualan = Params::JENISPENJUALAN_KARYAWAN;
                $criteria->select = array('t.pasienpegawai_id,  t.pasienprofilrs_id, t.pasieninstalasiunit_id, t.pendaftaran_id, penjualanresep_t.jenispenjualan','penjualanresep_t.returresep_id',' t.jenispenjualan','t.penjualanresep_id','t.pasien_id','t.pegawai_id', 't.nama_pegawai',' t.gelardepan', 't.gelarbelakang_nama','t.alamat_pasien','t.no_rekam_medik','t.namadepan','t.nama_pasien','t.nama_bin','t.tanggal_lahir',
                                          't.noresep','t.totharganetto','t.totalhargajual','t.instalasiasal_nama','t.ruanganasal_nama','t.reseptur_id',
                                          't.tglpenjualan','(pendaftaran_t.umur) as umur','t.jeniskelamin','t.tglresep','returresep_t.alasanretur');
                $criteria->group = 't.pasienpegawai_id,  t.pasienprofilrs_id, t.pasieninstalasiunit_id,t.pendaftaran_id, penjualanresep_t.jenispenjualan, penjualanresep_t.returresep_id, t.jenispenjualan, t.no_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.tanggal_lahir, t.noresep, t.totharganetto,
                                    t.totalhargajual, t.instalasiasal_nama, t.ruanganasal_nama, t.penjualanresep_id, t.reseptur_id,t.pegawai_id, t.nama_pegawai, t.gelardepan, t.gelarbelakang_nama,t.tglpenjualan, t.pasien_id,pendaftaran_t.umur, t.jeniskelamin, t.alamat_pasien, t.tglresep,returresep_t.alasanretur';
                $criteria->order = 't.reseptur_id DESC';
                //HARUSNYA JANGAN ADA JOIN DI MODEL YANG MEMANGGIL VIEW TABLE (DB), JIKA ADA YG PERLU DI TAMBAHKAN HUBUNGI ANALIS
                $criteria->join = 'LEFT JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id LEFT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id LEFT JOIN returresep_t ON returresep_t.penjualanresep_id = penjualanresep_t.penjualanresep_id';
                $criteria->addBetweenCondition('DATE(t.tglpenjualan)',  $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.jenispenjualan)',strtolower($jenisPenjualan),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.noresep)',strtolower($this->noresep),true);
		$criteria->compare('t.totharganetto',$this->totharganetto);
		$criteria->compare('t.totalhargajual',$this->totalhargajual);
		$criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("t.reseptur_id = ".$this->reseptur_id);						
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id);						
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);						
		} 
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);						
		}  
		if(!empty($this->pasienpegawai_id)){
			$criteria->addCondition("t.pasienpegawai_id = ".$this->pasienpegawai_id);						
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
		/**
		 * menampilkan daftar kunjungan yang telah melakukan pembelian obat
		 */
		public function searchDialogKunjungan(){
			$criteria = new CDbCriteria();
			$criteria->group = "pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_pendaftaran, t.pasien_id, t.no_rekam_medik, t.nama_pasien, t.jeniskelamin, t.ruanganasal_nama, t.carabayar_nama";
			$criteria->select = $criteria->group;
			$criteria->join = "JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id";
            $criteria->compare('LOWER(pendaftaran_t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
            $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(t.instalasiasal_nama)', 'rawat jalan');
            $criteria->order = 'pendaftaran_t.no_pendaftaran desc';
            //$criteria->limit = 5;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
        public function getNamaRuangan(){
            return RuanganM::model()->findByPk($this->create_ruangan)->ruangan_nama;
        }
//        public function getNamaDokter($id = null){
//            if(empty($id))
//                $modDokter = DokterpegawaiV::model()->findByAttributes(array('pegawai_id' =>$this->pegawai_id));
//            else
//                $modDokter = DokterpegawaiV::model()->findByAttributes(array('pegawai_id' =>$id));
//            return $modDokter->gelardepan." ".$modDokter->nama_pegawai.', '.$modDokter->gelarbelakang_nama;
//        }
        
        public function getNamaInstalasi($id){
            $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id' =>$id));
            return $modInstalasi->instalasi_nama;
        }
        
        public function getNamaPegawai($id = null){
//        public function getNamaPegawai($id = null){
            if(!empty($id)){
                    $modPegawai = PegawaiM::model()->findByPk($id);
            }
            return (!empty($modPegawai->NamaLengkap) ? $modPegawai->NamaLengkap : "-");
//            return (!empty($this->gelardepan) ? $this->gelardepan : "")." - ".(!empty($this->nama_pegawai) ? $this->nama_pegawai : "");
//            return (!empty($this->gelardepan) ? $this->gelardepan : "")." - ".(!empty($this->nama_pegawai) ? $this->nama_pegawai : "")." ".$modPegawai->nama_pegawai.', '.(!empty($modPegawai->gelarbelakang_nama) ? $modPegawai->gelarbelakang_nama : "");
        }
        
        public function getNamaDokter(){
            return (!empty($this->gelardepan) ? $this->gelardepan : "")." ".(!empty($this->nama_pegawai) ? $this->nama_pegawai : "")." ".(!empty($this->gelarbelakang_nama) ? $this->gelarbelakang_nama : "");
        }
        
        public function getNomorResepSudahBayar(){
            $result = ObatalkespasienT::model()->count('penjualanresep_id =:penjualanresep and (oasudahbayar_id is not null or returresepdet_id is not null)', array(':penjualanresep'=>$this->penjualanresep_id));
            return (($result > 0) ? true : false);
        }
        
        public function getNoRekamMedisNoPendaftaran()
        {
            return $this->no_rekam_medik.' '.$this->no_pendaftaran;
        }
        
        public function getNamapasien()
        {
            return $this->namadepan.' '.$this->nama_pasien;
        }
        
        public function getInstalasiRuanganAsal()
        {
            return $this->instalasiasal_nama.' '.$this->ruanganasal_nama;
        }
        
        public function getStatusPenjualan($alasanretur)
        {
            $status = '';
            if($alasanretur == "BATAL TRANSAKSI PENJUALAN"){
                $status = "Sudah Dibatalkan";
            }else{
                $status = "Sudah Diretur";
            }
            return $status;
        }

                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                } elseif ($column->dbType == 'timestamp without time zone'){
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                } elseif ($column->dbType == 'double precision') {
//                    $format = new CNumberFormatter('id');
//                    $this->$columnName = $format->format('#,##0', $this->$columnName);
                }
            }
            return true;
        }
        
        /**
        * menampilkan list jenis penjualan untuk pencarian
        * @return string
        */
        public static function listJenisPenjualan()
        {
            $jenispenjualan = array(
                Params::JENISPENJUALAN_RESEP=>Params::JENISPENJUALAN_RESEP,
                Params::JENISPENJUALAN_RESEP_LUAR=>Params::JENISPENJUALAN_RESEP_LUAR,
                Params::JENISPENJUALAN_BEBAS=>Params::JENISPENJUALAN_BEBAS,
            );
            asort($jenispenjualan);
            return $jenispenjualan;
        }
}