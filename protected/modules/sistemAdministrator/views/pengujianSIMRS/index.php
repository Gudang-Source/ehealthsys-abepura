<div class="white-container">
    <legend class="rim2">Pengujian <b>SIMRS</b></legend>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pengujiansimrs-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#dataForm_method',
    )); ?>

    <div class="row-fluid">
		<div class = "span6">
			<div class="control-group ">
				<?php echo CHtml::label('Method','dataForm_method', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('dataForm[method]', $dataForm['method'], array('ajaxpost'=>'Post (Ajax)','ajaxget'=>'Get (Ajax)'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",))?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Interval Refresh','dataForm_refreshinterval', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('dataForm[refreshinterval]', $dataForm['refreshinterval'], array('size'=>4,'maxlength'=>4,'class'=>'span1 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);",))?>
					<label>detik (1 ~ 9999)</label>
				</div>
			</div>
			

		</div>
		<div class = "span6">
			<div class="control-group ">
				<?php echo CHtml::label('Pattern','dataForm_pattern', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('dataForm[pattern]', $dataForm['pattern'], array('cactiverecord'=>'CActiveRecord','dao'=>'Data Access Object (DAO)'),array('class'=>'span3', 'onchange'=>'setTableModel();','onkeypress'=>"return $(this).focusNextInputField(event);",))?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Table','dataForm_table_uji', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('dataForm[table_uji]', $dataForm['table_uji'], array('infokunjunganrj_v'=>'infokunjunganrj_v','tariftindakanperdaruangan_v'=>'tariftindakanperdaruangan_v','informasistokobatalkes_v'=>'informasistokobatalkes_v'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",))?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Model','dataForm_model_uji', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('dataForm[model_uji]', $dataForm['model_uji'], array('InfokunjunganrjV'=>'InfokunjunganrjV','TariftindakanperdaruanganV'=>'TariftindakanperdaruanganV','InformasistokobatalkesV'=>'InformasistokobatalkesV'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",))?>
				</div>
			</div>
		</div>
    </div>
    <div class="row-fluid">
		<div style="text-align: center;">
			<label>
				Tips: Tekan tombol Ctrl + Shift + Q untuk menampilkan tab monitoring Firefox.
			</label>
		</div>
		<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Mulai',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_mulai','class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'mulaiPengujian();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Berhenti',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('id'=>'btn_berhenti','class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'hentikanPengujian();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                
                <?php //$this->widget('UserTips',array('type'=>'create'));?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial('_jsFunctions',array('dataForm'=>$dataForm)); ?>