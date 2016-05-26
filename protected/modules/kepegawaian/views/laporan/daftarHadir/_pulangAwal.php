<?php
    $format = new MyFormatter();
    $cr = new CDbCriteria();                            
    $cr->addBetweenCondition('tglpresensi', $format->formatDateTimeForDb($tgl_awal), $format->formatDateTimeForDb($tgl_akhir));    
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition('statusscan_id=:p1');
    $cr->params[':p1'] = $statusscan_id;
    $pr = PresensiT::model()->findAll($cr);
    if (empty($pr)){echo "-";
    }else{         
        $total = 0;        
        foreach ($pr as $pr):
            $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi))." 15:00:00");
            $pulang = strtotime(date('Y-m-d H:i:s',strtotime($pr->tglpresensi)));
            if ($pulang > $tepat){
                $pulang = $tepat;
            }
            $menit = floor(round(abs($pulang - $tepat) / 60,2));
            $total = $total + $menit;
        endforeach;        
        $j =  floor(abs($total) / 60);                       
        $m =  floor(abs(($total / 60) - $j) * 60);
        
      //  if ($pulang > $tepat){
         //   echo  "0 Jam";
      //  }else{
            echo $j.' Jam '.$m.' Menit';
       // }
    
    }
?>