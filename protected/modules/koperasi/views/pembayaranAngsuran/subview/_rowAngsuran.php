<?php 
foreach ($angsuran as $item) :
	$bayar = PembayaranangsuranT::model()->findByAttributes(array('jmlangsuran_id'=>$item->jmlangsuran_id), array('order'=>'pembayaranangsuran_id desc'));
	$denda = 0;
	$head = 'angsuran['.$item->jmlangsuran_id.']';
	$listSumber = CHtml::listData(PotongansumberM::model()->findAll('potongansumber_aktif = true'), 'potongansumber_id', 'namapotongan');
	if (empty($bayar)) $sisa = $item->jmlpokok_angsuran + $item->jmljasa_angsuran;
	else $sisa = $bayar->jmlsisa_pembangsuran;
	
	//foreach ($bayar as $b) {
	//	$denda += $b->jmldenda_byrangsuran;
	//}
	$disabled = $item->isudahbayar == true;
	
?>
<tr>
	<td><?php echo CHtml::checkBox($head.'[check]', $disabled, array('class'=>'cekAngsuran','uncheckValue'=>0, 'disabled'=>$disabled)); ?></td>
	<td>
		<?php echo date('d/m/Y', strtotime($item->tglangsuran))."<br>".date('d/m/Y', strtotime($item->tgljatuhtempoangs));?>
		<?php echo CHtml::hiddenField($head.'[jthTempo]', (time() > strtotime($item->tgljatuhtempoangs))); ?>
		<?php echo CHtml::hiddenField($head.'[sisa]', $sisa); ?>
		<?php echo CHtml::hiddenField($head.'[tglpembayaranangsuran]', date('d/m/Y')); ?>
	</td>
	<td width="20"><?php echo CHtml::textField($head.'[byrangsuranke]', $item->angsuran_ke, array('readonly'=>'true', 'class'=>'form-control')); ?></td>
	<td><?php echo CHtml::textField($head.'[jmlpokok_byrangsuran]', MyFormatter::formatNumberForPrint($item->jmlpokok_angsuran), array('readonly'=>true, 'class'=>'form-control num')); ?></td>
	<td><?php echo CHtml::textField($head.'[jmljasa_byrangsuran]', MyFormatter::formatNumberForPrint($item->jmljasa_angsuran), array('readonly'=>true, 'class'=>'form-control num')); ?></td>
	<td><?php echo CHtml::textField($head.'[jmldenda_byrangsuran]', MyFormatter::formatNumberForPrint((int)$item->jmldenda_angsuran), array('readonly'=>true, 'class'=>'form-control num')); ?></td>
	<td><?php echo CHtml::textField($head.'[jml_terbayar]',  MyFormatter::formatNumberForPrint(($item->jmlpokok_angsuran + $item->jmljasa_angsuran) - $sisa), array('readonly'=>true, 'class'=>'form-control num')); ?></td>
	<td><?php echo CHtml::textField($head.'[jml_bayar]', '0', array('readonly'=>$disabled, 'class'=>'form-control num jmlBayar')); ?></td>
	<?php /*<td width="120"><?php echo CHtml::dropDownList($head.'[potongansumber_id]', null, $listSumber, array('class'=>'form-control', 'disabled'=>$disabled)); ?></td> */ ?>
	<td><?php echo CHtml::textField($head.'[jmlsisa_pembangsuran]', 0,  array('class'=>'form-control num', 'readonly'=>true)); ?></td>
</tr>
<?php endforeach; ?>