<?php
class PSInfokunjunganpersalinanV extends InfokunjunganpersalinanV
{
	public $tgl_awal,$tgl_akhir;
        public $bln_awal,$bln_akhir;
        public $thn_awal,$thn_akhir;
        public $jns_periode;
	public $ceklis = false;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getNamaModel() {
        return __CLASS__;
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
                $criteria->addCondition(" t.ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
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
    
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id='.$this->pasien_id);
		}
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        if(!empty($this->propinsi_id)){
            $criteria->addCondition('propinsi_id='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if(!empty($this->kabupaten_id)){
            $criteria->addCondition('kabupaten_id='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if(!empty($this->kelurahan_id)){
            $criteria->addCondition('kelurahan_id='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        if(!empty($this->kecamatan_id)){
            $criteria->addCondition('kecamatan_id='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id='.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if(!empty($this->carabayar_id)){
            $criteria->addCondition('carabayar_id='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        if(!empty($this->caramasuk_id)){
            $criteria->addCondition('caramasuk_id='.$this->caramasuk_id);
		}
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        if(!empty($this->shift_id)){
            $criteria->addCondition('shift_id='.$this->shift_id);
		}
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        if(!empty($this->asalrujukan_id)){
            $criteria->addCondition('asalrujukan_id='.$this->asalrujukan_id);
		}
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
		$criteria->addCondition('ruangan_id='.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if(!empty($this->instalasi_id)){
            $criteria->addCondition('instalasi_id='.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        if(!empty($this->jeniskasuspenyakit_id)){
            $criteria->addCondition('jeniskasuspenyakit_id='.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id='.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
	}

    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        if ($_GET['filter'] == 'carabayar') {
            if (!empty($model->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= 'penjamin_nama,t.tgl_pendaftaran';
            } else if (!empty($model->carabayar_id)) {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama,t.tgl_pendaftaran';
            } else {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama,t.tgl_pendaftaran';
            }
        } else if ($_GET['filter'] == 'wilayah') {
            if (!empty($model->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama,t.tgl_pendaftaran';
            } else if (!empty($model->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama,t.tgl_pendaftaran';
            } else if (!empty($model->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= 'kecamatan_nama,t.tgl_pendaftaran';
            } else if (!empty($model->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= 'kabupaten_nama,t.tgl_pendaftaran';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama,t.tgl_pendaftaran';
            }
        }

        if (!isset($_GET['filter'])){
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama,t.tgl_pendaftaran';
        }

        if (count($addCols) > 0){
            if (is_array($addCols)){
                foreach ($addCols as $i => $v){
                    $criteria->group .= ','.$v;
                    $criteria->select .= ','.$v.' as '.$i;
                }
            }            
        }

        return $criteria;
    }
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        
        
        $criteria = $this->criteriaGrafik($this, 'tick');
        if (!empty($criteria->group) &&(!empty($this->pilihanx))){
            $criteria->group .=',';
        }
        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ' statuspasien,t.tgl_pendaftaran';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ' kunjungan,';
        }
        else if ($this->pilihanx == 'rujukan'){
            $criteria->select .= ', statusmasuk as data';
            $criteria->group .= ' statusmasuk,t.tgl_pendaftaran';
        }
        
        if (empty($this->pilihanx)){
            $criteria = $this->criteriaGrafik($this, 'data');
        }

        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->propinsi_id)){
            $criteria->addCondition('propinsi_id='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if(!empty($this->kabupaten_id)){
            $criteria->addCondition('kabupaten_id='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if(!empty($this->kelurahan_id)){
            $criteria->addCondition('kelurahan_id='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        if(!empty($this->kecamatan_id)){
            $criteria->addCondition('kecamatan_id='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if(!empty($this->carabayar_id)){
            $criteria->addCondition('carabayar_id='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->addCondition('ruangan_id='.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('tgl_pendaftaran BETWEEN \'' . $this->tgl_awal . '\' AND \'' . $this->tgl_akhir . '\'');
        if(!empty($this->pasien_id)){
            $criteria->addCondition('pasien_id='.$this->pasien_id);
		}
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        if(!empty($this->propinsi_id)){
            $criteria->addCondition('propinsi_id='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if(!empty($this->kabupaten_id)){
            $criteria->addCondition('kabupaten_id='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if(!empty($this->kelurahan_id)){
            $criteria->addCondition('kelurahan_id='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        if(!empty($this->kecamatan_id)){
            $criteria->addCondition('kecamatan_id='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id='.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if(!empty($this->carabayar_id)){
            $criteria->addCondition('carabayar_id='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        if(!empty($this->caramasuk_id)){
            $criteria->addCondition('caramasuk_id='.$this->caramasuk_id);
		}
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        if(!empty($this->shift_id)){
            $criteria->addCondition('shift_id='.$this->shift_id);
		}
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        if(!empty($this->asalrujukan_id)){
            $criteria->addCondition('asalrujukan_id='.$this->asalrujukan_id);
		}
            $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
		$criteria->addCondition('ruangan_id='.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if(!empty($this->instalasi_id)){
            $criteria->addCondition('instalasi_id='.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        if(!empty($this->jeniskasuspenyakit_id)){
            $criteria->addCondition('jeniskasuspenyakit_id='.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition('kelaspelayanan_id='.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
}