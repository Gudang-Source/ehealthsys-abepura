<?php

class GZLaporanJumlahPorsiV extends LaporanjmlporsigiziruanganV {
    
    public $tgl_awal;
    public $tgl_akhir;  
     
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->select='jenisdiet_nama, jenisdiet_id';
        $criteria->group='jenisdiet_nama, jenisdiet_id';
        $criteria->addBetweenCondition('tglkirimmenu', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
        $criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
        $criteria->compare('ruangan_id',$this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function searchPrint()
        {
                 // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->select='jenisdiet_nama, jenisdiet_id';
        $criteria->group='jenisdiet_nama, jenisdiet_id';
        $criteria->addBetweenCondition('tglkirimmenu', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
        $criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
        $criteria->compare('ruangan_id',$this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
        }
    
    // public function searchPrint() {
    //     // Warning: Please modify the following code to remove attributes that
    //     // should not be searched.

    //     $criteria = new CDbCriteria;
    //     $criteria = $this->functionCriteria();

    //     return new CActiveDataProvider($this, array(
    //                 'criteria' => $criteria,
    //                 // 'pagination'=>false,
    //             ));
    // }
    
     public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria(){
        $criteria=new CDbCriteria;

        $criteria->addBetweenCondition('tglkirimmenu', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(tglkirimmenu)',strtolower($this->tglkirimmenu),true);
        $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
        $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
        $criteria->compare('LOWER(jml_kirim)',strtolower($this->jml_kirim),true);
        $criteria->compare('ruangan_id',$this->ruangan_id);
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }   

    public function getSumKelas($kelaspelayanan_id = null, $idjenisdiet, $ruangan_id = null){
            if(isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
                $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            }
            // var_dump($idjenisdiet);
            $format = new MyFormatter();
            $criteria=new CDbCriteria();
            $criteria->group = 'ruangan_id, kelaspelayanan_id, jenisdiet_id';
            // foreach($groups AS $i => $group){
            //     if($group == 'jenisdiet_id'){
            //         $criteria->group .= ', jenisdiet_id';
            //         $criteria->compare('jenisdiet_id',$this->jenisdiet_id);
            //     }
            // }
            
			$criteria->compare('jenisdiet_id',$idjenisdiet);
			if(!empty($kelaspelayanan_id)){
				$criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
			}
            if(!empty($ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
            }
            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->jml_kirim;
            }
             return $totTarif;
        }

    public function getSumJml($idjenisdiet, $ruangan_id=null){
        if (isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            
        }
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria->group = 'ruangan_id, jenisdiet_id';
        $criteria->compare('jenisdiet_id',$idjenisdiet);

		if(!empty($ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$ruangan_id);
		}
		if(isset($_GET['GZLaporanJumlahPorsiV'])){
			$tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
			$tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
			$criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
		}
		$criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
		$modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
		$totTarif = 0;
		foreach($modTarif as $key=>$tarif){
			$totTarif += $tarif->jml_kirim;
		}
		 return $totTarif;

    }        

    public function getSumJmlT($ruangan_id=null){
            $format = new MyFormatter();
            $criteria = new CDbCriteria();
            $criteria->group = 'kelaspelayanan_id,ruangan_id,jenisdiet_nama';
//            foreach($groups AS $i => $group){
//            if($group == 'jenisdiet'){
//                    $criteria->group .= ', kelaspelayanan_id,ruangan_id';
//                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                    $criteria->compare('ruangan_id',$this->ruangan_id);
//                // $criteria->compare('ruangan_id',$this->ruangan_id);
//            } }

            if(!empty($ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
            }

            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
//                $jenisdiet_nama =$_GET['GZLaporanJumlahPorsiV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
                $criteria->addInCondition('jenisdiet_id',$this->jenisdiet_id);
            }
            $criteria->select = $criteria->group.',jenisdiet_nama, sum(jml_kirim) AS jml_kirim';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->jml_kirim;
            }
             return $totTarif;

            // if(isset($_GET['GZLaporanJumlahPorsiV'])){
            //     $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
            //     $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
            //     $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
            // }
            // $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
            // $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            // $totTarif = 0;
            // foreach($modTarif as $key=>$tarif){
            //     $totTarif += $tarif->jml_kirim;
            // }
            //  return $totTarif;

    }        

     public function getSumTotal($idjenisdiet){

         if (isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
            $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            
        }
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria->group = 'jenisdiet_id';
        $criteria->compare('jenisdiet_id',$idjenisdiet);




            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
            }
            $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->jml_kirim;
            }
             return $totTarif;
     }

     public function getSumTotalT($idjenisdiet=null){

         $format = new MyFormatter();
         $criteria = new CDbCriteria();
         $criteria->group = 'kelaspelayanan_id,ruangan_id,jenisdiet_nama';
//        foreach($groups AS $i => $group){
//            if($group == 'jenisdiet'){
//                $criteria->group .= ', kelaspelayanan_id,ruangan_id';
//                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                $criteria->compare('ruangan_id',$this->ruangan_id);
//                // $criteria->compare('ruangan_id',$this->ruangan_id);
//            }
//        }

        if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
//                $jenisdiet_nama =$_GET['GZLaporanJumlahPorsiV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
                $criteria->addInCondition('jenisdiet_id',$this->jenisdiet_id);
            }
            $criteria->select = $criteria->group.',jenisdiet_nama, sum(jml_kirim) AS jml_kirim';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->jml_kirim;
            }
             return $totTarif;
     }

