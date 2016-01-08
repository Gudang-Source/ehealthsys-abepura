<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'fakasuspenyakitobat-m-search',
                 'type'=>'horizontal',
)); ?>
                <?php // echo $form->DropDownListRow($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --',)); ?>
		<?php echo $form->DropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJeniskasuspenyakitItems(),'jeniskasuspenyakit_id','jeniskasuspenyakit_nama'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);"	)); ?>
                <?php //echo $form->DropDownListRow($model, 'obatalkes_id', CHtml::listData($model->getObatalkesItems(),'obatalkes_id','obatalkes_nama'),array('empty'=>'-- Pilih --')); ?>

	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
