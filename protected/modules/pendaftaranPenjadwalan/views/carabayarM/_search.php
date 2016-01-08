<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppcarabayar-m-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'carabayar_nama'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'carabayar_id',array('class'=>'span5')); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'carabayar_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'carabayar_nama',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'metode_pembayaran',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'carabayar_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'carabayar_loket',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'carabayar_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
            
	

	
            
	

	

	<?php //echo $form->textFieldRow($model,'carabayar_singkatan',array('class'=>'span3','maxlength'=>1)); ?>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
