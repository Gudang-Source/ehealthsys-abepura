<?php
class PPPasienmasukpenunjangV extends PasienmasukpenunjangV
{
        public $data;
        public $jumlah;
        public $tick;
        public $Jenis_kasus_nama_penyakit;
        public $tgl_awal,$tgl_akhir;
        public $adaKarcis = false;
        public $bulan;                
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
        
        /**
         * menampilkan data terakhir daftar
         */
        public function searchPendaftaranTerakhir()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
		$criteria->addCondition('ispasienluar = false');
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
		$criteria->compare('LOWER(kabupten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition("instalasiasal_id = ".$this->instalasiasal_id); 			
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
		$criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',($this->bulan));
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
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
        
        public function searchPenunjang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
                        . "left join rujukan_t r on r.rujukan_id = p.rujukan_id";
                
                $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		//$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
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
                $criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
                $criteria->compare('r.rujukandari_id', $this->rujukandari_id);
                // $criteria->compare('lower(nama_perujuk)', strtolower($this->nama_perujuk), true);
                
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);			
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);			
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('DATE_PART(MONTH,t.tgl_pendaftaran)',($this->bulan));
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(t.nama_pegawai)',($this->nama_pegawai));
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
//		$criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',$this->bulan,true);
//		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
//		$criteria->compare('LOWER(suku_nama)',strtolower($this->suku_nama),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
                $criteria->order = 't.tgl_pendaftaran DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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

           // if (count($addCols) > 0){
               // if (is_array($addCols)){
                 //   foreach ($addCols as $i => $v){
                   //     $criteria->group .= ','.$v;
                    //    $criteria->select .= ','.$v.' as '.$i;
                   // }
              //  }            
         //   }
            //$criteria->group = 'penjamin_nama, ruangan_nama';
            
           
            return $criteria;
        }
        
        public function searchGrafik(){
               
			$criteria = $this->criteriaGrafik($this, 'data', array('tick'=>'ruangan_nama'));
                        
			//$criteria->order = 'ruangan_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
        public function searchGrafikAgama(){
               
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, agama as data, agama as tick';
			$criteria->group = 'agama';
			$criteria->order = 'agama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
			$criteria->order = 'jumlah DESC';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
                        
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikStatusPerkawinan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = "count(pendaftaran_id) as jumlah, (CASE statusperkawinan WHEN '' THEN 'TIDAK DIKETAHUI' ELSE statusperkawinan END ) as data";
			$criteria->group = 'statusperkawinan';
			$criteria->order = 'statusperkawinan';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
			

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
			$criteria->group = 'nama_pegawai';
			$criteria->order = 'nama_pegawai ASC';
                        
                        return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'pagination' => false
			));
        }
        public function searchGrafikPenjamin(){
            
                $criteria=new CDbCriteria;
               
                $criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama as data';
                $criteria->group = 'penjamin_nama';
                $criteria->order = 'penjamin_nama';
                
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
				
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
				if(!empty($this->ruangan_id)){                    
                                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                                }else{
                                   if (!empty($this->instalasi_id)){
                                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                                   }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
                $criteria->order = 'jumlah DESC';
                
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
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

            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');

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
            if(!empty($this->ruangan_id)){                    
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }else{
               if (!empty($this->instalasi_id)){
                   $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
               }
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
			
			

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
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
			if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
                        
                        $criteria->group = 'ruangan_nama';
                        $criteria->order = 'ruangan_nama ASC';                       
                        
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'pagination' => false,
			));
        }
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
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
		if(!empty($this->ruangan_id)){                    
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        }else{
                           if (!empty($this->instalasi_id)){
                               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                           }
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
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function searchTableLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
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
		if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
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
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function criteriaSearch()
	{
		$criteria=new CDbCriteria;
		if(isset($this->tgl_awal) && isset($this->tgl_akhir)){
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		}
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);			
		}
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
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);			
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);		
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);			
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);			
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		// $criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',($this->bulan));
		if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
                }
		$criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
		//$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
//		$criteria->compare('DATE_PART(MONTH,tgl_pendaftaran)',$this->bulan,true);
//		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
//		$criteria->compare('LOWER(suku_nama)',strtolower($this->suku_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		// $criteria->order = 'tgl_pendaftaran DESC';
		return $criteria;
	}
        
	    public function searchUmur(){
	        $criteria = $this->criteriaSearch();
	        $criteria->order = 'golonganumur_nama';    
                
	        return new CActiveDataProvider($this, array(
	                'criteria'=>$criteria,
	        ));
	    }

        public function printUmur(){
            $criteria = $this->criteriaSearch();
            $criteria->order = 'golonganumur_nama';          
            //$criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }

        public function searchJk(){
            $criteria = $this->criteriaSearch();
            $criteria->order = 'jeniskelamin';          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        public function printJk(){
            $criteria = $this->criteriaSearch();
            $criteria->order = 'jeniskelamin';          
            //$criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }


        public function searchStatus(){
            $criteria = $this->criteriaSearch();
            $criteria->order = 'statuspasien';          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        public function printStatus(){
            $criteria = $this->criteriaSearch();
            $criteria->order = 'statuspasien';          
            //$criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
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
        
        public function getNamaModel()
        {
            return __CLASS__;
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