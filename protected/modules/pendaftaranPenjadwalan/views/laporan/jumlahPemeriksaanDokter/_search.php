
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchInfoKunjungan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    $format = new MyFormatter();
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
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="row-fluid">
            <div class="span4">
                <?php echo CHtml::label('Kunjungan', 'tglmasukpenunjang', array('class' => 'control-label')) ?>
                <?php echo CHtml::hiddenField('type','',array()); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('class'=>'span2', 'onchange'=>'ubahJnsPeriode();')); ?>
                </div>
            </div>
            <div class="span4">
                <div class='control-group hari'>
                    <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d',strtotime($model->tgl_awal))); ?>                     
                       <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal).' 00:00:00'; ?>                     
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
                                'options'=>array(
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
                        echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class='control-group hari'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d',strtotime($model->tgl_akhir))); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions' => array('readonly' => true,'class' => "span2",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir).' 23:59:59'; ?>
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
                                'options'=>array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,'class' => "span2",
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
                        echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                        ?>
                    </div>
                </div>
            </div> 
        </div>

    <table width="100%" border="0">
        <tr>
            
            <td> <div id='searching'>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'dokter',
                            'slide' => false,
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content3' => array(
                                    'header' => 'Berdasarkan Dokter Pemeriksa',
                                    'isi' => $form->dropDownListRow($model, 'dokter_id', 
                                            CHtml::listData(DokterV::model()->findAll('pegawai_aktif = true  order by nama_pegawai asc'), 'pegawai_id', 'namaLengkap'),
                                            array('empty'=>'-- Pilih --')),
                                    'active' => true,
                                ),
                            ),
                            'htmlOptions' => array('class' => 'aw',)
                        ));


                        echo CHtml::hiddenField('idSupplier');
                        ?>
                        
                    </fieldset>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
                            'slide' => false,
                            'content' => array(
                                'content2' => array(
                                    'header' => 'Berdasarkan Penjamin',
                                    'isi' => CHtml::hiddenField('filter', 'penjamin', array('disabled' => 'disabled')) .
                                             $form->dropDownListRow($model, 'penjamin_id', 
                                                     CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true'), 'penjamin_id', 'penjamin_nama'), 
                                                     array('empty' => '-- Pilih --')),
                                    'active' => true
                                ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>
                </div></td>
                <td><div id='searching'>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
                            'slide' => false,
                            'content' => array(
                                'content2' => array(
                                    'header' => 'Berdasarkan Instalasi dan Ruangan',
                                    'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . 
                                                        $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true and revenuecenter = true order by instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array('type' => 'POST',
                                            'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganForCheckBox', array('encode' => false, 'namaModel' => '' . get_class($model) . '')),
                                            'update' => '#ruangan', //selector to update
                                        ),
                                    )) . '
                                        <div class="control-group">
                                            <label class="control-label">Ruangan</label>
                                            <div id="ruangan" class="controls">
                                                <label>Data Tidak Ditemukan</label>
                                            </div>
                                        </td>',
                                    'active' => true
                                ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>

                </div>
            </td>
        </tr>
    </table>

    <div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'))
    ." ".CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
?>
    </div>
<?php //$this->widget('TipsMasterData', array('type' => 'create')); ?>    
   
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('idPendaftaran' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>
</fieldset> 

<?php
//Yii::app()->clientScript->registerScript('onclickButton','
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modDokter = new PPDokterpegawaiV;
if (isset($_GET['PPDokterpegawaiV'])) {
    $modDokter->attributes = $_GET['PPDokterpegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modDokter->search(),
    'filter' => $modDokter,
    'template' => "{pager}{summary}\n{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
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
            'filter' => false,
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Dokter',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Alamat',
            'name' => 'alamat_pegawai',
            'value' => '$data->alamat_pegawai',
        ),
        array(
            'header' => 'Tempat,' . "<br/>" . 'Tanggal Lahir',
            'type' => 'raw',
            'name' => 'tempatlahir_pegawai',
            'value' => '$data->tempatlahir_pegawai.","."<br/>".$data->tgl_lahirpegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$urlPeriode = Yii::app()->createUrl('actionAjax/GantiPeriode');
$js = <<< JSCRIPT

function setPeriode(){
    namaPeriode = $('#PeriodeName').val();
        $.post('${urlPeriode}',{namaPeriode:namaPeriode},function(data){
            $('#PPLaporanJumlahPemeriksaanDokterV_tglAwal').val(data.periodeawal_b);
            $('#PPLaporanJumlahPemeriksaanDokterV_tglAkhir').val(data.periodeakhir_b);
        },'json');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('setPeriode',$js,CClientScript::POS_HEAD);
?>
<script>
    function checkPilihan(event){
            var namaPeriode = $('#PeriodeName').val();

            if(namaPeriode == ''){
                alert('Pilih Kategori Pencarian');
                event.preventDefault();
                $('#dtPicker3').datepicker("hide");
                return true;
                ;
            }
        }
    $(document).ready(function() {
        jQuery('#dokternama').autocomplete({'showAnim': 'fold', 'minLength': 2, 'focus': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#dokternama").val(ui.item.nama_pegawai);
                $("#PPLaporankunjunganbydokterV_dokter_nama").val(ui.item.nama_pegawai);
                return false;
            }, 'select': function(event, ui) {
                $("#idSupplier").val(ui.item.pegawai_id);
                $("#namadokter").val(ui.item.pegawai_id);
                return false;
            }, 'source': '/simrs/index.php?r=ActionAutoComplete/getDokter'});
    });
</script>
<script>
    function checkAll() {
        if ($("#checkAllRuangan").is(":checked")) {
            $('#ruangan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            })
//        alert('Checked');
        } else {
            $('#ruangan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
    }
</script>