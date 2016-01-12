<?php

class MAReevaluasiasetT extends ReevaluasiasetT
{
	public $namaaset;
	public $no_registrasi;	
	public $jenis_aset;
	public $barang_nama,$barang_kode,$barang_type,$barang_namalainnya;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		/*
		 * search dialog aset
		 */
		public function searchAset()
		{
			$criteria=new CDbCriteria;
			
			$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
			$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
			$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
			$criteria->compare('LOWER(barang_namalainnya)',strtolower($this->barang_namalainnya),true);

			$criteria->condition="t.invasetlain_id is not null or t.invtanah_id is not null or t.invperalatan_id is not null or 
						t.invgedung_id is not null or t.invjalan_id is not null";		
			$criteria->limit=10;
			//print_r($criteria);die();
			return new CActiveDataProvider('MABarangV', array(
							'criteria'=>$criteria,
							'pagination'=>false,
					));
			}
			
		/*
		 * search dialog aset
		 */
		public function searchNoreg()
		{
			$criteria=new CDbCriteria;
			$criteria->condition='invasetlain_noregister is not null or invtanah_noregister is not null or invperalatan_noregister is not null or invgedung_noregister is not null or
						invjalan_noregister is not null';		
			$criteria->limit=10;
			return new CActiveDataProvider('MABarangV', array(
							'criteria'=>$criteria,
							'pagination'=>false,
					));
			}
			
		/*
		 * search revaluasi aset
		 */
		public function searchReevaluasiAset()
		{
			$criteria=new CDbCriteria;			
			$criteria->join = "join penyusutanaset_t on (penyusutanaset_t.barang_id=t.barang_id)
							   join penyusutanasetdetail_t on (penyusutanaset_t.penyusutanaset_id=penyusutanasetdetail_t.penyusutanaset_id)
							";
			$criteria->select="t.*,
						date_part('month', age(penyusutanaset_t.tgl_penyusutan,penyusutanaset_t.create_time) * penyusutanasetdetail_t.penyusutanaset_saldo) as penyusutan
						,penyusutanasetdetail_t.penyusutanaset_saldo as saldo,penyusutanaset_t.hargaperolehan as hrg_peroleh,penyusutanaset_t.umurekonomis as umur_ekonomis,
						concat(t.invasetlain_noregister,t.invtanah_noregister,t.invperalatan_noregister,t.invgedung_noregister,t.invjalan_noregister) as noreg";
			$criteria->condition="t.barang_kode='".isset($_GET['barang_kode']) ? 'NULL' : $_GET['barang_kode'] ."' or
						penyusutanaset_t.invasetlain_id is not null or penyusutanaset_t.invtanah_id 
						is not null or penyusutanaset_t.invperalatan_id is not null or penyusutanaset_t.invgedung_id is not null or
						penyusutanaset_t.invjalan_id is not null				
						";
			$criteria->limit=10;
			return new CActiveDataProvider('MABarangV', array(
							'criteria'=>$criteria,
							'pagination'=>false,
					));
			}				
}