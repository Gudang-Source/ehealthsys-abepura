<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajenis-carabayar-m-search',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'carabayar_nama',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'metode_pembayaran',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'carabayar_aktif',array('checked'=>'carabayar_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'carabayar_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
