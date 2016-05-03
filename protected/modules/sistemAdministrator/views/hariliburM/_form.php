<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpharilibur-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onClick'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	//'focus'=>'#'.Chtml::activeId($model,'tglharilibur'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

		<div class = "span6">
			<div class='control-group'>
					<?php echo CHtml::label('Tanggal Hari Libur <span class="required">*</span>', 'tglharilibur', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php $model->tglharilibur = $format->formatDateTimeForUser($model->tglharilibur); ?>
						<?php 
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tglharilibur', 
								'mode'=>'date',
								'options'=>array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true,
									'class' => "span2 required",
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'onclick' => "return $(this).focusNextInputField(event)"),
							));  
						?>
					</div>
			</div>
			<?php echo $form->textFieldRow($model,'namaharilibur',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
			<?php echo $form->checkBoxRow($model,'harilibur_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Hari Libur',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php //$this->widget('UserTips',array('content'=>''));                                     
                    $content = $this->renderPartial($this->path_tips.'tipsaddedit4b',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
               
                ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
