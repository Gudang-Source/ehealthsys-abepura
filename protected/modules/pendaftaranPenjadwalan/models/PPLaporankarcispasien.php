<?php
class PPLaporankarcispasien extends LaporankarcispasienV {

    public $data;
    public $jumlah;
    public $tick;
    public $tgl_awal,$tgl_akhir;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTableLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
               
		$criteria=new CDbCriteria;

		$criteria->order = 'ruangan_nama';
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
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
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
               
		$criteria=new CDbCriteria;
            
		if (!empty($this->ruangan_id)){
			$criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
			$criteria->group = 'ruangan_nama';
		}
		else if (!empty($this->instalasi_id)){
			$criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data, instalasi_nama as tick';
			$criteria->group = 'instalasi_nama, ruangan_nama';
			$criteria->order = 'instalasi_nama, ruangan_nama';

		}else{
			$criteria->select = 'count(pendaftaran_id) as jumlah, instalasi_nama as data';
			$criteria->group = 'instalasi_nama';
			$criteria->order = 'instalasi_nama';
		}

		$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');

		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
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
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->limit = -1;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.
                
                
                $criteria=new CDbCriteria;
//                if (!empty($this->ruangan_id)){
//                    $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_id, kelaspelayanan_nama as data';
//                    $criteria->group = 'kelaspelayanan_nama, kelaspelayanan_id';
//                }
//                else if (!empty($this->instalasi_id)){
//                    $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_id, kelaspelayanan_nama as data, ruangan_nama as tick';
//                    $criteria->group = 'kelaspelayanan_nama, kelaspelayanan_id, ruangan_nama';
//
//                }else{
//                    $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_id, kelaspelayanan_nama as data, instalasi_nama as tick';
//                    $criteria->group = 'kelaspelayanan_nama, kelaspelayanan_id, instalasi_nama';
//                }
                $criteria->order = 'ruangan_nama';
			$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
			$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
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
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
			$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
			}
			$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
			}
			$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
        }
        
        
        
        public function getNamaModel(){
            return __CLASS__;
        }

}