<div class = "span6">
	<div class="control-group ">
		<?php echo CHtml::label('Waktu Pemakaian Obat', '', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::hiddenField('o','',array()); ?>
			<?php echo CHtml::hiddenField('x','',array()); ?>
			<?php echo CHtml::hiddenField('sd','',array()); ?>
			<?php echo CHtml::hiddenField('soh','',array()); ?>
			<?php echo CHtml::hiddenField('k','',array()); ?>
			<?php echo CHtml::hiddenField('lt','',array()); ?>
			<?php echo CHtml::hiddenField('buffer_stok','',array()); ?>
			<?php echo CHtml::activeHiddenField($modRencanaKebFarmasi, 'leadtime_lt', array('readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only')) ?>
			<?php echo CHtml::activeTextField($modRencanaKebFarmasi, 'jmlwaktupemakaian', array('readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only')) ?> bulan
			<?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i> Hitung RO',
					array('onclick'=>'hitungRO();return false;',
						  'class'=>'btn btn-primary',
						  'onkeyup'=>"hitungRO();",
						  'rel'=>"tooltip",
						  'title'=>"Klik untuk menghitung Recomended Order (RO)",)); ?>
		</div>
	</div>
</div>
