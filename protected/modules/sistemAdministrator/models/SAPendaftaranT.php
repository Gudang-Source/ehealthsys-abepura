<?php

class SAPendaftaranT extends PendaftaranT
{    
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function relations()
	{ 
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                        'penanggungJawab'=>array(self::BELONGS_TO,'PenanggungjawabM','penanggungjawab_id'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                        'jeniskasuspenyakit'=>array(self::BELONGS_TO,'JeniskasuspenyakitM','jeniskasuspenyakit_id'),
                        'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                        'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
                        'instalasi'=>array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
                        'carabayar'=>array(self::BELONGS_TO,  'CarabayarM', 'carabayar_id'),
                        'kirimkeunitlain'=>array(self::HAS_MANY, 'PasienkirimkeunitlainT', 'pendaftaran_id'),
                        'anamnesa'=>array(self::HAS_ONE, 'AnamnesaT', 'pendaftaran_id'),
                        'pemeriksaanfisik'=>array(self::HAS_ONE, 'PemeriksaanfisikT', 'pendaftaran_id'),
                        'pasienmasukpenunjang'=>array(self::HAS_ONE, 'PasienmasukpenunjangT', 'pendaftaran_id'),
                        'diagnosa'=>array(self::HAS_MANY, 'PasienmorbiditasT', 'pendaftaran_id'),
                        'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                        'hasilpemeriksaanlab'=>array(self::HAS_ONE, 'HasilpemeriksaanlabT', 'pendaftaran_id'),
                        'pasienpulang'=>array(self::HAS_ONE, 'PasienpulangT', 'pasienpulang_id'),
                        'tindakanpelayanan'=>array(self::HAS_MANY, 'TindakanpelayananT', 'pendaftaran_id'),
                        'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                    
		);
	}
        
    public function searchRiwayat($data)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
			
			if (!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
			}
			if (!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
			}
			if (!empty($this->caramasuk_id)){
				$criteria->addCondition('caramasuk_id ='.$this->caramasuk_id);
			}
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
			if (!empty($this->pasien_id)){
				$criteria->addCondition('pasien_id ='.$this->pasien_id);
			}
			if (!empty($this->shift_id)){
				$criteria->addCondition('shift_id ='.$this->shift_id);
			}
			if (!empty($this->golonganumur_id)){
				$criteria->addCondition('golonganumur_id ='.$this->golonganumur_id);
			}
			if (!empty($this->kelaspelayanan_id)){
				$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
			}
			if (!empty($this->rujukan_id)){
				$criteria->addCondition('rujukan_id ='.$this->rujukan_id);
			}
			if (!empty($this->penanggungjawab_id)){
				$criteria->addCondition('penanggungjawab_id ='.$this->penanggungjawab_id);
			}
			if (!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
			}
			if (!empty($this->instalasi_id)){
				$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
			}
			if (!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition('jeniskasuspenyakit_id ='.$this->jeniskasuspenyakit_id);
			}
            $criteria->condition = "pasien_id = ".$data;
//            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
//            $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
//            $criteria->compare('no_urutantri',$this->no_urutantri);
//            $criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
//            $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
//            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
//            $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
//            $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
//            $criteria->compare('alihstatus',$this->alihstatus);
//            $criteria->compare('byphone',$this->byphone);
//            $criteria->compare('kunjunganrumah',$this->kunjunganrumah);
//            $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
//            $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
            //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
            //$criteria->order = 'no_urutantri';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function getKelasPelayananItems()
    {
        return SAKelasPelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
    }

    public function getCarabayarItems()
    {
        return CarabayarM::model()->findAll("carabayar_aktif=TRUE ORDER BY carabayar_nama");
    }

    public function getPenjaminItems()
    {
        return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
    }

}
?>