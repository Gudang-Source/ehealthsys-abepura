<?php
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>
<table class="table table-striped table-condensed">
    <?php
    $jmlKolom = 0;
    $jenisWaktus = array();
    $tglKirims = array();
//    echo "<tr>";
//    echo "<td>Rincian</td>";
    foreach ($dataArray AS $row => $data) {
        if (count($data) > 1) {
            if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
                $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
//                echo "<td style='text-align:center'>";
//                echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])));
//                echo "</td>";
            } else {
//                echo "<td>";
//                echo "</td>";
            }
            $jmlKolom ++;
        } else {
            if (!empty($models) || !empty($data)) {
                $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;

//                echo "<td style='text-align:center'>";
//                echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data)));
//                echo "</td>";
            } else {
//                echo "<td>";
//                echo "</td>";
            }
            $jmlKolom ++;
        }
    }
//    echo "<td>Total</td>";
//    echo "</tr>";
    ?>
    
    <?php
    $criteria = new CDbCriteria;
    $criteria->group = 'rekening1_id,nmrekening1,kdrekening1';
    $criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
    $criteria->order = 'rekening1_id,nmrekening1,kdrekening1';
    $modelLaporan = AKLaporanlabarugiV::model()->findAll($criteria);
    $spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $nmrekening1_temp = "";
    $totSaldo = 0;
    $labarugi = 0;
    $pendapatan = 0;
    $pendapatan1 = 0; //LNG-5891
    $pendapatan2 = 0; //LNG-5891
    $beban = 0;
    $beban1 = 0; //LNG-5891
    $beban2 = 0; //LNG-5891
    foreach ($modelLaporan as $i => $data) {

        if ($data->nmrekening1) {
            $totSaldo = $data->jumlah;
            $nmrekening1 = $data->nmrekening1;
            $rekening1_id = $data->rekening1_id;
        } else {
            $nmrekening1 = '-';
        }

        if ($nmrekening1_temp != $nmrekening1) {
            if ($data->kdrekening1) {
                $kdrekening1 = $data->kdrekening1;
                $rekening1_id = $data->rekening1_id;
            } else {
                $kdrekening1 = '-';
            }

            echo "<tr class='segmen1'>
                    <td colspan=3><b><i>" . $nmrekening1 . "</i></b></td>";
            for ($i = 0; $i < $jmlKolom - 1; $i++) {
                echo "<td>";
                echo "</td>";
            }
            echo " </tr>";

            $criteria2 = new CDbCriteria;
            $termId1 = $rekening1_id;
            $term1 = $nmrekening1;
            $termKode1 = $kdrekening1;
            if (!empty($periodeposting_id)) {
                $criteria2->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
            }
            $conditionid1 = "rekening1_id = " . $termId1;
            $condition1 = "nmrekening1 ILIKE '%" . $term1 . "%'";
            $conditionKode1 = "kdrekening1 ILIKE '%" . $termKode1 . "%'";
            $criteria2->limit = -1;
            $criteria2->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2';
            $criteria2->select = $criteria2->group . ', sum(jumlah) as jumlah';
            $criteria2->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2 ASC';

            $detail1 = AKLaporanlabarugiV::model()->findAll($criteria2);
            $nmrekening2_temp = "";
            foreach ($detail1 as $key => $rekening2) {
                if ($rekening2->nmrekening2) {
                    $nmrekening2 = $rekening2->nmrekening2;
                } else {
                    $nmrekening2 = '-';
                }

                if ($nmrekening2_temp != $nmrekening2) {
                    if ($rekening2->kdrekening2) {
                        $kdrekening2 = $rekening2->kdrekening2;
                    } else {
                        $kdrekening2 = '-';
                    }

                    $criteria3 = new CDbCriteria;
                    $term2 = $nmrekening2;
                    $termKode2 = $kdrekening2;
                    if (!empty($periodeposting_id)) {
                        $criteria3->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
                    }
                    $condition2 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%'";
                    $conditionKode2 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%'";
                    $criteria3->addCondition($condition2);
                    $criteria3->addCondition($conditionKode2);
                    $criteria3->limit = -1;
                    $criteria3->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3';
                    $criteria3->select = $criteria3->group;
                    $criteria3->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3 ASC';

                    $detail2 = AKLaporanlabarugiV::model()->findAll($criteria3);
                    $nmrekening3_temp = "";
                    foreach ($detail2 as $key => $rekening3) {
                        if ($rekening3->nmrekening3) {
                            $nmrekening3 = $rekening3->nmrekening3;
                        } else {
                            $nmrekening3 = '-';
                        }

                        if ($nmrekening3_temp != $nmrekening3) {
                            if ($rekening3->kdrekening3) {
                                $kdrekening3 = $rekening3->kdrekening3;
                            } else {
                                $kdrekening3 = '-';
                            }

                            echo "
                                <tr class='segmen3'>
                                      <td colspan=3><b><i>" . $spasi2 . $nmrekening3 . "</i></b></td>";
                            for ($i = 0; $i < $jmlKolom - 1; $i++) {
                                echo "<td>";
                                echo "</td>";
                            }
                            echo " </tr>
                            ";

                            $criteria4 = new CDbCriteria;
                            $term3 = $nmrekening3;
                            $termKode3 = $kdrekening3;
                            if (!empty($periodeposting_id)) {
                                $criteria4->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
                            }
                            $condition3 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%'";
                            $conditionKode3 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%'";
                            $criteria4->addCondition($condition3);
                            $criteria4->addCondition($conditionKode3);
                            $criteria4->limit = -1;
                            $criteria4->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4';
                            $criteria4->select = $criteria4->group . " ,sum(jumlah) as jumlah";
                            $criteria4->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4 ASC';

                            $detail3 = AKLaporanlabarugiV::model()->findAll($criteria4);
                            $nmrekening4_temp = "";

                            foreach ($detail3 as $key => $rekening4) {
                                if ($rekening4->nmrekening4) {
                                    $nmrekening4 = $rekening4->nmrekening4;
                                    $rekening4_id = $rekening4->rekening4_id;
                                } else {
                                    $nmrekening4 = '-';
                                }

                                if ($nmrekening4_temp != $nmrekening4) {
                                    if ($rekening4->kdrekening4) {
                                        $kdrekening4 = $rekening4->kdrekening4;
                                        $rekening4_id = $rekening4->rekening4_id;
                                    } else {
                                        $kdrekening4 = '-';
                                    }

                                    echo "
                                                <tr class='segmen4'>
                                                    <td width='200px;'><b>" . $spasi3 . $nmrekening4 . "</b></td>";
                                    $tot_segmen_4 = 0;
                                    for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                                        $sql = "
                                            SELECT 
                                            sum(jumlah) as jumlah
                                            FROM laporanlabarugi_v
                                            WHERE rekening4_id =" . $rekening4_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                                        $result = Yii::app()->db->createCommand($sql)->queryRow();                   
                                        $tot_segmen_4 += isset($result['jumlah']) ? abs($result['jumlah']) : 0;
                              
                                        echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";
                                    }
                                    echo "<td width='150px;' style='text-align:right'>" . number_format($tot_segmen_4) . "</td>";
                                    echo "
                                                </tr>
                                            ";

                                    $criteria5 = new CDbCriteria;
                                    $term4 = $nmrekening4;
                                    $termKode4 = $kdrekening4;
                                    if (!empty($periodeposting_id)) {
                                        $criteria5->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
                                    }
                                    $condition4 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%' AND nmrekening4 ILIKE '%" . $term4 . "%'";
                                    $conditionKode4 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%' AND kdrekening4 ILIKE '%" . $termKode4 . "%'";
                                    $criteria5->addCondition($condition4);
                                    $criteria5->addCondition($conditionKode4);
                                    $criteria5->limit = -1;
                                    $criteria5->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5';
                                    $criteria5->select = $criteria5->group . ', sum(jumlah) as jumlah';
                                    $criteria5->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5 ASC';

                                    $detail4 = AKLaporanlabarugiV::model()->findAll($criteria5);
                                    $nmrekening5_temp = "";
                                    foreach ($detail4 as $key => $rekening5) {

                                        if ($rekening5->nmrekening5) {
                                            $nmrekening5 = $rekening5->nmrekening5;
                                            $rekening5_id = $rekening5->rekening5_id;
                                        } else {
                                            $nmrekening5 = '-';
                                        }



                                        echo "
                                                <tr class='segmen5'>
                                                    <td width='200px;'>" . $spasi4 . $nmrekening5 . "</td>";
                                        $tot_segmen_5 = 0;
                                        for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                                            $sql = "
                                            SELECT 
                                            sum(jumlah) as jumlah
                                            FROM laporanlabarugi_v
                                            WHERE rekening5_id =" . $rekening5_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                                            $result = Yii::app()->db->createCommand($sql)->queryRow();
                                            $tot_segmen_5 += isset($result['jumlah']) ? abs($result['jumlah']) : 0;
                                            echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";
                                        }
                                        echo "<td width='150px;' style='text-align:right'>" . number_format($tot_segmen_5) . "</td>";
                                        echo "
                                                </tr>
                                            ";
                                    }

                                    $nmrekening4_temp = $nmrekening4;
                                }
                            }

                            $nmrekening3_temp = $nmrekening3;
                        }
                    }

                    $nmrekening2_temp = $nmrekening2;
                }
            }

            echo "
                        <tr class='segmen1'>
                                <td style='text-align:right'><strong>Total " . $nmrekening1 . "</strong></td>";
            $tot_segmen_1 = 0;
            for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                $sql = "
                        SELECT 
                        sum(jumlah) as jumlah
                        FROM laporanlabarugi_v
                        WHERE rekening1_id =" . $rekening1_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                $result = Yii::app()->db->createCommand($sql)->queryRow();
                $tot_segmen_1 += isset($result['jumlah']) ? abs($result['jumlah']) : 0;

                echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";	
            }
            echo "<td width='150px;' style='text-align:right'><strong>" . number_format($tot_segmen_1) . "</strong></td>";
            echo "
                        </tr>
                    ";


            $nmrekening1_temp = $nmrekening1;
        }

    }
    echo "
                        <tr>
                                <td><strong>Laba (Rugi)</strong></td>";
            $tot_labarugi = 0;
            for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                $sql = "
                        SELECT 
                        coalesce(sum(jumlah),0) as jumlah
                        FROM laporanlabarugi_v
                        WHERE rekening1_id = 3 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
                $pendapatan1 = Yii::app()->db->createCommand($sql)->queryRow();
                $sql1 = "
                        SELECT 
                        coalesce(sum(jumlah),0) as jumlah
                        FROM laporanlabarugi_v
                        WHERE rekening1_id = 4 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
                $pendapatan2 = Yii::app()->db->createCommand($sql1)->queryRow();
                $pendapatan = abs($pendapatan1['jumlah'] + $pendapatan2['jumlah']);

                $sql2 = "
                        SELECT 
                        coalesce(sum(jumlah),0) as jumlah
                        FROM laporanlabarugi_v
                        WHERE rekening1_id = 5 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
                $beban1 = Yii::app()->db->createCommand($sql2)->queryRow();
                $sql3 = "
                        SELECT 
                        coalesce(sum(jumlah),0) as jumlah
                        FROM laporanlabarugi_v
                        WHERE rekening1_id = 6 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
                $beban2 = Yii::app()->db->createCommand($sql3)->queryRow();
                $beban = $beban1['jumlah'] + $beban2['jumlah'];

                $labarugi = $pendapatan - $beban;

                if ($labarugi < 0) {
                    $tot_labarugi += $labarugi;
                    echo "<td width='150px;' style='text-align:right'>(<strong>" . number_format(abs($labarugi)) . "</strong>)</td>";
                } else {
                    $tot_labarugi += $labarugi;
                    echo "<td width='150px;' style='text-align:right'><strong>" . number_format($labarugi) . "</strong></td>";
                }					
            }
            if ($labarugi < 0) {
                echo "<td width='150px;' style='text-align:right'>(<strong>" . number_format(abs($tot_labarugi)) . "</strong>)</td>";
            }else{
                echo "<td width='150px;' style='text-align:right'><strong>" . number_format($tot_labarugi) . "</strong></td>";
            }
            echo "
                        </tr>
                    ";


    ?>
</table>