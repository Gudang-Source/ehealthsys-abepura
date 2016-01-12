<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sagambartubuh-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'nama_gambar',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'nama_file_gbr',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textAreaRow($model,'path_gambar',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'gambar_resolusi_x',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'gambar_resolusi_y',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'gambar_create',array('class'=>'span3')); ?>
            <?php echo $form->textFieldRow($model,'gambar_update',array('class'=>'span3')); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'gambartubuh_aktif'); ?>
            </div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'gambartubuh_id',array('class'=>'span3')); ?>

            
            

	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
