<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));
//    $modStatuspresensi = PresensiT::model()->find("pegawai_id=$pegawai_id AND DATE(tglpresensi)='$datepresensi' AND statuskehadiran_id is NOT NULL");
    
    //$modStatuskehadiran = StatuskehadiranM::model()->findByPK($statuskehadiran_id);
    //if (!empty($modStatuskehadiran))
   // {
    //    echo $modStatuskehadiran->statuskehadiran_nama;
   // } else {
    //    echo "-";
    //}
                               $cr4 = new CDbCriteria();
                               $cr4->compare('tglpresensi::date', $datepresensi);
                               $cr4->compare('pegawai_id', $pegawai_id);                            
                               $cr4->addCondition('statusscan_id=:p1');
                               $cr4->params[':p1'] = Params::STATUSSCAN_MASUK;
                               $pr4 = PresensiT::model()->find($cr4);
                               

                               $cr5 = new CDbCriteria();
                               $cr5->compare('tglpresensi::date', $datepresensi);
                               $cr5->compare('pegawai_id', $pegawai_id);                            
                               $cr5->addCondition('statusscan_id=:p1');
                               $cr5->params[':p1'] = Params::STATUSSCAN_PULANG;
                               $pr5 = PresensiT::model()->find($cr5);
                               
                               if (count($pr4)>0){
                                   $waktu = date('H:i:s', strtotime($pr4->tglpresensi));
                                   if ( ($waktu >= '09:00:00') AND ($waktu <= '10:00:00')){
                                        echo StatuskehadiranM::model()->findByPk(Params::STATUSKEHADIRAN_ALPHA)->statuskehadiran_nama;
                                    }else{
                                        echo $pr4->statuskehadiran->statuskehadiran_nama;
                                    }                                    
                               }else{
                                   if (count($pr5)){                                       
                                       echo $pr5->statuskehadiran->statuskehadiran_nama;
                                   }else{
                                       echo '-';
                                   }
                               }
?>