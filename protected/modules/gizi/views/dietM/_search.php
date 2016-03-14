<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
    'id'=>'gzdiet-m-search',
                'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'tipediet_id',
                CHtml::listData($model->TipeDietItems, 'tipediet_id', 'tipediet_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'jenisdiet_id',
                CHtml::listData($model->JenisdietItems, 'jenisdiet_id', 'jenisdiet_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                'empty'=>'-- Pilih --',)); ?>
        </td>
        <td>
            <?php
                echo $form->dropDownListRow($model,'zatgizi_id',
                CHtml::listData($model->ZatgiziItems, 'zatgizi_id', 'zatgizi_nama'),
                array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                'empty'=>'-- Pilih --',));                
            ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'diet_kandungan', array('class'=>'numbersOnly')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>