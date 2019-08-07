<?php ?>
<tr class="rencanaaskepdet">
	<td><?php echo CHtml::activeHiddenField($modDetail, '[0]diagnosakep_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
		<?php
		if (!empty($modDetail->diagnosakep_id)) {
			?><div class="control-group"><?php
			echo CHtml::activeCheckBox($modDetail, '[0]isdiagnosa', array('uncheckValue' => 0, 'onclick' => 'cekListDiagnosa(this)', 'onkeyup' => "return $(this).focusNextInputField(event);",'class'=>'control-label'));
			?><div class="controls">
				<?php echo CHtml::activeTextField($modDetail, '[0]diagnosakep_nama', array('readonly' => true)); ?>	
				</div>
			</div>
			<?php
		}
		?>
		<div class="control-group">
			<?php echo CHtml::label('Subjektif', '[0]evaluasiaskepdet_subjektif', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_subjektif', array('required'=>true,'class' => 'span12')); ?>	
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Objektif', '[0]evaluasiaskepdet_objektif', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_objektif', array('required'=>true,'class' => 'span12')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Assessment', '[0]evaluasiaskepdet_assessment', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_assessment', array('required'=>true,'class' => 'span12')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Planning', '[0]evaluasiaskepdet_planning', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($modDetail, '[0]evaluasiaskepdet_planning', array('required'=>true,'class' => 'span12')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Hasil Evaluasi', '[0]evaluasiaskepdet_hasil', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($modDetail, '[0]evaluasiaskepdet_hasil', array('tercapai' => 'Tercapai',
					'tidak tercapai' => 'Tidak Tercapai',), array('required'=>true,'empty' => '--Pilih--')); ?>
			</div>
		</div>
    </td>
</tr>
