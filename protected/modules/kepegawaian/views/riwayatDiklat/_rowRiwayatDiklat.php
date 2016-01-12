<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'infoRiwayatDiklat-grid',
	'dataProvider'=>$model->searchInfo($pegawai),
//	'filter'=>$model, 
	'mergeHeaders'=>array(
            0=>array(
                'start'=>6,
                'end'=>8,
                'name'=>'Keputusan diklat',
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
			'header'=>'Jenis Diklat',
			'type'=>'raw',
			'value'=>'(isset($data->jenisdiklat->jenisdiklat_nama) ? $data->jenisdiklat->jenisdiklat_nama : "-")',
		),
		array(
			'header'=>'Nama Diklat',
			'type'=>'raw',
			'value'=>'$data->pegawaidiklat_nama',
		),
		array(
			'header'=>'Tanggal Mulai Diklat',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->pegawaidiklat_tahun)))',
		),
		array(
			'header'=>'Lama Diklat',
			'type'=>'raw',
			'value'=>'$data->pegawaidiklat_lamanya',
		),
		array(
			'header'=>'Tempat',
			'type'=>'raw',
			'value'=>'$data->pegawaidiklat_tempat',
		),
		array(
			'header'=>'No.',
			'type'=>'raw',
			'value'=>'$data->nomorkeputusandiklat',
		),
		array(
			'header'=>'Tanggal Penetapan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglditetapkandiklat)))',
		),
		array(
			'header'=>'Nama Pimpinan',
			'type'=>'raw',
			'value'=>'$data->pejabatygmemdiklat',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->pegawaidiklat_keterangan',
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
	'id'=>'infoRiwayatDiklat-info-search',
		'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span6">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Jenis Diklat', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'jenisdiklat_id',CHtml::listData(JenisdiklatM::model()->findAllByAttributes(array('jenisdiklat_aktif'=>true),array('order'=>'jenisdiklat_nama')),'jenisdiklat_id','jenisdiklat_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>			
			<div class="control-group ">
				<?php echo $form->labelEx($model,'Nama Diklat', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'pegawaidiklat_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span6">		
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Mulai Diklat', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->pegawaidiklat_tahun = $format->formatDateTimeForUser($model->pegawaidiklat_tahun); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'pegawaidiklat_tahun', 
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
				<?php echo $form->labelEx($model,'Tempat', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'pegawaidiklat_tempat',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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