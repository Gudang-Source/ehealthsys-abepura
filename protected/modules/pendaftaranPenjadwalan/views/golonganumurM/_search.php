<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppgolonganumur-m-search',
        'focus'=>'#'.CHtml::activeId($model,'golonganumur_nama'),
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'golonganumur_id',array('class'=>'span5')); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'golonganumur_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'golonganumur_nama',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'golonganumur_minimal',array('class'=>'span3')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'golonganumur_namalainnya',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'golonganumur_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'golonganumur_maksimal',array('class'=>'span3')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'golonganumur_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
            
            
            

            

            

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
