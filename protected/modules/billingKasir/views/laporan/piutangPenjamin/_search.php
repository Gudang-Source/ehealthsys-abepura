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
                    <?php echo CHtml::hiddenField('filter_tab', 'penjamin'); ?>
      <table width="100%">
            <tr>
            <td>
                Tanggal Pembayaran <?php echo $form->dropDownList($model,'bulan',
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
            <td>
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
  </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), 
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl('laporan/LaporanRekapPiutang'), array('class'=>'btn btn-danger','onKeypress'=>'return formSubmit(this,event)')); ?>
    </div>
</div>    
<?php $this->endWidget();
      $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
      $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY); ?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BKLaporanrekappendapatanV_tgl_awal').val(data.periodeawal);
            $('#BKLaporanrekappendapatanV_tgl_akhir').val(data.periodeakhir);
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


