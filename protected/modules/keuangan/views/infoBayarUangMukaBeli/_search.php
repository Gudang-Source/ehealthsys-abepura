<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pembayaran-t-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modBayar,'nobuktibayar'),
)); ?>

<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Tgl. Pembayaran Uang Muka','tgluangmuka', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$modBayar->tgl_awal = isset($modBayar->tgl_awal) ? MyFormatter::formatDateTimeForUser($modBayar->tgl_awal) : date('d M Y');
					$this->widget('MyDateTimePicker',array(
						'model'=>$modBayar,
						'attribute'=>'tgl_awal',
						'mode'=>'date',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
						),
					)); 
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
					$modBayar->tgl_akhir = isset($modBayar->tgl_akhir) ? MyFormatter::formatDateTimeForUser($modBayar->tgl_akhir) : date('d M Y');
					$this->widget('MyDateTimePicker',array(
									'model'=>$modBayar,
									'attribute'=>'tgl_akhir',
									'mode'=>'date',
									'options'=> array(
										'dateFormat'=>Params::DATE_FORMAT,
										'minDate' => 'd',
									),
									'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
									),
					)); 
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
            <?php echo CHtml::label('No. Pembayaran','nobuktibayar', array('class'=>'control-label')) ?>
            <div class="controls">
				<?php // echo $form->textField($modBayar,'nobuktibayar',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>     
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
                <?php // echo CHtml::label('Nama Pasien','nama_pasien', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                          // echo $form->textField($modBayar,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
	</div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
            $this->createUrl($this->id.'/index'), 
            array('class'=>'btn btn-danger',
                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	<?php  
		$content = $this->renderPartial('../tips/informasi',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>
<?php $this->endWidget(); ?>
