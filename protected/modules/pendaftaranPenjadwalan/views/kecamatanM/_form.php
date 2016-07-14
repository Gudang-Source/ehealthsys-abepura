
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppkecamatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#propinsi',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<div class="control-group ">
		<?php echo CHtml::label('Propinsi','propinsi_id', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'propinsi_id', CHtml::listData($model->PropinsiItems, 'propinsi_id', 'propinsi_nama'), 
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
						'ajax'=>array('type'=>'POST',
						'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
						'update'=>"#".CHtml::activeId($model, 'kabupaten_id'),
			)));?>
			<?php echo $form->error($model, 'propinsi_id'); ?>
		</div>
	</div>
	<div class="control-group ">
		<?php echo $form->labelEx($model,'kabupaten_id', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), 
				array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", ));?>
			<?php echo $form->error($model, 'kabupaten_id'); ?>
		</div>
	</div>
        <table style = "width:100%;">
            <tr>
                <th style ="text-align:center;" >Kecamatan</th>
                <th style ="text-align:center;">Nama Lain</th>
                <th style ="text-align:center;">Latitude</th>
                <th style ="text-align:center;">Longitude</th>
            </tr>
            <tr>
                <td>
                    <?php echo $form->textField($model,'kecamatan_nama',array('onkeyup'=>"namaLain(this)", 'class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>$model->getAttributeLabel('kecamatan_nama'))); ?>
                    <span class="required">*</span>
                </td>
                <td>
                    <?php echo $form->textField($model,'kecamatan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50, 'placeholder'=> $model->getAttributeLabel('kecamatan_namalainnya'))); ?>
                </td>                
                <td>

                        <?php echo $form->textField($model,'latitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=> $model->getAttributeLabel('latitude'))); ?>
                        <?php echo CHtml::htmlButton('<i class="icon-search icon-white"></i>',
                                                    array(
                                                            'class'=>'btn btn-primary btn-location',
                                                            'rel'=>'tooltip',
                                                            'id'=>'yw1',
                                                            'onclick' =>'changeSize()',
                                                            'title'=>'Klik untuk mencari Longitude & Latitude',)); 
                        ?>                        

                </td>
                <td>
                     <?php echo $form->textField($model,'longitude',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder'=> $model->getAttributeLabel('longitude'))); ?>                    
               
                    <!--Extension location-picker latitude & longitude-->
                   <?php               

                           $this->widget('ext.LocationPicker2.CoordinatePicker', array(
                                   'model' => $model,
                                   'latitudeAttribute' => 'latitude',
                                   'longitudeAttribute' => 'longitude',
                                   //optional settings
                                   'editZoom' => 12,
                                   'pickZoom' => 7,
                                   'defaultLatitude' => $model->latitude,
                                   'defaultLongitude' => $model->longitude,
                           ));
                   ?>    
                                        
                </td>
                <td>
                    <?php echo CHtml::htmlButton( '<i class="icon-plus-sign icon-white"></i>', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);','id'=>'row1-plus')); ?>
                </td>
            </tr>
        </table>
        
	<table id="tbl-kecamatan" class="table table-striped table-bordered table-condensed">
		<?php
                echo CHtml::hiddenField('Nomor',0, array('id'=>'nomor'));
             ?>
	</table>
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
					Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
					Yii::app()->createUrl($this->module->id.'/kecamatanM/admin'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

		<?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
		$this->createUrl('/pendaftaranPenjadwalan/KecamatanM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
		<?php
			$content = $this->renderPartial('rawatDarurat.views.tips.tipsaddedit2b',array(),true);
			$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
		?>
	</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array()); ?>