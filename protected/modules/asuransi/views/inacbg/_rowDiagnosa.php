<tr>
	<td>
		<?php echo CHtml::activeCheckBox($modPasienMorbiditas,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNol(this);')); ?>		
	</td>
	<td>		
		<?php echo CHtml::activeHiddenField($modPasienMorbiditas, '[ii]pasienmorbiditas_id',array('class'=>'span3')); ?>
		<?php echo CHtml::activeHiddenField($modPasienMorbiditas, '[ii]diagnosa_id',array('class'=>'span3')); ?>
		<span id="kodeDiagnosa" name="[ii][diagnosa_kode]"><?php echo isset($modPasienMorbiditas->diagnosa_kode) ? $modPasienMorbiditas->diagnosa_kode : ""; ?></span>			
	</td>
	<td>
		<span id="namaDiagnosa" name="[ii][diagnosa_nama]"><?php echo isset($modPasienMorbiditas->diagnosa_nama) ? $modPasienMorbiditas->diagnosa_nama : ""; ?></span>
	</td>	
	<td>
		<span id="keterangan" name="[ii][kelompokdiagnosa_nama]"><?php echo isset($modPasienMorbiditas->kelompokdiagnosa_nama) ? $modPasienMorbiditas->kelompokdiagnosa_nama : ""; ?></span>
	</td>	
	<td>
		<span id="level" name="[ii][level]"><?php echo isset($modPasienMorbiditas->level) ? $modPasienMorbiditas->level : ""; ?></span>
	</td>	
	<td></td>
</tr>