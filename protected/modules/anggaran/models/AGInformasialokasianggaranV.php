<?php
class AGInformasialokasianggaranV extends InformasialokasianggaranV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasialokasianggaranV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchProgramKerja()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->programkerja_id)){
			$criteria->addCondition('programkerja_id = '.$this->programkerja_id);
		}
		$criteria->compare('LOWER(programkerja_nama)',strtolower($this->programkerja_nama),true);
		$criteria->compare('LOWER(programkerja_kode)',strtolower($this->programkerja_kode),true);
		if(!empty($this->subprogramkerja_id)){
			$criteria->addCondition('subprogramkerja_id = '.$this->subprogramkerja_id);
		}
		$criteria->compare('LOWER(subprogramkerja_nama)',strtolower($this->subprogramkerja_nama),true);
		$criteria->compare('LOWER(subprogramkerja_kode)',strtolower($this->subprogramkerja_kode),true);
		if(!empty($this->kegiatanprogram_id)){
			$criteria->addCondition('kegiatanprogram_id = '.$this->kegiatanprogram_id);
		}
		$criteria->compare('LOWER(kegiatanprogram_nama)',strtolower($this->kegiatanprogram_nama),true);
		$criteria->compare('LOWER(kegiatanprogram_kode)',strtolower($this->kegiatanprogram_kode),true);
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		$criteria->compare('LOWER(subkegiatanprogram_nama)',strtolower($this->subkegiatanprogram_nama),true);
		$criteria->compare('LOWER(subkegiatanprogram_kode)',strtolower($this->subkegiatanprogram_kode),true);
		$criteria->compare('nilaiygdisetujui',$this->nilaiygdisetujui);
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}		
		$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('LOWER(tglapprrencanggaran)',strtolower($this->tglapprrencanggaran),true);
//		if(!empty($this->statusalokasi)){
		//	$criteria->addCondition('statusalokasi is false or statusalokasi is null');
//		}
			
		//$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function searchProgramKerjaAlokasi() {
            $provider = $this->searchProgramKerja();
            $provider->criteria->addCondition('statusalokasi = false or statusalokasi is null');
        
            return $provider;
        }
        
        public function searchProgramKerjaRealisasi() {
            $provider = $this->searchProgramKerja();
            $provider->criteria->addCondition('statusalokasi = true');
        
            return $provider;
        }

}