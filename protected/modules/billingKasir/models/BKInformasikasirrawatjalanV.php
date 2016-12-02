<?php

/**
 * This is the model class for table "infokunjungan_rj".
 *
 * The followings are the available columns in table 'infokunjungan_rj':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $alamat_pasien
 * @property string $kelompokumur_nama
 * @property string $ruangan_nama
 * @property string $penjamin_nama
 * @property string $nama_pegawai
 * @property string $jeniskasuspenyakit_nama
 * @property integer $rujukan_id
 */
class BKInformasikasirrawatjalanV extends InformasikasirrawatjalanV
{
        public $instalasi_id;
        public $statusBayar;
        public $total_belum;
        public $total_oa_belum;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganRj the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRJ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$format = new MyFormatter();

                $tb = "case when n.total_belum is null then 0 else n.total_belum end";
                $tt = "case when n.total_tindakan is null then 0 else n.total_tindakan end";
                $ob = "case when o.total_oa_belum is null then 0 else o.total_oa_belum end";
                $ot = "case when o.total_oa is null then 0 else o.total_oa end";
                
                $criteria->select = "t.*, "
                        . "${tb} as total_belum,
                            ${tt} as total_tindakan,
                            ${ob} as total_oa_belum,
                            ${ot} as total_oa";
                
                $criteria->join = "left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.tindakansudahbayar_id is null then 1 else 0 end) as total_belum,
                count(p.tindakanpelayanan_id) as total_tindakan

                from tindakanpelayanan_t p
                group by p.pendaftaran_id
                ) n on n.pendaftaran_id = t.pendaftaran_id

                left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.oasudahbayar_id is null and (true <> (p.penjualanresep_id is not null and p.penjamin_id = 1)) then 1 else 0 end) as total_oa_belum,
                count(p.obatalkespasien_id) as total_oa

                from obatalkespasien_t p
                group by p.pendaftaran_id
                ) o on o.pendaftaran_id = t.pendaftaran_id
                
                left join pendaftaran_t pp on pp.pendaftaran_id = t.pendaftaran_id
                ";
                
                if ($this->statusBayar == "BELUM LUNAS") {
                    $criteria->addCondition("(${tb}) > 0 or (${ob}) > 0 or (${tt}) = 0");
                } else if ($this->statusBayar == "LUNAS") {
                    $criteria->addCondition("(${tb}) = 0 and (${ob}) = 0 and (${tt}) > 0");
                }
                
                
		$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
//                $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
   		$criteria->order = 't.tgl_pendaftaran DESC';
		//$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
		
                $criteria->addCondition('pp.pasienadmisi_id is null');
                
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranTagihanPasienController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjungan(){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
			$criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->order = 'tgl_pendaftaran DESC';
            
            //var_dump($criteria); die;
            
            // $criteria->limit = 5;
            if($this->instalasi_id == Params::INSTALASI_ID_RJ){
                $model = new BKInformasikasirrawatjalanV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RD){
                $model = new BKInformasikasirrdpulangV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RI){
                $model = new BKInformasikasirinappulangV;
            }
            
            return new CActiveDataProvider($model, array(
                        'criteria'=>$criteria,
                        // 'pagination'=>false,
                ));
        }
        
        /**
         * menampilkan data kunjungan pasien yang siap bayar di kasir
         * model & criteria harus sama dengan PembayaranUangMukaController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialogKunjunganUangMuka(){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('penjamin_id', $this->penjamin_id);
            $criteria->compare('ruangan_id', $this->ruangan_id);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->order = 'tgl_pendaftaran DESC';
            // $criteria->limit = 5;
            if($this->instalasi_id == Params::INSTALASI_ID_RJ){
                $model = new BKInformasikasirrawatjalanV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RD){
                $model = new BKInformasikasirrdpulangV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RI){
                $model = new BKInformasikasirinappulangV;
            }
            return new CActiveDataProvider($model, array(
                        'criteria'=>$criteria,
                        //' pagination'=>false,
                ));
        }
        
         public function getTanggal()
        {
            $format = new MyFormatter(); 
            return $format->formatDateTimeForUser($this->tgl_pendaftaran);
        }
        
        public function getRuanganItems($instalasi_id=null)
        {
            if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id, 'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));   
            }
        }
}