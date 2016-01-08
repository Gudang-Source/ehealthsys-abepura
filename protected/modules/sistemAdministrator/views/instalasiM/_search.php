<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sainstalasi-m-search',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'instalasi_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'instalasi_singkatan',array('class'=>'span1','maxlength'=>3)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'instalasi_lokasi',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'instalasi_aktif',array('checked'=>'instalasi_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'instalasi_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'instalasi_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
