<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rencana-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'noperencnaan'),
)); ?> 
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<div class="row-fluid">
	<div class="span4">
			<div class="control-group ">
				<?php echo CHtml::label('Tanggal Retur','tglReturPembelian', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
							$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_awal',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
								),
								'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
							)); 
							$model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
						?>
					</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
							$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tgl_akhir',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
											),
							)); 
							$model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
						?>
					</div>
			</div>
			<?php echo $form->textFieldRow($model,'noretur',array('placeholder'=>'Ketik No. Retur','class'=>'numberOnly')); ?>
	</div>
	<div class="span4">
			<div class="control-group ">
				<?php echo CHtml::label('Tanggal Terima Faktur','tglterimafaktur', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$model->tglterimafaktur = $format->formatDateTimeForUser($model->tglterimafaktur);
							$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tglterimafaktur',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
								),
								'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
							)); 
							$model->tglterimafaktur = $format->formatDateTimeForDb($model->tglterimafaktur);
						?>
					</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Tanggal Faktur','tglfaktur', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
							$model->tglfaktur = $format->formatDateTimeForUser($model->tglfaktur);
							$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'tglfaktur',
											'mode'=>'date',
											'options'=> array(
												'dateFormat'=>Params::DATE_FORMAT,
											),
											'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
											),
							)); 
							$model->tglfaktur = $format->formatDateTimeForDb($model->tglfaktur);
						?>
					</div>
			</div>
			<?php echo $form->textFieldRow($model,'nofaktur',array('placeholder'=>'Ketik No. Faktur','class'=>'numberOnly')); ?>
    </div>
	<div class="span4">
			<div class="control-group ">
				<?php echo $form->labelEx($model,'instalasi_nama', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model,'instalasi_nama',CHtml::listData(GFInformasireturpembelianV::model()->getInstalasi('instalasi_id'), 'instalasi_nama', 'instalasi_nama'),
                        array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                        'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
					</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model,'ruangan_nama', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model,'ruangan_nama',CHtml::listData(GFInformasireturpembelianV::model()->getRuangan('ruangan_id'), 'ruangan_nama', 'ruangan_nama'),
						array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
						'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
					</div>
			</div>	
	</div>
</div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); echo "&nbsp;"; ?>
        <?php
           $content = $this->renderPartial('../tips/informasi_gudangfarmasi',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>