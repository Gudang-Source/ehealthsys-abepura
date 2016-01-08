<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'gzbahanmakanan-m-search',
                'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'golbahanmakanan_id',
                   CHtml::listData($model->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'),
                   array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
            <?php echo $form->dropDownListRow($model,'sumberdanabhn',
                   CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'),
                   array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'jenisbahanmakanan',
                   CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'),
                   array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
            <?php echo $form->dropDownListRow($model,'kelbahanmakanan',
                   CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'),
                   array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'namabahanmakanan',array('size'=>60,'maxlength'=>100)); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>