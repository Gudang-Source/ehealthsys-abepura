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

		$this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
		$this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
//                $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
   		$criteria->order = 'tgl_pendaftaran DESC';
		//$criteria->compare('LOWER(statusperiksa)',strtolower(Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
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
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 5;
            if($this->instalasi_id == Params::INSTALASI_ID_RJ){
                $model = new BKInfokunjunganrjV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RD){
                $model = new BKInfokunjunganrdV;
            }else if($this->instalasi_id == Params::INSTALASI_ID_RI){
                $model = new BKInfopasienmasukkamarV;
            }
            return new CActiveDataProvider($model, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
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
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
            }
        }
}