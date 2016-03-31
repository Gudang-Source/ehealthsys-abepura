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
class RDInfoKunjunganRDV extends InfokunjunganrdV
{
         public $ceklis = false;
         public $tgl_awal,$tgl_akhir;
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
                
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar ),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
                $criteria->compare('pegawai_id', $this->pegawai_id);
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
                
		if($this->ceklis)
		{
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'defaultOrder'=>'tgl_pendaftaran asc',
                        )
		));
	}
        
        public function searchDialogKunjungan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar ),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('jeniskelamin', $this->jeniskelamin);
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
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		// $criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        // 'pagination'=>false,
		));
	}
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        
        
        function getNamaPasienNamaBin()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        
        public function getInsatalasiRuangan()
        {
               
            return $this->instalasi_nama.' / '.$this->ruangan_nama;
        }

        public function getStatus($status,$id){
            if($status == "ANTRIAN"){
                $status = '<button id="red" class="btn btn-primary" name="yt1">'.$status.'</button>';

            }else if($status == "SEDANG PERIKSA"){
                $status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else if($status == "SUDAH PULANG"){
                $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else if($status == "SUDAH DI PERIKSA"){
                $status = '<button id="red" class="btn btn-danger-red" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else{
                $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1">'.$status.'</button>';
            }
            return $status;
        }

    public function getPeriksaPasien($status,$id,$bayar,$nopen,$alih){
        if($bayar != null){
            $status = '<center><a id='.$nopen.' href="#"  onclick="cekStatus(\''.$status.'\')" rel="tooltip" 
                            data-original-title="Klik untuk Pemeriksaan Pasien"><i class="icon-list-alt"></i></a></center>';
        }else{
            if($status == "ANTRIAN"){
                $status = "<center><a id=".$nopen." href=\"index.php?r=rawatDarurat/anamnesaTRD&pendaftaran_id=".$id."\" rel=\"tooltip\" data-original-title=\"Klik untuk Pemeriksaan Pasien\">
                            <i class=\"icon-list-alt\"></i>
                            </a></center>";

            }else if($status == "SEDANG PERIKSA"){
                $status = "<center><a id=".$nopen." href=\"index.php?r=rawatDarurat/anamnesaTRD&pendaftaran_id=".$id."\" rel=\"tooltip\" data-original-title=\"Klik untuk Pemeriksaan Pasien\">
                            <i class=\"icon-list-alt\"></i>
                            </a></center>";
            }else if($status == "BATAL PERIKSA" || $status =="DIBATALKAN" ||     $status == "SEDANG DIRAWAT INAP" || $alih == true || $status == "SUDAH PULANG"){
                $status = '<center><a id='.$nopen.' href="#"  onclick="cekStatus(\''.$status.'\')" rel="tooltip" 
                                data-original-title="Klik untuk Pemeriksaan Pasien"><i class="icon-list-alt"></i></a></center>';
            }else{
                $status = "<center><a id=".$nopen." href=\"index.php?r=rawatDarurat/anamnesaTRD&pendaftaran_id=".$id."\" rel=\"tooltip\" data-original-title=\"Klik untuk Pemeriksaan Pasien\">
                            <i class=\"icon-list-alt\"></i>
                            </a></center>";
            }
        }
        
        return $status;
    }

    public function getTindakLanjut($status,$id,$nopen,$pasienpulang,$carakeluar,$alih){
            if($status == "ANTRIAN" || $status == "BATAL PERIKSA" || $status == "DIBATALKAN" || $status == "SEDANG DIRAWAT INAP"){
                $status = '<center><a href="#"  onclick="cekStatus(\''.$status.'\')"
                                     rel="tooltip" data-original-title="Klik Untuk Menindak Lanjuti Pasien"><i class="icon-pencil"></i></a></center>';
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

	public function getNamaKamar(){
		$modMasukKamar = PasienadmisiT::model()->findByAttributes(array('pasienadmisi_id'=>$this->pendaftaran->pasienadmisi_id));
		$modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id'=>$modMasukKamar['ruangan_id']));
		return "Ruangan : ".$modRuangan['ruangan_nama'];
	}
	
	public function getNoBed(){
		$modMasukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$this->pendaftaran->pasienadmisi_id),array('order'=>'masukkamar_id desc'));
		$modKamar = KamarruanganM::model()->findByAttributes(array('kamarruangan_id'=>$modMasukKamar['kamarruangan_id']));
		if(count($modMasukKamar)>0 && count($modKamar)>0)
			return "<span>No.Kamar : ".$modKamar['kamarruangan_nokamar']."<br> No.Bed : ".$modKamar['kamarruangan_nobed']."</span>";
		else
			return "";
	}
	
	
}