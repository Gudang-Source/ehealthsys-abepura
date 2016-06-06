<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'informasistokbarang-search',
	'type'=>'horizontal',
)); ?>
<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'barang_type',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'barang_kode',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'barang_nama',array('class'=>'span3')); ?>

	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'barang_merk',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'barang_noseri',array('class'=>'span3')); ?>
		<?php echo $form->textFieldRow($model,'barang_ukuran',array('class'=>'span3')); ?>

	</div>
	<div class="span4">
		<?php echo $form->textFieldRow($model,'barang_thnbeli',array('class'=>'span3')); ?>
		
		<?php
		echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3',
			'ajax' => array('type' => 'POST',
				'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
				'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
		?>	
		<?php echo $form->dropDownListRow($model,'ruangan_id',  CHtml::listData(GURuanganM::getRuanganStokBarangs($model->instalasi_id),'ruangan_id','ruangan_nama'),array('class'=>'span3')); ?>
		
	</div>
</div>
	
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl('index'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'return refreshForm(this);'));  ?>
		<?php  
				$content = $this->renderPartial('gudangUmum.views.informasiStokBarang.tips.informasi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
		?> 
	</div>

<?php $this->endWidget(); ?>
