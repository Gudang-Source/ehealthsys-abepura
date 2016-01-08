<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakecamatan-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kecamatan_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kecamatan_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kecamatan_aktif',array('checked'=>'kecamatan_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kecamatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kabupaten_id',array('class'=>'span3')); ?>

	

	

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
