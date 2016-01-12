<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahverifikasi-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        )
    );
?>
<?php
if (isset($_GET['sukses'])) {
	Yii::app()->user->setFlash('success', "Data verifikasi berkas medical check up berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset class="box" id="form-databerkas">
	<legend class="rim"><span class='judul'>Data Berkas</span></legend>
	<div class="row-fluid">  
		<div class="span6">
			<div class="control-group ">	
				<?php echo $form->labelEx($model, 'nosurat_rs',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'nosurat_rs',array('class'=>'span3')); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'namarumahsakit',array('class'=>'control-label'))?>
				<div class="controls">
					<?php echo $form->textField($model,'namarumahsakit',array('class'=>'span4')); ?>
				</div>
			</div>
			<div class="span6">
				<div class="control-group ">				
					<?php echo CHtml::label('Tgl. Berkas Diterima <span class="required">*</span>', 'tglberkasmcumasuk', array('class' => 'control-label required')) ?>
					<div class="controls">					
						<?php   
							$model->tglberkasmcumasuk = (!empty($model->tglberkasmcumasuk) ? date('d/m/Y H:i:s',  strtotime($model->tglberkasmcumasuk)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tglberkasmcumasuk',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
									'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask span3','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
							)); 
						?>
					</div>
				</div>
			</div>		
		</div>
	</div>
</fieldset>
<div class="form-actions">
    <?php
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			array('class'=>'btn btn-danger', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
function closeDialog(){
	window.parent.$('#dialogVerifikasiBerkas').dialog('close');
}
</script>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>