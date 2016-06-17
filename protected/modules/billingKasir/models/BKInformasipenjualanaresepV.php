<?php
class BKInformasipenjualanaresepV extends InformasipenjualanaresepV
{
        public $ruangan_nama;
        public $umur;
        public $penanggungjawab_id;
        public $nama_pj;
        public $pengantar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenjualanaresepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * menampilkan pasien masuk penunjang group by pendaftaran
         */
        public function criteriaGroupByPenjualan(){
            $criteria = new CDbCriteria();
            $criteria->group = 'pendaftaran_id,pasien_id, pasienpegawai_id,no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, penjualanresep_id, jenispenjualan,'
                    . ' agama, golongandarah, photopasien, alamatemail, tglresep, noresep, carabayar_id, penjamin_id, ruanganasal_nama, carabayar_nama, penjamin_nama, tglpenjualan, instalasiasal_nama';
            $criteria->select = $criteria->group;
            return $criteria;
        }
                
        /**
         * menampilkan data kunjungan pasien 
         * model & criteria harus sama dengan PembayaranPenjualanApotekController/AutocompleteKunjungan
         * @return \CActiveDataProvider
         */
        public function searchDialog(){
            $format = new MyFormatter();
            $criteria = $this->criteriaGroupByPenjualan();
            $criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
            $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
            $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
            $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
            $criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
            $criteria->addCondition("(true <> (lower(instalasiasal_nama) ilike '%rawat jalan%' and penjamin_id = 1))");
            $criteria->order = 'tglpenjualan DESC';
            //$criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        //'pagination'=>false,
                ));
        }
        /**
         * menampilkan terakhir masuk penunjang
         */
        public function getPenunjangAkhir(){
            $criteria = new CdbCriteria();
            if(!empty($this->pendaftaran_id)){
                $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
                $criteria->order = "penjualanresep_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }else if(!empty($this->pasienpegawai_id)){
                $criteria->addCondition("pasienpegawai_id = ".$this->pasienpegawai_id);
                $criteria->order = "penjualanresep_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }
            if(!empty($this->penjualanresep_id)){
                $criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);
                $criteria->order = "penjualanresep_id DESC";
                $criteria->limit = 1;
                $model = $this->find($criteria);
            }
            if(isset($model)){
                return $model;
            }else{
                return new $this;
            }
            
        }
        
}