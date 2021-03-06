<?php
    $criteria = new CDbCriteria;
    $criteria->select = 't.tindakanpelayanan_id, t.pendaftaran_id, t.ruangan_id, t.tgl_pendaftaran,t.pegawai_id, t.daftartindakan_tindakan, t.qty_tindakan';
    $criteria->group = $criteria->select;
	if($pendaftaran_id == null || $ruangan_id == null || $tgl_pendaftaran == null){
		if(!empty($pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$pegawai_id);			
		}
    }else{
		if(!empty($pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$pendaftaran_id);			
		}
		if(!empty($ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$ruangan_id);			
		}
		if(!empty($tgl_pendaftaran)){
			$criteria->addCondition("DATE(t.tgl_pendaftaran) = '".$tgl_pendaftaran."'"); 
		}
    }
    $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON t.tindakanpelayanan_id = tindakanpelayanan_t.tindakanpelayanan_id LEFT JOIN tindakankomponen_t ON tindakankomponen_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
    
    
//    $modTarif = LaporanrekaptransaksiV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'ruangan_id'=>$ruangan_id,'tgl_pendaftaran'=>$tgl_pendaftaran));
    $modTarif = LaporanrekaptransaksiV::model()->findAll($criteria);
    $totTarif = 0;
    
    foreach($modTarif as $key=>$tarif){
       //if($tarif->daftartindakan_tindakan == true){
           $totTarif += $tarif->qty_tindakan;
           /*
           if($totTarif == null){
               echo "0";
       }else{
               echo $totTarif;
           }
            * 
            */
       //}else{
//           echo "0";
           
       //}
   }
   echo number_format($totTarif,0,"",".");
?>