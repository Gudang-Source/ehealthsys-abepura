<legend class="rim"><i class="icon-white icon-search"></i> <?php echo  Yii::t('mds','Search Patient') ?></legend>
<style>
    td label.checkbox{
        width: 150px;
        display:inline-block;

    }

    .checkbox.inline + .checkbox.inline{
        margin-left:0px;
    }
</style>
<table width="100%" class="table-condensed">
    <tr>
        <td width="50%">
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal Pembayaran','tglPembayaran', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>                                
        </td>
        <td>
            <div class="control-group ">
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>                
            <div class="control-group ">
                <?php echo CHtml::hiddenField('filter','carabayar',array('disabled'=>true)); ?>
                <?php echo CHtml::label('Cara Bayar','carabayar', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                        echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                'update' => '#penjamin_tbl',  //selector to update
                            ),
                        ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Penjamin','penjamin', array('class'=>'control-label inline')) ?>
                <div class="controls" id="penjamin_tbl">
                    <label>Data Tidak Ditemukan</label>
                </div>
            </div>
                <?php

            ?>
            <?php echo CHtml::hiddenField('filter_tab', 'all'); ?>
            </div>                    
        </td>
    </tr>
</table>

<script type="text/javascript">
    function cek_all_ruangan(obj){
        if($(obj).is(':checked')){
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function cek_all_penjamin(obj){
        if($(obj).is(':checked')){
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function checkAll(){
         if($('#checkAllCaraBayar').is(':checked')){
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#penjamin_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>