<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
        #jeniss label.checkbox{
            width: 100px;
            display:inline-block;
        }
    </style>
    <div class="row-fluid">
        <div class="span4">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::label('Periode Laporan', 'tgladmisi', array('class' => 'control-label')) ?>
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
    </div>  
    <table width="100%">
        <tr>
            <td>        
                <div id='searching'>
                    <fieldset >
                         <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big4',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content6' => array(
                                    'header' => 'Berdasarkan Kunjungan',
                                    'isi' => '<table>
                                                            <tr>
                                                            <td>' .$form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>',
                                    'active' => true,
                                ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                      
                    </fieldset>
                </div>
            </td>
            <td>
                 <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content2' => array(
                                    'header' => 'Berdasarkan Cara Bayar',
                                    'isi' => '<table><tr>
                                                        <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Cara Bayar</label></td>
                                                        <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'ajax' => array('type' => 'POST',
                                            'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                                        ),
                                    )) . '</td>
                                                            </tr><tr>
                                                        <td><label>Penjamin</label></td><td>' .
                                    $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '</td></tr></table>',
                                    'active' => true,
                                ),
                            ),
                        ));
                        ?>
                    </fieldset>
            </td>
        </tr>
        <tr>
            <td>
                <div class="row-fluid" id='searching'>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big1',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content1' => array(
                                    'header' => 'Berdasarkan Jenis Pemeriksaan',
                                    'isi' => '<table>
                                                            <tr>
                                                            <td>' . CHtml::hiddenField('idJenisPemeriksaan')
                                    . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'jenispemeriksaanlab_nama', array('id' => 'jenispemeriksaanlab', 'data-offset-top' => 200,
                                        'data-spy' => 'affix', 'style' => 'margin-top:-3px; margin-left:-3px',
                                        'inline' => false,
                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/JenisPemeriksaanlab'),
                                        'placeholder' => 'Ketikan Jenis Pemeriksaan Lab'))
                                    . '<a href="javascript:void(0);" id="tombolJenisPemeriksaanLab" 
                                                                    onclick="$(&quot;#dialogJenisPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                                                        <i class="icon-list"></i>
                                                        <i class="icon-search">
                                                        </i>
                                                        </a>
                                                        </span>
                                                        </div></td></tr></table>',
                                    'active' => true,
                                ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>
                </td>
                <td>
                    <fieldset>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big2',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content3' => array(
                                    'header' => 'Berdasarkan Pemeriksaan',
                                    'isi' => '<table>
                                                            <tr>
                                                            <td>' . CHtml::hiddenField('idPemeriksaan')
                                    . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'pemeriksaanlab_nama', array('id' => 'pemeriksaanlab', 'data-offset-top' => 200,
                                        'data-spy' => 'affix', 'style' => 'margin-top:-3px; margin-left:-3px',
                                        'inline' => false,
                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pemeriksaanlab'),
                                        'placeholder' => 'Ketikan Nama Pemeriksaan Lab'))
                                    . '<a href="javascript:void(0);" id="tombolPemeriksaanLab" 
                                                                    onclick="$(&quot;#dialogPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                                                        <i class="icon-list"></i>
                                                        <i class="icon-search">
                                                        </i>
                                                        </a>
                                                        </span>
                                                        </div></td></tr></table>',
                                    'active' => true,
                                ),
                            ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>
                    </fieldset>
                </div>
            </td>
        </tr>
        <tr>
           <td>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'big',
                            'slide'=>true,
                            'content'=>array(
                                    'content7'=>array(
                                    'header'=>'Berdasarkan Instalasi dan Ruangan',
                                    'isi'=>'<table>
                                                            <tr>
                                                                    <td>'.CHtml::hiddenField('filter', 'carabayar', array('disabled'=>'disabled')).'<label>Instalasi</label></td>
                                                                    <td>'.$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                            'ajax' => array('type' => 'POST',
                                                                                    'url' => $this->createUrl('/ActionDynamic/GetRuanganAslForCheckBox/', array('encode' => false, 'namaModel' => ''.get_class($model).'')),
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
                                                                            <div margin id="ruangan">
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
           </td>
      
               <td>
                   <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'kunjungan5',
                        'slide'=>false,
                        'content'=>array(
                        'content5'=>array(
                            'header'=>'Data grafik',
                            'isi'=>  '<table>
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', true, array('name'=>'dataGrafik', 'value' => 'kunjungan')).' <label>Kunjungan</label></td>                                               
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'carabayar')).' <label>Cara Bayar</label></td>                                                                                           
                                        </tr>                                            
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'jenispemeriksaan')).' <label>Jenis Pemeriksaan</label></td>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'pemeriksaan')).' <label>Pemeriksaan</label></td>
                                        </tr>
                                        <tr>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'instalasiasal')).' <label>Instalasi asal</label></td>
                                            <td>'.CHtml::radioButton('tampilGrafik', false, array('name'=>'dataGrafik', 'value' => 'ruanganasal')).' <label>Ruangan Asal</label></td>
                                        </tr>
                                    </table>',          
                            'active'=>TRUE,
                                ),
                        ),
    //                                    'htmlOptions'=>array('class'=>'aw',)
                        )); ?>	
               </td>
           </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
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

