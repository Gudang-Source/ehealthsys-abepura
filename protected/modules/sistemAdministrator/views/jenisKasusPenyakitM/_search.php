<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'sajeniskasus-penyakit-m-search'
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jeniskasuspenyakit_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'jeniskasuspenyakit_aktif',array('checked'=>'jeniskasuspenyakit_aktif')); ?>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'jeniskasuspenyakit_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
