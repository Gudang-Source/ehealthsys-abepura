<?php
class PSInfokunjunganpersalinanV extends InfokunjunganpersalinanV
{
	public $tgl_awal,$tgl_akhir;
	public $ceklis = false;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                

                $criteria->addCondition('date(t.tgl_pendaftaran)::date BETWEEN \''.$this->tgl_awal.'\'::date AND \''.$this->tgl_akhir.'\'::date');

                $criteria->join = 'left join pasienadmisi_t a on a.pendaftaran_id = t.pendaftaran_id';
                
                
                $criteria->compare('a.kamarruangan_id', $this->kamarruangan_id);
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id ='.$this->propinsi_id);
		}
                $criteria->compare('t.pegawai_id', $this->pegawai_id);
                $criteria->compare('t.kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id ='.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id ='.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id ='.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id ='.$this->instalasi_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id ='.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id ='.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->order='t.tgl_pendaftaran DESC';


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    function getNamaPasienNamaBin()
    {
        return $this->nama_pasien.' bin '.$this->nama_bin;
    }
    
    
    public function getInsatalasiRuangan()
    {
           
        return $this->instalasi_nama.' / '.$this->ruangan_nama;
    }
    
    public function getCaraBayarPenjamin2() {                         
        return $this->instalasi_nama.PHP_EOL.'<br/>'.$this->ruangan_nama;
    }
    
    public function getNoPendaftaranRekammedik() {                         
        return $this->no_pendaftaran.PHP_EOL.'<br/>'.$this->no_rekam_medik;
    }
    
    public function getCaraMasukTransportasi() {                         
        return $this->caramasuk_nama.PHP_EOL.'<br/>'.$this->transportasi;
    }

    public function getNamaNamaBIN()
        {
        	if (!empty($this->nama_bin)) {
        		return $this->nama_pasien.' alias '.$this->nama_bin;
        	} else {
       			return $this->nama_pasien;
       		}
        }

    public function getTindakLanjut($status,$id,$nopen,$pasienpulang,$carakeluar,$alih){
	if($status == "ANTRIAN" || $status == "BATAL PERIKSA" || $status == "DIBATALKAN" || $status == "SEDANG DIRAWAT INAP"){
	    $status = '<center><a href="#"  onclick="cekStatus(\''.$status.'\')"
				 rel="tooltip" data-original-title="Pasien Pulang"><i class="icon-pencil"></i></a></center>';
	}else if($status == "SEDANG PERIKSA" || $status == "SUDAH PULANG"){
	     $status = '<center><a href="index.php?r=rawatDarurat/daftarPasien/PasienPulang&pendaftaran_id='.$id.'&dialog=1" 
			     onclick="$(\'#dialogPasienPulang\').dialog(\'open\');" target="iframePasienPulang" 
				 rel="tooltip" data-original-title="Klik Untuk Menindak Lanjuti Pasien"><i class="icon-pencil"></i></a></center>';
	}else if(!empty($pasienpulang)&& ($carakeluar == "DIRAWAT INAP") OR ($carakeluar == "DIPULANGKAN") OR ($carakeluar == "DIRUJUK")){
	    $status = '<center>'.$carakeluar.'<br>
			<a href="index.php?r=rawatDarurat/daftarPasien/BatalRawatInap&pendaftaran_id='.$id.'" rel=\"tooltip" 
			    onclick="$(\'#dialogBatalRawatInap\').dialog(\'open\');" target="iframeBatalRawatInap" 
				data-original-title="Klik Untuk Batal '.$carakeluar.'"><i class="icon-remove"></i></a></center>';
	}else{
	      $status = '<center><a href="index.php?r=rawatDarurat/daftarPasien/PasienPulang&pendaftaran_id='.$id.'&dialog=1" 
			     onclick="$(\'#dialogPasienPulang\').dialog(\'open\');" target="iframePasienPulang" 
				 rel="tooltip" data-original-title="Klik Untuk Menindak Lanjuti Pasien"><i class="icon-pencil"></i></a></center>';
	}
    return $status;
    } 
}