<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'satabular-list-m-search',
        'type'=>'horizontal',
)); ?>
<!--<table width="100%">
    <tr>
        <td>-->
            <?php echo $form->textFieldRow($model,'tabularlist_chapter',array('class'=>'span3','maxlength'=>50)); ?>
<!--        </td>
    </tr>
    <tr>
        <td>-->
            
<!--        </td>
    </tr>
</table>-->
	<?php //echo $form->textFieldRow($model,'tabularlist_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tabularlist_block',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textAreaRow($model,'tabularlist_title',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'tabularlist_revisi',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'tabularlist_versi',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->checkBoxRow($model,'tabularlist_aktif',array('checked'=>'tabularlist_aktif')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
