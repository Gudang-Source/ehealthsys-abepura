<?php
foreach ($angsuran as $item):
	$pinjaman = PinjamanT::model()->findByPk($item->pinjaman_id);

?>
<tr>
	<td>
		<?php echo CHtml::hiddenField('angsuran[]', $item->jmlangsuran_id); ?>
		<?php echo date("d/m/Y", strtotime($pinjaman->tglpinjaman)); ?>
	</td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jmlpokok_angsuran); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jmljasa_angsuran); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->jmlpokok_angsuran + $item->jmljasa_angsuran); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint(($item->jmlpokok_angsuran + $item->jmljasa_angsuran) - $item->sisa); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item->sisa); ?></td>
</tr>
<?php endforeach; ?>
