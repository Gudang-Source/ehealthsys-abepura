<div class="search-form" style="">
    <?php
    $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        #penjamin, #ruangan{
            width:650px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <table width="100%">
        <tr>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Tanggal Penjualan</legend>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php //echo CHtml::hiddenField('src', ''); ?>
                    <div class = 'control-label'>Tanggal Penjualan</div>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
    //                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
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
    //                                         'maxdate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </fieldset>
            </td>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Jenis Obat </legend>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'jenisobatalkes_id', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <div id="penjamin">
                                <?php echo CHtml::checkBox('pilihSemua', true, array('onclick'=>'checkAll();')) ?> <label><b>Pilih Semua</b></label><br>
                                <?php echo $form->checkBoxList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('autofocus'=>true, 'class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
        ?> 
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPenjualanJenisoa', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD); ?>
<script>
    function checkAll(){
        if($('#pilihSemua').is(':checked')){
            $('#penjamin').each(function(){
                $(this).find('input').attr('checked',true);
            });
        }else{
            $('#penjamin').each(function(){
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAll();
</script>