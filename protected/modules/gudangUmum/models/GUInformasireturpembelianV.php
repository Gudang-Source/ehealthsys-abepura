<?php
class GUInformasireturpembelianV extends InformasireturpembelianV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfoformulirinvbarangV the static model class
     */
    public $tgl_awal,$tgl_akhir;
    public $bln_awal,$bln_akhir;
    public $thn_awal,$thn_akhir;
    public $jns_periode;
    public $tick;
    public $data;
    public $jumlah;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	
        
    public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglretur DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglretur DESC';
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('tglretur',$this->tgl_awal,$this->tgl_akhir,true);
        $criteria->compare('nofaktur', $this->nofaktur);
        if(!empty($this->ruangan_id)){                    
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }else{
           if (!empty($this->instalasi_id)){
               $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
           }
        }
        
        if (!empty($this->supplier_id))
        {
            $criteria->addInCondition('supplier_id', $this->supplier_id);
        }


        return $criteria;
    }
     
     public function searchReturPembelianGrafik()
     {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

            $criteria=new CDbCriteria;
            
            $criteria->select = 'count(returpembelian_id) as jumlah, supplier_nama as data';
            $criteria->group = 'returpembelian_id, supplier_nama';
            $criteria->addBetweenCondition('tglretur',$this->tgl_awal,$this->tgl_akhir,true);
            $criteria->compare('nofaktur', $this->nofaktur);
            if(!empty($this->ruangan_id)){                    
                $criteria->addInCondition('ruangan_id', $this->ruangan_id);
            }else{
               if (!empty($this->instalasi_id)){
                   $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
               }
            }

            if (!empty($this->supplier_id))
            {
                $criteria->addInCondition('supplier_id', $this->supplier_id);
            }



            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }        	
}
