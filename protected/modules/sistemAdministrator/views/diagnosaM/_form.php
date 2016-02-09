

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadiagnosa-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'diagnosa_kode'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>
        <div class="row-fluid">
			<div class="span4">
				<?php echo $form->dropDownListRow($model,'klasifikasidiagnosa_id',SAKlasifikasidiagnosaM::model()->getDropdownItems(),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'-- Pilih --')); ?>
				<?php echo $form->textFieldRow($model,'diagnosa_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
				<?php echo $form->textFieldRow($model,'diagnosa_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
			<div class="span4">
				<?php echo $form->textFieldRow($model,'diagnosa_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textFieldRow($model,'diagnosa_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
			<div class="span4">
				<?php echo $form->textFieldRow($model,'diagnosa_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->checkBoxRow($model,'diagnosa_imunisasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->checkBoxRow($model,'diagnosa_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		<div class="row-fluid">
<!--				<div class="control-group">
					<?php // echo CHtml::label('DTD Diagnosa', 'dtd_id', array('class'=>'control-label')); ?>
					<div class="controls">-->

						 <?php 
//						  $arrDTD = array();
//							 foreach($modDTDDiagnosaM as $data){
//								$arrDTD[] = $data['dtd_id'];
//							} 
//							   $this->widget('application.extensions.emultiselect.EMultiSelect',
//											 array('sortable'=>true, 'searchable'=>true)
//										);
//								echo CHtml::dropDownList(
//								'dtd_id[]',
//								$arrDTD,
//								CHtml::listData(SADtdM::model()->findAll(array('order'=>'dtd_nama')), 'dtd_id', 'dtd_nama'),
//								array('multiple'=>'multiple','key'=>'dtd_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
//										);
						  ?>
<!--					</div>
				</div>-->
		</div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Diagnosa ICD X', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
                        
                <?php
                    $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                    $this->widget('UserTips',array('content'=>$content));
                ?>
	</div>

<?php $this->endWidget(); ?>
