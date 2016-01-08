<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'salinen-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'linen_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'jenislinen_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'rakpenyimpanan_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'bahanlinen_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'barang_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'kodelinen',array('class'=>'span3','maxlength'=>50)); ?>

            <?php echo $form->textFieldRow($model,'tglregisterlinen',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'noregisterlinen',array('class'=>'span3','maxlength'=>50)); ?>

            <?php echo $form->textFieldRow($model,'namalinen',array('class'=>'span3','maxlength'=>200)); ?>

            <?php echo $form->textFieldRow($model,'namalainnya',array('class'=>'span3','maxlength'=>200)); ?>

            <?php echo $form->textFieldRow($model,'merklinen',array('class'=>'span3','maxlength'=>50)); ?>

            <?php echo $form->textFieldRow($model,'beratlinen',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'warna',array('class'=>'span3','maxlength'=>20)); ?>

            <?php echo $form->textFieldRow($model,'tahunbeli',array('class'=>'span3','maxlength'=>6)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jmlcucilinen',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

            <?php echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

            <?php echo $form->checkBoxRow($model,'linen_aktif'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->textAreaRow($model,'gambarlinen',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
