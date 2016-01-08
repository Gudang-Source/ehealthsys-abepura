<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'klonloginpemakai-k-form',
	'enableAjaxValidation'=>false,
                'type'=>'horizontal',
		        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    
    
					<fieldset class="box" id="form-pasien">
					<legend class="rim"><span class='judul'>Data Asli</span><span class='tombol' style='display:none;'></span></legend>					
					<table>
						<tr>
							<td><?php echo CHtml::activeLabel($model,'jenispemakai'); ?></td>
							<td><?php echo CHtml::textField('jenispemakai',empty($nama->nama_pasien) ? 'Pegawai':'Pasien',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readOnly'=>true)); ?></td>
						</tr>
						<tr>
							<td><?php echo CHtml::activeLabel($model,'nama_pegawai'); ?></td>
							<td>			<?php echo CHtml::textField('nama_pegawai',empty($nama->nama_pasien) ? $nama->nama_pegawai : $nama->nama_pasien ,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readOnly'=>true)); ?>	</td>
						</tr>
						<tr>
							<td><?php echo CHtml::activeLabel($model,'nama_pemakai'); ?></td>
							<td><?php echo CHtml::textField('nama_pemakai',$model->nama_pemakai ,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readOnly'=>true)); ?>	</td>
						</tr>						
					</table>	                    
					</fieldset>


					<fieldset class="box" id="form-pasien">
					<legend class="rim"><span class='judul'>Data Klon</span><span class='tombol' style='display:none;'></span></legend>					
	                    <?php echo $form->textFieldRow($models, 'jenispemakai', array('value'=>empty($nama->nama_pasien) ? 'Pegawai':'Pasien', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'pilihPemakai(this);','readOnly'=>true)); ?>
						<?php echo $form->textFieldRow($models,'nama_pegawai',array('value'=>  empty($nama->nama_pasien) ? $nama->nama_pegawai : $nama->nama_pasien , 'onblur'=>'nospaces(this);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20,'onkeyup'=>"return $(this).focusNextInputField(event)",'readOnly'=>true)); ?>
						<?php echo $form->textFieldRow($models,'nama_pemakai',array('value'=>$model->nama_pemakai."_clone", 'onblur'=>'nospaces(this);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php echo $form->passwordFieldRow($models,'new_password',array('onblur'=>'nospaces(this);','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>					
					</fieldset>



            
            <div class="form-actions">
                                    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                         Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                         array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton')); ?>
									<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
									array('class'=>'btn btn-danger', 'type'=>'button', 'name'=>'btn_batal','onclick'=>'close_dialog()')); ?>         
			</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
	function close_dialog()
    {
		window.top.location.href= '<?php echo Yii::app()->createUrl('sistemAdministrator/loginpemakaiK/admin'); ?>';
    }	
</script>
