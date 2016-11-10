<legend class = "rim"><i class = "icon-search icon-white"></i> Pencarian</legend>
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
    <div class="row-fluid">
		<div class="span4">
                    <?php $format = new MyFormatter(); ?>
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::label('Periode Laporan', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                        </div> 

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls"> 
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div> 
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                 
                    </div>
        </div>
           
               <table width = "100%">     
        <tr>           
            <td>
                <div id='searching'>
                    <fieldset>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'dokter',
                                    'slide'=>false,
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                                    'content'=>array(
                                        'content3'=>array(
                                            'header'=>'Berdasarkan Dokter',
                                            'isi'=>'<table >
                                                        <tr>
                                                        <td >'.CHtml::hiddenField('namadokter')
                                                        .'<div class="input-append"><span class="add-on">'.$form->textField($model, 'nama_pegawai', array('id'=>'dokternama','data-offset-top'=>200,'data-spy'=>'affix','style'=>'margin-top:-3px; margin-left:-3px','inline'=>false, 
                                                        'class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event)",'sourceUrl'=> $this->createUrl('/ActionAutoComplete/DaftarAllDokter'),'placeholder'=>'Ketikan Nama Dokter')).'<a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
                                                    <i class="icon-list"></i>
                                                    <i class="icon-search">
                                                    </i>
                                                    </a>
                                                    </span>
                                                    </div></td></tr></table>',
                                            'active'=>true,
                                            ),
                                    ),
                                    'htmlOptions'=>array('class'=>'aw',)
                            ));
                        
                        
                        echo CHtml::hiddenField('idSupplier'); ?>
                            <?php 
//                            $this->widget('MyJuiAutoComplete',array(
//                                        'model'=>$model, 
////                                        'name'=>'namapegawai',
//                                        'attribute'=>'dokter_nama',
//                                        'id'=>'dokternama',
//                                        'value'=>$namapegawai,
//                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/getDokter'),
//                                        'options'=>array(
//                                           'showAnim'=>'fold',
//                                           'minLength' => 2,
//                                           'focus'=> 'js:function( event, ui ) {
//                                                $("#idSupplier").val( ui.item.pegawai_id);
//                                                $("#dokternama").val( ui.item.nama_pegawai );
//                                                $("#PPLaporankunjunganbydokterV_dokter_nama").val( ui.item.nama_pegawai );
//                                                return false;
//                                            }',
//                                           'select'=>'js:function( event, ui ) {
//                                                $("#idSupplier").val( ui.item.pegawai_id);
//                                                $("#namadokter").val( ui.item.pegawai_id);
//                                                return false;
//                                            }',
//
//                                        ),
//                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','placeholder'=>'Ketikan Nama Dokter'),
//                                        'tombolDialog'=>array('idDialog'=>'dialogDokter','idTombol'=>'tombolDokterDialog'),
//                                
//                            )); ?>
                    </fieldset>
                </div>
            </td>
        </tr>
    </table> 
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
		 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
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
    $(document).ready(function(){
        jQuery('#dokternama').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
        $("#idSupplier").val( ui.item.pegawai_id);
        $("#dokternama").val( ui.item.nama_pegawai );
        $("#BKLaporanpembebasantarifV_nama_pegawai").val( ui.item.nama_pegawai );
        return false;
        },'select':function( event, ui ) {
        $("#idSupplier").val( ui.item.pegawai_id);
        $("#namadokter").val( ui.item.pegawai_id);
        return false;
        },'source':'<?php echo $this->createUrl('/ActionAutoComplete/DaftarAllDokter'); ?>'}); 
    });
    function cek_all_ruangan(obj){
        if($(obj).is(':checked')){
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
</script>


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
                                            $(\"#dokternama\").val(\"$data->nama_pegawai\");

                                        "))',
                    ),          
                    array(
                        'header' => 'NIP',
                        'name' => 'nomorindukpegawai',
                    ),
                    array(
                        'name'=>'nama_pegawai',
                        'header'=>'Nama Dokter',
                        'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'
                    ),                    
                    array(
                        'header' => 'Jabatan',
                        'name' => 'jabatan_id',
                        'value' => function($data){
                            $j = JabatanM::model()->findByPk($data->jabatan_id);
                            
                            if (count($j)>0){
                                return $j->jabatan_nama;
                            }else{
                                return '-';
                            }
                        },
                        'filter' => Chtml::activeDropDownList($pegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),                        
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>