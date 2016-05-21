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
                    <legend class="rim">Berdasarkan Tanggal Pelayanan</legend>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::label('Tanggal Pelayanan', 'tgl_pelayanan', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
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
                            'htmlOptions' => array('readonly' => true,'class'=>'dtPicker3',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                    <?php echo CHtml::label('Sampai dengan', ' s/d', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
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
                            'htmlOptions' => array('readonly' => true,'class'=>'dtPicker3',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </fieldset>
            </td>
            <td>
                <fieldset class="box2">
                    <legend class="rim">Berdasarkan Dokter</legend>
                    <div class="controls">
                        <?php echo CHtml::activehiddenField($model, 'pegawai_id', array('readonly'=>true)); ?>
                        <?php echo CHtml::label('Nama Dokter', 'nama_dokter', array('class' => 'control-label', 'style'=>'text-align:center;')) ?>
                        <div class="controls">
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'BKLaporanpembebasantarifV[nama_pegawai]',
                                'value'=>$model->pegawai_id,
                                'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/GetDokterJenisKelamin'),
                                'options'=>array(
                                   'minLength' => 1,
                                   'select'=>'js:function( event, ui ){
                                               $("#BKLaporanpembebasantarifV_nama_pegawai").val(ui.item.value);
                                               $("#BKLaporanpembebasantarifV_pegawai_id").val(ui.item.pegawai_id);
                                                return false;
                                               }', 
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDokter','idTombol'=>'tombolDokterDialog'),
                                'htmlOptions'=>array('class'=>'span3', 
                                                    'placeholder'=>'Ketik Nama Dokter','onkeypress'=>"return $(this).focusNextInputField(event)"),
                            ));
                              ?>
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
    $pegawai = new DokterV('search');
    $pegawai->ruangan_id = Yii::app()->user->ruangan_id;
    if (isset($_GET['DokterV'])){
        $pegawai->attributes = $_GET['DokterV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pendaftaran-t-grid',
            'dataProvider'=>$pegawai->search(),
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
                                            $(\"#BKLaporanpembebasantarifV_nama_pegawai\").val(\"$data->gelardepan\"+\" \"+\"$data->nama_pegawai\"+\" \"+\"$data->gelarbelakang_nama\");

                                        "))',
                    ),
                    array(
                        'header' => 'Agama',
                        'name' => 'gelardepan',
                        'value' => '$data->gelardepan',
                        'filter' => CHtml::dropDownList('DokterV[gelardepan]', $pegawai->gelardepan, LookupM::getItems('gelardepan'),array('empty'=>'-- Pilih --'))
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        'header'=>'Nama Dokter',
                    ),                                
                     array(
                        'header' => 'Gelar Belakang',
                        'name' => 'gelarbelakang_nama',
                        'value' => '$data->gelarbelakang_nama',
                        'filter' => CHtml::dropDownList('DokterV[gelarbelakang_nama]', $pegawai->gelarbelakang_nama, CHtml::listData(GelarbelakangM::model()->findAll("gelarbelakang_aktif = true ORDER BY gelarbelakang_nama ASC"), 'gelarbelakang_nama', 'gelarbelakang_nama'),array('empty'=>'-- Pilih --'))
                    ),
                    array(
                        'header' => 'Jenis Kelamin',
                        'name' => 'jeniskelamin',
                        'value' => '$data->jeniskelamin',
                        'filter' => CHtml::dropDownList('DokterV[jeniskelamin]', $pegawai->jeniskelamin, LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --'))
                    ),
                    array(
                        'header' => 'Agama',
                        'name' => 'agama',
                        'value' => '$data->agama',
                        'filter' => CHtml::dropDownList('DokterV[agama]', $pegawai->agama, LookupM::getItems('agama'),array('empty'=>'-- Pilih --'))
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>