<?php

class BSLaporansensuspenunjangV extends LaporansensusbedahsentralV{

/**
 * #view yang sebelumnya LaporansensuspenunjangV digunakan, sebelum diganti menajadi LaporansensusbedahsentralV
 *  
 */
	public $jns_periode;
	public $tgl_awal, $bln_awal, $thn_awal;
	public $tgl_akhir, $bln_akhir, $thn_akhir;
	public $data, $jumlah;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

//        if (!is_array($this->kunjungan)){
//            $this->kunjungan = 0;
//        }
        if (is_array($this->kunjungan)){
            $criteria->addInCondition('kunjungan', $this->kunjungan);
        }else{
            $this->kunjungan = array('KUNJUNGAN BARU','KUNJUNGAN LAMA');
        }
       
        
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('kunjungan', $this->kunjungan);
		
        
        if(!empty($this->carabayar_id)){
                $criteria->addCondition('carabayar_id = '.$this->carabayar_id);
        }

      //  if(!empty($this->ruanganasal_id)){
            if (!empty($this->ruanganasal_id)){
                $criteria->addInCondition('ruanganasal_id',$this->ruanganasal_id);
			}else{
				if (!empty($this->instalasiasal_id)){
					$criteria->addCondition("instalasiasal_id = '".$this->instalasiasal_id."' ");
				}
			}
      //  }
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));

        return $criteria;
    }

    public function searchPrint() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'pagination'=>false, 
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchGrafik() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();
		$criteria->select = 'count(pendaftaran_id) as jumlah';
        
        if ($_GET['tampilGrafik'] == 'instalasiasal'){
			$criteria->select .= ', instalasiasal_nama as data';
			$criteria->group .= 'instalasiasal_nama';
		}elseif ($_GET['tampilGrafik'] == 'ruanganasal'){
			$criteria->select .= ', ruanganasal_nama as data';
			$criteria->group .= 'ruanganasal_nama';
		}elseif ($_GET['tampilGrafik'] == 'carabayar'){
			$criteria->select .= ', carabayar_nama as data';
			$criteria->group .= 'carabayar_nama';
		}elseif ($_GET['tampilGrafik'] == 'penjamin'){
			$criteria->select .= ', penjamin_nama as data';
			$criteria->group .= 'penjamin_nama';
		}elseif ($_GET['tampilGrafik'] == 'kunjungan'){
			$criteria->select .= ', kunjungan as data';
			$criteria->group .= 'kunjungan';
		}

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getNamaModel() {
        return __CLASS__;
    }
    
   // public function getKunjungan(){
      //  $kunjungan = array('Kunjungan satu','Kunjungan dua');
        //return $kunjungan;
    //}
    
    public static function getKunjungan()
    {
        $data = array();
        $criteria = new CDbCriteria();        
        $criteria->select = "kunjungan";
        $criteria->group = "kunjungan";
        $criteria->order = "kunjungan ASC";        
        $models=self::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                $data[$model->kunjungan]= ($model->kunjungan);
        }else{
            $data[""] = null;
        }

        return $data;
    }
	
	public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getNamaNamaBIN()
        {
        	if (!empty($this->nama_bin)) {
        		return $this->nama_pasien.' alias '.$this->nama_bin;
        	} else {
        		return $this->nama_pasien;
        	}
        	
            
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.'/ <br/> '.$this->penjamin_nama;
        }
        
        public function getAlamatRTRW()
        {
            return $this->alamat_pasien.'/<br>'.$this->rt.'  '.$this->rw;
        }
        
        public function getNoRMNoPend(){
            return $this->no_rekam_medik.'<br/>/ '.$this->no_pendaftaran;
        }
        
        public function getTglMasukNoPenunjang(){
            return MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($this->tglmasukpenunjang))).'/<br/> '.PHP_EOL.$this->no_masukpenunjang;
        }
        
        public function getJenisKelaminUmur(){
            return $this->jeniskelamin.'/ <br/> '.$this->umur;
        }
        public function getInstalasiRuangan(){
            return $this->instalasiasal_nama.'/ <br/> '.$this->ruanganasal_nama;
        }

}

?>
