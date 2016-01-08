<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus' => '#BKLaporanpembayaranpelayananV_carabayar_id',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
 <style>
        td label.checkbox{
            width: 300px;
            display:inline-block;

        }
        .checkbox.inline + .checkbox.inline{
            width: 300px;
            display:inline-block;
        }
    </style>
    <fieldset class="box2">
        <legend class="rim">Berdasarkan Tanggal Bukti Bayar</legend>
        <table width="100%">
            <tr>
                <td>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class = 'control-label'>Tanggal Pembayaran</div>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'datetime',
//                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div> 
                </td>
                <td>
                    <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'datetime',
//                                         'maxdate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <table width="100%" border="0">
        <tr>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Cara Bayar </legend>                 
                        <?php echo '<table id="penjamin_tbl">
                            <tr>
                                <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Cara&nbsp;Bayar</label></td>
                                <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll('carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array('type' => 'POST',
                                        'url' => $this->createUrl('GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                        'update' => '#penjamin',  //selector to update
                                    ),
                                )) . '
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Penjamin</label></td>
                                <td>
                                    <div id="penjamin">
                                        <label> Data Tidak Ditemukan </label>
                                    </div>
                                </td>
                            </tr>
                        </table>'; ?>
                </fieldset>
            </td>
            <td>
                <div id='searching'>
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Ruangan Kasir &nbsp;<?php echo CHtml::checkBox('cek_ruangan', true, array('onchange'=>'cek_all_ruangan(this)','value'=>'cek_ruangan'));?></legend>
                        <?php echo '<table id="ruangan_tbl">
                            <tr>
                                <td>'.
                                $form->checkBoxList($model, 'ruangan_id', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)")).'
                                </td>
                            </tr>
                        </table>'; ?>
                    </fieldset>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
		 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
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
</script>