<?php
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach ($models AS $row => $data) {
	$dataArray["$data->tglperiodeposting_awal"] = $data->tglperiodeposting_awal;
}
?>
<div id="tableLaporan" class="grid-view table table-striped table-condensed">
	<table width="100%">
		<thead>
			<?php
			$jmlKolom = 0;
			$jenisWaktus = array();
			$tglKirims = array();
			echo "<tr>";
			echo "<th rowspan=2>No.</th>";
			echo "<th rowspan=2>Rasio</th>";
//				echo "<th style=text-align:center; colspan='$jmlKolom'>Presentase(%)</th>";

			echo "</tr>";
			echo "<tr>";
			foreach ($dataArray AS $row => $data) {
				if (count($data) > 1) {
					if (!empty($models) || !empty($data['tglperiodeposting_awal'])) {
						$tglKirims[$jmlKolom]['tglperiodeposting_awal'] = $data['tglperiodeposting_awal'];
						echo "<th style='text-align:center'>";
						echo MyFormatter::formatMonthForUser(date("Y-m-d", strtotime($data['tglperiodeposting_awal'])));
						echo " (%)";
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
						echo " (%)";
						echo "</th>";
					} else {
						echo "<th>";
						echo "</th>";
					}
					$jmlKolom ++;
				}
			}
			?>
		</thead>
		<tbody>
			<?php
			$criteria = new CDbCriteria();
			$criteria->select = 'nama_rasio';
			$criteria->group = 'nama_rasio';
			$model = AKLaporanrasioR::model()->findAll($criteria);
			$no_urut = 1;
			foreach ($model as $i => $data) {
				?>
				<tr>
					<td style="text-align:center;"><?php echo $no_urut; ?> .</td>
					<td> <?php echo $data->nama_rasio; ?> </td>
					<?php
					for ($i = 0; $i <= $jmlKolom - 1; $i++) {
						$ratio = 0;
						$criteria1 = new CDbCriteria();
						$criteria1->join = 'JOIN periodeposting_m AS periodeposting ON periodeposting.periodeposting_id = t.periodeposting_id';
						$criteria1->compare('LOWER(nama_rasio)', strtolower($data->nama_rasio), true);
						$periodeposting_awal = $tglKirims[$i]['tglperiodeposting_awal'];
						$periodeposting_awal_akhir = '';
						$criteria1->addCondition("periodeposting.tglperiodeposting_awal = '$periodeposting_awal'");

						$model = AKLaporanrasioR::model()->find($criteria1);
						if (isset($model)) {
							$ratio = $model->rasio;
						}
						echo "<td width='150px;' style='text-align:center'>" . number_format($ratio, 3) . "</td>";
					}
					?>
				</tr>
				<?php $no_urut ++;
			}
			?>

		</tbody>
	</table>
</div>