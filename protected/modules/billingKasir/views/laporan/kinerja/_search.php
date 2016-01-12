<legend class="rim"><i class="icon-white icon-search"></i> Pencarian </legend>
<div class="search-form" style="">
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'searchLaporan',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
    <style>
        label.checkbox, label.radio{
                width:150px;
                display:inline-block;
            }
    </style>
    <table>
        <tr>
            <td>
                Tanggal Masuk Penunjang <?php echo $form->dropDownList($model,'bulan',
                        array(
                            'hari'=>'Hari Ini',
                            'bulan'=>'Bulan',
                            'tahun'=>'Tahun',
                        ),
                        array(
                            'empty'=>'--Pilih--',
                            'id'=>'PeriodeName',
                            'onChange'=>'setPeriode()',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;',
                        )
                        );
                    ?>
            </td>
            <td width="250px">
                <?php echo CHtml::hiddenField('filter_tab', 'kelas'); ?>
                <?php
                $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
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
                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                ?>
            </td>
            <td width="50px">s/d</td>
            <td>
                <?php
                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
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
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                ?>
            </td>
            <td>
                <div id="search_kelas">
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <div class="control-label"> Kelas Pelayanan </div>
                                    <div class="controls">
                                        <?php
                                            echo $form->dropDownList($model,'kelaspelayanan_id',CHtml::listData(KelaspelayananM::model()->findAll(),'kelaspelayanan_id','kelaspelayanan_nama'),array('empty'=>'--Pilih--','style'=>'width:140px'));
                                        ?>
                                    </div>
                                </div> 
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="search_bangsal">
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <div class="control-label"> Ruang Penunjang</div>
                                    <div class="controls">
                                        <?php
                                            echo $form->dropDownList($model,'ruanganpenunj_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('empty'=>'--Pilih--','style'=>'width:140px'));
                                        ?>
                                    </div>
                                </div>                    
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl('laporan/LaporanKinerjaPerBangsal'), array('class'=>'btn btn-danger','onKeypress'=>'return formSubmit(this,event)')); ?>
    </div> 
</div>    
<?php
    $this->endWidget();
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai ?>
<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#content4").find("input[type=\'checkbox\']").attr("checked", "checked");
',  CClientScript::POS_READY);
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BKLaporankinerjapenunjangV_tgl_awal').val(data.periodeawal);
            $('#BKLaporankinerjapenunjangV_tgl_akhir').val(data.periodeakhir);
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


