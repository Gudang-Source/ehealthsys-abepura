<?php
$dataArray = array();
$dataID = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	array_push($dataID, $data->periodeposting_id);
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}

// var_dump($_GET, $dataID);

$spasi1 = "&emsp;";
$spasi2 = "&emsp;&emsp;";
$spasi3 = "&emsp;&emsp;&emsp;";
$spasi4 = "&emsp;&emsp;&emsp;&emsp;";

// var_dump($_GET, $dataArray, $dataID);

$betwens = "";

if (!empty($model->periodeposting_id)) {
	$criteria = new CDbCriteria;
	$criteria->select = 'r.*, (case when t.jumlah is null then 0 else t.jumlah end) as jumlah';
	$criteria->order = 'r.kdrekening1,r.kdrekening2,r.kdrekening5';
	$criteria->addCondition('periodeposting_id = '.$model->periodeposting_id." or periodeposting_id is null");
	$criteria->join = "right join rekeningakuntansi_v r on r.rekening5_id = t.rekening5_id";
	$criteria->addCondition("t.kelrekening_id in ('5','6')");

	// var_dump($criteria); die;

	$modelLaporan = AKLaporanlabarugiV::model()->findAll($criteria);
} else $modelLaporan = array();

/*
$criteria = new CDbCriteria;
//$criteria->group = 'rekening1_id,nmrekening1,kdrekening1';
//$criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
$criteria->order = 'rekening1_id,nmrekening1,kdrekening1';
$criteria->compare('periodeposting_id', $dataID);
$modelLaporan = AKLaporanlabarugiV::model()->findAll($criteria);
*/
$detail = array(
	'pendapatan'=>array(
		'total'=>0,
		'rek2'=>array(),
	),
	'beban'=>array(
		'total'=>0,
		'rek2'=>array(),
	),
);
$labarugi = 0;
$totals = 0;
$flag = '';


foreach ($modelLaporan as $item) {
	//var_dump($item->attributes); die;
	if ($item->kelrekening_id == '5') {
		$flag = 'pendapatan';
		$totals = 0 - $item->jumlah;
	} else if ($item->kelrekening_id == '6') {
		$flag = 'beban';
		$totals = $item->jumlah;
	}
	
	$detail[$flag]['total'] += $totals;
	
	if (empty($detail[$flag]['rek2'][$item->kdrekening2])) {
		$detail[$flag]['rek2'][$item->kdrekening2] = array(
			'nama'=>$item->nmrekening2,
			'total'=>0,
			'rek5'=>array(),
		);
	}
	$detail[$flag]['rek2'][$item->kdrekening2]['total'] += $totals;
	
	if (empty($detail[$flag]['rek2'][$item->kdrekening2]['rek5'][$item->kdrekening5])) {
		$detail[$flag]['rek2'][$item->kdrekening2]['rek5'][$item->kdrekening5] = array(
			'nama'=>$item->nmrekening5,
			'total'=>0,
		);
	}
	
	$detail[$flag]['rek2'][$item->kdrekening2]['rek5'][$item->kdrekening5]['total'] += $totals;
}

// var_dump($detail);




if (isset($_GET['caraPrint'])) :
	echo $this->renderPartial('_tablePrint', array('detail'=>$detail), true);
else :

?>

<div style="width: 50%; float:left;">
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th>Rincian</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2" style="font-weight: bold; font-style:italic;">PENDAPATAN</td>
			</tr>
			<?php echo $this->renderPartial('_subTabel', array(
				'detail'=>$detail['pendapatan']['rek2'],
			), true); ?>
			<tr>
				<td style="font-weight: bold; font-style:italic; text-align: center;">TOTAL PENDAPATAN</td>
				<td style="font-weight: bold; font-style:italic; text-align: right;">
					<?php echo MyFormatter::formatNumberForPrint($detail['pendapatan']['total']); ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div style="width: 50%; float:left;">
	<table class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th>Rincian</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2" style="font-weight: bold; font-style:italic;">BIAYA</td>
			</tr>
			<?php echo $this->renderPartial('_subTabel', array(
				'detail'=>$detail['beban']['rek2'],
			), true); ?>
			<tr>
				<td style="font-weight: bold; font-style:italic; text-align: center;">TOTAL BIAYA</td>
				<td style="font-weight: bold; font-style:italic; text-align: right;">
					<?php echo MyFormatter::formatNumberForPrint($detail['beban']['total']); ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<?php 

