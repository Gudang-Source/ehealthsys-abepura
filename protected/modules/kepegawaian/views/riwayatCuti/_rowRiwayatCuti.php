<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'infoRiwayatCuti-grid',
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
			'header'=>'Jenis Cuti',
			'type'=>'raw',
			'value'=>'(isset($data->jeniscuti->jeniscuti_nama) ? $data->jeniscuti->jeniscuti_nama : "-")',
		),
		array(
			'header'=>'Tanggal Cuti',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglmulaicuti)))." s/d ".MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglakhircuti)))',
		),
		array(
			'header'=>'Lama Cuti',
			'type'=>'raw',
			'value'=>'$data->lamacuti." hari."',
		),
		array(
			'header'=>'No. SK',
			'type'=>'raw',
			'value'=>'$data->noskcuti',
		),
		array(
			'header'=>'Tanggal Ditetapkan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglditetapkanskcuti)',
		),
		array(
			'header'=>'Keperluan',
			'type'=>'raw',
			'value'=>'$data->keperluancuti',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->keterangan',
		),
		array(
			'header'=>'Pejabat Mengetahui',
			'type'=>'raw',
			'value'=>'$data->pejabatmengetahui',
		),
		array(
			'header'=>'Pejabat Menyetujui',
			'type'=>'raw',
			'value'=>'$data->pejabatmenyetujui',
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
	'id'=>'infoRiwayatCuti-info-search',
	'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span6">	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jenis Cuti', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'jeniscuti_id',CHtml::listData(jeniscutiM::model()->findAllByAttributes(array('jeniscuti_aktif'=>true),array('order'=>'jeniscuti_nama')),'jeniscuti_id','jeniscuti_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'No SK', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'noskcuti',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span6">		
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Mulai Cuti', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->tglmulaicuti = $format->formatDateTimeForUser($model->tglmulaicuti); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglmulaicuti', 
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
				<?php echo $form->labelEx($model,'Tanggal Akhir Cuti', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->tglakhircuti = $format->formatDateTimeForUser($model->tglakhircuti); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglakhircuti', 
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