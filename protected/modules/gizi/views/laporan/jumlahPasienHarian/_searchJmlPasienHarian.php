<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
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
        td label.checkbox{
            width: 150px;
            display:inline-block;

        }
        .checkbox.inline + .checkbox.inline{
            margin-left:0px;
        }
    </style>
    <table width="100%">
        <tr>
            <td width="35%">
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Tanggal</legend>
                    <div class="control-group ">
                        <?php echo $form->hiddenField($model, 'pilihan_tab', array('value'=>"report")); ?>
                        <div class='control-label'>Tanggal Kirim Menu&nbsp;</div>
                        <div class='controls'>
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
                    <?php echo CHtml::label(' sampai dengan', ' s/d', array('class' => 'control-label')) ?>
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
                </fieldset>
            </td>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Jenis Diet</legend>
                    <div class="controls" id="cbJenisDiet">
                        <label><?php echo CHtml::checkBox('pilihSemuaJenis',true,array('onclick'=>'pilihSemuaJenisDiet();')); ?> <b>Pilih Semua</b> </label><br>
                        <?php echo $form->checkBoxList($model, 'jenisdiet_id', CHtml::listData(JenisdietM::model()->findAll('jenisdiet_aktif = true'), 'jenisdiet_id', 'jenisdiet_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </fieldset>
            </td>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Waktu</legend>
                    <div class="controls" id="cbWaktu">
                        <label><?php echo CHtml::checkBox('pilihSemuaWaktu',true,array('onclick'=>'pilihSemuaJenisWaktu();')); ?> <b>Pilih Semua</b> </label><br>
                        <?php echo $form->checkBoxList($model, 'jeniswaktu_id', CHtml::listData(JeniswaktuM::model()->findAll('jeniswaktu_aktif = true'), 'jeniswaktu_id', 'jeniswaktu_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <div style="float:left;margin-right:6px;">
        <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
             'type' => 'GET', 
             'url' => array("/".$this->route), 
             'update' => '#tables',
             'beforeSend' => 'function(){
                                  $("#tables").addClass("animation-loading");
                              }',
             'complete' => 'function(){
                                  $("#tables").removeClass("animation-loading");
                              }',
         ))); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onClick'=>'onReset()')); ?>
        </div>
        
    </div>
    <div style="clear:both;"></div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<script type="text/javascript">
    function pilihSemuaJenisDiet(){
        if($("#pilihSemuaJenis").is(':checked')){
            $("#cbJenisDiet").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#cbJenisDiet").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    pilihSemuaJenisDiet();
    function pilihSemuaJenisWaktu(){
        if($("#pilihSemuaWaktu").is(':checked')){
            $("#cbWaktu").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#cbWaktu").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    pilihSemuaJenisWaktu();

</script>