<?php
/**
 * Dialog untuk Jenis Pemeriksaan Lab
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisPemeriksaanLab',
    'options' => array(
        'title' => 'Daftar Jenis Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => true,
    ),
));

$modJenisPemeriksaan = new JenispemeriksaanlabM;
$modJenisPemeriksaan->unsetAttributes();
if (isset($_GET['JenispemeriksaanlabM'])) {
    $modJenisPemeriksaan->attributes = $_GET['JenispemeriksaanlabM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenispemeriksaan-m-grid',
    'dataProvider' => $modJenisPemeriksaan->search(),
    'filter' => $modJenisPemeriksaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idJenisPemeriksaan\").val(\"$data->jenispemeriksaanlab_id\");
                                                      $(\"#jenispemeriksaanlab\").val(\"$data->jenispemeriksaanlab_nama\");
                                                      $(\"#dialogJenisPemeriksaanLab\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
//                array(
//                    'header'=>'ID',
//                    'filter'=>false,
//                    'value'=>'$data->jenispemeriksaanlab_id',
//                ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_nama',
            'value' => '$data->jenispemeriksaanlab_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog untuk Nama Pemeriksaan Lab
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPemeriksaanLab',
    'options' => array(
        'title' => 'Daftar Nama Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => true,
    ),
));

$modPemeriksaan = new PemeriksaanlabM;
$modPemeriksaan->unsetAttributes();
if (isset($_GET['PemeriksaanlabM'])) {
    $modPemeriksaan->attributes = $_GET['PemeriksaanlabM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pemeriksaan-m-grid',
    'dataProvider' => $modPemeriksaan->search(),
    'filter' => $modPemeriksaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idPemeriksaan\").val(\"$data->pemeriksaanlab_id\");
                                                      $(\"#pemeriksaanlab\").val(\"$data->pemeriksaanlab_nama\");
                                                      $(\"#dialogPemeriksaanLab\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
//                array(
//                    'header'=>'ID',
//                    'filter'=>false,
//                    'value'=>'$data->pemeriksaanlab_id',
//                ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_id',
            'value' => '$data->jenispemeriksaan->jenispemeriksaanlab_nama',
            'filter' => Chtml::activeDropDownList($modPemeriksaan, 'jenispemeriksaanlab_id', Chtml::listData(LBJenisPemeriksaanLabM::model()->findAll(" jenispemeriksaanlab_aktif = TRUE ORDER BY jenispemeriksaanlab_nama ASC "), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty'=>'-- Pilih --'))
        ),
        array(
            'header' => 'Kode Pemeriksaan',
            'name' => 'pemeriksaanlab_kode',
            'value' => '$data->pemeriksaanlab_kode',
        ),
        array(
            'header' => 'Nama Pemeriksaan',
            'name' => 'pemeriksaanlab_nama',
            'value' => '$data->pemeriksaanlab_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script>
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#searchLaporan input[name*="ruanganasal_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#searchLaporan input[name*="ruanganasal_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>