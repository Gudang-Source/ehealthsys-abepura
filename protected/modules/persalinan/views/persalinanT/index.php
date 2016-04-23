<style>
    .control-group{
        padding:5px;
    }
    td .control-group:hover{
        background-color: #B5C1D7;
    }
    .additional-text{
        display:inline-block;
        font-size: 11px;
    }
</style>
<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Transaksi berhasil disimpan !");

?>
<div class='white-container'>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php // $this->renderPartial('/_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,'format'=>$format)); ?>
    <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
    <?php $this->renderPartial('persalinan.views.pemeriksaanPasienPersalinan._jsFunctions',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
    <fieldset class='box'>
        <legend class='rim'>Persalinan</legend>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pspersalinan-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
            'focus' => '#',
                ));
        ?>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model, 'kegiatanpersalinan_id', CHtml::listData(PSKegiatanpersalinanM::model()->findAll(), 'kegiatanpersalinan_id', 'kegiatanpersalinan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'kelsebababortus_id', CHtml::listData(PSKelsebababortusM::model()->findAll(), 'kelsebababortus_id', 'kelsebababortus_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'sebababortus_id', CHtml::listData(PSSebababortusM::model()->findAll(), 'sebababortus_id', 'sebababortus_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData($model->DokterItems, 'pegawai_id', 'nama_pegawai'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'jeniskegiatanpersalinan', LookupM::model()->getItems('jeniskegiatanpersalinan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php //echo $form->textFieldRow($model,'tglmulaipersalinan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglmulaipersalinan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmulaipersalinan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                    //
                                    //'onkeypress' => "js:function(){getUmur(this);}",
                                    //'onSelect' => 'js:function(){$(this).close();}',
                                    //'yearRange' => "-60:+0",
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglmulaipersalinan'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglselesaipersalinan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglselesaipersalinan',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglselesaipersalinan'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'lamapersalinan_jam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'lamapersalinan_jam', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Jam</div>
                            <?php echo $form->error($model, 'lamapersalinan_jam'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model, 'carapersalinan', LookupM::getItems('carapersalinan'), array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <?php echo $form->dropDownListRow($model, 'posisijanin', LookupM::getItems('posisijanin'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <div class="control-group">
                        <label class="control-label"><?php echo $form->Label($model, 'tglmelahirkan'); ?></label>
                        <div class="controls">
                            <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglmelahirkan',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                            ?>
                        </div>
                        <div class="checkbox inline">
                            <?php echo $form->checkBox($model, 'islahirdirs', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo CHtml::activeLabel($model, 'islahirdirs'); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($model, 'tglmelahirkan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                    <?php echo $form->dropDownListRow($model, 'keadaanlahir',LookupM::getItems('keadaanlahir'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange'=> 'setKematian();', 'maxlength' => 100)); ?>
                    <?php //echo $form->textFieldRow($model, 'masagestasi_minggu', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'masagestasi_minggu', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'masagestasi_minggu', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Minggu</div><br/>
                            <?php echo $form->error($model, 'masagestasi_minggu'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'paritaske', CustomFunction::getNomorUrutText(1,10), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'jmlkelahiranhidup', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'jmlkelahiranhidup', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Orang</div>
                            <?php echo $form->error($model, 'jmlkelahiranhidup'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'jmlkelahiranmati', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'jmlkelahiranmati', array('class'=>'span1 numbersOnly','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
                            ?> <div class='additional-text'>Orang</div>
                            <?php echo $form->error($model, 'jmlkelahiranmati'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($model, 'sebabkematian', LookupM::getItems('sebabkematian'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglabortus', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglabortus',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglabortus'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'jmlabortus', array('class' => 'span3 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textAreaRow($model, 'catatan_dokter', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan_id',  CHtml::listData($model->BidanItems, 'pegawai_id', 'nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan2_id',  CHtml::listData($model->BidanItems, 'pegawai_id', 'nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'bidan3_id',  CHtml::listData($model->BidanItems, 'pegawai_id', 'nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($model, 'paramedis_id',  CHtml::listData($model->ParamedisItems, 'pegawai_id', 'nama_pegawai'), array('empty' =>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <div class="form-actions"> 
        <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id.'/daftarPasien/index'), array('class' => 'btn btn-danger',
                     'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'));
        ?>
        <?php
            $content = $this->renderPartial('../persalinanT/tips/transaksi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div> 
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function setKematian(){
        var keadaan_lahir = $('#PSPersalinanT_keadaanlahir').val();
        if (keadaan_lahir == 'Lahir Hidup'){            
            $('#PSPersalinanT_jmlkelahiranmati').attr('disabled','true');
            $('#PSPersalinanT_sebabkematian').attr('disabled','true');
            $('#PSPersalinanT_tglabortus').attr('disabled','true');
            $('#PSPersalinanT_tglabortus_date').hide();
            $('#PSPersalinanT_jmlabortus').attr('disabled','true');
        } else {
            $('#PSPersalinanT_jmlkelahiranmati').removeAttr('disabled');
            $('#PSPersalinanT_sebabkematian').removeAttr('disabled');
            $('#PSPersalinanT_tglabortus').removeAttr('disabled');
            $('#PSPersalinanT_tglabortus_date').show();
            $('#PSPersalinanT_jmlabortus').removeAttr('disabled');
        }
    }
    $(document).ready(function(){
        setKematian();
    });
</script>