$labarugi = $detail['pendapatan']['total'] - $detail['beban']['total'];
if ($labarugi < 0) {
	$labarugi = "(".MyFormatter::formatNumberForPrint($labarugi).")";
} else {
	$labarugi = MyFormatter::formatNumberForPrint($labarugi);
}

?>
<div style="width: 100%">
	<table class="table table-striped table-bordered table-condensed tots">
		<tbody>
			<tr>
				<td>TOTAL PENDAPATAN</td>
				<td class="tot"><?php echo MyFormatter::formatNumberForPrint($detail['pendapatan']['total']); ?></td>
			</tr>
			<tr>
				<td>TOTAL BIAYA</td>
				<td class="tot"><?php echo MyFormatter::formatNumberForPrint($detail['beban']['total']); ?></td>
			</tr>
			<tr>
				<td>LABA/RUGI</td>
				<td class="totlr"><?php echo $labarugi; ?></td>
			</tr>
		</tbody>
	</table>
</div>

<style>
	.tots td {
		font-weight: bold;
	}
	.tot {
		text-align: right !important;
		font-weight: bold;
		font-style: italic;
	}
	.totlr {
		text-align: right !important;
		font-weight: bold;
		font-style: italic;
		text-decoration: underline;
	}
</style>




<?php endif; ?>

