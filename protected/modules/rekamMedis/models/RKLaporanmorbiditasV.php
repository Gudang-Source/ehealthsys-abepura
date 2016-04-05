<?php
class RKLaporanmorbiditasV extends LaporanmorbiditasV
{
        public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $lakilaki,$perempuan,$jumlahkunjungan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         *  method untuk criteria
         * @return CDbCriteria 
         */
	protected function functionCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "golonganumur_nama, tglmorbiditas, diagnosa_nama,umur_0_28hr,umur_28hr_1thn, umur_1_4thn,umur_5_14thn,umur_15_24thn,umur_25_44thn,umur_45_64thn, umur_65, jeniskelamin, pendaftaran_id , CASE WHEN jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN 0 else 1 END AS lakilaki, CASE WHEN jeniskelamin = '".Params::JENIS_KELAMIN_PEREMPUAN."' THEN 1 else 0 END AS perempuan";
		$criteria->group = "golonganumur_nama, tglmorbiditas, diagnosa_nama,umur_0_28hr,umur_28hr_1thn, umur_1_4thn,umur_5_14thn,umur_15_24thn,umur_25_44thn,umur_45_64thn, umur_65, jeniskelamin, pendaftaran_id";
//             
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);			
		}
		$criteria->addBetweenCondition('DATE(tglmorbiditas)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(kasusdiagnosa)',strtolower($this->kasusdiagnosa),true);
		$criteria->compare('umur_0_28hr',$this->umur_0_28hr);
		$criteria->compare('umur_28hr_1thn',$this->umur_28hr_1thn);
		$criteria->compare('umur_1_4thn',$this->umur_1_4thn);
		$criteria->compare('umur_5_14thn',$this->umur_5_14thn);
		$criteria->compare('umur_15_24thn',$this->umur_15_24thn);
		$criteria->compare('umur_25_44thn',$this->umur_25_44thn);
		$criteria->compare('umur_45_64thn',$this->umur_45_64thn);
		$criteria->compare('umur_65',$this->umur_65);
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);			
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);			
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
                
                

		return $criteria;
	}
        /**
         *  method untuk data provider pada table laporan
         * @return CActiveDataProvider 
         */
        public function searchTable(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'diagnosa_nama, sum(umur_0_28hr) as umur_0_28hr,sum(umur_28hr_1thn) as umur_28hr_1thn, sum(umur_1_4thn) as umur_1_4thn, sum(umur_5_14thn) as umur_5_14thn, sum(umur_15_24thn) as umur_15_24thn,sum(umur_25_44thn) as umur_25_44thn,sum(umur_45_64thn) as umur_45_64thn, sum(umur_65) as umur_65, count(pendaftaran_id) as jumlah, '
                    . 'COUNT(CASE WHEN jeniskelamin !=\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' THEN 1 ELSE NULL END) AS lakilaki, COUNT(CASE WHEN jeniskelamin =\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' THEN 1 ELSE NULL END) AS perempuan, count(pendaftaran_id) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }
        /**
         * method untuk data provider pada print laporan
         * @return CActiveDataProvider 
         */
        public function searchPrint(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'diagnosa_nama, sum(umur_0_28hr) as umur_0_28hr,sum(umur_28hr_1thn) as umur_28hr_1thn, sum(umur_1_4thn) as umur_1_4thn, sum(umur_5_14thn) as umur_5_14thn, sum(umur_15_24thn) as umur_15_24thn,sum(umur_25_44thn) as umur_25_44thn,sum(umur_45_64thn) as umur_45_64thn, sum(umur_65) as umur_65, count(pendaftaran_id) as jumlah, COUNT(CASE WHEN jeniskelamin !=\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' THEN 1 ELSE NULL END) AS lakilaki, COUNT(CASE WHEN jeniskelamin =\''.Params::JENIS_KELAMIN_PEREMPUAN.'\' THEN 1 ELSE NULL END) AS perempuan, count(pendaftaran_id) as jumlahkunjungan';
            $crit->group = 'diagnosa_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
                        'pagination'=>false, 
                        'sort' => false,
		));
        }
        /**
         * method untuk data provider grafik
         * @return CActiveDataProvider 
         */
        public function searchGrafik(){
            $criteria = $this->functionCriteria();
            $crit = $criteria;
            $crit->select = 'golonganumur_nama as tick, jeniskelamin as data, count(pendaftaran_id) as jumlah';
            $crit->group = 'golonganumur_nama,jeniskelamin';
            return new CActiveDataProvider($this, array(
			'criteria'=>$crit,
		));
        }

}