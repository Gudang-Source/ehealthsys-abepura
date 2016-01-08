<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
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
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php //echo CHtml::hiddenField('src', ''); ?>
                <?php echo CHtml::label('Tanggal Resep', 'tgl_awal', array('class'=>'control-label')); ?>
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
            </td>
            <td> <?php echo CHtml::label('Sampai dengan', ' tgl_akhir', array('class' => 'control-label')) ?>
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
<!--                <div class="control-group">
                    <?php //echo $form->labelEx($model, 'nama_pasien', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php //echo $form->textField($model, 'nama_pasien', array('class'=>'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php //echo $form->labelEx($model, 'noresep', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php //echo $form->textField($model, 'noresep', array('class'=>'span2')); ?>
                    </div>
                </div>-->
            </td>
            <td>
                <div class="control-group">  
                    <?php echo $form->labelEx($model,'pegawai_id', array('class'=>'control-label')); ?> 
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model,'pegawai_id'); ?>
                        <?php //echo CHtml::hiddenField('ygmengajukan_id'); ?>
                            <div style="float:left;">
                                <?php
                                    $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model,
                                        'attribute'=>'dokter',
                                        'sourceUrl'=>  Yii::app()->createUrl('farmasiApotek/laporanFarmasi/listPegawai'),
                                        'options'=>array(
                                            'showAnim'=>'fold',
                                            'minLength'=>2,
                                            'select'=>'js:function( event, ui ) {
                                                    $("#FAPenjualanResepT_pegawai_id").val(ui.item.pegawai_id);
                                                    $("#FAPenjualanResepT_dokter").val(ui.item.nama_pegawai);
                                            }',
                                        ),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'float:left;')
                                    ));
                                ?>
                            </div>
                    </div>          
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()'));
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
        myConfirm("Apakah anda ingin me-refresh halaman?","Perhatian!",
        function(r){
            if(r){
                window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanJasaRacikan', array('modul_id'=>Yii::app()->session['modul_id'])).'";
            }
        }); 
    }', CClientScript::POS_HEAD); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if(isset($_GET['PegawaiM'])){
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modPegawai->search(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($model,'dokter').'\").val(\"$data->nama_pegawai\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        'gelardepan',
        'nama_pegawai',
        'jeniskelamin',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>