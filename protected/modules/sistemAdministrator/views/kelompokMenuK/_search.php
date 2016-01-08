<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelompok-menu-k-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelmenu_nama',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelmenu_namalainnya',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
    </tr>
    <tr>
        <td colspan='2'>
            <?php echo $form->checkBoxRow($model,'kelmenu_aktif',array('checked'=>'kelmenu_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelmenu_id',array('class'=>'span5')); ?>

	

	

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
