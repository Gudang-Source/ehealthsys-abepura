<?php
class ARPasienM extends PasienM
{
	public $no_pendaftaran;
	public $tgl_pendaftaran;
	public $tgl_admisi;
	public $tgl_rm_awal;
	public $tgl_rm_akhir;
	public $jeniskasuspenyakit_nama;
	public $ceklis;
	public $umur,$thn,$bln,$hr; //untuk pendaftaran.umur
	public $isPasienLama = false;
	public $propinsiNama, $kabupatenNama, $kecamatanNama, $kelurahanNama;
	public $cari_kelurahan_nama, $cari_kecamatan_nama; //filter pencarian
	public $nomorindukpegawai,$nama_pegawai,$pegawai_aktif;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	/**
	 * untuk menampilkan data pada grid dialog pasien
	 * @return \CActiveDataProvider
	 */
	public function searchDialog()
	{
		$criteria=$this->criteriaSearch();
		$criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
							LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		if($this->ispasienluar){
			$criteria->addCondition('ispasienluar = TRUE');
		}else{
			$criteria->addCondition('ispasienluar = FALSE');
		}
		$criteria->limit=5;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}
