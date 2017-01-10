<?php

class BKInformasibayaruangmukaV extends InformasibayaruangmukaV
{
		
	/**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return InfopasienmasukkamarV the static model class
        */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        public function sisaPembayaran($jmlpembayaran, $jumlahuangmuka) {
			$sisaPembayaran = '';
			$sisa = 0;
			if ($jmlpembayaran > $jumlahuangmuka) {
				$sisa = $jmlpembayaran - $jumlahuangmuka;
				$sisaPembayaran = "Rp. " . number_format($sisa, 0, ",", ".");
			} elseif ($jmlpembayaran < $jumlahuangmuka) {
				$sisa = $jumlahuangmuka - $jmlpembayaran;
				$sisaPembayaran = "Rp. " . number_format($sisa, 0, ",", ".");
			} else {
				$sisaPembayaran = "Rp. 0";
			}

			return $sisaPembayaran;
		}
		
		public function searchInformasi() {
			$prov = $this->search();
			
			
			
			$prov->criteria->group = $prov->criteria->select =
				"tgluangmuka, no_pendaftaran, no_rekam_medik, nama_pasien, "
				. "carabayar_nama, penjamin_nama, jumlahuangmuka, "
				. "pemakaianuangmuka, sisauangmuka, jmlpembayaran, "
				. "jumlahuangmuka, keteranganuangmuka, tglperjanjian, "
				. "keterangan_perjanjian, bayaruangmuka_id, instalasi_nama, ruangan_nama";
			
			return $prov;
		}
	
}