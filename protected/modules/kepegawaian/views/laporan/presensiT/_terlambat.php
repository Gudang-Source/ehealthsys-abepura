<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));

     $cr = new CDbCriteria();                            
    $cr->compare('tglpresensi::date', $datepresensi);
    $cr->compare('pegawai_id', $pegawai_id);
    $cr->addCondition('statusscan_id=:p1');
    $cr->params[':p1'] = 1;
    $pr = PresensiT::model()->find($cr);
    if ($statuskehadiran_id == Params::STATUSKEHADIRAN_HADIR)
    {
        if (empty($pr)){echo "-";
        }else{

        //return $pr1->jam;
        $shift = KPPresensiT::model()->getShiftId($pegawai_id);
        if (count($shift)>0){
            $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).$shift->shift_jamawal);
        }else{
            $tepat = strtotime(date('Y-m-d',strtotime($pr->tglpresensi))." 08:15:00");
        }             
        $masuk = strtotime(date('Y-m-d H:i:s',strtotime($pr->tglpresensi)));
        $jam = floor(round(abs($masuk - $tepat) / 60,2));

        if ($masuk < $tepat){
            echo  "0 Menit";
        }else{
            echo $jam.' Menit';
        }}
    }else{
        echo '-';
    }
?>