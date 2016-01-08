<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($modSEP,'nosep',array('class'=>'control-label required')); ?>
			<div class="controls">
				<?php echo CHtml::activeHiddenField($modSEP, 'sep_id',array('class'=>'span3')); ?>
				<?php echo CHtml::activeTextField($modSEP, 'nosep',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'tglsep',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'tglsep',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'nokartuasuransi',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'nokartuasuransi',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'nama_peserta',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'nama_peserta',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'Jenis Kelamin',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'jeniskelamin',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($modSEP,'tglrujukan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'tglrujukan',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'norujukan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'norujukan',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'politujuan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'politujuan',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'jnspelayanan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'jnspelayanan',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'klsrawat',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'klsrawat',array('class'=>'span3')); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($modSEP,'diagnosaawal',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'diagnosaawal',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'tglpulang',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextField($modSEP, 'tglpulang',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($modSEP,'catatansep',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::activeTextArea($modSEP, 'catatansep',array('class'=>'span3')); ?>
			</div>
		</div>
		<div class='control-group'>
			<?php echo CHtml::label('Surat Rujukan','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->checkBox($modSEP,'surat_rujukan', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div> 
	</div>
</div>