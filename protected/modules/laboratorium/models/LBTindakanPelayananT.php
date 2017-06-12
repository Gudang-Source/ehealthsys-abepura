<?php

class LBTindakanPelayananT extends TindakanpelayananT
{
        public $pemeriksaanlab_id; //untuk form daftar tindakan pemeriksaan
        public $jenistarif_id; //untuk form daftar tindakan pemeriksaan
        public $totaltariftindakan; //di print status
		
		public $dokterpemeriksa1Nama; //untuk default pemeriksa
		public $pegawai_id,$nama_pegawai;
		public $status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanpelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * menampilkan pemeriksaan lab berdasarkan daftartindakan_id
         * @return type
         */
        public function getPemeriksaanLab(){
            return LBPemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
        }

}