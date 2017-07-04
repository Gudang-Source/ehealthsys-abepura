<?php
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));
//    $modStatuspresensi = PresensiT::model()->find("pegawai_id=$pegawai_id AND DATE(tglpresensi)='$datepresensi' AND statuskehadiran_id is NOT NULL");
    
    //$modStatuskehadiran = StatuskehadiranM::model()->findByPK($statuskehadiran_id);
    //if (!empty($modStatuskehadiran))
   // {
    //    echo $modStatuskehadiran->statuskehadiran_nama;
   // } else {
    //    echo "-";
    //}/*
/*
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
 * */
 
					$jammasuk = PresensiT::model()->getRealJam(Params::STATUSSCAN_MASUK, $datepresensi, $pegawai_id);					
					if (!empty($jammasuk)){
						$cekShiftBerlaku = ShiftberlakuM::model()->cekSHift($datepresensi.' '.$jammasuk, $kelompokjabatan,'masuk');
					}else{
						$cekShiftBerlaku = null;
					}

				
					$jammasuk = PresensiT::model()->getRealJam(Params::STATUSSCAN_MASUK, $datepresensi, $pegawai_id);
					$jampulang = PresensiT::model()->getRealJam(Params::STATUSSCAN_PULANG, $datepresensi, $pegawai_id);

					$jamMulai = ShiftberlakuM::model()->cekOntime($datepresensi.' '.$jammasuk, $kelompokjabatan,'masuk',true);

					$jamAkhir = ShiftberlakuM::model()->cekOntime($datepresensi.' '.$jampulang, $kelompokjabatan,'pulang', true);



					if ($jamMulai != '-'){
						$masukPecah = explode('__', $jamMulai);
						if ( ($masukPecah[0] <= $jammasuk) AND ($masukPecah[1] >= $jammasuk)){
							echo PresensiT::model()->getWarnaKehadiran(StatuskehadiranM::model()->findByPk(Params::STATUSKEHADIRAN_HADIR)->statuskehadiran_nama);
						}else{
							echo PresensiT::model()->getWarnaKehadiran(StatuskehadiranM::model()->findByPk(Params::STATUSKEHADIRAN_ALPHA)->statuskehadiran_nama);
						}
					}else{	
						//if ($cekShiftBerlaku != '-'){
							echo PresensiT::model()->getWarnaKehadiran(StatuskehadiranM::model()->findByPk(Params::STATUSKEHADIRAN_ALPHA)->statuskehadiran_nama);
					}
?>