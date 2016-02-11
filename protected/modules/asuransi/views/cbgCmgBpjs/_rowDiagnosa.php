<?php if(isset($modPasienMorbiditas)){ ?>
<tr>
	<td>
		<?php echo CHtml::activeHiddenField($modPasienMorbiditas, '[ii]pasienmorbiditas_id',array('class'=>'span3')); ?>
		<?php echo CHtml::activeHiddenField($modPasienMorbiditas, '[ii]diagnosa_id',array('class'=>'span3')); ?>
		<span id="kodeDiagnosa" name="[ii][diagnosa_kode]"><?php echo isset($diagnosa->diagnosa_kode) ? $modPasienMorbiditas->diagnosa_kode : ""; ?></span>			
	<td>
	<td>
		<span id="namaDiagnosa" name="[ii][diagnosa_nama]"><?php echo isset($diagnosa->diagnosa_nama) ? $modPasienMorbiditas->diagnosa_nama : ""; ?></span>
	<td>
</tr>
<?php }else{ ?>
<tr>
	<td>
		<span id="kodeDiagnosa" name="[ii][diagnosa_kode]"></span>
	</td>
	<td>
		<span id="namaDiagnosa" name="[ii][diagnosa_nama]"></span>
	</td>
</tr>
<?php } ?>