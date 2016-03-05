<?php
class BKLaporanCaraBayar extends LaporankunjunganrsV {
    public $pilihan_tab;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPasien()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
    
    public function rekapPenjamin()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->select = 'COUNT(penjamin_id) as jumlah, penjamin_nama';
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_id, penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }

    public function printRekapPenjamin()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->select = 'COUNT(penjamin_id) as jumlah, penjamin_nama';
        $criteria->order = 'penjamin_nama';
        $criteria->group = 'penjamin_id, penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }    
    
    public function searchPrintLaporan()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'penjamin_nama';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }    
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition('penjamin_id != 117');
        $criteria->compare('ruangan_id', $this->ruangan_id);
		//if(!empty($this->ruangan_id)){
		//	$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		//}
        return $criteria;
    }
    
    public function getNamaModel() {
        return __CLASS__;
    }
    
    public function getNamaDokter()
    {
        $query = "SELECT pegawai_m.nama_pegawai FROM pegawai_m
        JOIN pendaftaran_t ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
        WHERE pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($query)->queryRow();
        return $result['nama_pegawai'];
    }
    
    public function getTglKeluar()
    {
        if(!is_null($this->pasienpulang_id))
        {
            $pulang = PasienpulangT::model()->findByPk($this->pasienpulang_id);
        }
        return (isset($pulang['tglpasienpulang']) ? $pulang['tglpasienpulang'] : '-') ;
    }

    public function getNamaPerujuk()
    {
        if($this->statusmasuk == 'RUJUKAN')
        {
            $rujukan = RujukanT::model()->findByPk($this->rujukan_id);
        }
        return (isset($rujukan['nama_perujuk']) ? $rujukan['nama_perujuk'] : '-') ;
    }
    
    public function getDiagnosa()
    {
        $sql = "SELECT * FROM diagnosa_m
            JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
            WHERE pasienmorbiditas_t.pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($sql)->queryAll();
        $diagnosa = array();
        foreach($result as $val)
        {
            $diagnosa[] = $val['diagnosa_nama'];
        }
        return (count($diagnosa) > 0 ? implode('<br>', $diagnosa) : '-');
    }
}
