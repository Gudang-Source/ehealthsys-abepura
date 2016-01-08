<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gupemakaianbarang-t-search',
        'type'=>'horizontal',
)); ?>

<div class="row-fluid">
	<div class="span6">
		<div class="control-group ">
			<?php echo $form->labelEx($model,'tglpemakaianbrg', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$model,
						'attribute'=>'tglAwal',
						'mode'=>'datetime',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
				)); ?>
			</div>
		</div>
		<div class="control-group ">
			<label class="control-label">
			   Sampai dengan
			</label>
			<div class="controls">
				<?php 
					$this->widget('MyDateTimePicker',array(
						'model'=>$model,
						'attribute'=>'tglAkhir',
						'mode'=>'datetime',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
					)); 
				?>
			</div>
		</div>
	</div>		
	<div class="span6">
		<?php echo $form->textFieldRow($model,'nopemakaianbrg',array('class'=>'span3', 'maxlength'=>20)); ?>
	</div>		
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php
		$content = $this->renderPartial('gudangUmum.views.tips.informasi',array(),true);
		$this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
