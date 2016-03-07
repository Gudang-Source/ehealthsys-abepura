<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sanilairujukan-m-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->dropDownListRow($model,'kelkumurhasillab_id', CHtml::listData(KelkumurhasillabM::model()->findAll(array('order'=>'kelkumurhasillab_urutan'),'kelkumurhasillab_aktif = true'),'kelkumurhasillab_id','kelkumurhasillabnama'),array('empty'=>'--Pilih--','class'=>'span3')); ?>

		<?php echo $form->dropDownListRow($model,'nilairujukan_jeniskelamin', LookupM::getItems('jeniskelamin'), array('empty'=>'--Pilih--','class'=>'span3','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'kelompokdet',array('class'=>'span3','maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'namapemeriksaandet',array('class'=>'span3','maxlength'=>200)); ?>

		<?php echo $form->textFieldRow($model,'nilairujukan_nama',array('class'=>'span3','maxlength'=>100)); ?>
	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'nilairujukan_min',array('class'=>'span3')); ?>

		<?php echo $form->textFieldRow($model,'nilairujukan_nama',array('class'=>'span3','maxlength'=>100)); ?>

		<?php echo $form->textFieldRow($model,'nilairujukan_min',array('class'=>'span3')); ?>

		<?php echo $form->textFieldRow($model,'nilairujukan_max',array('class'=>'span3')); ?>

	</div>
	<div class="span4">


		<?php //echo $form->textFieldRow($model,'nilairujukan_satuan',array('class'=>'span3','maxlength'=>50)); 
                      echo $form->dropDownListRow($model, 'nilairujukan_satuan',LookupM::getItems('satuanhasillab'), array('empty'=>'--Pilih--'))
                ?>

		<?php echo $form->textFieldRow($model,'nilairujukan_metode',array('class'=>'span3','maxlength'=>30)); ?>
            <div>
		<?php echo $form->checkBoxRow($model,'nilairujukan_aktif'); ?>
            </div>
        </div>
</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	</div>

<?php $this->endWidget(); ?>
