<?php
Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('#searchLaporan').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
	");
?>
<?php
$spasi = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$style = "style='max-width:1500px;overflow-x:scroll;'";
if (isset($caraPrint)) {
	$style = "";
	$segmen_1 = isset($segmen[0]) ? $segmen[0] : null;
	$segmen_2 = isset($segmen[1]) ? $segmen[1] : null;
	$segmen_3 = isset($segmen[2]) ? $segmen[2] : null;
	$segmen_4 = isset($segmen[3]) ? $segmen[3] : null;
	$segmen_5 = isset($segmen[4]) ? $segmen[4] : null;
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
	$segmen = '';
}
?>
<?php
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>
<div id="tableLaporan" class="grid-view">
    <div <?php echo $style; ?>>
<table class="table table-striped table-condensed">
    <thead>
		<?php
		$jmlKolom = 0;
		$jenisWaktus = array();
		$tglKirims = array();
		echo "<tr>";
		echo "<th>Rincian</th>";
		foreach ($dataArray AS $row => $data) {
			if (count($data) > 1) {
				if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
					$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
					echo "<th style='text-align:center'>";
					echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])));
					echo "</th>";
				} else {
					echo "<th>";
					echo "</th>";
				}
				$jmlKolom ++;
			} else {
				if (!empty($models) || !empty($data)) {
					$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data;

					echo "<th style='text-align:center'>";
					echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data)));
					echo "</th>";
				} else {
					echo "<th>";
					echo "</th>";
				}
				$jmlKolom ++;
			}
		}
		echo "</tr>";
		?>

    </thead>
    <tbody>
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
						// 	$criteria2->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
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
			
											$jumlah = $result2['jumlah'];
			
										echo "<td width='150px;' style='text-align:right'><span class='totalRek2' style='display:none;'>" . number_format(abs($jumlah)) . "</span></td>";
								}
								echo " </tr>
								";

								$criteria3 = new CDbCriteria;
								$term2 = $nmrekening2;
								$termKode2 = $kdrekening2;
								// if (!empty($periodeposting_id)) {
								// 	$criteria3->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
								// }
								// $condition2 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%'";
								// $conditionKode2 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%'";
								// $criteria3->addCondition($condition2);
								// $criteria3->addCondition($conditionKode2);
								// $criteria3->limit = -1;
								// $criteria3->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3';
								// $criteria3->select = $criteria3->group;
								// $criteria3->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3 ASC';
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
				//					
												$jumlah = $result3['jumlah'];
				//							
											echo "<td width='150px;' style='text-align:right'><span class='totalRek3' style='display:none;'>" . number_format(abs($jumlah)) . "</span></td>";
										}
										echo " </tr>
								";

										$criteria4 = new CDbCriteria;
										$term3 = $nmrekening3;
										$termKode3 = $kdrekening3;
										// if (!empty($periodeposting_id)) {
										// 	$criteria4->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
										// }
										// $condition3 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%'";
										// $conditionKode3 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%'";
										// $criteria4->addCondition($condition3);
										// $criteria4->addCondition($conditionKode3);
										// $criteria4->limit = -1;
										// $criteria4->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4';
										// $criteria4->select = $criteria4->group . " ,sum(jumlah) as jumlah";
										// $criteria4->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4 ASC';

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
			
														$jumlah = $result['jumlah'];
						
													echo "<td width='150px;' style='text-align:right'>" . number_format(abs($jumlah)) . "</td>";
												}


												echo "
													</tr>
												";

												$criteria5 = new CDbCriteria;
												$term4 = $nmrekening4;
												$termKode4 = $kdrekening4;
												// if (!empty($periodeposting_id)) {
												// 	$criteria5->addCondition("date(tglperiodeposting_awal) = '" . $tahun . '-' . $periodeposting_id . "'");
												// }
												// $condition4 = "nmrekening1 ILIKE '%" . $term1 . "%' AND nmrekening2 ILIKE '%" . $term2 . "%' AND nmrekening3 ILIKE '%" . $term3 . "%' AND nmrekening4 ILIKE '%" . $term4 . "%'";
												// $conditionKode4 = "kdrekening1 ILIKE '%" . $termKode1 . "%' AND kdrekening2 ILIKE '%" . $termKode2 . "%' AND kdrekening3 ILIKE '%" . $termKode3 . "%' AND kdrekening4 ILIKE '%" . $termKode4 . "%'";
												// $criteria5->addCondition($condition4);
												// $criteria5->addCondition($conditionKode4);
												// $criteria5->limit = -1;
												// $criteria5->group = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5';
												// $criteria5->select = $criteria5->group . ', sum(jumlah) as jumlah';
												// $criteria5->order = 'rekening1_id,nmrekening1,kdrekening1,rekening2_id,nmrekening2,kdrekening2,rekening3_id,nmrekening3,kdrekening3,rekening4_id,nmrekening4,kdrekening4,rekening5_id,nmrekening5,kdrekening5 ASC';

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
							
															$jumlah = $result['jumlah'];
							
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
//					
								$jumlah = $result['jumlah'];
//							
							echo "<td width='150px;' style='text-align:right'>" . number_format($jumlah) . "</td>";
						}



						echo "
							</tr>
						";


						$nmrekening1_temp = $nmrekening1;
					}
				}
				
				?>
			</tbody>
		</table>
    </div>
