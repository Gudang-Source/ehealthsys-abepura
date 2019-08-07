<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal',
	'htmlOptions'=>array('class'=>'form-groups-bordered'),
)); ?>

		<?php //echo $form->textFieldRow($model,'potongansumber_id',array('class'=>'form-control', 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('potongansumber_id'),)); ?>

		<?php echo $form->textFieldRow($model,'namapotongan',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('namapotongan'),)); ?>

		<?php echo $form->textFieldRow($model,'namapotonganlainnya',array('class'=>'form-control','maxlength'=>100, 'placeholder'=>'Cari Berdasarkan '.$model->getAttributeLabel('namapotonganlainnya'),)); ?>

		<?php //echo $form->checkBoxRow($model,'potongansumber_aktif',array('class'=>'form-control')); ?>
		  <div class="form-group">
            <?php echo $form->labelEx($model, 'potongansumber_aktif',array('class'=>'control-label col-sm-3')); ?>
            <div class="col-sm-1">
                <?php echo $form->checkBox($model,'potongansumber_aktif',array('class'=>'form-control','checked'=>true)); ?>
            </div>
        </div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-5">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php /* $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Cari',
			'htmlOptions'=>array('class'=>'btn-primary'),
		)); 
		 * ?>
		 */ ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
