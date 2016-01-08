<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'nilai-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'nilai_angkamin',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nilai_angkamaks',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nilai_sebutan',array('class'=>'span3','maxlength'=>15)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'nilai_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'nilai_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
