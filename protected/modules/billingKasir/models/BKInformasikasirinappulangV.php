<?php
class BKInformasikasirinappulangV extends InformasikasirinappulangV
{
        public $ceklis, $tgl_awalAdmisi, $tgl_akhirAdmisi;
        public $tgl_awal,$tgl_akhir,$tgl_awal_admisi,$tgl_akhir_admisi;
        public $statusBayar;
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
                    $criteria->addBetweenCondition('DATE(t.tgladmisi)',$this->tgl_awal_admisi,$this->tgl_akhir_admisi);	       
            }else{
                    $criteria->addBetweenCondition('DATE(t.tglpulang)',$this->tgl_awal,$this->tgl_akhir);
                    
            }

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
                sum(case when p.oasudahbayar_id is null then 1 else 0 end) as total_oa_belum,
                count(p.obatalkespasien_id) as total_oa

                from obatalkespasien_t p
                group by p.pendaftaran_id
                ) o on o.pendaftaran_id = t.pendaftaran_id
            ";
            
            
            //$criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
            $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
			}
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
			}
                        
			if(!empty($this->ruanganakhir_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruanganakhir_id);
			}
            
            $criteria->order = 'tgladmisi DESC';
            //$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));

            if ($this->statusBayar == "BELUM LUNAS") {
                $criteria->addCondition("(${tb}) > 0 or (${ob}) > 0 or (${tt}) = 0");
            } else if ($this->statusBayar == "LUNAS") {
                $criteria->addCondition("(${tb}) = 0 and (${ob}) = 0 and (${tt}) > 0");
            }
            
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

	public function getRuanganItems($instalasi_id=null)
        {
            if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id, 'ruangan_aktif'=>'true'),array('order'=>'ruangan_nama'));   
            }
        }
}