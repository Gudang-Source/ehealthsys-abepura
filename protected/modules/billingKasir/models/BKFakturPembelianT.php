<?php

class BKFakturPembelianT extends FakturpembelianT
{
        public $tgl_awal,$tgl_akhir,$tgl_awalJatuhTempo,$tgl_akhirJatuhTempo,$SupplierItems,$supplier_id;
        public $bln_awal, $bln_akhir, $thn_akhir, $thn_awal, $jns_periode;
        public $filter, $data, $tick, $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturpembelianT the static model class
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

		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('syaratbayar_id = '.$this->syaratbayar_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
                $criteria->addBetweenCondition('tglfaktur', $this->tgl_awal, $this->tgl_akhir);
                if (isset($_GET['berdasarkanJatuhTempo']))
                    if($_GET['berdasarkanJatuhTempo']>0)
                        $criteria->addBetweenCondition('tgljatuhtempo', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);
					
//		$tglfaktur = $criteria->compare('DATE(tglfaktur)',$this->tglfaktur);	
//		$tgljatuhtempo = $criteria->compare('DATE(tgljatuhtempo)',$this->tgljatuhtempo);	
//		$tglfaktur = MyFormatter::formatDateTimeForDb($this->tglfaktur);	
			
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
              
                    
                if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
                            $criteria->addInCondition('supplier_id',$this->supplier_id);
                    }else{
                        $criteria->addCondition('supplier_id IS NULL');
                    }                    
                }
               
                    
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('syaratbayar_id = '.$this->syaratbayar_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
                $criteria->addBetweenCondition('tglfaktur', $this->tgl_awal, $this->tgl_akhir);
                $criteria->limit = 10;
//                if (isset($_GET['berdasarkanJatuhTempo']))
//                    if($_GET['berdasarkanJatuhTempo']>0)
//                        $criteria->addBetweenCondition('tgljatuhtempo', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
                            $criteria->addInCondition('supplier_id',$this->supplier_id);
                    }else{
                        $criteria->addCondition('supplier_id IS NULL');
                    }                    
                }
		if(!empty($this->syaratbayar_id)){
			$criteria->addCondition('syaratbayar_id = '.$this->syaratbayar_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
                $criteria->addBetweenCondition('tglfaktur', $this->tgl_awal, $this->tgl_akhir);                
                $criteria->limit = -1;
//                if (isset($_GET['berdasarkanJatuhTempo']))
//                    if($_GET['berdasarkanJatuhTempo']>0)
//                        $criteria->addBetweenCondition('tgljatuhtempo', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                    $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                }elseif ($column->dbType == 'timestamp without time zone'){
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                }
//            }
//            return true;
//        }
        
        public function getSupplierItems()
        {
            return SupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama');
        }
		
        public function getUmurHutang(){
                $tglfaktur = $this->tglfaktur;	
                $tgljatuhtempo = $this->tgljatuhtempo;			
                $dob=$tglfaktur; 
                $jatuhtempo=$tgljatuhtempo;
                list($y,$m,$d)=explode('-',$dob);
                list($ty,$tm,$td)=explode('-',$jatuhtempo);
                if($td-$d<0){
                        $day=($td+30)-$d;
                        $tm--;
                }
                else{
                        $day=$td-$d;
                }
                if($tm-$m<0){
                        $month=($tm+12)-$m;
                        $ty--;
                }
                else{
                        $month=$tm-$m;
                }
                $year=$ty-$y;

                $umurHutang = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';

                return $umurHutang;
        }
        
       
        
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN supplier_m s ON t.supplier_id = s.supplier_id ";
        $criteria->select = 'count(t.fakturpembelian_id) as jumlah';
        $filter = isset($this->filter)?$this->filter:null;
        if ( $filter == 'supplier') {           
            $criteria->select .= ', s.supplier_nama as data';
            $criteria->group .= 's.supplier_nama';            
        }else{
            $criteria->select .= ', s.supplier_nama as data';
            $criteria->group .= 's.supplier_nama';   
        }      
                       

        if(!empty($this->fakturpembelian_id)){
                $criteria->addCondition('t.fakturpembelian_id = '.$this->fakturpembelian_id);
        }
       if ($this->filter == 'supplier'){
                    if(!empty($this->supplier_id)){
                            $criteria->addInCondition('t.supplier_id',$this->supplier_id);
                    }else{
                        $criteria->addCondition('t.supplier_id IS NULL');
                    }                    
                }
        if(!empty($this->syaratbayar_id)){
                $criteria->addCondition('t.syaratbayar_id = '.$this->syaratbayar_id);
        }
        if(!empty($this->ruangan_id)){
                $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
        }
        $criteria->compare('LOWER(t.nofaktur)',strtolower($this->nofaktur),true);
        $criteria->addBetweenCondition('t.tglfaktur', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = "jumlah DESC";
        

        return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
    }
}