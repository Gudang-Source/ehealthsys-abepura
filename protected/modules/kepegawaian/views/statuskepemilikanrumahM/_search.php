
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'search-t-statuskepemilikanrumah',
                'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'statuskepemilikanrumah_nama',array('size'=>10,'maxlength'=>10)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'statuskepemilikanrumah_namalain',array('size'=>10,'maxlength'=>10)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'statuskepemilikanrumah_aktif',array('checked'=>true)); ?>
        </td>
    </tr>
</table>
		
		
		

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>