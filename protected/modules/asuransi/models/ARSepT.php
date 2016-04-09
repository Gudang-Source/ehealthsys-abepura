<?php
class ARSepT extends SepT
{
	public $no_rekam_medik,$nopeserta,$pasien_id,$penjamin_id,$carabayar_id;
	public $asuransipasien_id,$namapemilikasuransi,$jenispeserta_id,$pendaftaran_id,$kelastanggungan_id;
	public $barcode_sep,$cari_sep,$surat_rujukan,$nama_peserta,$jeniskelamin;
	public $nama_pasien,$klsrawat_nama,$kelaspelayanan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sep_id',$this->sep_id);
		if(!empty($this->tglsep)){
			$criteria->addBetweenCondition('DATE(tglsep)', $this->tglsep, $this->tglsep);
		}
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		if(!empty($this->tglrujukan)){
			$criteria->addBetweenCondition('DATE(tglrujukan)', $this->tglrujukan, $this->tglrujukan);
		}
		$criteria->compare('LOWER(norujukan)',strtolower($this->norujukan),true);
		$criteria->compare('LOWER(ppkrujukan)',strtolower($this->ppkrujukan),true);
		$criteria->compare('LOWER(ppkpelayanan)',strtolower($this->ppkpelayanan),true);
		$criteria->compare('jnspelayanan',$this->jnspelayanan);
		$criteria->compare('LOWER(catatansep)',strtolower($this->catatansep),true);
		$criteria->compare('LOWER(diagnosaawal)',strtolower($this->diagnosaawal),true);
		$criteria->compare('LOWER(politujuan)',strtolower($this->politujuan),true);
		$criteria->compare('klsrawat',$this->klsrawat);
		if(!empty($this->tglpulang)){
			$criteria->addBetweenCondition('DATE(tglpulang)', $this->tglpulang, $this->tglpulang);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('LOWER(nosep)',strtolower($this->nosep),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(norujukan)',strtolower($this->norujukan),true);
		$criteria->compare('LOWER(ppkrujukan)',strtolower($this->ppkrujukan),true);
		$criteria->compare('LOWER(ppkpelayanan)',strtolower($this->ppkpelayanan),true);
		$criteria->compare('jnspelayanan',$this->jnspelayanan);
		$criteria->compare('LOWER(catatansep)',strtolower($this->catatansep),true);
		$criteria->compare('LOWER(diagnosaawal)',strtolower($this->diagnosaawal),true);
		$criteria->compare('LOWER(politujuan)',strtolower($this->politujuan),true);
		$criteria->compare('klsrawat',$this->klsrawat);
		$criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.sep_id = t.sep_id';
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getJenisPesertaItems(){
		return JenisPesertaM::model()->findAllByAttributes(array('jenispeserta_aktif'=>true));
	}
	
	/**
	 * Mengambil daftar semua kelaspelayanan
	 * @return CActiveDataProvider 
	 */
	public function getKelasTanggunganItems()
	{
		return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
	}
	
	/**
	* Mengambil daftar semua carabayar
	* @return CActiveDataProvider 
	*/
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	/**
	* Mengambil daftar semua penjamin
	* @return CActiveDataProvider 
	*/
	public function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
			return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
			return array();
	}
        
        public function getRuanganNama($politujuan)
        {
            
            if (is_numeric($politujuan)):
                $nama = RuanganM::model()->findAllByAttributes(array('ruangan_id'=>$politujuan));

                if (empty($nama)):
                    $data = '';
                else:
                    foreach($nama as $nama):
                        $data = $nama->ruangan_nama;
                    endforeach;
                endif;                
            else:    
                $nama = RuanganM::model()->findAllByAttributes(array('ruangan_singkatan'=>$politujuan));

                if (empty($nama)):
                    $data = '';
                else:
                    foreach($nama as $nama):
                        $data = $nama->ruangan_nama;
                    endforeach;
                endif;
            endif;
            return $data;
        }
}