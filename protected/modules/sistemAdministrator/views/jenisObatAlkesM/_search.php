<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfjenis-obat-alkes-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'jenisobatalkes_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jenisobatalkes_namalain',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'jenisobatalkes_aktif', array('checked'=>'$data->jenisobatalkes_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'jenisobatalkes_id',array('class'=>'span3')); ?>

<div class="form-actions">
  <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
