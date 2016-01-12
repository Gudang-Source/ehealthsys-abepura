<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'salayarantrian-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row-fluid">

	<div class = "span6">
            <?php // echo $form->textFieldRow($model,'layarantrian_jenis',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->dropDownListRow($model,'layarantrian_jenis', LookupM::getItems('layarantrian_jenis'),array('class'=>'span3', 'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'onchange'=>'showMultiSelect(this)')); ?>
            <?php echo $form->textFieldRow($model,'layarantrian_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'layarantrian_judul',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo $form->textAreaRow($model,'layarantrian_runningtext',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
  
            <div class="control-group <?php echo ($model->layarantrian_jenis==Params::LAYARANTRIAN_JENIS_POLIKLINIK)?'':'hide'; ?> ms" id="poliklinik">
                        <?php echo Chtml::label('Poliklinik','Poliklinik',array('class'=>'control-label'));?>
                        <div class="controls">
                           <?php                
                               $this->widget('application.extensions.emultiselect.EMultiSelect',
                                             array('sortable'=>true, 'searchable'=>true)
                                        );
                                echo CHtml::dropDownList(
                                'ruangan_id_poliklinik[]',
                                $model->ruanganMs,
                                CHtml::listData(SARuanganM::model()->findAll('ruangan_aktif=TRUE AND instalasi_id='.Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'),
                                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                        );
                          ?>
                        </div>
            </div>
            <div class="control-group <?php echo ($model->layarantrian_jenis==Params::LAYARANTRIAN_JENIS_PENUNJANG)?'':'hide'; ?> ms" id="penunjang">
                        <?php echo Chtml::label('Penunjang','Penunjang',array('class'=>'control-label'));?>
                        <div class="controls">
                           <?php            
                                $criteria = new CDbCriteria();
                                $criteria->join = 'JOIN instalasi_m ON t.instalasi_id = instalasi_m.instalasi_id';
                                $criteria->addCondition('instalasirujukaninternal = TRUE and instalasi_aktif = TRUE AND ruangan_aktif=TRUE');
                               $this->widget('application.extensions.emultiselect.EMultiSelect',
                                             array('sortable'=>true, 'searchable'=>true)
                                        );
                                echo CHtml::dropDownList(
                                'ruangan_id_penunjang[]',
                                $model->ruanganMs,
                                CHtml::listData(SARuanganM::model()->findAll($criteria), 'ruangan_id', 'ruangan_nama'),
                                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                        );
                          ?>
                        </div>
            </div>
            <div class="control-group <?php echo ($model->layarantrian_jenis==Params::LAYARANTRIAN_JENIS_KASIR)?'':'hide'; ?> ms" id="kasir">
                        <?php echo Chtml::label('Kasir','Kasir',array('class'=>'control-label'));?>
                        <div class="controls">
                           <?php                
                               $this->widget('application.extensions.emultiselect.EMultiSelect',
                                             array('sortable'=>true, 'searchable'=>true)
                                        );
                                echo CHtml::dropDownList(
                                'ruangan_id_kasir[]',
                                $model->ruanganMs,
                                CHtml::listData(SARuanganM::model()->findAll('ruangan_aktif=TRUE AND instalasi_id='.Params::INSTALASI_ID_KASIR), 'ruangan_id', 'ruangan_nama'),
                                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                        );
                          ?>
                        </div>
            </div>

        </div>
        <div class = "span6">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo Params::urlBackgroundAntrianThumbs().'kecil_'.$model->layarantrian_latarbelakang; ?>"> 
           <?php echo $form->labelEx($model,'layarantrian_latarbelakang', array('class'=>'control-label','onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                <div class="controls">
                    <?php echo CHtml::activeFileField($model,'layarantrian_latarbelakang',array('maxlength'=>254, 'hint'=>'Unggah file untuk latar belakang')); ?>                
                </div>
            <?php echo $form->textFieldRow($model,'layarantrian_maksitem',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'layarantrian_itemhigh',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'layarantrian_itemwidth',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'layarantrian_intrefresh',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model,'layarantrian_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="row-fluid">
	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('id'=>'btn_resset','class'=>'btn btn-danger', 'type'=>'reset')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Data Layar Antrian',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php
                    $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function showMultiSelect(obj){
        val = $(obj).val().toLowerCase(); 
        $('.ms').hide();
        $('#'+val).show();
    }
</script>