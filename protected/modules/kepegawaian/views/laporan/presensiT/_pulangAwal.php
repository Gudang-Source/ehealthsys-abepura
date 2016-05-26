<?php
   $cr = new CDbCriteria();                            
    $cr->compare('tglpresensi::date', $datepresensi);
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition('statusscan_id=:p1');
    $cr->params[':p1'] = 2;
    $pr = PresensiT::model()->find($cr);
    if (empty($pr)){
        echo "-";
    }else{
       
        //return $pr1->jam;
        $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi))." 15:00:00");
        $pulang = strtotime(date('Y-m-d H:i:s',strtotime($pr->tglpresensi)));
        $jam = floor(round(abs($pulang - $tepat) / 60,2));

        if ($pulang > $tepat){
            echo  "0 Menit";
        }else{
            echo $jam.' Menit';
        }
    
    }
?>