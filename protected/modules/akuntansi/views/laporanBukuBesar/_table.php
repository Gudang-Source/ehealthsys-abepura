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
		} else {
			if ($data->nmrekening4) {
				$nmRekening = $data->nmrekening4;
			} else {
				$nmRekening = $data->nmrekening3;
			}
		}
		
		if (!isset($nmRekening_temp[$nmRekening])) {
			$nmRekening_temp[$nmRekening] = 1;
		}else{
			$nmRekening_temp[$nmRekening]++;
		}
		
		if($nmRekening_temp[$nmRekening] == 1){
			if ($data->kdrekening5) {
				$kdRekening = $data->kdrekening5;
				$kdRekening_text = $data->kdrekening1 . '-' . $data->kdrekening2 . '-' . $data->kdrekening3 . '-' . $data->kdrekening4 . '-' . $data->kdrekening5;
			} else {
				if ($data->kdrekening4) {
					$kdRekening = $data->kdrekening4;
					$kdRekening_text = $data->kdrekening1 . '-' . $data->kdrekening2 . '-' . $data->kdrekening3 . '-' . $data->kdrekening4;
				} else {
					$kdRekening = $data->kdrekening3;
					$kdRekening_text = $data->kdrekening1 . '-' . $data->kdrekening2 . '-' . $data->kdrekening3;
				}
			}
			echo "<table class='table table-striped table-condensed'>
                    <tr>
                        <td><strong>Kode Cost Center</strong></td>
                        <td><strong>:</strong></td>
                        <td>" . $data->kodeunitkerja . "</td>
                    </tr>
                    <tr>
                        <td><strong>Kode Rekening</strong></td>
                        <td><strong>:</strong></td>
                        <td>" . $kdRekening_text . "</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Rekening</storng></td>
                        <td><strong>:</strong></td>
                        <td>" . $nmRekening . "</td>
                    </tr>";
			echo "</table>";

			echo "<table width='100%' border='1' class='table table-striped '>
					<tr style='font-weight:bold;'>
						<th rowspan='2'>Tanggal Transaksi</th>
						<th rowspan='2'>Tanggal Posting</th>
						<th rowspan='2'>Jenis Jurnal</th>".
						// <th rowspan='2' style='text-align:center'>No. Ref</th> /* LNG-5816 */
						"<th rowspan='2'>No. Jurnal</th>
						<th rowspan='2'>Uraian Transaksi</th>						
						<th colspan='2' style='text-align:center'>Saldo</th>
						<th rowspan='2' style='text-align:center'>Saldo</th>
					</tr>
					<tr style='font-weight:bold;'>
						<td style='text-align:center'>Debit</td>
						<td style='text-align:center'>Kredit</td>
					</tr>";

			$criteria = new CDbCriteria;
			$term = $nmRekening;
			$termKode = $kdRekening;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id =' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->ruangan_id)) {
				$criteria->addCondition('ruangan_id =' . $modelLaporan->ruangan_id);
			}
//			$criteria->group = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5,rekening5_nb,tglbukubesar';
//			$criteria->select = $criteria->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
			$criteria->select = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5,rekening5_nb,tglbukubesar,saldodebit,saldokredit,uraiantransaksi,tgl_transaksi,jenisjurnal_nama,nobuktijurnal';
			$condition = "nmrekening5 ILIKE '%" . $term . "%' OR nmrekening4 ILIKE '%" . $term . "%' OR nmrekening3 ILIKE '%" . $term . "%'";
			$conditionKode = "kdrekening5 ILIKE '%" . $termKode . "%' OR kdrekening4 ILIKE '%" . $termKode . "%' OR kdrekening3 ILIKE '%" . $termKode . "%'";
			$criteria->addCondition($condition);
			$criteria->addCondition($conditionKode);
			$criteria->limit = -1;
			$criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, tglbukubesar ASC';

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
					<td width='150px;'>" . MyFormatter::formatDateTimeId(date("Y-m-d",strtotime($details->tgl_transaksi))) . "</td>
					<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
					<td width='150px;'>" . $details->jenisjurnal_nama . "</td>".
					// <td width='40px;' style='text-align:center'>".$details->no_referensi . "</td>
					"<td width='150px;'>" . $details->nobuktijurnal . "</td>
					<td width='200px;'>" . $details->uraiantransaksi . "</td>					
					<td width='150px;' style='text-align:right'>" . number_format($details->saldodebit) . "</td>
					<td width='150px;' style='text-align:right'>" . number_format($details->saldokredit) . "</td>
					<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
				</tr>";
			}

			echo "<tfoot>
						<tr>
							<td colspan=6 style='text-align:right'><strong>Total : ".$nmRekening." </strong></td>
							<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totKredit) . "</td>
							<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
						</tr>
					</tfoot>";
			echo "</table><br/><br/>";
		}
	}
	?>
