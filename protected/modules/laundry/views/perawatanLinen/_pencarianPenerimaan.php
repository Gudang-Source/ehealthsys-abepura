<div class="search-form">
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'pencarian-form',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($modPenerimaanLinenDetail,'nopenerimaanlinen'),
        ));
?>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group ">
				<?php echo CHtml::label('Tanggal Penerimaan','Tanggal Awal', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$modPenerimaanLinenDetail->tgl_awal = (!empty($modPenerimaanLinenDetail->tgl_awal) ? date("d/m/Y H:i:s",strtotime($modPenerimaanLinenDetail->tgl_awal)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modPenerimaanLinenDetail,
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
							$modPenerimaanLinenDetail->tgl_akhir = (!empty($modPenerimaanLinenDetail->tgl_akhir) ? date("d/m/Y H:i:s",strtotime($modPenerimaanLinenDetail->tgl_akhir)) : null);
							$this->widget('MyDateTimePicker',array(
								'model'=>$modPenerimaanLinenDetail,
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
				<?php echo CHtml::label('No. Penerimaan','',array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->textField($modPenerimaanLinenDetail,'nopenerimaanlinen',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>false)); ?>
					</div> 
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($modPenerimaanLinenDetail,'Jenis Perawatan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($modPenerimaanLinenDetail,'jenisperawatanlinen',LookupM::getItems('jenisperawatan'),array('empty'=>'--Pilih--','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
					</div> 
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::label('Instalasi', 'instalasi_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanLinenDetail,'instalasi_id', $instalasiTujuans, 
							array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
									'ajax'=>array('type'=>'POST',
												'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modPenerimaanLinenDetail))),
												'update'=>"#".CHtml::activeId($modPenerimaanLinenDetail, 'ruangan_id'),
									)));?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($modPenerimaanLinenDetail,'ruangan_id',$ruanganTujuans,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>           
				</div>
			</div>			
		</div>
	</div>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					$this->createUrl($this->id.'/index'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'return refreshForm(this);'));  ?>
	</div>
<?php $this->endWidget(); ?>
</div>