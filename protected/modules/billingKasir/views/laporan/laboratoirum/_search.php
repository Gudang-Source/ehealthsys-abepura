<legend class="rim"><i class="icon-white icon-search"></i> Pencarian : </legend>
<style>
    table{
        margin-bottom: 0px;
    }
    .form-actions{
        padding:4px;
        margin-top:5px;
    }
    #ruangan label{
        width: 120px;
        display:inline-block;
    }
    .nav-tabs>li>a{display:block; cursor:pointer;}
    td label.checkbox{
        width: 150px;
        display:inline-block;

    }

    .checkbox.inline + .checkbox.inline{
        margin-left:0px;
    }    
</style>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <div class='control-label'>Tanggal Tindakan&nbsp;</div>
                <div class='controls'>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>                    
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                    ?>  
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div> 
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>  
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <div class="control-group ">
                <div class='control-label'>Tanggal Tindakan&nbsp;</div>
                <div class='controls'>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>  
                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                    ?> 
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
            <?php echo $form->hiddenField($model,'filter_tab'); ?> 
            <div class="control-group">
                <div class='control-label'>Cara Bayar</div>
                <div class='controls'>
                    <?php
                        echo $form->dropDownList($model, 'carabayar_id',
                            CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'),
                            array(
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type'=>'POST',
                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox',
                                        array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')
                                    ),
                                    'update' => '#penjamin',
                                ),
                            )
                        );
                        echo CHtml::checkBox('cek_penjamin', true, array('onchange'=>'cek_all_penjamin(this)','value'=>'cek_penjamin'));
                        echo '&nbsp;<label>Cek Semua</label>';
                    ?>                    
                </div>
            </div>
            <div class="control-group">
                <div class='control-label'>Penjamin</div>
                <div class='controls'>
                    <div id="penjamin"><label>Data Tidak Ditemukan</label></div>
                </div>
            </div>  
            <div class="control-group">
                <?php echo CHtml::label('Asal', 'asal', array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'asal',array('rs'=>ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->nama_rumahsakit, 'rujukan'=>'Rujukan'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>

        </td>
    </tr>
</table>
<div class="form-actions">
    <div style="float:left;margin-right:6px;">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
    </div>
    <div style="float:left;margin-right:6px;">
        <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKeseluruhan');           
            
         ?>
    </div>
<!--    <div style="float:left;margin-left:0px;">
       
    </div>-->
    <div style="clear:both;"></div>
</div>
<?php
    $this->endWidget();
?>
</div>
<script type="text/javascript">
    function cek_all_penjamin(obj){
        if($(obj).is(':checked')){
            $("#penjamin").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#penjamin").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>