<?php
} else {
	$nmRekening_temp = "";
	echo "<table class='table table-striped table-condensed'>
				<thead>
					<tr>
						<th rowspan='2'>Tanggal Transaksi</th>
						<th rowspan='2'>Tanggal Posting</th>
						<th rowspan='2'>Jenis Jurnal</th>
						<th rowspan='2' style='text-align:center'>No. Ref</th>
						<th rowspan='2'>No. Bukti Jurnal</th>
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
		} else {
			if ($data->nmrekening4) {
				$nmRekening = $data->nmrekening4;
			} else {
				$nmRekening = $data->nmrekening3;
			}
		}
		
		if (!isset($nmRekening_temp[$nmRekening])) {
			$nmRekening_temp[$nmRekening] = 1;
		}else{
			$nmRekening_temp[$nmRekening]++;
		}
		
		if($nmRekening_temp[$nmRekening] == 1){
			if ($data->kdrekening5) {
				$kdRekening = $data->kdrekening5;
				$kdRekening_text = $data->kdrekening1 . '-' . $data->kdrekening2 . '-' . $data->kdrekening3 . '-' . $data->kdrekening4 . '-' . $data->kdrekening5;
			} else {
				if ($data->kdrekening4) {
					$kdRekening = $data->kdrekening4;
					$kdRekening_text = $data->kdrekening1 . '-' . $data->kdrekening2 . '-' . $data->kdrekening3 . '-' . $data->kdrekening4;
				} else {
					$kdRekening = $data->kdrekening3;
					$kdRekening_text = $data->kdrekening1 . '-' . $data->kdrekening2 . '-' . $data->kdrekening3;
				}
			}

			echo "
				<tr>
                      <td colspan=9><b>" . $data->kodeunitkerja . " - " . $data->koderekening . " " . $nmRekening . "</b></td>
                </tr>
					";

			$criteria = new CDbCriteria;
			$term = $nmRekening;
			$termKode = $kdRekening;
			if (!empty($modelLaporan->periodeposting_id)) {
				$criteria->addCondition('periodeposting_id =' . $modelLaporan->periodeposting_id);
			}
			if (!empty($modelLaporan->ruangan_id)) {
				$criteria->addCondition('ruangan_id =' . $modelLaporan->ruangan_id);
			}
//			$criteria->group = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5,rekening5_nb,tglbukubesar';
//			$criteria->select = $criteria->group.', sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit';
			$criteria->select = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id,nmrekening1, nmrekening2, nmrekening3, nmrekening4, nmrekening5, kdrekening1, kdrekening2,kdrekening3,kdrekening4,kdrekening5,rekening5_nb,tglbukubesar, saldodebit, saldokredit,uraiantransaksi,tgl_transaksi,jenisjurnal_nama,nobuktijurnal';
			
			$condition = "nmrekening5 ILIKE '%" . $term . "%' OR nmrekening4 ILIKE '%" . $term . "%' OR nmrekening3 ILIKE '%" . $term . "%'";
			$conditionKode = "kdrekening5 ILIKE '%" . $termKode . "%' OR kdrekening4 ILIKE '%" . $termKode . "%' OR kdrekening3 ILIKE '%" . $termKode . "%'";
			$criteria->addCondition($condition);
			$criteria->addCondition($conditionKode);
			$criteria->limit = -1;
			$criteria->order = 'rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, tglbukubesar ASC';

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
				
				if($details->saldodebit != 0){
					echo "<tr>
						<td width='150px;'>" . MyFormatter::formatDateTimeId(date("Y-m-d",strtotime($details->tgl_transaksi))) . "</td>
						<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
						<td width='150px;'>" . $details->jenisjurnal_nama . "</td>
						<td width='150px;'>" . $details->nobuktijurnal . "</td>
						<td width='200px;'>" . $details->uraiantransaksi . "</td>
						<td width='40px;' style='text-align:center'>".$details->no_referensi . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldodebit) . "</td>
						<td width='150px;' style='text-align:right'>0</td>
						<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
					</tr>";
				}
				if($details->saldokredit != 0){
					echo "<tr>
						<td width='150px;'>" . MyFormatter::formatDateTimeId(date("Y-m-d", strtotime($details->tgl_transaksi))) . "</td>
						<td width='150px;'>" . MyFormatter::formatDateTimeId($details->tglbukubesar) . "</td>
						<td width='150px;'>" . $details->jenisjurnal_nama . "</td>
						<td width='40px;' style='text-align:center'>".$details->no_referensi . "</td>
						<td width='150px;'>" . $details->nobuktijurnal . "</td>
						<td width='200px;'>" . $details->uraiantransaksi . "</td>						
						<td width='150px;' style='text-align:right'>0</td>
						<td width='150px;' style='text-align:right'>" . number_format($details->saldokredit) . "</td>
						<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
					</tr>";
				}
			}

			echo "
			<tr>
				<td colspan=6 style='text-align:right'><strong>Total " . $nmRekening . "</strong></td>
				<td width='150px;' style='text-align:right'>" . number_format($totDebit) . "</td>
				<td width='150px;' style='text-align:right'>" . number_format($totKredit) . "</td>
				<td width='150px;' style='text-align:right'>" . number_format($totSaldo) . "</td>
			</tr>
		";

		}
	}	
	echo "<tbody>
		  </table>";
}
?>