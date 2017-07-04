<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sashift-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->textFieldRow($model,'shift_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>

		<?php echo $form->textFieldRow($model,'shift_kode',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>1)); ?>

		<?php echo $form->textFieldRow($model,'shift_namalainnya',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);",'maxlength'=>50)); ?>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo CHtml::label('Dari Jam','',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'shift_jamawal',
					'mode' => 'time',
					'options' => array(
						'dateFormat' => Params::TIME_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)",'class' => 'required'),
						
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Sampai Dengan','',array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'shift_jamakhir',
					'mode' => 'time',
					'options' => array(
						'dateFormat' => Params::TIME_FORMAT,
						//'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)",'class' => 'required'),
					
				));
				?>
			</div>
		</div>
	</div>
	<div class="span4">
	<?php echo $form->textFieldRow($model,'shift_urutan',array('class'=>'span1 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

	<?php echo $form->checkBoxRow($model,'shift_aktif'); ?>
	</div>
	
</div>
<div class="row-fluid block-tabel">
        <h6>Tabel <b>Shift Berlaku</b></h6>
        <table id="table-lookup" class="table table-striped table-bordered table-condensed">
            <thead>
				<th>Kelompok Jabatan</th>
                <th>Jam Masuk Min</th>
                <th>Jam Masuk</th>
                <th>Jam Masuk Maks</th>
				<th>Jam Pulang Min</th>
                <th>Jam Pulang</th>
                <th>Jam Pulang Maks</th>              
                <th>Tanggal Berlaku</th>
				<th style="text-align:center;"><button type="button" class="btn btn-primary" onclick="tambahLookup();"><i class="icon-plus-sign icon-white"></i></button></th>
            </thead>
            <tbody>
				<?php 
						
						if (!empty($model->shift_id)){
							$cekBerlaku = SAShiftberlakuM::model()->findAll("shift_id = '".$model->shift_id."' ");
							if (!empty($cekBerlaku)){
								$i=0;
								foreach($cekBerlaku as $cekBerlaku){
									$cekBerlaku->shiftberlaku_tgl = date('d/m/Y', strtotime($cekBerlaku->shiftberlaku_tgl));
									echo $this->renderPartial($this->path_view.'_rowLookupUpdate',array('modBerlaku'=>$cekBerlaku,'i'=>$i));
									$i++;
								}
							}
						}
				?>
            </tbody>
        </table>
    </div>
<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        '',
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Shift',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php 
                    $content = $this->renderPartial($this->path_tips.'tipsaddedit2f',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                 
                ?>
		</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modBerlaku'=>$modBerlaku)); ?>
