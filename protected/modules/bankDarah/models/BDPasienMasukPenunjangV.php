<?php

class BDPasienMasukPenunjangV extends PasienmasukpenunjangV
{
    public $statusperiksahasil;
    public $printhasillab;
    public $isPasienBatalPeriksa = false; //MENAMPILKAN PASIEN YG DIBATALKAN
    public $bulan;
    public $tgl_awal,$tgl_akhir;
    public $pegawaipenunjang_id;
	public $perawat_id = null; //untuk tindakanpelayanan_t (analis lab)
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    /**
     * untuk Lab Klinik
     * @return \CActiveDataProvider
     */
    public function searchLab()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->select = "*, hasilpemeriksaanlab_t, t.pegawai_id as pegawaipenunjang_id, t.pasienbatalperiksa_id, tglbatal, keterangan_batal";
            $criteria->join = "
                JOIN hasilpemeriksaanlab_t ON hasilpemeriksaanlab_t.pasien_id = t.pasien_id AND hasilpemeriksaanlab_t.pendaftaran_id = t.pendaftaran_id AND hasilpemeriksaanlab_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id
                join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id
            ";
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(hasilpemeriksaanlab_t.statusperiksahasil)',strtolower($this->statusperiksahasil),true);
            if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
                $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
            else
                $criteria->addCondition('t.pasienbatalperiksa_id is null');
            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = "t.tglmasukpenunjang ASC"; //tglmasukpenunjang = tgl pendaftaran
            $criteria->addCondition("p.pasienbatalperiksa_id is null");
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));


    }

    public function searchPemeriksaan(){
        $criteria=new CDbCriteria;
        $criteria->addCondition('instalasiasal_id = '.Params::INSTALASI_ID_LAB);
        $criteria->order='tgl_pendaftaran DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }

    public function searchRincian()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
                $criteria->select = 't.tgl_pendaftaran, t.no_rekam_medik,t.no_pendaftaran,t.nama_pasien,t.nama_bin,t.carabayar_nama,t.nama_pegawai,t.jeniskasuspenyakit_nama,t.pendaftaran_id,t.pembayaranpelayanan_id,t.pembayaranpelayanan_id';
        $criteria->group = 't.tgl_pendaftaran, t.no_rekam_medik,t.no_pendaftaran,t.nama_pasien,t.nama_bin,t.carabayar_nama,t.nama_pegawai,t.jeniskasuspenyakit_nama,t.pendaftaran_id,t.pembayaranpelayanan_id,t.pembayaranpelayanan_id';
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
        $criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
        $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
        $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
        $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
        $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
        $criteria->compare('rt',$this->rt);
        $criteria->compare('rw',$this->rw);
        $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
        $criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
        $criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
        $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
        $criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
        $criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id = '.$this->pekerjaan_id);
		}
        $criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
        $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
        $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
        $criteria->compare('alihstatus',$this->alihstatus);
        $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
        $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
        $criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
        $criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
        $criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id = '.$this->caramasuk_id);
		}
        $criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition('golonganumur_id = '.$this->golonganumur_id);
		}
        $criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
        $criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
        $criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
        $criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
        $criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition('asalrujukan_id = '.$this->asalrujukan_id);
		}
        $criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id = '.$this->penanggungjawab_id);
		}
        $criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
        $criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
        $criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
		}
        $criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
		}
        $criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('LOWER(gelardokterasal)',strtolower($this->gelardokterasal),true);
        $criteria->compare('LOWER(nama_dokterasal)',strtolower($this->nama_dokterasal),true);
        $criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
        $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
        $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
        $criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
        $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
        $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
        $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}                
		if($this->statusBayar == 'LUNAS'){
			$criteria->addCondition('pembayaranpelayanan_id is not null');
		}else if($this->statusBayar == 'BELUM LUNAS'){
			$criteria->addCondition('pembayaranpelayanan_id is null');
		}
        $criteria->order='tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    /**
     * untuk lab patologi anatomi
     * @return \CActiveDataProvider
     */
    public function searchLabAnatomi()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
            
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            // $criteria->compare('LOWER(hasilpemeriksaanlab_t.statusperiksahasil)',strtolower($this->statusperiksahasil),true);
            if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
                $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
            else
                $criteria->addCondition('t.pasienbatalperiksa_id is null');
            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//                $criteria->compare('LOWER(nama_bin )',strtolower($this->nama),true);
//                $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
            $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = "t.tglmasukpenunjang ASC"; //tglmasukpenunjang = tgl pendaftaran
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
                
        
    }

    public function searchDialogLab()
    {
        $criteria=new CDbCriteria;
        $criteria->select = "*, hasilpemeriksaanlab_t, t.pasienbatalperiksa_id, tglbatal, keterangan_batal";
         $criteria->join = "
            JOIN hasilpemeriksaanlab_t ON hasilpemeriksaanlab_t.pasien_id = t.pasien_id AND hasilpemeriksaanlab_t.pendaftaran_id = t.pendaftaran_id AND hasilpemeriksaanlab_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id
            join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id
        ";
        $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(hasilpemeriksaanlab_t.statusperiksahasil)',strtolower($this->statusperiksahasil),true);
        if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
            $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
        else
            $criteria->addCondition('t.pasienbatalperiksa_id is null');
        $criteria->addCondition('t.ruangan_id='.Yii::app()->user->getState('ruangan_id'));
//                $criteria->compare('LOWER(nama_bin )',strtolower($this->nama),true);
//                $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
       // $criteria->addBetweenCondition('tglmasukpenunjang', $this->tgl_awal, $this->tgl_akhir);
//                $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
        $criteria->order = "t.tglmasukpenunjang ASC"; //tglmasukpenunjang = tgl pendaftaran
        $criteria->addCondition("p.pasienbatalperiksa_id is null");
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
                
    }
        
    public function getNamaLengkapDokter($pegawai_id)
    {
        // return $pegawai_id;
        $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
        if(!empty($dokter->nama_pegawai)){
            return $dokter->namaLengkap;
        }else{
            return "-";
        }
    }

    public function getNamaPegawai($pegawai_id)
    {
        $dokter = PegawaiM::model()->findByAttributes(
            array('pegawai_id'=>$pegawai_id)
        );
        return $dokter->nama_pegawai;
    }        

    /**
     * menampilkan data terakhir daftar
     */
    public function searchPendaftaranTerakhir()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
            $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
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
			if(!empty($this->instalasiasal_id)){
				$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
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
            $criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',($this->bulan));
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
            $criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }

    
    /**
     * menampilkan dialog kunjungan
     */
    public function searchDialogKunjungan()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
            $criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
			}
            $criteria->addCondition("t.statusperiksa NOT IN ('SUDAH PULANG', 'BATAL PERIKSA') ");
            $criteria->compare('LOWER(t.nama_pegawai)',  strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
            $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            $criteria->order = 't.tglmasukpenunjang DESC';
            $criteria->join = 'join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id';
            
            $criteria->addCondition('p.pasienbatalperiksa_id is null');
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                  //  'pagination'=>false,
            ));
    }
    
    public function getNamaModel()
    {
        return __CLASS__;
    }
	
	/**
	 * perawat_id tindakanpelayanan_t yg sudah ada
	 */
	public function getPerawatId(){
		$loadTindakan = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id),"perawat_id IS NOT NULL");
		if(isset($loadTindakan->perawat_id)){
			if(!empty($loadTindakan->perawat_id)){
				return $loadTindakan->perawat_id;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
        
}