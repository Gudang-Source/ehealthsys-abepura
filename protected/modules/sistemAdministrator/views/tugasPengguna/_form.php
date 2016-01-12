<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'satugaspengguna-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    
    <div class="row-fluid">

	<div class = "span4">
            <?php // echo $form->dropDownListRow($model,'peranpengguna_id',CHtml::listData($model->getPeranPengguna(), 'peranpengguna_id', 'peranpenggunanama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','onchange'=>'cekPengguna(this.value)')); ?>
            <?php echo $form->dropDownListRow($model,'peranpengguna_id',CHtml::listData($model->getPeranPengguna(), 'peranpengguna_id', 'peranpenggunanama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'tugas_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'tugas_namalainnya',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'tugaspengguna_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class = "span4">
            <?php echo $form->textAreaRow($model,'keterangan_tugas',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class = "span4">
            
        </div>
    </div>
    <div class="block-tabel">
        <h6>Tabel <b>Tugas Pemakai</b></h6>
        <table class='table table-striped table-bordered table-condensed' id="tugasPengguna">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Modul</th>
                    <th>Nama Controller</th>
                    <th>Nama Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->getModul() as $i => $modul) { ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo CHtml::CheckBox('modul','', array(
                                        'value'=>$modul->url_modul,
                                        'modul_id'=>$modul->modul_id,
                                        'onclick'=>'tambahController(this)',
                                        'id'=>$modul->url_modul,
                                        )); ?>
                        <?php echo $modul->modul_nama; ?></td>
                    <td id="<?php echo 'row_controller_'.$modul->url_modul; ?>"></td>
                    <td id="<?php echo 'row_action_'.$modul->url_modul; ?>"></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="row-fluid">
	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'));  ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Tugas Pemakai',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                <?php $this->widget('UserTips',array('type'=>'create'));?>
        </div>
    </div>
<?php $this->endWidget(); ?>
