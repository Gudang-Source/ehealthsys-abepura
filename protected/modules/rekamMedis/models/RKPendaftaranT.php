<?php
class RKPendaftaranT extends PendaftaranT
{
    public $kunjunganperhari, $tahun, $carabayar_nama, $jeniskasuspenyakit_nama, $namaLengkap;
    public $penjamin_nama, $jeniskelamin, $no_rekam_medik, $nama_pasien, $namadepan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getInstalasiResepturItems(){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id',array(
                        Params::INSTALASI_ID_RI, 
                        Params::INSTALASI_ID_RJ, 
                        Params::INSTALASI_ID_RD) 
                    );
            $criteria->order = 'instalasi_nama';
            $modInstalasis = InstalasiM::model()->findAll($criteria);
            if(count($modInstalasis) > 0)
                return $modInstalasis;
            else
                return null;
        }
        
        public function searchDialogKunjungan(){
            $criteria = new CDbCriteria();
            $criteria->with = array('pasien');
            $criteria->addCondition('t.pasienbatalperiksa_id is null');
            $criteria->compare('LOWER(pasien.jeniskelamin)',  strtolower($this->jeniskelamin),TRUE);
            $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik),TRUE);
            $criteria->compare('LOWER(t.no_pendaftaran)',  strtolower($this->no_pendaftaran),TRUE);
            $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),TRUE);
            $criteria->compare('t.carabayar_id', $this->carabayar_id);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
            
        }
        
        

}
