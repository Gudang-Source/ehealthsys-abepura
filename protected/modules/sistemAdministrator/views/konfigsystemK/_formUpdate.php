
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakonfigsystem-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'mr_lab'),
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class="span4">        
        <div class="box">
			<?php echo $form->textFieldRow($model, 'jmldigitrm', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 2, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_jenazah'))); ?>
			<?php echo $form->textFieldRow($model, 'normlama_min', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('normlama_min'),'placeholder'=>'000000')); ?>
			<?php echo $form->textFieldRow($model, 'normlama_maks', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('normlama_maks'),'placeholder'=>'000000')); ?>
            <?php echo $form->textFieldRow($model, 'mr_lab', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_lab'))); ?>
            <?php echo $form->textFieldRow($model, 'mr_rad', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_rad'))); ?>
            <?php echo $form->textFieldRow($model, 'mr_ibs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_ibs'))); ?>
            <?php echo $form->textFieldRow($model, 'mr_rehabmedis', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_rehabmedis'))); ?>
            <?php echo $form->textFieldRow($model, 'mr_apotik', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_apotik'))); ?>
            <?php echo $form->textFieldRow($model, 'mr_jenazah', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mr_jenazah'))); ?>
        </div>
        <div class="box">
            <?php echo $form->textAreaRow($model, 'running_text_display', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('running_text_display'))); ?>
            <?php echo $form->textAreaRow($model, 'running_text_kiosk', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('running_text_kiosk'))); ?>
            <?php echo $form->checkBoxRow($model, 'isantrian', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isantrian'),)); ?>
        </div>
        <div class="box">
            <?php echo $form->textFieldRow($model, 'bpjs_uid', array('class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bpjs_uid'))); ?>
            <?php echo $form->textFieldRow($model, 'bpjs_secret', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bpjs_secret'))); ?>
            <?php echo $form->textFieldRow($model, 'bpjs_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bpjs_host'))); ?>
            <?php echo $form->textFieldRow($model, 'bpjs_port', array('placeholder' => '3000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('bpjs_port'))); ?>
            <?php echo $form->textFieldRow($model, 'bpjs_inacbg_path', array('class'=>'span3', 'rel'=>'tooltip', 'title'=>'Host INA-CBG untuk Bridging BPJS')); ?>
            <?php echo $form->checkBoxRow($model, 'isbridging', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbridging'),)); ?>
        </div>
        <div class="box">
            <?php echo $form->dropDownListRow($model, 'jenissuaraantrian', array('LAKI-LAKI' => 'LAKI-LAKI', 'PEREMPUAN' => 'PEREMPUAN'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('jenissuaraantrian'))); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'delaytombolantrian', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'delaytombolantrian', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('delaytombolantrian'))); ?> Detik
                </div>
            </div>

        </div>
    </div>
    <div class="span4">
        <div class="box">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_rj', array('class' => 'control-label')) ?>
                <div class="controls"> 
                    <?php echo $form->textField($model, 'nopendaftaran_rj', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_rj'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_ri', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopendaftaran_ri', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_ri'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_gd', array('class' => 'control-label')) ?>
                <div class="controls">    
                    <?php echo $form->textField($model, 'nopendaftaran_gd', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('pendaftaran_gd'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_lab', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopendaftaran_lab', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_lab'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_rad', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopendaftaran_rad', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_rad'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_ibs', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopendaftaran_ibs', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_ibs'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_rehabmedis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopendaftaran_rehabmedis', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_rehabmedis'))); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no pendaftaran_jenazah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'nopendaftaran_jenazah', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nopendaftaran_jenazah'))); ?>
                </div>
            </div>
        </div>
        <div class="box">
            <?php echo $form->textFieldRow($model, 'persentasirujin', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persentasirujin'))); ?>
            <?php echo $form->textFieldRow($model, 'persentasirujout', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('persentasirujout'))); ?>
        </div>
        <div class="box">
            <?php echo $form->textFieldRow($model, 'monitoringrefresh', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('monitoringrefresh'))); ?>
        </div>
        <div class="box">
            <?php echo $form->textFieldRow($model, 'lamakonfbooking', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('lamakonfbooking'))); ?>
            <?php //	LNG-369	  echo $form->textFieldRow($model,'refreshnotifikasi',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200));  ?>
        </div>
        <div class="box">
            <?php echo $form->textFieldRow($model, 'nodejs_host', array('placeholder' => 'http://192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nodejs_host'))); ?>
            <?php echo $form->textFieldRow($model, 'nodejs_port', array('placeholder' => '3000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nodejs_port'))); ?>
            <?php echo $form->checkBoxRow($model, 'is_nodejsaktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_nodejsaktif'),)); ?>
            <?php echo $form->textFieldRow($model, 'telnet_host', array('placeholder' => '192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('telnet_host'))); ?>
            <?php echo $form->textFieldRow($model, 'telnet_port', array('placeholder' => '6000', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('telnet_port'))); ?>
            <?php echo $form->checkBoxRow($model, 'is_telnetaktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('is_telnetaktif'),)); ?>
            <?php echo $form->textFieldRow($model, 'hl7broker_host', array('placeholder' => '192.168.1.1', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_host'))); ?>
            <?php echo $form->textFieldRow($model, 'hl7broker_port', array('placeholder' => '25750', 'class' => 'span3 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_port'))); ?>
            <?php echo $form->checkBoxRow($model, 'hl7broker_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('hl7broker_aktif'),)); ?>
        </div>
    </div>
    <div class="span4">
        <div class="box">

            <?php echo $form->checkBoxRow($model, 'iskarcis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('iskarcis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'karcisbarulama', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('karcisbarulama'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'printkartulsng', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('printkartulsng'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'printkunjunganlsng', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('printkunjunganlsng'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'nama_huruf_capital', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('nama_huruf_capital'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'alamat_huruf_capital', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('alamat_huruf_capital'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'dokterruangan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('dokterruangan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'tindakanruangan', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tindakanruangan'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'tindakankelas', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tindakankelas'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'tgltransaksimundur', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('tgltransaksimundur'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'krngistokgizi', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('krngistokgizi'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'krngistokumum', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('krngistokumum'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php //	LNG-369	  echo $form->checkBoxRow($model,'monitoringpresensi', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

            <?php echo $form->checkBoxRow($model, 'akomodasiotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('akomodasiotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'iskartudgntemplate', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('iskartudgntemplate'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>


            <?php echo $form->checkBoxRow($model, 'mapdashboard', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('mapdashboard'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'isbayarkekasirpenunjang', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isbayarkekasirpenunjang'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'isjurnalotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('isjurnalotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'ispostingotomatis', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'issmsgateway', array('rel' => 'tooltip', 'title' => $model->getAttributeTooltip('ispostingotomatis'), 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="box">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'jatuhtempoklaim', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jatuhtempoklaim', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('jatuhtempoklaim'))); ?> Hari
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'jatuhtempotagihan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jatuhtempotagihan', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('jatuhtempotagihan'))); ?> Hari
                </div>
            </div>

        </div>
        <div class="box">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'masaberlaku_pelamar_hr', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'masaberlaku_pelamar_hr', array('class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200, 'rel' => 'tooltip', 'title' => $model->getAttributeTooltip('masaberlaku_pelamar_hr'))); ?> Hari
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
//        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
//                            $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), 
//                            array('class'=>'btn btn-danger',
//                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('id' => 'btn_resset', 'class' => 'btn btn-danger', 'type' => 'reset'));
        ?>
        <?php
//            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Konfigurasi Sistem', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
        $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScript('angka', "
$(document).ready(function () {
        $('.numbersOnly').keypress(function(event) {
                var charCode = (event.which) ? event.which : event.keyCode
                if ((charCode >= 48 && charCode <= 57)
                        || charCode == 46
                        || charCode == 44)
                        return true;
                return false;
        });
});
", CClientScript::POS_HEAD); ?>
