<?php

class FAPendaftaranT extends PendaftaranT
{
        public $is_pasien = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * getInstalasiResepturItems = menampilkan instalasi yang bisa menerima resep
         * @return null
         */
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
        public function getRuangan(){
            $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id'=>$this->ruangan_id));
            if(!empty($modRuangan->ruangan_nama))
                return isset($modRuangan->ruangan_nama) ? $modRuangan->ruangan_nama:'';
            else
                return null;
        }
        public function getKelasPelayanan()
        {
        $kelas = KelaspelayananM::model()->findByPk($this->kelaspelayanan_id);
            if(!empty($kelas->kelaspelayanan_nama))
                return isset($kelas->kelaspelayanan_nama) ? $kelas->kelaspelayanan_nama:'';
            else
                return null;
        }
        public function getRujukan()
        {
        $rujukan = RujukanT::model()->findByPk($this->rujukan_id);
            if(!empty($rujukan->rujukan_id))
                return isset($rujukan->rujukan_id) ? $rujukan->rujukan_id:'';
            else
                return null;
        }
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
}