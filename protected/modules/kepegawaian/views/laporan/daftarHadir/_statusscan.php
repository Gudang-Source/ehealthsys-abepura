<?php
    $modStatuspresensi = PresensiT::model()->find("pegawai_id=$pegawai_id AND statusscan_id=$statusscan_id AND DATE(tglpresensi)='$datepresensi'");// AND statuskehadiran_id='$statuskehadiran_id' 
    $format = new MyFormatter();
    if (!empty($modStatuspresensi))
    {
        
        $tglpresensi = $format->formatDateTimeForDb($modStatuspresensi->tglpresensi);
//        echo $tglpresensi;
        echo date('H:i:s', strtotime($tglpresensi));
    } else {
        echo "-";
    }
?>