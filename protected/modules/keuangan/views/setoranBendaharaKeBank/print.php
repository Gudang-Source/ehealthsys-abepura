<style>
	.jdl {
		text-align: center;
		font-weight: bold;
		margin: 10px;
	}
	
	.tab_detail th, .tab_detail td {
		border: 1px solid black;
	}
	
	.tab_detail {
		margin-bottom: 20px;
	}
	
	.tab_detail thead, .tab_detail tfoot {
		font-weight: bold;
	}
	
	.tab_head {
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>

<?php
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'sub/_headerPrint'); 
}

?>
<table class="tab_head" width="100%">
	<tr>
		<td nowrap>Diterima Uang Sebesar</td>
		<td>: </td>
		<td width="100%"><strong><?php echo MyFormatter::formatNumberForPrint($total); ?></strong></td>
		<td>No.</td>
		<td>: </td>
		<td><?php echo $model->nosetoranbdhara; ?></td>
	</tr>
	<tr>
		<td>Terbilang</td>
		<td>: </td>
		<td><strong><em><?php echo strtoupper(MyFormatter::formatNumberTerbilang($total)); ?> RUPIAH</em></strong></td>
		<td>Bank</td>
		<td>: </td>
		<td nowrap><?php echo $setorbank->namabank; ?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td nowrap>No. Rekening</td>
		<td>: </td>
		<td><?php echo $setorbank->norekening; ?></td>
	</tr>
</table>

<table class="tab_detail" width="100%">
	<thead>
		<tr>
			<th>Kode Rekening</th>
			<th>Uraian Rincian</th>
			<th>Jumlah</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($det as $setorankasir_id=>$val): ?>
		<tr>
			<td colspan="3"><strong><?php echo $val['no']; ?></strong></td>
		</tr>
		
			<?php foreach ($val['det'] as $item): ?>
		<tr>
			<td><?php echo $item['rek']; ?></td>
			<td><?php echo $item['kel']; ?></td>
			<td style="text-align: right; "><?php echo MyFormatter::formatNumberForPrint($item['nilai']); ?></td>
		</tr>
			<?php endforeach; ?>
		
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">Total</td>
			<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
		</tr>
	</tfoot>
</table>

<table width='100%'>
	<tr>
		<td>&nbsp;</td>
		<td width="100%">&nbsp;</td>
		<td align='center' nowrap><?php echo Yii::app()->user->getState('kecamatan_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
	</tr>
	<tr>
		<td align='center' nowrap>Mengetahui</td>
		<td align='center' style="text-align: center;"></td>
		<td align='center' style="text-align: center;" nowrap>Bendahara</td>
	</tr>
	<tr>
		<td align='center' style="text-align: center;" nowrap>
			<br/><br/><br/><br/><br/>
			<?php
				echo "<u>".$model->mengetahui_nama."</u><br/>".$nip[1];

			?>
		</td>
		<td align='center' style="text-align: center;"></td>
		<td align='center' style="text-align: center;" nowrap>
			<br/><br/><br/><br/><br/>
			<?php 
				echo "<u>".$model->pegawai_nama."</u><br/>".$nip[0];
			?>
		</td>
	</tr>
</table>