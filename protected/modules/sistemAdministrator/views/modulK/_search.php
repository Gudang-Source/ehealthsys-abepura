<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sakelompok-menu-k-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelompokmodul_nama',array('class'=>'span3','maxlength'=>30)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'modul_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'modul_aktif',array('checked'=>'modul_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'modul_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'modul_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textAreaRow($model,'modul_fungsi',array('rows'=>6, 'cols'=>30, 'class'=>'span4')); ?>

	<?php //echo $form->textFieldRow($model,'tglrevisimodul',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'tglupdatemodul',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'url_modul',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'icon_modul',array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'modul_key',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'modul_urutan',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
