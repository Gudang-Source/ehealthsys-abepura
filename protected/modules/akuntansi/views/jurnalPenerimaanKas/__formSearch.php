<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<fieldset class="box" id="frmSearchJurnalRek">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'form-search-jurnal-rek',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)'
                ),
                'focus'=>'#',
            )
        );
    ?>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <label class="control-label" for="AKJurnalrekeningT_tgl_akhir">Tanggal Bukti Jurnal</label>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_awal',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>

                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="AKJurnalrekeningT_tgl_akhir">Sampai Dengan</label>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_akhir',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'nobuktijurnal',array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <?php echo $form->textFieldRow($model,'kodejurnal',array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>                
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>
    <?php $this->endWidget();?>    
</fieldset>