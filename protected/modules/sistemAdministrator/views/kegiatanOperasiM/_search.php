<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'bskegiatan-operasi-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kegiatanoperasi_kode',array('class'=>'span2','maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kegiatanoperasi_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kegiatanoperasi_namalainnya',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'kegiatanoperasi_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kegiatanoperasi_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
