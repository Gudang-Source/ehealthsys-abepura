<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($modSterilisasiDetail,'sterilisasi_no'),
        ));
?>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group ">
				<?php echo CHtml::label('Tanggal Penerimaan','Tanggal Awal', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modSterilisasiDetail->tgl_awal = (!empty($modSterilisasiDetail->tgl_awal) ? date("d/m/Y H:i:s",strtotime($modSterilisasiDetail->tgl_awal)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modSterilisasiDetail,
								'attribute'=>'tgl_awal',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
	//                                'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
					</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Sampai Dengan','Tanggal Akhir', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modSterilisasiDetail->tgl_akhir = (!empty($modSterilisasiDetail->tgl_akhir) ? date("d/m/Y H:i:s",strtotime($modSterilisasiDetail->tgl_akhir)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modSterilisasiDetail,
								'attribute'=>'tgl_akhir',
								'mode'=>'datetime',
								'options'=> array(
									'showOn' => false,
	//                                'maxDate' => 'd',
									'yearRange'=> "-150:+0",
								),
								'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
								),
						)); ?>
					</div>
			</div>
		</div>
		<div class="span4">			
			<div class="control-group ">
				<?php echo CHtml::label('No. Sterilisasi','',array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modSterilisasiDetail,'sterilisasi_no',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
					</div> 
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modSterilisasiDetail,'instalasi_id', $instalasiTujuans, 
							array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
									'ajax'=>array('type'=>'POST',
												'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modSterilisasiDetail))),
												'update'=>"#".CHtml::activeId($modSterilisasiDetail, 'ruangan_id'),
									)));?>
				</div>
			</div>			
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modSterilisasiDetail,'ruangan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
				</div>
			</div>			
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onkeypress'=>'searchPenerimaan();','onclick'=>'searchPenerimaan()')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
	</div>
<?php $this->endWidget(); ?>
</div>