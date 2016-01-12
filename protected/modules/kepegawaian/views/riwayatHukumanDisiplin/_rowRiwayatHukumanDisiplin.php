<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'infoRiwayatHukumanDisiplin-grid',
	'dataProvider'=>$model->searchInfo($pegawai),
//	'filter'=>$model, 
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No.',
			'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
			'type'=>'raw',
			'htmlOptions'=>array('style'=>'text-align:center;'),
		),
		array(
			'header'=>'Jenis Hukuman',
			'type'=>'raw',
			'value'=>'(isset($data->jnshukdisiplin->jnshukdisiplin_nama) ? $data->jnshukdisiplin->jnshukdisiplin_nama : "-")',
		),
		array(
			'header'=>'Jabatan',
			'type'=>'raw',
			'value'=>'(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
		),
		array(
			'header'=>'Tanggal Hukuman',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->hukdisiplin_tglhukuman)',
		),
		array(
			'header'=>'Ruangan Pegawai',
			'type'=>'raw',
			'value'=>'$data->hukdisiplin_ruangan',
		),
		array(
			'header'=>'No. SK',
			'type'=>'raw',
			'value'=>'$data->hukdisiplin_nosk',
		),
		array(
			'header'=>'Lama Hukuman',
			'type'=>'raw',
			'value'=>'(isset($data->hukdisiplin_lamabln) ? $data->hukdisiplin_lamabln." bulan". : "-")',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->hukdisiplin_keterangan',
		),
		array(
			'header'=>Yii::t('zii','Delete'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{delete}',
			'buttons'=>array(
							'delete'=> array(),
			)
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'infoRiwayatHukumanDisiplin-info-search',
	'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span6">	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'No SK', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'hukdisiplin_nosk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>	
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Hukuman', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->hukdisiplin_tglhukuman = $format->formatDateTimeForUser($model->hukdisiplin_tglhukuman); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'hukdisiplin_tglhukuman', 
							'mode'=>'date',
							'options'=>array(
								'dateFormat' => Params::DATE_FORMAT,
							),
							'htmlOptions' => array('readonly' => true,
								'class' => "span2",
								'onkeypress' => "return $(this).focusNextInputField(event)"),
						));  
					?>
				</div>
			</div>	
		</div>
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jenis Hukuman', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'jnshukdisiplin_id',CHtml::listData(JnshukdisiplinM::model()->findAllByAttributes(array('jnshukdisiplin_aktif'=>true),array('order'=>'jnshukdisiplin_nama')),'jnshukdisiplin_id','jnshukdisiplin_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jabatan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'hukdisiplin_jabatan',CHtml::listData(JabatanM::model()->findAllByAttributes(array('jabatan_aktif'=>true),array('order'=>'jabatan_nama')),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		<?php echo $form->hiddenField($model,'pegawai_id',array('value'=>$pegawai,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
		</div>
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
			<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('RencanaLemburT/Informasi'), array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
			<?php
				$content = $this->renderPartial('../tips/informasi_riwayatPekerjaan',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
			?>
		</div>

		<?php $this->endWidget(); ?>
	</div>
</fieldset>