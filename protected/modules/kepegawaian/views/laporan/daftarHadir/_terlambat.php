<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));

    $format = new MyFormatter();
    $cr = new CDbCriteria();                            
    $cr->addBetweenCondition('tglpresensi', $format->formatDateTimeForDb($tgl_awal), $format->formatDateTimeForDb($tgl_akhir));    
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition('statusscan_id=:p1');
    $cr->params[':p1'] = $statusscan_id;    
    $pr = PresensiT::model()->findAll($cr);   
    
    $shift = KPPresensiT::model()->getShiftId($pegawai_id);
       
    if (empty($pr)){echo "-";
    }else{         
        $total = 0;
        
        foreach ($pr as $pr):    
            if (count($shift)>0){
                $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).$shift->shift_jamawal);
            }else{
                 $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi))." 08:15:00");
            } 
           
            $masuk = strtotime(date('Y-m-d H:i:s',strtotime($pr->tglpresensi)));
            if ($masuk < $tepat){
                $masuk = $tepat;
            }
            $menit = floor(round(abs($masuk - $tepat) / 60,2));            
            $total = $total + $menit;
        endforeach;        
        $j =  floor(abs($total) / 60);                       
        $m =  floor(abs(($total / 60) - $j) * 60);
        
       // if ($masuk < $tepat){
         //   echo  "0 Jam";
       // }else{
            echo $j.' Jam '.$m.' Menit';
       // }
    
    }
?>