 public function getSumKelasP($groups=array(),$kelaspelayanan_id = null, $ruangan_id = null){
       
        //  if (isset($_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'])){
        //     $komponentarif_id = $_GET['GZLaporanJumlahPorsiV']['kelaspelayanan_id'];
            
        // }
        $format = new MyFormatter();
        $criteria = new CDbCriteria();
        $criteria->group = 'kelaspelayanan_id,ruangan_id,jenisdiet_nama';
            foreach($groups AS $i => $group){
            if($group == 'jenisdiet'){
                $criteria->group .= ', kelaspelayanan_id,ruangan_id';
                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                $criteria->compare('ruangan_id',$this->ruangan_id);
                // $criteria->compare('ruangan_id',$this->ruangan_id);
            }
        }
            if(!empty($kelaspelayanan_id)){
                $criteria->addCondition('kelaspelayanan_id = '.$kelaspelayanan_id);
            }
            if(!empty($ruangan_id)){
                $criteria->addCondition('ruangan_id = '.$ruangan_id);
            }

            if(isset($_GET['GZLaporanJumlahPorsiV'])){
                $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
                $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
//                $jenisdiet_nama =$_GET['GZLaporanJumlahPorsiV']['jenisdiet_nama'];
                $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
                $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
                $criteria->addInCondition('jenisdiet_id',$this->jenisdiet_id);
            }
            $criteria->select = $criteria->group.',jenisdiet_nama, sum(jml_kirim) AS jml_kirim';
            $modTarif = LaporanjmlporsigiziruanganV::model()->findAll($criteria);
            $totTarif = 0;
            foreach($modTarif as $key=>$tarif){
                $totTarif += $tarif->jml_kirim;
            }
             return $totTarif;
     }
    // if(isset($_GET['GZLaporanjmlporsikelasruanganV'])){
    // $tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
    // $tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
    // $jenisdiet_nama =$_GET['GZLaporanjmlporsikelasruanganV']['jenisdiet_nama'];
    // $criteria->addBetweenCondition('tglkirimmenu',$tgl_awal,$tgl_akhir);
    // $criteria->compare('LOWER(jenisdiet_nama)',strtolower($this->jenisdiet_nama));
    // }
    // $criteria->select = $criteria->group.', sum(jml_kirim) AS jml_kirim';
    // $modKirim = LaporanjmlporsikelasruanganV::model()->findAll($criteria);
    // $totKirim = 0;




    
    public function getNamaModel(){
        return __CLASS__;
    }

}