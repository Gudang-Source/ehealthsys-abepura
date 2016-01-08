<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'type'=>'horizontal',
                'id'=>'gzbahandiet-m-search',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'bahandiet_nama',array('size'=>60,'maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'bahandiet_namalain',array('size'=>60,'maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'bahandiet_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
