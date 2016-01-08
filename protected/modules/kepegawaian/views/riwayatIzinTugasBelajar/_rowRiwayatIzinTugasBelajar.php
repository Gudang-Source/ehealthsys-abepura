<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'infoRiwayatIzinTugasBelajar-grid',
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
			'header'=>'Tanggal Mulai Belajar',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmulaibelajar)',
		),
		array(
			'header'=>'Nomor Keputusan',
			'type'=>'raw',
			'value'=>'$data->nomorkeputusan',
		),
		array(
			'header'=>'Tanggal Ditetapkan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglditetapkan)',
		),
		array(
			'header'=>'Keterangan',
			'type'=>'raw',
			'value'=>'$data->keteranganizin',
		),
		array(
			'header'=>'Pejabat yang memutuskan',
			'type'=>'raw',
			'value'=>'$data->pejabatmemutuskan',
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
	'id'=>'infoRiwayatIzinTugasBelajar-info-search',
	'type'=>'horizontal',
)); ?>
<fieldset class="box">
<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
	<div class="search-form" style="display:true">
		<div class="row-fluid">
		<div class="span4">	
			<div class="control-group ">
				<?php echo $form->labelEx($model,'No Keputusan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'nomorkeputusan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
		</div>
		<div class="span4">		
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Mulai Belajar', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->tglmulaibelajar = $format->formatDateTimeForUser($model->tglmulaibelajar); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglmulaibelajar', 
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
		<div class="span4">
			<div class='control-group'>
				<?php echo $form->labelEx($model,'Tanggal Ditetapkan', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php $model->tglditetapkan = $format->formatDateTimeForUser($model->tglditetapkan); ?>
					<?php 
						$this->widget('MyDateTimePicker', array(
							'model' => $model,
							'attribute' => 'tglditetapkan', 
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