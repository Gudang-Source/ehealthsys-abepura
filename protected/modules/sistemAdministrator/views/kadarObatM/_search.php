<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'type'=>'horizontal',
        'id'=>'search',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'lookup_name',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->hiddenField($model,'lookup_kode');?>
        </td>
<!--    </tr>
    <tr>
        <td>
            <?php echo $form->hiddenField($model,'lookup_value');?>
        </td>
        <td>
            <?php echo $form->hiddenField($model,'lookup_urutan');?>
        </td>
    </tr>-->
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'lookup_aktif',array('checked'=>'lookup_aktif')); ?>
        </td>
    </tr>
</table>
	
        
        
        
	

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
