<?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'search',
            'type'=>'horizontal',
    )); 
?>

	<table width='100%'>
        <tr>
            <td>
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'namabank', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'namabank',array('placeholder'=>'Nama Bank','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'style'=>'width:150px;')); ?>
                     </div>
                </div> 
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'alamatbank', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->textArea($model,'alamatbank',array('placeholder'=>'Alamat Bank','rows'=>3, 'cols'=>30, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:150px;')); ?>
                     </div>
                </div>
               <div class="control-group ">
        <?php echo $form->labelEx($model,'propinsi_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'kabupaten_id'),
                                ),
                                'onchange'=>"",));?>
            <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                        array('class'=>'btn btn-primary','onclick'=>"{addPropinsi(); $('#dialog-addpropinsi').dialog('open');}",
                              'id'=>'btn-addpropinsi','onkeyup'=>"return $(this).focusNextInputField(event)",
                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('propinsi_id'))) */?>
            <?php echo $form->error($model, 'propinsi_id'); ?>
        </div>
    </div>
            </td>
            <td>
                <div class="control-group ">
        <?php echo $form->labelEx($model,'kabupaten_id', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
                        array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('SetDropdownKecamatan',array('encode'=>false,'model_nama'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'kecamatan_id'),
                                ),
                                'onchange'=>"",));?>
            <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                            array('class'=>'btn btn-primary','onclick'=>"{addKabupaten(); $('#dialog-addkabupaten').dialog('open');}",
                                                  'id'=>'btn-addkabupaten','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                  'rel'=>'tooltip','title'=>'Klik untuk menambah '.$model->getAttributeLabel('kabupaten_id'))) */?>
            <?php echo $form->error($model, 'kabupaten_id'); ?>
        </div>
    </div>
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'kodepos', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'kodepos',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'style'=>'width:150px;')); ?>
                     </div>
                </div>
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'negara', array('class'=>'control-label')) ?>
                     <div class="controls">
                          <?php echo $form->textField($model,'negara',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'style'=>'width:150px;')); ?>
                     </div>
                </div>
            </td>
            <td>
                <div class='control-group'>
                            <?php echo CHtml::label('Rekening Debit','rekeningDebit', array('class'=>'control-label')); ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'rekening_debit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:150px;')); ?>
                     </div>
                </div>
                <div class='control-group'>
                            <?php echo CHtml::label('Rekening Kredit','rekeningDebit', array('class'=>'control-label')); ?>
                     <div class="controls">
                         <?php echo $form->textField($model,'rekeningKredit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:150px;')); ?>
                     </div>
                </div>
                <div class='control-group'>
                            <?php echo $form->labelEx($model,'matauang_id', array('class'=>'control-label')) ?>
                     <div class="controls">
                         <?php echo $form->dropDownList($model,'matauang_id',CHtml::listData(MatauangM::model()->findAll(), 'matauang_id', 'matauang'),
                                                          array('style'=>'width:160px;','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                     </div>
                </div>
            </td>
        </tr>
    </table>

	<div class="form-actions">
                <?php 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit')); 
                ?>
	</div>

<?php $this->endWidget(); ?>
