<?php
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
    $dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>

<!--<div id="tableLaporan" class="grid-view">
    <div <?php // echo $style; ?>>-->
        <table class="table table-striped table-condensed">
            <!--<thead>-->
                <?php
                $jmlKolom = 0;
                $jenisWaktus = array();
                $tglKirims = array();
//              echo "<tr>";
//              echo "<th>Rincian</th>";
                foreach ($dataArray AS $row => $data) {
                    if (count($data) > 1) {
                        if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
                            $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
//                          echo "<th style='text-align:center'>";
//                          echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])));
//                          echo "</th>";
                        } else {
//                          echo "<th>";
//                          echo "</th>";
                        }
                        $jmlKolom ++;
                    } else {
                        if (!empty($models) || !empty($data)) {
                            $tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;

//                          echo "<th style='text-align:center'>";
//                          echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data)));
//                          echo "</th>";
                        } else {
//                          echo "<th>";
//                          echo "</th>";
                        }
                        $jmlKolom ++;
                    }
                }
//              echo "</tr>";
                ?>
            <!--</thead>-->
            <!--<tbody>-->
                <?php
                $criteria = new CDbCriteria;
                $criteria->group = 'rekening1_id,nmrekening1,kdrekening1';
                $criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
                $criteria->order = 'rekening1_id,nmrekening1,kdrekening1';
                $modelLaporan = AKLaporanneracaV::model()->findAll($criteria);
                $spasi1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $spasi2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $spasi3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $spasi4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                $nmrekening1_temp = "";
                $totSaldo = 0;
                $labarugi = 0;
                $pendapatan = 0;
                $beban = 0;
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
                        echo "
                        <tr class='segmen1'>
                              <td colspan=2><b><i>" . $nmrekening1 . "</i></b></td>";
                        for ($i = 0; $i < $jmlKolom - 1; $i++) {
                            echo "<td></td>";
                        }
                        echo " </tr>
                                ";

                        $criteria2 = new CDbCriteria;
                        $termId1 = $rekening1_id;
                        $term1 = $nmrekening1;
                        $termKode1 = $kdrekening1;
                        // if (!empty($periodeposting_id)) {
                        //  $criteria2->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
                        // }
                        $conditionid1 = "rekening1_id = " . $termId1;
                        // $condition1 = "nmrekening1 ILIKE '%" . $term1 . "%'";
                        // $conditionKode1 = "kdrekening1 ILIKE '%" . $termKode1 . "%'";
                        // $criteria2->limit = -1;
                        $criteria2->addCondition($conditionid1);
                        // $criteria2->addCondition($condition1);
                        // $criteria2->addCondition($conditionKode1);
                        // $criteria2->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2';
                        // $criteria2->select = $criteria2->group . ', sum(jumlah) as jumlah';
                        // $criteria2->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2 ASC';

                        // $detail1 = AKLaporanneracaV::model()->findAll($criteria2);
                        
                        $detail1 = AKRekening2M::model()->findAll($criteria2);
                        $nmrekening2_temp = "";
                        foreach ($detail1 as $key => $rekening2) {
                            if ($rekening2->nmrekening2) {
                                $nmrekening2 = $rekening2->nmrekening2;
                                $rekening2_id = $rekening2->rekening2_id;
                            } else {
                                $nmrekening2 = '-';
                            }

                            if ($nmrekening2_temp != $nmrekening2) {
                                if ($rekening2->kdrekening2) {
                                    $kdrekening2 = $rekening2->kdrekening2;
                                    $rekening2_id = $rekening2->rekening2_id;
                                } else {
                                    $kdrekening2 = '-';
                                }

                                echo "
                                    <tr class='segmen2'>
                                          <td><b><i>" . $spasi1 . $nmrekening2 . "</i></b></td>";
                                for ($i = 0; $i < $jmlKolom; $i++) {
                                    $sql2 = "
                                    SELECT 
                                    sum(jumlah) as jumlah
                                    FROM laporanneraca_v
                                    WHERE rekening2_id =" . $rekening2_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                                        $result2 = Yii::app()->db->createCommand($sql2)->queryRow();
            //                  LNG-5914        
            //                          if($result2['jumlah'] < 0){
            //                              $jumlah = $result2['jumlah'] * (-1);
            //                          }else{
                                            $jumlah = $result2['jumlah'];
            //                          }
            //                  end
//                                      echo "<td width='150px;' style='text-align:right'><span class='totalRek2' style='display:none;'>" . number_format($result2['jumlah']) . "</span></td>";
                                        echo "<td width='150px;' style='text-align:right'><span class='totalRek2' style='display:none;'>" . number_format(abs($jumlah)) . "</span></td>";
                                }
                                echo " </tr>
                                ";

                                $criteria3 = new CDbCriteria;
                                $term2 = $nmrekening2;
                                $termKode2 = $kdrekening2;
                                $criteria3->addCondition('rekening2_id = '.$rekening2_id);
                                $detail2 = AKRekening3M::model()->findAll($criteria3);
                                $nmrekening3_temp = "";
                                foreach ($detail2 as $key => $rekening3) {
                                    if ($rekening3->nmrekening3) {
                                        $nmrekening3 = $rekening3->nmrekening3;
                                        $rekening3_id = $rekening3->rekening3_id;
                                    } else {
                                        $nmrekening3 = '-';
                                    }

                                    if ($nmrekening3_temp != $nmrekening3) {
                                        if ($rekening3->kdrekening3) {
                                            $kdrekening3 = $rekening3->kdrekening3;
                                            $rekening3_id = $rekening3->rekening3_id;
                                        } else {
                                            $kdrekening3 = '-';
                                        }

                                        echo "
                                        <tr class='segmen3'>
                                          <td ><b><i>" . $spasi2 . $nmrekening3 . "</i></b></td>";
                                        for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                                        $sql3 = "
                                        SELECT 
                                        sum(jumlah) as jumlah
                                        FROM laporanneraca_v
                                        WHERE rekening3_id =" . $rekening3_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                                            $result3 = Yii::app()->db->createCommand($sql3)->queryRow();
                //                  LNG-5914        
                //                          if($result3['jumlah'] < 0){
                //                              $jumlah = $result3['jumlah'] * (-1);
                //                          }else{
                                                $jumlah = $result3['jumlah'];
                //                          }
                //                  end
//                                          echo "<td width='150px;' style='text-align:right'><span class='totalRek3' style='display:none;'>" . number_format($result3['jumlah']) . "</span></td>";
                                            echo "<td width='150px;' style='text-align:right'><span class='totalRek3' style='display:none;'>" . number_format(abs($jumlah)) . "</span></td>";
                                        }
                                        echo " </tr>
                                ";

                                        $criteria4 = new CDbCriteria;
                                        $term3 = $nmrekening3;
                                        $termKode3 = $kdrekening3;
                                        $criteria4->addCondition('rekening3_id = '.$rekening3_id);
                                        
                                        $detail3 = AKRekening4M::model()->findAll($criteria4);
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

                                                for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                                                    $sql = "
                                                SELECT 
                                                sum(jumlah) as jumlah
                                                FROM laporanneraca_v
                                                WHERE rekening4_id =" . $rekening4_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                                                    $result = Yii::app()->db->createCommand($sql)->queryRow();
                        //                  LNG-5914        
                        //                          if($result['jumlah'] < 0){
                        //                              $jumlah = $result['jumlah'] * (-1);
                        //                          }else{
                                                        $jumlah = $result['jumlah'];
                        //                          }
                        //                  end
//                                                  echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
                                                    echo "<td width='150px;' style='text-align:right'>" . number_format(abs($jumlah)) . "</td>";
                                                }


                                                echo "
                                                    </tr>
                                                ";

                                                $criteria5 = new CDbCriteria;
                                                $term4 = $nmrekening4;
                                                $termKode4 = $kdrekening4;
                                                $criteria5->addCondition('rekening4_id = '.$rekening4_id);
                                                
                                                $detail4 = AKRekening5M::model()->findAll($criteria5);
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
                                                        <td width='200px;'>" . $spasi4 . $nmrekening5 . " </td>";

                                                    for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                                                        $sql = "
                                                SELECT 
                                                sum(jumlah) as jumlah
                                                FROM laporanneraca_v
                                                WHERE rekening5_id =" . $rekening5_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                                                        $result = Yii::app()->db->createCommand($sql)->queryRow();
                            //                  LNG-5914        
                            //                          if($result['jumlah'] < 0){
                            //                              $jumlah = $result['jumlah'] * (-1);
                            //                          }else{
                                                            $jumlah = $result['jumlah'];
                            //                          }
                            //                  end
//                                                      echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
                                                        echo "<td width='150px;' style='text-align:right'>" . number_format(abs($jumlah)) . "</td>";
                                                    }


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
                        for ($i = 0; $i <= $jmlKolom - 1; $i++) {

                            $sql = "
                                                SELECT 
                                                sum(jumlah) as jumlah
                                                FROM laporanneraca_v
                                                WHERE rekening1_id =" . $rekening1_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


                            $result = Yii::app()->db->createCommand($sql)->queryRow();
//                  LNG-5914        
//                          if($result['jumlah'] < 0){
//                              $jumlah = $result['jumlah'] * (-1);
//                          }else{
                                $jumlah = $result['jumlah'];
//                          }
//                  end
//                          echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
                            echo "<td width='150px;' style='text-align:right'>" . number_format($jumlah) . "</td>";
                        }



                        echo "
                            </tr>
                        ";


                        $nmrekening1_temp = $nmrekening1;
                    }
                }
                ?>
        </table>