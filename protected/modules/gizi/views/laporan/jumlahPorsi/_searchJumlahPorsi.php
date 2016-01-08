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
            <td width="33%">
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Tanggal</legend>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>
                    <div class = 'control-label'>Tanggal Kirim Menu</div>
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
                    <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
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
                    <div class="control-group ">
                        <div class="controls" id="cbJenisDiet">
                            <label><?php echo CHtml::checkBox('pilihSemuaJenis',true,array('onclick'=>'pilihSemuaJenisDiet();')); ?> <b>Pilih Semua</b> </label><br>
                            <?php echo $form->checkBoxList($model, 'jenisdiet_id', CHtml::listData(JenisdietM::model()->findAll('jenisdiet_aktif = true'), 'jenisdiet_id', 'jenisdiet_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
<!--                    <div class="control-group ">
                        <label class="control-label">Jenis Diet</label>
                        <div class="controls" id="cbJenisDiet">
                            <?php //echo $form->textField($model, 'jenisdiet_nama', array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    </div> -->
          
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan','ajax' => array(
             'type' => 'GET', 
             'url' => array("/".$this->route), 
             'update' => '#tableLaporan',
             'beforeSend' => 'function(){
                                  $("#tableLaporan").addClass("animation-loading");
                              }',
             'complete' => 'function(){
                                  $("#tableLaporan").removeClass("animation-loading");
                              }',
         ))); 
        ?>
        <?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
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

</script>