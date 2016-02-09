

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadtd-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onSubmit'=>'return requiredCheck(this);'),
        'focus'=>'#'.CHtml::activeId($model,'dtd_noterperinci'),
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <table width="100%">
            <tr>
                <td>
                     <?php echo $form->textFieldRow($model,'dtd_noterperinci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <div class="control-group">
                      <?php echo $form->labelEx($model,'tabularlist_id',array('class'=>'control-label required')); ?>
                         <div class="controls inline">
                      <?php echo $form->dropDownList($model,'tabularlist_id',  CHtml::listData($model->getTabularItems(), 'tabularlist_id', 'tabularlist_block'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3')); ?> 
                         </div> 
                     </div>
                     <?php echo $form->textFieldRow($model,'dtd_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     <?php echo $form->textFieldRow($model,'dtd_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'dtd_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'dtd_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'dtd_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->checkBoxRow($model,'dtd_menular', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->checkBoxRow($model,'dtd_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
            <?php /*
            <tr>
                <td colspan="2">
                     <?php //echo $form->labelEx($modDTDDiagnosaM,'diagnosa_id',array('class'=>'control-label'));  ?>
                        <div class="control-group">
                            <div class="controls">

                                 <?php 
                                  $arrDiagnosa = array();
                                     foreach($modDTDDiagnosaM as $data){
                                        $arrDiagnosa[] = $data['diagnosa_id'];
                                    } 
                                       $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                     array('sortable'=>true, 'searchable'=>true)
                                                );
                                        echo CHtml::dropDownList(
                                        'diagnosa_id[]',
                                        $arrDiagnosa,
                                        CHtml::listData(SADiagnosaM::model()->findAll(array('order'=>'diagnosa_nama')), 'diagnosa_id', 'diagnosa_nama'),
                                        array('multiple'=>'multiple','key'=>'diagnosa_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                                );
                                  ?>
                            </div>
                        </div>
                </td>
            </tr>
             * 
             */ ?>
        </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan DTD', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                    $this->createUrl('Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>                 
                          

                <?php 
                      $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                      $this->widget('UserTips',array('content'=>$content));  ?>
                    

	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('SADtdM_dtd_namalainnya').value = nama.value.toUpperCase();
    }
</script>