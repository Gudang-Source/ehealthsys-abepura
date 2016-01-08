<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadiagnosa-icdixm-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'diagnosaicdix_id',array('class'=>'span5')); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'diagnosaicdix_kode',array('class'=>'span5','maxlength'=>10)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'diagnosaicdix_nama',array('class'=>'span5','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'diagnosaicdix_aktif',array('checked'=>'diagnosaicdix_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //cho $form->textFieldRow($model,'diagnosaicdix_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'diagnosatindakan_katakunci',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'diagnosaicdix_nourut',array('class'=>'span5')); ?>


<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
