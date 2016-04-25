<?php

/**
 * This is the model class for table "infokunjunganrd_v".
 *
 * The followings are the available columns in table 'infokunjunganrd_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $alamat_pasien
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $rujukan_id
 */
class PPInfoKunjunganRDV extends InfokunjunganrdV
{
        public $data;
        public $jumlah;
        public $tick;
        public $Jenis_kasus_nama_penyakit;
        public $tgl_awal,$tgl_akhir;
        public $adaKarcis = false;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
                        . "left join rujukan_t r on r.rujukan_id = p.rujukan_id";
                
                $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
                $criteria->compare('t.pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
                
                $criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
                $criteria->compare('r.rujukandari_id', $this->rujukandari_id);
                
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id); 			
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id); 			
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id); 			
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id); 			
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id); 			
		}
                // $criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
                $criteria->compare('lower(t.nama_perujuk)', strtolower($this->nama_perujuk), true);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("t.rujukan_id = ".$this->rujukan_id); 			
		}
		$criteria->order = 't.tgl_pendaftaran DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
		$criteria->order = 'tgl_pendaftaran DESC';
                $criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
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
                    $criteria->group .= 'penjamin_nama';
                } else if (!empty($model->carabayar_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group = 'penjamin_nama';
                } else {
                    $criteria->select .= ', carabayar_nama as '.$type;
                    $criteria->group = 'carabayar_nama';
                }
            } else if ($_GET['filter'] == 'wilayah') {
                if (!empty($model->kelurahan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kecamatan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kabupaten_id)) {
                    $criteria->select .= ', kecamatan_nama as '.$type;
                    $criteria->group .= 'kecamatan_nama';
                } else if (!empty($model->propinsi_id)) {
                    $criteria->select .= ', kabupaten_nama as '.$type;
                    $criteria->group .= 'kabupaten_nama';
                } else {
                    $criteria->select .= ', propinsi_nama as '.$type;
                    $criteria->group .= 'propinsi_nama';
                }
            }

            if (!isset($_GET['filter'])){
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
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
        
	public function searchGrafik(){
                
		$criteria = $this->criteriaGrafik($this, 'data', array('tick'=>'ruangan_nama'));

		$criteria->order = 'ruangan_nama';

		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
	//		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchTableLaporan()
		{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
			$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
			$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
	//		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id = ".$this->rujukan_id); 			
			}

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
        
        public function searchPrint()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
            $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
            $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
            $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
            $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
//		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id = ".$this->rujukan_id); 			
			}
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
	}
        
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
         public function searchGrafikAgama(){
             
                $criteria=new CDbCriteria;
               
                $criteria->select = 'count(pendaftaran_id) as jumlah, agama as data';
                $criteria->group = 'agama';
                $criteria->order = 'agama';
                
                $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
				if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
				}
				$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
				if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
				}
				$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
				if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
				}
				$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
				if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
				}
				$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
				if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
				}
				$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
				}
				$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
				}
				$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
				$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
//		                
				return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
				));
        }
        public function searchGrafikUmur(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, golonganumur_nama as data';
			$criteria->group = 'golonganumur_nama';
			$criteria->order = 'golonganumur_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikJk(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, jeniskelamin as data';
			$criteria->group = 'jeniskelamin';
			$criteria->order = 'jeniskelamin';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikStatus(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, statuspasien as data';
			$criteria->group = 'statuspasien';
			$criteria->order = 'statuspasien';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikPekerjaan(){
            
			$criteria=new CDbCriteria;
               
			$criteria->select = 'count(pendaftaran_id) as jumlah, pekerjaan_nama as data';
			$criteria->group = 'pekerjaan_nama';
			$criteria->order = 'pekerjaan_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikStatusPerkawinan(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, statusperkawinan as data';
			$criteria->group = 'statusperkawinan';
			$criteria->order = 'statusperkawinan';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikKecamatan(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, kecamatan_nama as data';
			$criteria->group = 'kecamatan_nama';
			$criteria->order = 'kecamatan_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
//		                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        public function searchGrafikKabupaten(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, kabupaten_nama as data';
			$criteria->group = 'kabupaten_nama';
			$criteria->order = 'kabupaten_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikCaraMasuk(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, caramasuk_nama as data';
			$criteria->group = 'caramasuk_nama';
			$criteria->order = 'caramasuk_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikDokterPemeriksa(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, nama_pegawai as data';
			$criteria->group = 'nama_pegawai';
			$criteria->order = 'nama_pegawai';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikUnitPelayanan(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
			$criteria->group = 'ruangan_nama';
			$criteria->order = 'ruangan_nama';

			$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
         public function searchGrafikPenjamin(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama as data';
			$criteria->group = 'penjamin_nama';
			$criteria->order = 'penjamin_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
         public function searchGrafikAlamat(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, alamat_pasien as data';
			$criteria->group = 'alamat_pasien';
			$criteria->order = 'alamat_pasien';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        public function searchGrafikRujukan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, nama_perujuk as data';
			$criteria->group = 'nama_perujuk';
			$criteria->order = 'nama_perujuk';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
         public function searchGrafikPemeriksaan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
			$criteria->group = 'ruangan_nama';
			$criteria->order = 'ruangan_nama';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikKetPulang(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, statusperiksa as data';
			$criteria->group = 'statusperiksa';
			$criteria->order = 'statusperiksa';

			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->propinsi_id)){
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 			
			}
			$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 			
			}
			$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        
        public function getNamaAlias()
        {
            if(!empty($this->nama_bin)){
                return $this->nama_pasien.' Alias '.$this->nama_bin;
            }else{
                return $this->nama_pasien;
            }
            
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }
        
        /**
         * menampilkan morbiditas pasien
         * @return type
         */
        public function getMorbiditas(){
            $criteria = new CDbCriteria();
            $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
            $modDiagnosa = PasienmorbiditasT::model()->find($criteria);
            return $modDiagnosa;
        }
}