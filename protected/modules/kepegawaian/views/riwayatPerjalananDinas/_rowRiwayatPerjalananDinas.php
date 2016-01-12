<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'infoRiwayatPerjalanDinas-grid',
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
			'header'=>'No. Urut',
			'type'=>'raw',
			'value'=>'$data->nourutperj',
		),
		array(
			'header'=>'Tujuan Dinas',
			'type'=>'raw',
			'value'=>'$data->tujuandinas',
		),
		array(
			'header'=>'Tugas Dinas',
			'type'=>'raw',
			'value'=>'$data->tugasdinas',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->descdinas',
		),
		array(
			'header'=>'Alamat Tujuan',
			'type'=>'raw',
			'value'=>'$data->alamattujuan',
		),
		array(
			'header'=>'Propinsi',
			'type'=>'raw',
			'value'=>'$data->propinsi_nama',
		),
		array(
			'header'=>'Kota',
			'type'=>'raw',
			'value'=>'$data->kotakabupaten_nama',
		),
		array(
			'header'=>'Tanggal Mulai',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmulaidinas)',
		),
		array(
			'header'=>'Tanggal Akhir',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->sampaidengan)',
		),
		array(
			'header'=>'Negara Tujuan',
			'type'=>'raw',
			'value'=>'$data->negaratujuan',
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
	'id'=>'infoRiwayatPerjalanDinas-info-search',
	'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span4">	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Tujuan Dinas', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'tujuandinas',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Tugas Dinas', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'tugasdinas',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Keterangan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'descdinas',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span4">	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Alamat Tujuan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'alamattujuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Propinsi', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'propinsi_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Kota', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'kotakabupaten_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Mulai Dinas', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->tglmulaidinas = $format->formatDateTimeForUser($model->tglmulaidinas); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglmulaidinas', 
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
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Akhir Dinas', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->sampaidengan = $format->formatDateTimeForUser($model->sampaidengan); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'sampaidengan', 
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
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Negara Tujuan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'negaratujuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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