<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian Berdasarkan Kunjungan</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class='control-group'>
                        <div class = 'control-label'>Tanggal Pemeriksaan</div>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'maxDate'=>'d',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                'class'=>'dtPicker2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <div class = 'control-label'>Sampai Dengan</div>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'maxDate'=>'d',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                'class'=>'dtPicker2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php
                    echo $form->textFieldRow($model, 'jumlahTampil', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly')); 
                    ?>

                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
        </div>
    </fieldset>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>


