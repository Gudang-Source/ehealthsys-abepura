<?php
class AKFakturpembelianT extends FakturpembelianT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturpembelianT the static model class
	 */
	
	public $tglAwal;
	public $tglAkhir;
	public $tglAwalJatuhTempo;
	public $tglAkhirJatuhTempo;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	* kriteria pencarian untuk dashboard
	* @return \CActiveDataProvider
	*/
	public function searchDashboard()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	   $criteria=new CDbCriteria;
	   $criteria->compare('DATE(tgljatuhtempo)', date("Y-m-d"));
	   $criteria->order = 'tgljatuhtempo ASC';
	   $criteria->limit = 10;
	   return new CActiveDataProvider($this, array(
		   'criteria'=>$criteria,
		   'pagination'=>false
	   ));
	}
	
	public function getSupplierItems()
	{
		return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='Farmasi' ORDER BY supplier_nama");
	}
	
	public function searchLaporan()
	{

		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaLaporan(),
                                                'pagination'=>array(
                                                    'pageSize'=>10
                                                )
		));
	}
        
	public function searchLaporanPrint()
	{

		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaLaporan(),
                                                'pagination'=>false,
		));
	}
	
	public function searchGrafik()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->select = 'count(fakturpembelian_id) as jumlah, fakturpembelian_id, tglfaktur as data, nofaktur';
			$criteria->group = 'tglfaktur, fakturpembelian_id, nofaktur';
//                     
			$criteria->addBetweenCondition('tglfaktur',$this->tglAwal,$this->tglAkhir);
			$criteria->compare('ruangan_id',Yii::app()->user->ruangan_id);

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
			));
	}

	public function getTotalharganetto()
	{
		$criteria = $this->criteriaLaporan();
		$criteria->select = 'SUM(totharganetto)';

		return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
	}
	
	public function criteriaLaporan()
                {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                    $format = new MyFormatter();
                    $criteria=new CDbCriteria;
                    $this->tglAwal  = $format->formatDateTimeForDb($this->tglAwal);
                    $this->tglAkhir = $format->formatDateTimeForDb($this->tglAkhir);
                    
                    $criteria->select = 't.nofaktur,t.tglfaktur, t.tgljatuhtempo, t.keteranganfaktur, t.bayarkesupplier_id,t.fakturpembelian_id,
                                         t.create_ruangan,supplier_m.supplier_id,supplier_m.supplier_nama,supplier_m.supplier_alamat,
                                         
                                         sum(bayarkesupplier_t.totaltagihan) as total_tagihan,
                                         sum(bayarkesupplier_t.jmldibayarkan) as total_bayar,
                                         sum(fakturdetail_t.jmldiscount) as total_discount,
                                         sum(fakturdetail_t.persendiscount) as discountpersen,
                                         sum(t.totalpajakppn) as total_ppn,
                                         sum(t.biayamaterai) as materai,
                                         sum(((penerimaandetail_t.jmlterima)-fakturdetail_t.jmldiscount)+t.totalpajakppn) as total_netto,
                                         (case when (t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan - bayarkesupplier_t.jmldibayarkan) else sum((((penerimaandetail_t.jmlterima)-fakturdetail_t.jmldiscount)+t.totalpajakppn)-0) end) as total_sisa,
                                         (case when (t.bayarkesupplier_id is not null) then sum(bayarkesupplier_t.totaltagihan) else sum(t.totalhargabruto) end) as total_tagihan
                                        ';
                    $criteria->join = 'LEFT JOIN bayarkesupplier_t ON t.fakturpembelian_id=bayarkesupplier_t.fakturpembelian_id 
                                       LEFT JOIN supplier_m ON supplier_m.supplier_id=t.supplier_id
                                       LEFT JOIN fakturdetail_t ON t.fakturpembelian_id = fakturdetail_t.fakturpembelian_id
                                       LEFT JOIN penerimaanbarang_t ON t.fakturpembelian_id = penerimaanbarang_t.fakturpembelian_id
                                       LEFT JOIN penerimaandetail_t ON penerimaanbarang_t.penerimaanbarang_id = penerimaandetail_t.penerimaanbarang_id';
                    $criteria->group = 't.nofaktur,t.tglfaktur,t.tgljatuhtempo,t.keteranganfaktur,t.create_ruangan,t.fakturpembelian_id,
                                        supplier_m.supplier_id,supplier_m.supplier_nama,supplier_alamat,t.bayarkesupplier_id,t.fakturpembelian_id';
                    $criteria->compare('t.supplier_id',$this->supplier_id);
                    $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
                    $criteria->addBetweenCondition('t.tglfaktur',$this->tglAwal,$this->tglAkhir);
                    $criteria->compare('t.create_ruangan',Yii::app()->user->ruangan_id);

                    return $criteria;
                }

}