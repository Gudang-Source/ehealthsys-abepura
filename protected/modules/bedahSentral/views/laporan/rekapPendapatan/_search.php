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
    <legend class="rim"><i class="icon-search"></i> Pencarian Berdasarkan : </legend>
    <table>
        <tr>
            <td>
                   Tanggal Kunjungan <?php echo $form->dropDownList($model,'bulan',
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
                array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
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
<?php 
//$urlGetPenjamin = Yii::app()->createUrl('ActionDynamic/GetPenjaminPasienForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().''));
//Yii::app()->clientScript->registerScript('ajax','
//    $("#'.CHtml::activeId($model, 'carabayar_id').'").change(function(){
//        id = $(this).val();
//        $.post("'.$urlGetPenjamin.'", {id:id},function(data){
//            
//        });
//    });
//',CClientScript::POS_READY); ?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>

<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
    
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#BSTindakandanoasudahbayarV_tgl_awal').val(data.periodeawal);
            $('#BSTindakandanoasudahbayarV_tgl_akhir').val(data.periodeakhir);
            $('#PPRuanganM_tgl_awal').val(data.periodeawal);
            $('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
//            if(data.namaPeriode == 1 ){
//                myAlert("Pencarian Berdasarkan : "+data.namaPeriode);
//            }
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