<?php /**
<table class="table table-striped table-bordered table-condensed">
    <thead>
		
		<tr>
			<th>Rincian</th>
			<th class="span2">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($detail as $rek1): ?>
		<tr>
			<td style="font-weight: bold; font-style: italic"><?php echo $rek1['nama']; ?></td>
			<td></td>
		</tr>
			<?php foreach ($rek1['rek2'] as $rek2): ?>
			<tr>
				<td style="font-weight: bold; font-style: italic"><?php echo $spasi1.$rek2['nama']; ?></td>
				<td></td>
			</tr>
				<?php foreach ($rek2['rek3'] as $rek3): ?>
				<tr>
					<td style="font-weight: bold;"><?php echo $spasi2.$rek3['nama']; ?></td>
					<td></td>
				</tr>
					<?php foreach ($rek3['rek4'] as $rek4): ?>
					<tr>
						<td style="font-weight: bold;"><?php echo $spasi3.$rek4['nama']; ?></td>
						<td style='text-align: right; font-weight: bold;'><?php 
						if ($rek4['total'] < 0) {
							echo MyFormatter::formatNumberForPrint(abs($rek4['total'])); 
						} else {
							echo "(".MyFormatter::formatNumberForPrint(abs($rek4['total'])).")"; 
						}
						
						?></td>
					</tr>
						<?php foreach ($rek4['rek5'] as $rek5): ?>
						<tr>
							<td><?php echo $spasi4.$rek5['nama']; ?></td>
							<td style='text-align: right;'><?php 
							if ($rek5['total'] < 0) {
							echo MyFormatter::formatNumberForPrint(abs($rek5['total'])); 
						} else {
							echo "(".MyFormatter::formatNumberForPrint(abs($rek5['total'])).")"; 
						}
							?></td>
						</tr>
						<?php endforeach; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
			<?php endforeach; ?>
		<tr>
			<td style="font-weight: bold; font-style: italic; text-align: center"><?php echo strtoupper("Total ".$rek1['nama']); ?></td>			
			<td style="font-weight: bold; font-style: italic; text-align: right"><?php 
			if ($rek1['total'] < 0) {
				echo MyFormatter::formatNumberForPrint(abs($rek1['total'])); 
			} else {
				echo "(".MyFormatter::formatNumberForPrint(abs($rek1['total'])).")"; 
			}
			?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td style="font-weight: bold; font-style: italic; text-align: center; text-decoration: underline;"><?php echo strtoupper("Total Laba/Rugi"); ?></td>			
			<td style="font-weight: bold; font-style: italic; text-align: right; text-decoration: underline;"><?php 
			if ($labarugi < 0) {
				echo MyFormatter::formatNumberForPrint(abs($labarugi)); 
			} else {
				echo "(".MyFormatter::formatNumberForPrint(abs($labarugi)).")"; 
			}
			?></td>
		</tr>
	</tbody>
		
		
		
		<?php /*
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
		echo "<th>Total</th>";
		echo "</tr>"; */
		/* ?>

    </thead>
    <tbody>
		<?php
		/*
		// var_dump($_GET); die;
		
		$criteria = new CDbCriteria;
		$criteria->group = 'rekening1_id,nmrekening1,kdrekening1';
		$criteria->select = $criteria->group . " ,sum(jumlah) as jumlah";
		$criteria->order = 'rekening1_id,nmrekening1,kdrekening1';
		$modelLaporan = AKLaporanlabarugiV::model()->findAll($criteria);
		$spasi1 = "&emsp;";
		$spasi2 = "&emsp;&emsp;";
		$spasi3 = "&emsp;&emsp;&emsp;";
		$spasi4 = "&emsp;&emsp;&emsp;&emsp;";
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
					  	<td colspan=2><b><i>" . $nmrekening1 . "</i></b></td>";
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
//				$criteria2->addCondition($conditionid1);
//				$criteria2->addCondition($condition1);
//				$criteria2->addCondition($conditionKode1);
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
						//	LNG-4071
						//	LNG-5015 (dimunculin lagi)
						
                        /* LNG-5411
                        echo "
									<tr>
										  <td colspan=2><b><i>" . $spasi1 . $nmrekening2 . "</i></b></td>";
						for ($i = 0; $i < $jmlKolom - 1; $i++) {
							echo "<td>";
							echo "</td>";
						}
						echo " </tr>
								"; */ /*
                           
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
//	LNG-4071
								//	LNG-5015 (dimunculin lagi)
								echo "
									<tr class='segmen3'>
										  <td colspan=2><b><i>" . $spasi2 . $nmrekening3 . "</i></b></td>";
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
//	LNG-4071			                    
											$tot_segmen_4 += isset($result['jumlah']) ? abs($result['jumlah']) : 0;
									//	LNG-5015 (dimunculin lagi)
									//	LNG-5900	echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
											// echo "<td width='150px;' style='text-align:right'></td>";
											// LNG-5900	
//												if(($rekening1_id == 3)||($rekening1_id == 4)){ // Pendapatan Operasional || Pendapatan Non Operasional	
//													echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";	
//												}else{
													echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";
//												}
											// end
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
											// LNG-5900	
//												if(($rekening1_id == 3)||($rekening1_id == 4)){ // Pendapatan Operasional || Pendapatan Non Operasional	
//													echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";	
//												}else{
													echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";
//												}
											// end
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
					//	LNG-5900	echo "<td width='150px;' style='text-align:right'><strong>" . number_format($result['jumlah']) . "</strong></td>";
					// LNG-5900	
//						if(($rekening1_id == 3)||($rekening1_id == 4)){ // Pendapatan Operasional || Pendapatan Non Operasional	
							echo "<td width='150px;' style='text-align:right'>" . number_format(abs($result['jumlah'])) . "</td>";	
//						}else{
//							echo "<td width='150px;' style='text-align:right'><strong>" . number_format($result['jumlah']) . "</strong></td>";
//						}
					// end
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

//					$sql = "
//							SELECT 
//							coalesce(sum(jumlah),0) as jumlah
//							FROM laporanlabarugi_v
//							WHERE kelrekening_id = 4 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
//					LNG-3546
//	LNG-5891				
//					$sql = "
//							SELECT 
//							coalesce(sum(jumlah),0) as jumlah
//							FROM laporanlabarugi_v
//							WHERE rekening1_id = 3 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
////					-----
//					$pendapatan = Yii::app()->db->createCommand($sql)->queryRow();
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
//				LNG-5900
//					$pendapatan = $pendapatan1['jumlah'] + $pendapatan2['jumlah'];
					$pendapatan = abs($pendapatan1['jumlah'] + $pendapatan2['jumlah']);
				// end LNG-5900
// end 
//					$sql2 = "
//							SELECT 
//							coalesce(sum(jumlah),0) as jumlah
//							FROM laporanlabarugi_v
//							WHERE kelrekening_id = 5 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
//					LNG-3546
//	LNG-5891				
//					$sql2 = "
//							SELECT 
//							coalesce(sum(jumlah),0) as jumlah
//							FROM laporanlabarugi_v
//							WHERE rekening1_id = 5 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";
////					-----
//					
//					$beban = Yii::app()->db->createCommand($sql2)->queryRow();
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
//	end			
//	LNG-5891
//					$labarugi = $pendapatan['jumlah'] - $beban['jumlah'];
					$labarugi = $pendapatan - $beban;
//	end 				
					if ($labarugi < 0) {
					// LNG-5858	
//						$tot_labarugi += abs($labarugi);
						$tot_labarugi += $labarugi;
					// end
//						$labarugi = "(" . abs($labarugi) . ")";
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

						
    </tbody>*/
		?>

