<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfpabrik-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'pabrik_kode',array('class'=>'span3','maxlength'=>20, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'pabrik_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'pabrik_namalain',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'pabrik_alamat',array('rows'=>4, 'cols'=>20, 'class'=>'span5')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'pabrik_propinsi',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'pabrik_kabupaten',array('class'=>'span3','maxlength'=>100)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'pabrik_aktif'); ?>
            </div>
        </td>
    </tr>
</table>

<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
