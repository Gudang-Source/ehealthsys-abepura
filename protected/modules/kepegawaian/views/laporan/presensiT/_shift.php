<?php

/*
//    $modStatuspresensi = PresensiT::model()->findByAttributes(array('karyawan_id'=>$karyawan_id, 'statusscan_id'=>$statusscan_id, 'date(tglpresensi)'=>'2012-10-09 08:23:09'));
    $format = new MyFormatter();
    $tglpresensiM = '';    
    $tglpresensiP = '';
    $modStatusMasuk = PresensiT::model()->findAll("pegawai_id=$pegawai_id AND statusscan_id=1 AND tglpresensi::text iLike '$datepresensi%' AND statuskehadiran_id=$statuskehadiran_id");
    if (count($modStatusMasuk)>0)
    {
        foreach($modStatusMasuk as $modStatusMasuk):
            $tglpresensiM = $format->formatDateTimeForDb($modStatusMasuk->tglpresensi);            
        endforeach;
    }
            
    $modStatusPulang = PresensiT::model()->findAll("pegawai_id=$pegawai_id AND statusscan_id=2 AND tglpresensi::text iLike '$datepresensi%' ");
    if (count($modStatusPulang)>0)
    {
        foreach($modStatusPulang as $modStatusPulang):
            $tglpresensiP = $format->formatDateTimeForDb($modStatusPulang->tglpresensi);            
        endforeach;
    }
    
    $format = new MyFormatter();
    if (!empty($modStatusMasuk))
    {
        
//        echo $tglpresensi;        
        $jamM = null;
        $jamP = null;
        $tgl = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($tglpresensiM)));
        $tglP = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($tglpresensiP)));
        $cekJadwal = PenjadwalandetailT::model()->cekPenjadwalan($pegawai_id, $tglpresensiM);
        $cekPertukaran = PertukaranjadwaldetT::model()->cekPertukaran($pegawai_id, $tglpresensiM);
        $jammasuk = PresensiT::model()->getJam(Params::STATUSSCAN_MASUK, $tglpresensiM, $pegawai_id);
        $jampulang = PresensiT::model()->getJam(Params::STATUSSCAN_PULANG, $tglpresensiM, $pegawai_id);
        $masuk = PresensiT::model()->findAll(" statusscan_id = '".Params::STATUSSCAN_MASUK."' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$pegawai_id' ");
echo $jampulang;
        if (count($masuk)>0)
        {
            foreach($masuk as $masuk):
                $jamM = $masuk->tglpresensi;
            endforeach;
        }
        $pulang = PresensiT::model()->findAll(" statusscan_id = '".Params::STATUSSCAN_PULANG."' AND tglpresensi::text iLike '$tglP%' AND pegawai_id = '$pegawai_id' ");

        if (count($pulang) > 0 )
        {
            foreach($pulang as $pulang):
                $jamP = $pulang->tglpresensi;
            endforeach;
        }


        if($cekPertukaran == 0)
        {
            if ($cekJadwal == 0){
                    if (isset($data->pegawai->shift_id)){
                    echo $data->pegawai->shift->shift_nama.' / '.$data->pegawai->shift->shift_jamawal.' s/d '.$data->pegawai->shift->shift_jamakhir;
                }else{
                    echo ShiftM::model()->getShift($jammasuk,$jampulang, $jamM, $jamP);
                }
            }  else {
                echo ShiftM::model()->getJam($cekJadwal);
            }
        }
        else
        {
            echo ShiftM::model()->getJam($cekPertukaran);
        }

                       
    }elseif (!empty($modStatusPulang)){
             
        $jamM = null;
        $jamP = null;
        $tgl = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($tglpresensiM)));
        $tglP = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($tglpresensiP)));
        $cekJadwal = PenjadwalandetailT::model()->cekPenjadwalan($pegawai_id, $tglpresensiP);
        $cekPertukaran = PertukaranjadwaldetT::model()->cekPertukaran($pegawai_id, $tglpresensiP);
        $jammasuk = PresensiT::model()->getJam(Params::STATUSSCAN_MASUK, $tglpresensiP, $pegawai_id);
        $jampulang = PresensiT::model()->getJam(Params::STATUSSCAN_PULANG, $tglpresensiP, $pegawai_id);
        $masuk = PresensiT::model()->findAll(" statusscan_id = '".Params::STATUSSCAN_MASUK."' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$pegawai_id' ");

        if (count($masuk)>0)
        {
            foreach($masuk as $masuk):
                $jamM = $masuk->tglpresensi;
            endforeach;
        }
        $pulang = PresensiT::model()->findAll(" statusscan_id = '".Params::STATUSSCAN_PULANG."' AND tglpresensi::text iLike '$tglP%' AND pegawai_id = '$pegawai_id' ");

        if (count($pulang) > 0 )
        {
            foreach($pulang as $pulang):
                $jamP = $pulang->tglpresensi;
            endforeach;
        }


        if($cekPertukaran == 0)
        {
            if ($cekJadwal == 0){
                    if (isset($data->pegawai->shift_id)){
                    echo $data->pegawai->shift->shift_nama.' / '.$data->pegawai->shift->shift_jamawal.' s/d '.$data->pegawai->shift->shift_jamakhir;
                }else{
                    echo ShiftM::model()->getShift($jammasuk,$jampulang, $jamM, $jamP);
                }
            }  else {
                echo ShiftM::model()->getJam($cekJadwal);
            }
        }
        else
        {
            echo ShiftM::model()->getJam($cekPertukaran);
        }
    }else{
        echo '-';
    }
 * 
 */


	$jammasuk = PresensiT::model()->getRealJam(Params::STATUSSCAN_MASUK, $datepresensi, $pegawai_id);
	$jampulang = PresensiT::model()->getRealJam(Params::STATUSSCAN_PULANG, $datepresensi, $pegawai_id);
	
	if (!empty($jammasuk)){
		$cekShiftBerlaku = ShiftberlakuM::model()->cekSHift($datepresensi.' '.$jammasuk, $kelompok_jabatan,'masuk');
	}elseif(!empty($jampulang)){										
		$cekShiftBerlaku = ShiftberlakuM::model()->cekSHift($datepresensi.' '.$jampulang, $kelompok_jabatan,'pulang');
	}else{
		$cekShiftBerlaku = '-';
	}
	echo $cekShiftBerlaku;
//}
?>