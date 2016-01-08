<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'infoRiwayatPendidikan-grid',
	'dataProvider'=>$model->searchInfo($pegawai),
//	'filter'=>$model, 
	'mergeHeaders'=>array(
            0=>array(
                'start'=>6,
                'end'=>8,
                'name'=>'Kolom Ijazah',
            )
        ),
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
			'header'=>'Pendidikan',
			'type'=>'raw',
			'value'=>'(isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : "-")',
		),
		array(
			'header'=>'Nama Sekolah / Universitas',
			'type'=>'raw',
			'value'=>'$data->namasek_univ',
		),
		array(
			'header'=>'Alamat Sekolah / Universitas',
			'type'=>'raw',
			'value'=>'$data->almtsek_univ',
		),
		array(
			'header'=>'Tanggal Masuk',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasuk)',
		),
		array(
			'header'=>'Lama Pendidikan (bulan)',
			'type'=>'raw',
			'value'=>'$data->lamapendidikan_bln." bulan."',
		),
		array(
			'header'=>'No',
			'type'=>'raw',
			'value'=>'$data->no_ijazah_sert',
		),
		array(
			'header'=>'Tanggal',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_ijazah_sert)',
		),
		array(
			'header'=>'Tanda Tangan',
			'type'=>'raw',
			'value'=>'$data->ttd_ijazah_sert',
		),
		array(
			'header'=>'Nilai Lulus / Grade Lulus',
			'type'=>'raw',
			'value'=>'$data->nilailulus." / ".$data->gradelulus',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->keteranganpend',
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
	'id'=>'infoRiwayatPendidikan-info-search',
		'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Pendidikan', array('class'=>'control-label','style'=>'width:150px;')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'pendidikan_nama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>			
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Nama Sekolah / Universitas', array('class'=>'control-label','style'=>'width:150px;')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'namasek_univ',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span6">		
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Nilai Lulus', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'nilailulus',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>		
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Grade Lulus', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'gradelulus',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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