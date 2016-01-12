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

        #penjamin label.checkbox{
            width: 100px;
            display:inline-block;
        }

    </style>
    <div class="row-fluid">
        <div class="span4">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Kunjungan</legend>
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::hiddenField('src', ''); ?>
                <div class = 'control-label'>Tanggal Pelayanan</div>
                <div class="controls">  
                    <?php
                    $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                    $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
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
        </div>
        <div class="span4">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan Cara Bayar </legend>
                <?php echo '<table>
                    <tr>
                        <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
                        <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array('type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                'update' => '#penjamin',  //selector to update
                            ),
                        )).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Penjamin</label>
                        </td>
                        <td>
                            <div id="penjamin">
                                 <label>Data Tidak Ditemukan</label>
                            </div>
                        </td>
                    </tr>
                </table>'; ?>
            </fieldset>
        </div>
        <div class="span4">
            <fieldset class="box2">
                <legend class="rim">Berdasarkan status bayar</legend>
                <?php echo '<table>
                    <tr>
                        <td>
                            <div class="penjamin">'.
                            $form->checkBoxList($model, 'tindakansudahbayar_id', CustomFunction::getStatusBayar(), array('value'=>'pengunjung', 'inline'=>true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'
                            </div>
                        </td>
                    </tr>
                </table>'; ?>
            </fieldset>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan','onclick'=>'pilihPencarian();')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<script>
function checkAll() {
    if ($("#checkAllCaraBayar").is(":checked")) {
        $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).attr('checked',true);
        })
//        myAlert('Checked');
    } else {
       $('#penjamin input[name*="penjamin_id"]').each(function(){
           $(this).removeAttr('checked');
        })
    }
    
}   
function konfirmasi(){
    location.reload();
}
function pilihPencarian(){
    var idCaraBayar = parseFloat($('#BSLaporanjasainstalasi_carabayar_id').val());
    if(!jQuery.isNumeric(idCaraBayar)){
        myAlert('Pilih Cara Bayar terlebih dahulu !');
        return false;
    }else{
        $('#searchLaporan').submit();
    }
}
</script>