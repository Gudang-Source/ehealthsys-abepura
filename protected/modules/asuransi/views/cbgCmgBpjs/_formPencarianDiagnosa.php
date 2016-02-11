<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Kata Kunci','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('katakunci_diagnosa','',array('class'=>'span3','placeholder'=>'Ketikan kata kunci')); ?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariDataDiagnosa();return false;',
							  'class'=>'btn btn-mini btn-primary btn-katakunci',
							  'onkeypress'=>"cariDataDiagnosa(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data Diagnosa",)); ?>
			</div>
		</div>
	</div>
	<div class="span4"></div>
	<div class="span4"></div>
</div>