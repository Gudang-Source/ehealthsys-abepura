<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'satipediet-m-search',
                 'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'tipediet_nama',array('class'=>'span3','size'=>25,'maxlength'=>25)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'tipediet_namalainnya',array('class'=>'span3','size'=>25,'maxlength'=>25)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'tipediet_aktif', array('checked'=>'tipediet_aktif')); ?>
        </td>
    </tr>
</table>
<?php /* echo $form->textField($model,'tipediet_id'); */ ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>