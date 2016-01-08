<?php
class GZPesanmenudietT extends PesanmenudietT{
    public $instalasi_id,$kelaspelayanan_id,$ruangna_id;
	public $carabayar_id,$penjamin_id;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public static function jenisPesan(){
        $result = array();
        foreach (LookupM::getItems('jenispesanmenu') as $i=>$value){
            if ($i != Params::JENISPESANMENU_PASIEN){
                $result[$i]=$value;
            }
        }
        return $result;
    }
    
    public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tglpesanmenu)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition('kirimmenudiet_id is null');
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(nopesanmenu)',strtolower($this->nopesanmenu),true);
		$criteria->compare('LOWER(adaalergimakanan)',strtolower($this->adaalergimakanan),true);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('LOWER(nama_pemesan)',strtolower($this->nama_pemesan),true);
		$criteria->compare('totalpesan_org',$this->totalpesan_org);
		$criteria->order='tglpesanmenu DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
    * Mengambil daftar semua kelaspelayanan
    * @return CActiveDataProvider 
    */
    public function getKelasPelayananItems($ruangan_id = null)
    {
        if($ruangan_id == ''){
           $ruangan_id = Yii::app()->user->getState('ruangan_id');
         }
        $criteria = new CdbCriteria();
        $criteria->addCondition('kelasruangan_m.ruangan_id = '.$ruangan_id);
        $criteria->addCondition('t.kelaspelayanan_aktif = true');
        $criteria->order = "t.urutankelas";
        $criteria->join = "JOIN kelasruangan_m ON t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
        return KelaspelayananM::model()->findAll($criteria);
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
		if(!empty($carabayar_id)){
			return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		}else{
			return array();
		}
	}
	
	public function getRuanganItems($instalasi_id=null)
	{
		if(!empty($instalasi_id)){
			return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
		}else{
			return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
		}
	}
	
	/**
	* menampilkan instalasi untuk pesan menu diet pasien
	* @return array
	*/
       public function getInstalasiItems(){
	   $criteria = new CDbCriteria();
	   $criteria->addInCondition('instalasi_id',array(
		       Params::INSTALASI_ID_RJ, 
		       Params::INSTALASI_ID_RD, 
		       Params::INSTALASI_ID_RI) 
		   );
	   $criteria->addCondition('instalasi_aktif = true');
	   $modInstalasis = InstalasiM::model()->findAll($criteria);
	   if(count($modInstalasis) > 0)
	       return $modInstalasis;
	   else
	       return array();
       }
}