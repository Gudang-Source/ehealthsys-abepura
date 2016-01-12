<div class="row-fluid">
	<div class="span12">
		<div class="control-group ">
			<?php echo CHtml::label('Kata Kunci','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::textField('katakunci_cmg','',array('class'=>'span3','placeholder'=>'Ketikan kata kunci')); ?>
				<?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
						array('onclick'=>'cariDataCMG();return false;',
							  'class'=>'btn btn-mini btn-primary btn-katakunci',
							  'onkeypress'=>"cariDataCMG(this);return false;",
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk mencari data CMG",)); ?>
			</div>
		</div>
	</div>
	<div class="span4"></div>
	<div class="span4"></div>
</div>