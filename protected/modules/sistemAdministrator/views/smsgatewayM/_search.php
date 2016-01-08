<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sasmsgateway-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'smsgateway_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'modul_id',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'tujuansms',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'jenissms',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'formatsms',array('class'=>'span3','maxlength'=>10)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jmlkaraktersms',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'katawalsms',array('class'=>'span3','maxlength'=>5)); ?>
            <?php echo $form->textFieldRow($model,'kataakhirsms',array('class'=>'span3','maxlength'=>5)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'ishurufkapital'); ?>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'modcontroller',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'modaction',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'templatesms',array('class'=>'span3','maxlength'=>250)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'statussms'); ?>
            </div>
        </td>
    </tr>
</table>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
