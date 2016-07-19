<?php

class BSLaporansensuspenunjangV extends LaporansensuspenunjangV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

//        if (!is_array($this->kunjungan)){
//            $this->kunjungan = 0;
//        }
        if (is_array($this->kunjungan)){
            $criteria->addInCondition('kunjungan', $this->kunjungan);
        }else{
            $this->kunjungan = array('KUNJUNGAN BARU','KUNJUNGAN LAMA');
        }
       
        
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('kunjungan', $this->kunjungan);
		
        
        if(!empty($this->carabayar_id)){
                $criteria->addCondition('carabayar_id = '.$this->carabayar_id);
        }

      //  if(!empty($this->ruanganasal_id)){
            if (is_array($this->ruanganasal_id)){
                $criteria->addInCondition('ruanganasal_id',$this->ruanganasal_id);
            }                
      //  }
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));

        return $criteria;
    }

    public function searchPrint() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'pagination'=>false, 
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchGrafik() {
        $criteria = new CDbCriteria();
        
        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(tglmasukpenunjang) as jumlah, kunjungan as data';
        $criteria->group = 'kunjungan';
        if ($this->pilihan == 'carabayar'){
            if (!empty($this->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else if (!empty($this->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as tick';
                $criteria->group .= ', carabayar_nama';
            }
        }
        else{
            if (is_array($this->ruanganasal_id)){
                $criteria->select .= ', ruanganasal_nama as tick';
                $criteria->group .= ', ruanganasal_nama';
            }
            else if (!empty($this->instalasiasal_id)){
                $criteria->select .= ', ruanganasal_nama as tick';
                $criteria->group .= ', ruanganasal_nama';
            }
            else {
                $criteria->select .= ', instalasiasal_nama as tick';
                $criteria->group .= ', instalasiasal_nama';
            }
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getNamaModel() {
        return __CLASS__;
    }
    
   // public function getKunjungan(){
      //  $kunjungan = array('Kunjungan satu','Kunjungan dua');
        //return $kunjungan;
    //}
    
    public static function getKunjungan()
    {
        $data = array();
        $criteria = new CDbCriteria();        
        $criteria->select = "kunjungan";
        $criteria->group = "kunjungan";
        $criteria->order = "kunjungan ASC";        
        $models=self::model()->findAll($criteria);
        if(count($models) > 0){
            foreach($models as $model)
                // $data[$model->lookup_value]= ucwords(strtolower($model->lookup_name));
                $data[$model->kunjungan]= ($model->kunjungan);
        }else{
            $data[""] = null;
        }

        return $data;
    }

}

?>
