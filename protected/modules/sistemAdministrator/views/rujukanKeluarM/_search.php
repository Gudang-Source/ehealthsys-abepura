<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'lkrujukankeluar-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'rumahsakitrujukan',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'alamatrsrujukan',array('rows'=>6, 'cols'=>20, 'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'telp_fax',array('class'=>'span3','maxlength'=>50)); ?>
            <?php echo $form->checkBoxRow($model,'rujukankeluar_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'rujukankeluar_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