</div>
<?php if(isset($caraPrint)){ ?>
<script type="text/javascript">
pilihSegmen();
function pilihSegmen(){
	var segmen1 = '<?php echo isset($segmen_1) ? $segmen_1 : ''; ?>';
	var segmen2 = '<?php echo isset($segmen_2) ? $segmen_2 : ''; ?>';
	var segmen3 = '<?php echo isset($segmen_3) ? $segmen_3 : ''; ?>';
	var segmen4 = '<?php echo isset($segmen_4) ? $segmen_4 : ''; ?>';
	var segmen5 = '<?php echo isset($segmen_5) ? $segmen_5 : ''; ?>';

	if(segmen1 == 1){
		segmen1 = 1;
		if(segmen2 != ''){
			if(segmen2 == 2){
				segmen2 = 2;
			}
			if(segmen2 == 3){
				segmen3 = 3;
			}
			if(segmen2 == 4){
				segmen4 = 4;
			}
			if(segmen2 == 5){
				segmen5 = 5;
			}
		}
		if(segmen3 != ''){
			if(segmen3 == 3){
				segmen3 = 3;
			}
			if(segmen3 == 4){
				segmen4 = 4;
			}
			if(segmen3 == 5){
				segmen5 = 5;
			}
		}
		if(segmen4 != ''){
			if(segmen4 == 4){
				segmen4 = 4;
			}
			if(segmen4 == 5){
				segmen5 = 5;
			}
		}
		if(segmen5 != ''){
			if(segmen5 == 5){
				segmen5 = 5;
			}
		}
	}
	if(segmen1 == 2){		
		if(segmen2 != ''){
			if(segmen2 == 3){
				segmen3 = 3;
			}
			if(segmen2 == 4){
				segmen4 = 4;
			}
			if(segmen2 == 5){
				segmen5 = 5;
			}
		}
		if(segmen3 != ''){
			if(segmen3 == 4 || segmen3 == 3){
				segmen4 = 4;
			}
			if(segmen3 == 5){
				segmen5 = 5;
			}
		}
		if(segmen4 != ''){
			if(segmen4 == 5 || segmen4 == 4){
				segmen5 = 5;
			}
		}
		segmen2 = 2;
		segmen1 = '';
	}
	if(segmen1 == 3){
		if(segmen2 != ''){
			if(segmen2 == 4){
				segmen4 = 4;
			}
			if(segmen2 == 5){
				segmen5 = 5;
			}
		}
		if(segmen3 != ''){
			if(segmen3 == 5){
				segmen5 = 5;
			}
		}
		segmen3 = 3;
		segmen1 = '';
		segmen2 = '';
	}
	if(segmen1 == 4){
		if(segmen2 != ''){
			if(segmen2 == 5){
				segmen5 = 5;
			}
		}
		segmen4 = 4;
		segmen1 = '';
		segmen2 = '';
		segmen3 = '';
	}
	if(segmen1 == 5){
		segmen5 = 5;
	}
	
    if(segmen3 != '' || (segmen4 != '' || segmen5 != ''))
        $(".totalRek2").fadeOut("slow");
    else
        $(".totalRek2").fadeIn("slow");

    if(segmen4 != '' || segmen5 != '')
        $(".totalRek3").fadeOut("slow");
    else
        $(".totalRek3").fadeIn("slow");

	if (segmen1 != '' && segmen2 != '' && segmen3 != '' && segmen4 != '' && segmen5 != '') {
        $(".segmen1").each(function(){
            $(this).fadeIn("slow");
        })
        $(".segmen2").each(function(){
            $(this).fadeIn("slow");
        })
         $(".segmen3").each(function(){
            $(this).fadeIn("slow");
        })
         $(".segmen4").each(function(){
            $(this).fadeIn("slow");
        })
         $(".segmen5").each(function(){
            $(this).fadeIn("slow");
        })
    }else{
        $(".segmen1").each(function(){
            $(this).fadeOut("slow");
        })
        $(".segmen2").each(function(){
            $(this).fadeOut("slow");
        })
         $(".segmen3").each(function(){
            $(this).fadeOut("slow");
        })
         $(".segmen4").each(function(){
            $(this).fadeOut("slow");
        })
         $(".segmen5").each(function(){
            $(this).fadeOut("slow");
        })
    }
	
    if(segmen1 != '' && segmen1 == 1){ 
        $(".segmen1").each(function(){
            if(segmen1 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });  
        $(".segmen2").each(function(){
            if(segmen2 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });  
        $(".segmen3").each(function(){
            if(segmen3 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen4").each(function(){
            if(segmen4 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if(segmen5 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(segmen2 != '' && segmen2 == 2){
        $(".segmen2").each(function(){
            if(segmen2 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });  
        $(".segmen3").each(function(){
            if(segmen3 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen4").each(function(){
            if(segmen4 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if(segmen5 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(segmen3 != '' && segmen3 == 3){
        $(".segmen3").each(function(){
            if(segmen3 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen4").each(function(){
            if(segmen4 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if(segmen5 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(segmen4 != '' && segmen4 == 4){
        $(".segmen4").each(function(){
            if(segmen4 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
        $(".segmen5").each(function(){
            if(segmen5 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
    if(segmen5 != '' && segmen5 == 5){
        $(".segmen5").each(function(){
            if(segmen5 != '')
                $(this).fadeIn("slow");
            else
                $(this).fadeOut("slow");
        });
    }
}
</script>
<?php } ?>