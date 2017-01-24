<?php foreach ($detail as $kode=>$item): ?>
<tr>
	<td colspan="2" style="font-weight: bold;">&emsp;<?php echo strtoupper($item['nama']); ?></td>
</tr>

<?php foreach ($item['rek5'] as $kode5=>$item5): ?>
<tr>
	<td>&emsp;&emsp;<?php echo $item5['nama']; ?></td>
	<td style="text-align: right; padding-right: 80px;"><?php echo MyFormatter::formatNumberForPrint($item5['total']); ?></td>
</tr>
<?php endforeach; ?>
<tr>
	<td>&emsp;&emsp;TOTAL <?php echo $item['nama']; ?></td>
	<td style="text-align: right; font-weight: bold;"><?php echo MyFormatter::formatNumberForPrint($item['total']); ?></td>
</tr>
<?php endforeach; ?>

