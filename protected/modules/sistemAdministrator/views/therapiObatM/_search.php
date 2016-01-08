<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gftherapi-obat-m-search',
        'type'=>'horizontal',
)); ?>

	
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'therapiobat_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'therapiobat_namalain',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'therapiobat_aktif', array('checked'=>'$data->therapiobat_aktif')); ?>
        </td>
    </tr>
</table>
	

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
