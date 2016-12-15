<?php foreach ($simpanan as $item):
	$jenis = JenissimpananM::model()->findByPk($item->jenissimpanan_id);
	$s = InformasijasasimpananV::model()->findByAttributes(array('simpanan_id'=>$item->simpanan_id));
	$jasa = 0;
	if (!empty($s)) $jasa = $s->jasasimpanan;
	/*$dAwal = new DateTime($item->tglsimpanan);
	$dSekarang = new DateTime(date('Y-m-d'));
	$tahun = $dAwal->diff($dSekarang, false)->y;

	$jasa = $item->jumlahsimpanan * $tahun * ($item->persenjasa_thn/100);*/
?>

<tr>
	<td>
		<?php echo CHtml::hiddenField('simpanan[]', $item->simpanan_id); ?>
		<?php echo date("d/m/Y", strtotime($item->tglsimpanan)); ?>
	</td>
	<td><?php echo $jenis->jenissimpanan; ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jumlahsimpanan); ?></td>
	<td style="text-align: right"><?php echo $jasa; ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jumlahsimpanan + $jasa); ?></td>
</tr>

<?php endforeach; ?>
