<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pskelsebababortus-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
           <?php echo $form->textFieldRow($model,'kelsebababortus_nama',array('class'=>'span3','maxlength'=>100)); ?> 
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelsebababortus_namalain',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kelsebababortus_aktif', array('checked'=>'$data->kelsebababortus_aktif')); ?>
        </td>
    </tr>
</table>
<?php //echo $form->textFieldRow($model,'kelsebababortus_id',array('class'=>'span5')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
