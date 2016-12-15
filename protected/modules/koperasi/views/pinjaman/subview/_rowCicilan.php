<?php
$angsuran = new JmlangsuranT;
$jatuhTempo = clone $tglPinjam;
$jatuhTempo->modify('+1 week');
for ($i = 0; $i < $cicil; $i++) : 
	$tglPinjam->add($intervalCicil);
	$jatuhTempo->add($intervalCicil);
?>
<tr>
	<td><?php echo CHtml::activeTextField($angsuran, '['.$i.']angsuran_ke', array('readonly'=>true, 'value'=>($i+1), 'class'=>'form-control', 'style'=>'text-align: right')); ?></td>
	<td><?php echo CHtml::activeTextField($angsuran, '['.$i.']tglangsuran', array('readonly'=>true, 'class'=>'form-control','value'=>$tglPinjam->format('d/m/Y'))); ?></td>
	<td>
	<?php 
		$this->widget('bootstrap.widgets.TbDatePicker', array(
			'model'=>$angsuran, 'attribute'=>'['.$i.']tgljatuhtempoangs', 'htmlOptions'=>array('class'=>'form-control date-able', 'value'=>$jatuhTempo->format('d/m/Y')) , 'options'=>array('format'=>'dd/mm/yyyy'),
			//'htmlOptions'=>array('value'=>$jatuhTempo->format('d/m/Y')),
		)); 
	?>
	</td>
	<td><?php echo CHtml::activeTextField($angsuran, '['.$i.']jmlpokok_angsuran', array('readonly'=>true, 'value'=>number_format($jmlCicil, 0, ',', '.'), 'class'=>'form-control', 'style'=>'text-align: right',)); ?></td>
	<td><?php echo CHtml::activeTextField($angsuran, '['.$i.']jmljasa_angsuran', array('readonly'=>true, 'value'=>number_format($jasaCicil, 0, ',', '.'), 'class'=>'form-control', 'style'=>'text-align: right',)); ?></td>
	<td><?php echo CHtml::textField('['.$i.']total_angsuran', number_format(($jasaCicil + $jmlCicil), 0, ',', '.') ,array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align: right',)); ?></td>
</tr>
<?php endfor; ?>