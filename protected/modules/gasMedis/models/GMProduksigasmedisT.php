<?php

class GMProduksigasmedisT extends ProduksigasmedisT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokobatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public $tgl_awal, $tgl_akhir, $petugas_nama, $mengetahui_nama;
        public function searchInformasi() {
            $provider = $this->search();
            $provider->criteria->with = array('petugas', 'mengetahui');
            $provider->criteria->compare('lower(petugas.nama_pegawai)', strtolower($this->petugas_nama), true);
            $provider->criteria->compare('lower(mengetahui.nama_pegawai)', strtolower($this->mengetahui_nama), true);
            $provider->criteria->addBetweenCondition('tgl_produksi::date', $this->tgl_awal, $this->tgl_akhir);
            
            return $provider;
        }
}