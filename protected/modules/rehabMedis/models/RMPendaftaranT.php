<?php
class RMPendaftaranT extends PendaftaranT {
    public $jeniskasuspenyakit_nama='';
    public $is_adapjpasien = 0;
    public $is_pasienrujukan = 0;
	public $diagnosa;
    
    public $isRujukan,$isPasienLama,$pakeAsuransi,$adaPenanggungJawab,$adaKarcis,$noRekamMedik;
    
     public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
    * menampilkan riwayat pendaftaran pasien di:
    * - pendaftaran Laboratorium
    * @return \CActiveDataProvider
    */
    public function searchRiwayatPasien(){
       $criteria=new CDbCriteria;
       $criteria->addCondition('pasien_id = '.$this->pasien_id);
       $criteria->order = 'tgl_pendaftaran desc';          
       $criteria->limit = 5;          
       return new CActiveDataProvider($this, array(
               'criteria'=>$criteria,
       ));
    }

    public function getRuanganItems($instalasiId ='') 
    {
        return RuanganM::model()->findAll('(instalasi_id = '.Params::INSTALASI_ID_LAB.' OR instalasi_id = '.Params::INSTALASI_ID_RAD.' OR instalasi_id = '.Params::INSTALASI_ID_REHAB. ' OR instalasi_id = '.Params::INSTALASI_ID_IBS. ') AND ruangan_aktif=true ORDER BY ruangan_nama');
    }
    public function getJenisKasusPenyakit()
    {
        return JeniskasuspenyakitM::model()->findAllByAttributes(array('jeniskasuspenyakit_aktif'=>true),array('order'=>'jeniskasuspenyakit_nama'));
    }
     public function getKelasPelayanan()
    {
        return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
    }
	/**
	* Mengambil daftar semua kelaspelayanan
	* @return CActiveDataProvider 
	*/
   public static function getKelasPelayananItems($ruangan_id = null)
   {
	   if($ruangan_id==null){
		   return array();
	   }else{
		  $criteria = new CdbCriteria();
		   $criteria->join = "JOIN kelasruangan_m on t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
		   $criteria->addCondition('t.kelaspelayanan_aktif = true');
		   $criteria->addCondition('kelasruangan_m.ruangan_id ='.$ruangan_id);
		   $criteria->order = "t.urutankelas";
		   return KelaspelayananM::model()->findAll($criteria);
	   } 
   }
   /**
	* mengambil data jenis kasus penyakit berdasarkan ruangan
	* @param type $ruangan_id
	*/
	public static function getJenisKasusPenyakitItems($ruangan_id = null)
	{            
		if(empty($ruangan_id)){
			$ruangan_id = Yii::app()->user->getState('ruangan_id');
		}
		$criteria = new CdbCriteria();
		$criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
		$criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
		$criteria->order = "t.jeniskasuspenyakit_nama";
		$criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
		return JeniskasuspenyakitM::model()->findAll($criteria);
	}
	/**
	* menampilkan dokter 
	* @param type $ruangan_id
	* @return type
	*/
   public static function getDokterItems($ruangan_id='')
   {
	   $criteria = new CdbCriteria();
	   if(!empty($ruangan_id)){
		   $criteria->addCondition("ruangan_id = ".$ruangan_id);					
	   }
	   $criteria->addCondition('pegawai_aktif = true');
	   $criteria->order = "nama_pegawai, gelardepan";
	   $modDokter = DokterV::model()->findAll($criteria);
	   return $modDokter;
   }
    public function getDokter()
    {
        return DokterV::model()->findAll('ruangan_id='.Yii::app()->user->getState('ruangan_id').' ORDER BY nama_pegawai');
    }
    public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
    public function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
				return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
				return array();
	}
	public function getParamedisItems($ruangan_id='')
	{
		if(!empty($ruangan_id))
			return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
		else
			return array();
	}
        
}
?>
