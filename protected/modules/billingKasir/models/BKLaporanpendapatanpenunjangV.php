<?php

class BKLaporanpendapatanpenunjangV extends LaporanpendapatanpenunjangV
{
    public $tgl_awal, $tgl_akhir, $bulan, $asal;
    public $filter_tab;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanpendapatanpenunjangV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchTable()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->order = 'tgl_tindakan';
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
            )
        );
    }
    
    public function searchPrint()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->order = 'tgl_tindakan';
        return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
    }

    public function printRekapTable()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
         $criteria->select = 'no_rekam_medik, no_pendaftaran, nama_pasien, penjamin_nama, pendaftaran_id, rujukan_id, sum(tarif_tindakan) AS tarif_tindakan, sum(subsidiasuransi_tindakan) AS subsidiasuransi_tindakan, sum(subsidipemerintah_tindakan) AS subsidipemerintah_tindakan, sum(subsisidirumahsakit_tindakan) AS subsisidirumahsakit_tindakan, sum(iurbiaya_tindakan) AS iurbiaya_tindakan';
        $criteria->group = 'no_pendaftaran, no_rekam_medik, nama_pasien, penjamin_nama, pendaftaran_id, rujukan_id';
        $criteria->order = 'no_rekam_medik, nama_pasien, no_pendaftaran';
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'pagination' => false,
            )
        );
    }
    
    public function searchDetailTable()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'pagination' => false,
            )
        );
    }
    
    public function printLapTransaksi()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $record = $this->model()->findAll($criteria);
        return $record;
    }
    
    public function searchTableGroup()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->select = 'no_rekam_medik, no_pendaftaran, nama_pasien, penjamin_nama, pendaftaran_id, rujukan_id, sum(tarif_tindakan) AS tarif_tindakan, sum(subsidiasuransi_tindakan) AS subsidiasuransi_tindakan, sum(subsidipemerintah_tindakan) AS subsidipemerintah_tindakan, sum(subsisidirumahsakit_tindakan) AS subsisidirumahsakit_tindakan, sum(iurbiaya_tindakan) AS iurbiaya_tindakan';
        $criteria->group = 'no_pendaftaran, no_rekam_medik, nama_pasien, penjamin_nama, pendaftaran_id, rujukan_id';
        $criteria->order = 'no_rekam_medik, nama_pasien, no_pendaftaran';
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
            )
        );
    }    
    
    public function functionCriteria()
    {
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('no_pendaftaran',  strtolower($this->no_pendaftaran), true);
            $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			if(!empty($this->penjamin_id)){
                            
                                $count = count($this->penjamin_id);
                                $penjamin_id = '';
                                for ($i=0;$i<$count;$i++)
                                {
                                    $penjamin_id = $this->penjamin_id[$i].',';
                                }
                                $penjamin_id = trim($penjamin_id, ',');
                                $criteria->addCondition('penjamin_id IN ('.$penjamin_id.')');
				
			}
            if(isset($this->asal)){
                if($this->asal == 'rs')
                    $criteria->addCondition('rujukan_id IS NULL');
                else if($this->asal == 'rujukan'){
                    $criteria->addCondition('rujukan_id IS NOT NULL');
                }
            }
            $criteria->addInCondition('ruangan_id',array(
                Params::RUANGAN_ID_LAB_KLINIK,
                Params::RUANGAN_ID_LAB_ANATOMI,
                Params::RUANGAN_ID_RAD,
            ));
            return $criteria;
    }
    
    public function getNamaModel()
    {
        return __CLASS__;
    }
    
    public function getTotalSubsidi(){
        return ($this->subsidiasuransi_tindakan + $this->subsidipemerintah_tindakan + $this->subsisidirumahsakit_tindakan);
    }
    
    public function getSumTarifTindakan()
    {
        $hasils = 0;
        $hasil = 0;
        $criteria=$this->functionCriteria();
        $criteria->select = 'SUM(tarif_tindakan) as tarif_tindakan';
        
        $hasils = $this->model()->findAll($criteria);
        foreach($hasils AS $i => $value){
            $hasil += $value->tarif_tindakan;
        }
        return $hasil;
//        return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    }
    
    public function getSumTotalSubsidi()
    {
        $hasils = 0;
        $hasil = 0;
        $criteria=$this->functionCriteria();
        $criteria->select = 'SUM(subsidiasuransi_tindakan) as subsidiasuransi_tindakan,'
                . '         SUM(subsidipemerintah_tindakan) as subsidipemerintah_tindakan,'
                . '         SUM(subsisidirumahsakit_tindakan) as subsisidirumahsakit_tindakan';
        
        $hasils = $this->model()->findAll($criteria);
        foreach($hasils AS $i => $value){
            $hasil += $value->subsidiasuransi_tindakan + $value->subsidipemerintah_tindakan + $value->subsisidirumahsakit_tindakan;
        }
        return $hasil;
//        return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
    }
}