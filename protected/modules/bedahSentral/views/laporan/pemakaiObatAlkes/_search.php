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

       label.checkbox{
                width:150px;
                display:inline-block;
            }

    </style>
    <fieldset class="box2">
        <legend class="rim">Berdasarkan Tanggal</legend>
        <?php echo CHtml::hiddenField('type', ''); ?>
        <?php //echo CHtml::hiddenField('src', ''); ?>
        <table width="100%" border="0">
          <tr>
                <td>
                    <div class = 'control-label'>Tanggal Pemakaian</div>
                        <div class="controls">  
                            <?php
                                $model->tgl_awal =  MyFormatter::formatDateTimeForUser($model->tgl_awal);
                                $model->tgl_akhir =  MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                                $this->widget('MyDateTimePicker',array(
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
                </td>
                <td style="padding:0px 100px 0 0;">
                        <?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
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
                </td>
            </tr>
        </table>
    </fieldset>
    <div id='searching'>
        <fieldset class="box2">
            <legend class="rim">Berdasarkan Jenis Obat
                <?php echo CHtml::checkBox('checkAllJenisObat',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua"; ?>
            </legend>
            <div class="controls">
                <div id="jenisObat">
                    <?php
                        echo $form->CheckBoxList($model,'jenisobatalkes_id',CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'),'jenisobatalkes_id','jenisobatalkes_nama'));
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
   
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
    </div>   
</div>    

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
function checkAll() {
    if ($("#checkAllJenisObat").is(":checked")) {
        $('#jenisObat input[name*="jenisobatalkes_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#jenisObat input[name*="jenisobatalkes_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
}   
function konfirmasi(){
    location.reload();
}
</script>