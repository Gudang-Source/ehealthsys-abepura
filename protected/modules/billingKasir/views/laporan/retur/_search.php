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
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Tanggal Retur Pembayaran</legend>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class = 'control-label'>Tanggal Retur</div>
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
                    <div class="control-label">
                        <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                    </div>
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
                </fieldset>
            </td>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Ruangan</legend>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'ruangan_id', array('readonly'=>true)); ?>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label('Ruangan Retur','ruangan_id', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                        <?php
                            echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuangankasirItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --'));
                        ?>
                        </div>
                    </div>
                </fieldset>
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
</script>

<?php 
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter1',
    'options'=>array(
        'title'=>'Dokter Pemeriksa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));
?> 
<?php

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end pemeriksa dialog =============================
?> 

<?php 
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Data Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>540,
        'resizable'=>false,
    ),
));
    $pegawai = new DokterpegawaiV('searchByDokter');
    if (isset($_GET['DokterpegawaiV'])){
        $pegawai->attributes = $_GET['DokterpegawaiV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftaran-t-grid',
            'dataProvider'=>$pegawai->searchByDokter(),
            'filter'=>$pegawai,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#dialogDokter\").dialog(\"close\");
                                            $(\"#BKLaporanpembebasantarifV_pegawai_id\").val(\"$data->pegawai_id\");
                                            $(\"#BKLaporanpembebasantarifV_nama_pegawai\").val(\"$data->nama_pegawai\");

                                        "))',
                    ),
                    'gelardepan',
                    array(
                        'name'=>'nama_pegawai',
                        'header'=>'Nama Dokter',
                    ),
                    'gelarbelakang_nama',
                    'jeniskelamin',
                    'agama',
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>