<style type="text/css">
	.table th{
		text-align: center;
	}
</style>
<?php
Yii::app()->clientScript->registerScript('cari cari', "
        $('#search-form').submit(function(){
			$('#tableLaporan').addClass('srbacLoading');
            $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<?php
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
}else {
	
}

$a = 0;
foreach ($jmlrekening as $key => $jmls) {
	$a += $jmls['urutan'];
	$struktur[$key] = $a;
}
?>

<?php
if (isset($caraPrint)) {
	$nmRekening_temp = "";

	foreach ($model as $i => $data) {
		if ($data->nmrekening5) {
			$nmRekening = $data->nmrekening5;
		}

		if ($nmRekening_temp != $nmRekening) {
			echo "<div id='tableLaporan' class='grid-view'>
				  <div style='max-width:1500px;overflow-x:scroll;'>";
			echo "<table class='table table-striped table-condensed'>
                    <tr>
                        <td><strong>Nama Rekening</storng></td>
                        <td><strong>:</strong></td>
                        <td>" . $nmRekening . "</td>
                    </tr>
					";
			echo "</table>";

			echo "<table width='100%' border='1' class='table table-striped '>
					<tr style='font-weight:bold;'>
						<td rowspan='2'>Periode Posting</td>
						<td rowspan='2'>Tgl Posting</td>
						<td rowspan='2'>Uraian Transaksi</td>
						<td colspan='2' style='text-align:center'>Saldo</td>
						<td rowspan='2' style='text-align:center'>Saldo</td>
					</tr>
					<tr style='font-weight:bold;'>
						<td style='text-align:center'>Debit</td>
						<td style='text-align:center'>Kredit</td>
					</tr>";

			$criteria = new CDbCriteria;
			$term = $nmRekening;
//			$termKode = $kdRekening;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id =' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->ruangan_id)) {
				$criteria->addCondition('ruangan_id =' . $modelLaporan->ruangan_id);
			}
			$criteria->group = 'rekening5_id, nmrekening5,rekening5_nb,tglbukubesar,periodeposting_nama';
			$criteria->select = $criteria->group . ', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
			$condition = "LOWER(nmrekening5) ILIKE '%" . strtolower($term) . "%' ";
			$criteria->addCondition($condition);
			$criteria->limit = -1;
			$criteria->order = 'rekening5_id, tglbukubesar ASC';

			$totDebit = 0;
			$totKredit = 0;
			$totSaldo = 0;
			$detail = AKLaporanbukubesarV::model()->findAll($criteria);
			foreach ($detail as $key => $details) {
				if ($details->saldodebit > 0 && $details->saldokredit > 0) {
					$saldo = $details->saldodebit - $details->saldokredit;
				} else if ($details->saldodebit > 0) {
					$saldo = $details->saldodebit - $details->saldokredit;
				} else if ($details->saldodebit <= 0 && $details->saldokredit > 0) {
					$saldo = $details->saldodebit - $details->saldokredit;
				}

				if ($details->rekening5_nb == 'D') {
					$saldo = $details->saldodebit - $details->saldokredit;
				} else {
					$saldo = $details->saldokredit;
				}

				$totDebit += $details->saldodebit;
				$totKredit += $details->saldokredit;

				if ($details->rekening5_nb == 'D') {
					$totSaldo = $totDebit - $totKredit;
				} elseif ($details->rekening5_nb == 'K') {
					$totSaldo = $totKredit - $totDebit;
				}

				echo "<tr>
					<td width='150px;'>" . $details->periodeposting_nama . "</td>
						<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
						<td width='200px;'>" . $details->getNamaRekening() . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldodebit) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldokredit) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
					</tr>";
			}

			echo "<tfoot>
						<tr>
							<td colspan=3 style='text-align:right'><strong>Total : </strong></td>
							<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totKredit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
						</tr>
					</tfoot>";
			echo "</table></div>
		  </div><br/><br/>";
		}
		$nmRekening_temp = $nmRekening;
	}
	?>
	<?php
} else {
	$nmRekening_temp = "";
	echo "<div id='tableLaporan' class='grid-view'>
				  <div style='max-width:1500px;overflow-x:scroll;'>";
	echo "<table class='table table-striped table-condensed'>
				<thead>
					<tr>
						<th rowspan='2'>Periode Posting</th>
						<th rowspan='2'>Tgl Posting</th>
						<th rowspan='2'>Uraian Transaksi</th>
						<th colspan='2' style='text-align:center'>Saldo</th>
						<th rowspan='2' style='text-align:center'>Saldo</th>
					</tr>
					<tr>
						<th style='text-align:center'>Debit</th>
						<th style='text-align:center'>Kredit</th>
					</tr>
				</thead>
				<tbody>";
	foreach ($model as $i => $data) {
		if ($data->nmrekening5) {
			$nmRekening = $data->nmrekening5;
		}

		if ($nmRekening_temp != $nmRekening) {
			echo "
				<tr>
                      <td colspan=6><b><i>" . $nmRekening . "</i></b></td>
                </tr>
					";

			$criteria = new CDbCriteria;
			$term = $nmRekening;
//			$termKode = $kdRekening;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id =' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->ruangan_id)) {
				$criteria->addCondition('ruangan_id =' . $modelLaporan->ruangan_id);
			}
			$criteria->group = 'rekening5_id, nmrekening5,rekening5_nb,tglbukubesar,periodeposting_nama';
			$criteria->select = $criteria->group . ', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
			$condition = "LOWER(nmrekening5) ILIKE '%" . strtolower($term) . "%' ";
			$criteria->addCondition($condition);
			$criteria->limit = -1;
			$criteria->order = 'rekening5_id, tglbukubesar ASC';

			$totDebit = 0;
			$totKredit = 0;
			$totSaldo = 0;
			$detail = AKLaporanbukubesarV::model()->findAll($criteria);
			foreach ($detail as $key => $details) {
				if ($details->saldodebit > 0 && $details->saldokredit > 0) {
					$saldo = $details->saldodebit - $details->saldokredit;
				} else if ($details->saldodebit > 0) {
					$saldo = $details->saldodebit - $details->saldokredit;
				} else if ($details->saldodebit <= 0 && $details->saldokredit > 0) {
					$saldo = $details->saldodebit - $details->saldokredit;
				}

				if ($details->rekening5_nb == 'D') {
					$saldo = $details->saldodebit - $details->saldokredit;
				} else {
					$saldo = $details->saldokredit;
				}

				$totDebit += $details->saldodebit;
				$totKredit += $details->saldokredit;

				if ($details->rekening5_nb == 'D') {
					$totSaldo = $totDebit - $totKredit;
				} elseif ($details->rekening5_nb == 'K') {
					$totSaldo = $totKredit - $totDebit;
				}

				echo "<tr>
					<td width='150px;'>" . $details->periodeposting_nama . "</td>
						<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
						<td width='200px;'>" . $details->getNamaRekening() . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldodebit) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldokredit) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
					</tr>";
			}

			echo "
						<tr>
							<td colspan=3 style='text-align:right'><strong>Total " . $nmRekening . "</strong></td>
							<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totKredit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
						</tr>
					";

			$nmRekening_temp = $nmRekening;
		}
	}
	echo "<tbody>
		  </table>
		  </div>
		  </div>";
}
?>
