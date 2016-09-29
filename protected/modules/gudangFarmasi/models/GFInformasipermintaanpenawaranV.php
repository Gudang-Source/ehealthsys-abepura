<?php

class GFInformasipermintaanpenawaranV extends InformasipermintaanpenawaranV
{
	public $tgl_awal,$tgl_akhir;
        public $bln_awal,$bln_akhir;
        public $thn_awal,$thn_akhir;
        public $jns_periode;
        public $jumlah, $data;
        
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipermintaanpenawaranV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tglpenawaran)',$this->tgl_awal,$this->tgl_akhir,true);

		$criteria->compare('LOWER(nosuratpenawaran)',strtolower($this->nosuratpenawaran),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('ispenawaranmasuk',$this->ispenawaranmasuk);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getPenawaranMasukItems(){
            $list = array(
                'FALSE' => 'KELUAR',
                'TRUE' => 'MASUK'
            );
            return $list;
        }
		
        public function getPegawaimengetahuiLengkap()
        {
                return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
        }

        public function getPegawaimenyetujuiLengkap()
        {
                return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
        }
        
        public function searchLaporanInformasiPenawaran() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionLaporanInformasiPenawaran();
            $criteria->order = 'ruangan_nama ASC, tglpenawaran DESC ';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }

        public function searchLaporanInformasiPenawaranPrint() {
            $criteria = new CDbCriteria();
            $criteria = $this->functionLaporanInformasiPenawaran();
            $criteria->order = 'ruangan_nama ASC, tglpenawaran DESC ';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                        'pagination' => false,
                    ));
        }

        protected function functionLaporanInformasiPenawaran() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.            
            $criteria = new CDbCriteria;            
            $criteria->addBetweenCondition('tglpenawaran',$this->tgl_awal,$this->tgl_akhir,true);                                               
            if (!empty($this->supplier_id)){
                $criteria->addCondition('supplier_id = '.$this->supplier_id);
            }
            
            if (!empty($this->statuspenawaran)){
                    $criteria->compare('LOWER(statuspenawaran)', strtolower($this->statuspenawaran),true);
                }


            return $criteria;
        }

        public function searchGrafikLaporanInformasiPenawaran()
        {
                    // Warning: Please modify the following code to remove attributes that
                    // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = "count(permintaanpenawaran_id) as jumlah, statuspenawaran as data";                
                $criteria->addBetweenCondition('tglpenawaran',$this->tgl_awal,$this->tgl_akhir,true);                           
                if (!empty($this->supplier_id)){
                    $criteria->addCondition('supplier_id = '.$this->supplier_id);
                }

                if (!empty($this->statuspenawaran)){
                    $criteria->compare('LOWER(statuspenawaran)', strtolower($this->statuspenawaran),true);
                }
                $criteria->group = 'permintaanpenawaran_id, statuspenawaran';
               


                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }     

}