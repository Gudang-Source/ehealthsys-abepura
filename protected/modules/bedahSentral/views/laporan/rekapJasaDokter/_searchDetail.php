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

   label.checkbox, label.radio{
            width:150px;
            display:inline-block;
        }

    </style>
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
      <table>
            <tr>
                <td>
                    <div class="control-group ">
                    
                    <?php echo CHtml::hiddenField('filter_tab','filter_tab',array()); ?>
                    <?php echo CHtml::label('Periode Laporan','Tanggal Pencarian ', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'bulan',
                                array(
                                    'hari'=>'Hari Ini',
                                    'bulan'=>'Bulan',
                                    'tahun'=>'Tahun',
                                ),
                                array(
                                    'id'=>'PeriodeName',
                                    'onChange'=>'setPeriode()',
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
                                )
                                );
                        ?>
                        </div>
                    </div>
                </td>
                <td width="250px">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                    ?>
                </td>
                <td width="50px">s/d</td>
                <td>
                    <?php
                        $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3','onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group ">
                    <?php echo CHtml::label('Nama Dokter','namaDokter', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php 
                                echo $form->dropDownList($model,'pegawai_id', CHtml::listData(DokterpegawaiV::model()->findAll(), 'pegawai_id', 'nama_pegawai'), 
                                          array('empty'=>'-- Pilih --','style'=>'width:160px','onkeypress'=>"return nextFocus(this,event)")); 
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
  </table>

    <div class="form-actions">
        <?php
             echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), 
                     array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
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
<?php 
Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BSLaporantindakankomponenV_tgl_awal').val(data.periodeawal);
            $('#BSLaporantindakankomponenV_tgl_akhir').val(data.periodeakhir);
            $('#PPRuanganM_tgl_awal').val(data.periodeawal);
            $('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode',$js,CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event){
            var namaPeriode = $('#PeriodeName').val();

            if(namaPeriode == ''){
                myAlert('Pilih Kategori Pencarian');
                event.preventDefault();
                $('#dtPicker3').datepicker("hide");
                return true;
                ;
            }
        }
</script>


