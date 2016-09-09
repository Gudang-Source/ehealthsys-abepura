<legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
    ?>
    <style>
        table{
            margin-bottom: 0px;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        #ruangan label{
            width: 120px;
            display:inline-block;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
    </style>
 <div class="row-fluid">
    <div class="span4">
        <?php echo CHtml::label('Kunjungan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
        </div>
    </div>
    <div class="span4">
        <div class='control-group hari'>
            <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <?php $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal)))); ?>
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
                <?php $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal)))); ?>
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
                <?php $model->bln_awal = $format->formatMonthForDb(date('Y-m', (strtotime($model->bln_awal)))); ?>
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
                <?php $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir)))); ?>
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
                <?php $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir)))); ?>
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
                <?php $model->bln_akhir = $format->formatMonthForDb(date('Y-m', (strtotime($model->bln_akhir)))); ?>
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
</div>
    <table width="100%">
        <tr>
            <td>
                <div id='searching'>
                    <fieldset>
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                    'id'=>'big',
                                    'slide'=>false,
                                    'content'=>array(
                                        'content2'=>array(
                                        'header'=>'Berdasarkan Instalasi dan Ruangan',
                                        'isi'=>'<table>
                                                    <tr>
                                                        <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
                                                        <td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'ajax' => array('type' => 'POST',
                                                                'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
                                                                'update' => '#ruangan',  //selector to update
                                                            ),
                                                        )).'
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label>Ruangan</label>
                                                        </td>
                                                        <td>
                                                            <div id="ruangan">
                                                                <label>Data Tidak Ditemukan</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                 </table>',
                                         'active'=>true
                                        ),
                                    ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
                            )); ?>
                    </fieldset>
                </div>
            </td>
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
                                            'header'=>'Berdasarkan Dokter Pemeriksa',
                                            'isi'=>'<table >
                                                        <tr>
                                                        <td >'.CHtml::hiddenField('namadokter')
                                                        .'<div class="input-append"><span class="add-on">'.$form->textField($model, 'dokter_nama', array('id'=>'dokternama','data-offset-top'=>200,'data-spy'=>'affix','style'=>'margin-top:-3px; margin-left:-3px','inline'=>false, 
                                                        'onkeypress' => "return $(this).focusNextInputField(event)",'sourceUrl'=> $this->createUrl('getDokter'),'placeholder'=>'Ketikan Nama Dokter')).'<a href="javascript:void(0);" id="tombolDokterDialog" onclick="$(&quot;#dialogDokter&quot;).dialog(&quot;open&quot;);return false;">
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
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
		<?php
 echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                        array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll','
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

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
/**
 * Dialog untuk nama Supplier
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Daftar Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDokter = new PPDokterpegawaiV;
if(isset($_GET['PPDokterpegawaiV'])){
    $modDokter->attributes = $_GET['PPDokterpegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawai-m-grid',
	'dataProvider'=>$modDokter->search(),
	'filter'=>$modDokter,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idDokter\").val(\"$data->pegawai_id\");
                                                      $(\"#dokternama\").val(\"$data->nama_pegawai\");
                                                      $(\"#dialogDokter\").dialog(\"close\");    
                                                      return false;
                                            "))',
                    ),
                array(
                    'header' => 'NIP',
                    'name' => 'nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class'=>'numbers-only'))
                ),
                array(
                    'header' => 'Dokter',
                    'name' => 'nama_pegawai',
                    'value' => '$data->namaLengkap',
                    'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class'=>'hurufs-only'))
                ),
                array(
                    'header' => 'Jabatan',
                    'name' => 'pegawai_id',
                    'value' => function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                        
                        if (count($j)>0){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    },
                    'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', CHtml ::listData(JabatanM ::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
                ),
               
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
    . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
    . '}',
));

$this->endWidget();
?>

<script>
    $(document).ready(function(){
    jQuery('#dokternama').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
$("#idSupplier").val( ui.item.pegawai_id);
$("#dokternama").val( ui.item.nama_pegawai );
$("#PPLaporankunjunganbydokterV_dokter_nama").val( ui.item.nama_pegawai );
return false;
},'select':function( event, ui ) {
$("#idSupplier").val( ui.item.pegawai_id);
$("#namadokter").val( ui.item.pegawai_id);
return false;
},'source':'<?php echo (Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_REKAM_MEDIS)?$this->createUrl('/rekamMedis/Laporan/getDokter'):$this->createUrl('/pendaftaranPenjadwalan/Laporan/getDokter'); ?>'}); 
    });
    </script>