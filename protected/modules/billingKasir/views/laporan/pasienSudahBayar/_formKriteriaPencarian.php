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
<div class = "row-fluid">
     <div class="span4">
                    <?php $format = new MyFormatter(); ?>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::label('Tanggal Pembayaran', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                        </div> 

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls"> 
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
    </div>
    <div class = "row-fluid">
        <div class = "span4">
             <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php //echo $form->textFieldRow($model,'nama_bin',array('placeholder'=>'Ketik Nama Panggilan','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>                                
        </div>
        
        <div class = "span4">
             <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>                
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
    </div>
           
        </td>
        
          
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
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>