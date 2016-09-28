<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ROLaporan10besarpenyakit
 *
 * @author sujana
 */
class ROLaporanrekaptransaksi extends LaporanrekaptransaksiV {

    public $jns_periode;
    public $tgl_awal, $tgl_akhir;
    public $bln_awal, $bln_akhir;
    public $thn_awal, $thn_akhir;
    public $jumlah, $data, $tick, $tot_tarif;
    public $status;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchLapPembayaPeriksaRAD() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionLapPembayaPeriksaRADCriteria();
        $criteria->order = 'tgl_pendaftaran DESC, nama_pasien ASC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchLapPembayaPeriksaRADPrint() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionLapPembayaPeriksaRADCriteria();
        $criteria->order = 'tgl_pendaftaran DESC, nama_pasien ASC';
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    protected function functionLapPembayaPeriksaRADCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->select = " tgl_pendaftaran, no_pendaftaran, no_rekam_medik, namadepan, "
                . "nama_pasien, gelardepan, nama_pegawai, gelarbelakang_nama, tarif_tindakan, "
                . "SUM(tarif_tindakan) as tot_tarif, carabayar_nama, penjamin_nama, "
                . "pendaftaran_id, tindakansudahbayar_id, ruangan_id ";
        $criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);                       
        if (!empty($this->carabayar_id))
        {
            $criteria->addCondition("carabayar_id = ".$this->carabayar_id);
        }
        
        if (!empty($this->penjamin_id))
        {
            $criteria->addCondition("penjamin_id = ".$this->penjamin_id);
        }
        
        if (!empty($this->pegawai_id)){
            $criteria->addCondition("pegawai_id = ".$this->pegawai_id);
        }
               
        if (!empty($this->status)){
            if (strtolower($this->status) == strtolower(Params::STATUSBAYAR_LUNAS)){
                $criteria->addCondition(" tindakansudahbayar_id IS NOT NULL ");
            }elseif (strtolower($this->status) == strtolower(Params::STATUSBAYAR_BELUM_LUNAS)){
                $criteria->addCondition(" tindakansudahbayar_id IS NULL ");
            }
        }
    
        $criteria->addCondition(" ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
        
        $criteria->group = " tgl_pendaftaran, no_pendaftaran, no_rekam_medik, namadepan, "
                . "nama_pasien, gelardepan, nama_pegawai, gelarbelakang_nama, "
                . "tarif_tindakan, carabayar_nama, penjamin_nama, "
                . "pendaftaran_id, tindakansudahbayar_id, ruangan_id ";


        return $criteria;
    }

     public function searchLapPembayaPeriksaRADGrafik()
     {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->select = "count(pendaftaran_id) as jumlah, carabayar_nama as data";
            $criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal,$this->tgl_akhir,true);                       
            if (!empty($this->carabayar_id))
            {
                $criteria->addCondition("carabayar_id = ".$this->carabayar_id);
            }

            if (!empty($this->penjamin_id))
            {
                $criteria->addCondition("penjamin_id = ".$this->penjamin_id);
            }

            if (!empty($this->pegawai_id)){
                $criteria->addCondition("pegawai_id = ".$this->pegawai_id);
            }

            if (!empty($this->status)){
                if (strtolower($this->status) == strtolower(Params::STATUSBAYAR_LUNAS)){
                    $criteria->addCondition(" tindakansudahbayar_id IS NOT NULL ");
                }elseif (strtolower($this->status) == strtolower(Params::STATUSBAYAR_BELUM_LUNAS)){
                    $criteria->addCondition(" tindakansudahbayar_id IS NULL ");
                }
            }

            $criteria->addCondition(" ruangan_id = ".Yii::app()->user->getState('ruangan_id'));

            $criteria->group = " carabayar_nama ";



            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }       
    
    public function getNamaModel()
    {
        return __CLASS__;
    }

}

?>
