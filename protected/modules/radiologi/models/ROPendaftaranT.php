<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ROPendaftaranT extends PendaftaranT
{
        public $jeniskasuspenyakit_nama='';
        public $is_adapjpasien = 0;
        public $is_pasienrujukan = 0;
		public $is_asubadak = 0;
		public $is_asudepartemen = 0;
		public $is_asupekerja = 0;
        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return KelompokmenuK the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
         /**
         * menampilkan riwayat pendaftaran pasien di:
         * - pendaftaran Radiologi
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
        /**
         * Mengambil daftar semua carabayar
         * @return CActiveDataProvider 
         */
        public static function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }
        /**
         * Mengambil daftar semua penjamin
         * @return CActiveDataProvider 
         */
        public static function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
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
         * Mengambil daftar semua kelaspelayanan di kelastanggungan
         * @return CActiveDataProvider 
         */
        public static function getKelasPelayanan()
        {
            return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
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
}
?>
