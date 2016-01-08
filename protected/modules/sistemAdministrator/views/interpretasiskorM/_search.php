<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'psinterpretasiskor-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'intepretasi_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'interpretasijmlskor',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'interpretasiskor_aktif', array('checked'=>'$data->interpretasiskor_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'interpretasiskor_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'interpretasimin',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'interpretasimax',array('class'=>'span5')); ?>

	<?php //echo $form->textAreaRow($model,'catatan',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>


	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
