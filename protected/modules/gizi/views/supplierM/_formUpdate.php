<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gzsupplier-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#GZSupplierM_supplier_kode',
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table class="table-condensed">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'supplier_kode',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
            <?php echo $form->textFieldRow($model,'supplier_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'supplier_namalain',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textAreaRow($model,'supplier_alamat',array('rows'=>4, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'supplier_kodepos',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
              <div class="control-group ">
				<?php echo $form->labelEx($model,'supplier_propinsi', array('class'=>'control-label refreshable')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'supplier_propinsi', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",
															'ajax' => array('type'=>'POST',
																'url'=> $this->createUrl('SetDropdownKabupaten',array('encode'=>false,'namaModel'=>get_class($model))), 
		//                                                        'update'=>'#'.CHtml::activeId($model, 'supplier_kabupaten'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
																'success'=>'function(data){$("#'.CHtml::activeId($model, "supplier_kabupaten").'").html(data);}',
															),
															'class'=>'span3',
					)); ?>
				</div>
			</div>
			<?php
				$propinsi_id = isset($model->supplier_propinsi) ? PropinsiM::model()->findByPk($model->supplier_propinsi)->propinsi_id : null;
			?>
			<?php echo $form->dropDownListRow($model,'supplier_kabupaten', CHtml::listData($model->getKabupatenItems($propinsi_id), 'kabupaten_id', 'kabupaten_nama') ,array('empty'=>'-- Pilih --',
												'onkeyup'=>"return $(this).focusNextInputField(event)",
												'class'=>'span3'
							)); ?>
            <?php echo $form->textFieldRow($model,'supplier_telp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>

            <?php echo $form->textFieldRow($model,'supplier_fax',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'supplier_npwp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'supplier_website',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'supplier_email',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'supplier_cp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'supplier_norekening',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'supplier_jenis',array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'readOnly'=>true)); ?>
            <div style="padding-left:140px;"><?php echo $form->checkBoxRow($model,'supplier_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?></div>
        </td>
    </tr>
    <tr>
<!--                <td colspan="2">
            <div class="control-group">
                <?php echo Chtml::label('Obat Alkes','Obat Alkes',array('class'=>'control-label'));?>
                <div class="controls">
                   <?php 
                      $arrObatAlkes = array();
                           foreach($modObatSupplier as $data)
                             {
                                $arrObatAlkes[] = $data['obatalkes_id'];
                             }

                        $this->widget('application.extensions.emultiselect.EMultiSelect',
                                     array('sortable'=>true, 'searchable'=>true)
                                );
                        echo CHtml::dropDownList(
                        'obatalkes_id[]',
                        $arrObatAlkes,
                        CHtml::listData(GZObatAlkesM::model()->findAll('obatalkes_aktif=TRUE ORDER BY obatalkes_nama'), 'obatalkes_id', 'obatalkes_nama'),
                        array('multiple'=>'multiple','key'=>'obatalkes_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                );
                  ?>
                </div>
            </div>      
        </td> -->
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeyUp'=>'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                Yii::app()->createUrl($this->module->id.'/supplierM/admin'), 
                array('class'=>'btn btn-danger',
                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Supplier', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                $this->createUrl('supplierM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
        $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama)
    {
        document.getElementById('GZSupplierM_supplier_namalain').value = nama.value.toUpperCase();
    }
</script>