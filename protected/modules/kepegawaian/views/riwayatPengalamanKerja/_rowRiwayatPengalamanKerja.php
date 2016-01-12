<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'infoRiwayatPengalamanKerja-grid',
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
			'header'=>'Nama perusahaan',
			'type'=>'raw',
			'value'=>'$data->namaperusahaan',
		),
		array(
			'header'=>'Bidang usaha',
			'type'=>'raw',
			'value'=>'$data->bidangperusahaan',
		),
		array(
			'header'=>'Jabatan',
			'type'=>'raw',
			'value'=>'$data->jabatanterahkir',
		),
		array(
			'header'=>'Tanggal Masuk',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasuk)',
		),
		array(
			'header'=>'Tanggal Keluar',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglkeluar)',
		),
		array(
			'header'=>'Lama Kerja',
			'type'=>'raw',
			'value'=>'$data->lama_tahun." tahun ".$data->lama_bulan." bulan."',
		),
		array(
			'header'=>'Alasan Berhenti',
			'type'=>'raw',
			'value'=>'$data->alasanberhenti',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->keterangan',
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
	'id'=>'infoRiwayatPengalamanKerja-info-search',
		'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Nama Perusahaan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'namaperusahaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>			
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Bidang Usaha', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'bidangperusahaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span6">		
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jabatan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'jabatanterahkir',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>		
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Alasan Berhenti', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'alasanberhenti',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		<?php echo $form->hiddenField($model,'pegawai_id',array('value'=>$pegawai,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</div>
		</div>
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
			<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('RencanaLemburT/Informasi'), array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
			<?php
				$content = $this->renderPartial('../tips/informasi_riwayatPribadi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
			?>
		</div>

		<?php $this->endWidget(); ?>
	</div>
</fieldset>