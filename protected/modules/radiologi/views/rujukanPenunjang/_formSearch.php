<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'search-penunjangrujukan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'',
            'htmlOptions'=>array(),
    )); 

    Yii::app()->clientScript->registerScript('search', "
    $('#search-penunjangrujukan-form').submit(function(){
            $.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                    <div class="controls">
                        <input type="text" value="" maxlength="20" placeholder="Ketik no. pendaftaran" id="noPendaftaran" name="noPendaftaran" autofocus=true onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div>    
                <div class="control-group ">
                    <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                    <div class="controls">
                        <input type="text" value="" maxlength="10" placeholder="Ketik no. rekam medik" id="noRekamMedik" name="noRekamMedik" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div>    
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">Nama Pasien </label>
                    <div class="controls">
                        <input type="text" value="" maxlength="50" placeholder="Ketik nama pasien" id="namaPasien" name="namaPasien" onkeypress="return $(this).focusNextInputField(event)" empty="-- Pilih --">
                    </div>
                </div> 
            </td>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        <?php echo CHtml::checkBox('cbTglMasuk', false, array('uncheckValue'=>0,'onClick'=>'cekTanggal()')); ?>
                        Tanggal Masuk 
                    </label>
                    <div class="controls">
                        <?php   $format = new MyFormatter;
                                $this->widget('MyDateTimePicker',array(
                                                'name'=>'tgl_awal',
    //                                            'value'=> date('d M Y').' 00:00:00',
                                                'value'=> $format->formatDateTimeForUser(date('d M Y', strtotime('-5 days'))),
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        ));?> </div></div>
                                                    <div class="control-group ">
                        <label for="namaPasien" class="control-label">
                           Sampai dengan
                          </label>
                        <div class="controls">
                                <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'name'=>'tgl_akhir',
                                                'value'=> $format->formatDateTimeForUser(date('d M Y')),
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                        )); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php 
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	

        </div>

    <?php $this->endWidget(); ?>
</fieldset>