</table>


<?php

/*
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>
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
                echo "<th>Total</th>";
		echo "</tr>";
		?>

    </thead>
    <tbody>
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
                $pendapatan1 = 0; 
		$pendapatan2 = 0; 
		$beban = 0;
                $beban1 = 0; 
		$beban2 = 0; 
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
					  	<td colspan=2><b><i>" . $nmrekening1 . "</i></b></td>";
				for ($i = 0; $i < $jmlKolom - 1; $i++) {
					echo "<td>";
					echo "</td>";
				}
				echo " </tr>
								";

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
//				$criteria2->addCondition($conditionid1);
//				$criteria2->addCondition($condition1);
//				$criteria2->addCondition($conditionKode1);
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

						/*echo "
									<tr>
										  <td colspan=2><b><i>" . $spasi1 . $nmrekening2 . "</i></b></td>";
						for ($i = 0; $i < $jmlKolom - 1; $i++) {
							echo "<td>";
							echo "</td>";
						}
						echo " </tr>
								";*/ /*

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
									<tr>
										  <td colspan=2><b><i>" . $spasi2 . $nmrekening3 . "</i></b></td>";
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
													<tr>
														<td width='200px;'><b>" . $spasi3 . $nmrekening4 . "</b></td>";

										for ($i = 0; $i <= $jmlKolom - 1; $i++) {

											$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanlabarugi_v
												WHERE rekening4_id =" . $rekening4_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


											$result = Yii::app()->db->createCommand($sql)->queryRow();
											echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
										}


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
													<tr>
														<td width='200px;'>" . $spasi4 . $nmrekening5 . "</td>";

											for ($i = 0; $i <= $jmlKolom - 1; $i++) {

												$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanlabarugi_v
												WHERE rekening5_id =" . $rekening5_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


												$result = Yii::app()->db->createCommand($sql)->queryRow();
												echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
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
							<tr>
									<td style='text-align:right'><strong>Total " . $nmrekening1 . "</strong></td>";
				for ($i = 0; $i <= $jmlKolom - 1; $i++) {

					$sql = "
												SELECT 
												sum(jumlah) as jumlah
												FROM laporanlabarugi_v
												WHERE rekening1_id =" . $rekening1_id . " AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


					$result = Yii::app()->db->createCommand($sql)->queryRow();
					echo "<td width='150px;' style='text-align:right'>" . number_format($result['jumlah']) . "</td>";
				}



				echo "
							</tr>
						";

				
				$nmrekening1_temp = $nmrekening1;
			}
			
		}
		echo "
							<tr>
									<td><strong>Laba Rugi</strong></td>";

				for ($i = 0; $i <= $jmlKolom - 1; $i++) {

					$sql = "
							SELECT 
							coalesce(sum(jumlah),0) as jumlah
							FROM laporanlabarugi_v
							WHERE kelrekening_id = 4 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


					$pendapatan = Yii::app()->db->createCommand($sql)->queryRow();
					$sql2 = "
												SELECT 
												coalesce(sum(jumlah),0) as jumlah
												FROM laporanlabarugi_v
												WHERE kelrekening_id = 5 AND date(tglperiodeposting_awal) = '" . $tglKirims[$i]['tglperiodeposting_awal'] . "'";


					$beban = Yii::app()->db->createCommand($sql2)->queryRow();
					$labarugi = $pendapatan['jumlah'] - $beban['jumlah'];
					if ($labarugi < 0) {
//						$labarugi = "(" . abs($labarugi) . ")";
						echo "<td width='150px;' style='text-align:right'>(" . number_format(abs($labarugi)) . ")</td>";
					} else {
						echo "<td width='150px;' style='text-align:right'>" . number_format($labarugi) . "</td>";
					}
					
					
				}

				echo "
							</tr>
						";


		?>
    </tbody>

</table>
								 * 
								 */ ?>