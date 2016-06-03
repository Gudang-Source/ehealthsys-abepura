<?php
class KPPresensiT extends PresensiT {
    public $ruangan_id;
    public $instalasi_id;
    public $kategoripegawai;
    public $datepresensi;
    public $unit_perusahaan;
    public $statusscan_nama;
    public $statuskehadiran_nama;
    public $kelompokpegawai_id;
    public $jabatan_id;
    
    
    public static function model($class = __CLASS__){
        return parent::model($class);
        
    }    
    
    
   
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
        
            $criteria=new CDbCriteria;
            $criteria->with = array('statusscan','pegawai', 'statuskehadiran');
            $criteria->compare('t.presensi_id',$this->presensi_id);
            $criteria->compare('t.statusscan_id',$this->statusscan_id);
            $criteria->compare('t.pegawai_id',$this->pegawai_id);
            $criteria->compare('t.statuskehadiran_id',$this->statuskehadiran_id);
            $criteria->addBetweenCondition('date(t.tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
//		$criteria->compare('tglpresensi',$this->tglpresensi,true);
            $criteria->compare('t.no_fingerprint',$this->no_fingerprint,true);
            $criteria->compare('t.verifikasi',$this->verifikasi);
            $criteria->compare('t.keterangan',$this->keterangan,true);
            $criteria->compare('t.create_time',$this->create_time,true);
            $criteria->compare('t.user_id',$this->user_id);
            $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(statusscan.statusscan_nama)',strtolower($this->statusscan_nama),true);
            $criteria->compare('LOWER(statuskehadiran.statuskehadiran_nama)',strtolower($this->statuskehadiran_nama),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function searchInformasiPresensi()
    {
        $provider = $this->search();
        $provider->criteria->with = array();
        $provider->criteria->join = "left join statusscan_m statusscan on statusscan.statusscan_id = t.statusscan_id "
                . "left join pegawai_m pegawai on pegawai.pegawai_id = t.pegawai_id "
                . "left join statuskehadiran_m statuskehadiran on statuskehadiran.statuskehadiran_id = t.statuskehadiran_id";
        $provider->criteria->group = "t.no_fingerprint, t.pegawai_id, t.statuskehadiran_id, t.tglpresensi::date, pegawai.nama_pegawai";
        $provider->criteria->select = $provider->criteria->group;
        
        $provider->criteria->compare('pegawai.kelompokpegawai_id', $this->kelompokpegawai_id);
        $provider->criteria->compare('pegawai.jabatan_id', $this->jabatan_id);
        
        $provider->criteria->order = 'pegawai.nama_pegawai, t.tglpresensi::date';
        
        return $provider;
    }
    
    public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
            
            $criteria=new CDbCriteria;
            $criteria->with = array('statusscan','pegawai', 'statuskehadiran');
            $criteria->compare('t.presensi_id',$this->presensi_id);
            $criteria->compare('t.statusscan_id',$this->statusscan_id);
            $criteria->compare('t.pegawai_id',$this->pegawai_id);
            $criteria->compare('t.statuskehadiran_id',$this->statuskehadiran_id);
            $criteria->addBetweenCondition('date(t.tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
            $criteria->compare('t.no_fingerprint',$this->no_fingerprint,true);
            $criteria->compare('t.verifikasi',$this->verifikasi);
            $criteria->compare('t.keterangan',$this->keterangan,true);
            $criteria->compare('t.create_time',$this->create_time,true);
            $criteria->compare('t.user_id',$this->user_id);
            $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(statusscan.statusscan_nama)',strtolower($this->statusscan_nama),true);
            $criteria->compare('LOWER(statuskehadiran.statuskehadiran_nama)',strtolower($this->statuskehadiran_nama),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
		));
        
        }

    public function detailPresensi()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 'date(t.tglpresensi) as datepresensi, t.pegawai_id, t.no_fingerprint, t.statuskehadiran_id';
        $criteria->order = 'date(t.tglpresensi)';
        $criteria->group = 'date(t.tglpresensi), t.pegawai_id, t.no_fingerprint, t.statuskehadiran_id';
        $criteria->addBetweenCondition('DATE(tglpresensi)', $this->tglpresensi, $this->tglpresensi_akhir);
        $criteria->compare('pegawai_id',$this->pegawai_id);       
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria
            )
        );
    }
    
    public function printDetailPresensi()
    {
        $criteria=new CDbCriteria;
        $criteria->select = 'date(t.tglpresensi) as datepresensi, t.pegawai_id, t.no_fingerprint, t.statuskehadiran_id';
        $criteria->order = 't.pegawai_id, date(t.tglpresensi)';
        $criteria->group = 'date(t.tglpresensi), t.pegawai_id, t.no_fingerprint, t.statuskehadiran_id';
        $criteria->compare('pegawai_id',$this->pegawai_id);
        $criteria->addBetweenCondition('DATE(tglpresensi)', $this->tglpresensi, $this->tglpresensi_akhir);
        return new CActiveDataProvider($this,
            array(
                'criteria'=>$criteria,
                'pagination'=>false
            )
        );
    }    
    
    public function criteriaPresensi()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->select = 'date(t.tglpresensi) as datepresensi, t.pegawai_id, t.no_fingerprint, t.statuskehadiran_id';
        $criteria->order = 't.pegawai_id, date(t.tglpresensi)';
        $criteria->group = 'date(t.tglpresensi), t.pegawai_id, t.no_fingerprint, t.statuskehadiran_id';
        $criteria->join = 'INNER JOIN pegawai_m ON pegawai_m.pegawai_id=t.pegawai_id';
        $criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
        $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
        $criteria->compare('kategoripegawai',$this->kategoripegawai);
        $criteria->compare('nofingerprint',$this->no_fingerprint);
        $criteria->compare('pegawai_m.unit_perusahaan',$this->unit_perusahaan);

        if(!empty($this->ruangan_id))
        {
            $criteria_dua = new CDbCriteria;
            $criteria_dua->compare('ruangan_id', $this->ruangan_id);
            $record = RuanganpegawaiM::model()->findAll($criteria_dua);
            $pegawai = array();
            $is_exist = null;
            foreach($record as $val)
            {
                if($is_exist != $val->pegawai_id)
                {
                    $pegawai[] = $val->pegawai_id;
                }
                $is_exist = $val->pegawai_id;
            }
            $criteria->compare('pegawai_m.pegawai_id',$pegawai);
        }

        return $criteria;
    }
    
    public function searchPresensi()
    {
        return new CActiveDataProvider($this, array(
            'criteria'=>$this->criteriaPresensi(),
            'pagination'=>array(
                'pageSize'=>10,
            )
        ));
    }
    
    public function searchPrintpresensi()
    {
        return new CActiveDataProvider($this, array(
            'criteria'=>$this->criteriaPresensi(),
            'pagination'=>false,
        ));
    }
    
    public function getTerlambat($tglpresensi, $jamkerjamasuk)
    {        
        $tepat = strtotime($tglpresensi);
        $masuk = strtotime(date('Y-m-d',  strtotime($tglpresensi)).' '.$jamkerjamasuk);
        
        return round(($tepat - $masuk) / 60);
        //$this->jamkerjamasuk
    }
    
    public function getPulangAwal($tglpresensi, $jamkerjamasuk)
    {
        $tepat = strtotime($tglpresensi);
        $pulang = strtotime(date('Y-m-d',  strtotime($tglpresensi)).' '.$jamkerjamasuk);
        
        return round(($pulang - $tepat) / 60);
    }
        
                public function getStatusItems()
                {
                    return StatuskehadiranM::model()->findAll();
                }
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function getShiftId($pegawai_id){
        $shift_id = KPPegawaiM::model()->findByPk($pegawai_id)->shift_id;
        
        return KPShiftM::model()->findByPk($shift_id);
    }
}