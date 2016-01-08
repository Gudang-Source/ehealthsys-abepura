<div class="search-form" style="">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
        #jeniss label.checkbox{
            width: 100px;
            display:inline-block;
        }
    </style>
    <table width="100%">
        <tr>
            <td class="row-fluid">
                <div class="span6">
                    <fieldset class="box2">
                        <legend class="rim">Berdasarkan Kunjungan</legend>
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php //echo CHtml::hiddenField('src', ''); ?>
                        <div class = 'control-label'>Tanggal Kunjungan</div>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'maxDate'=>'d',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                'class'=>'dtPicker2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div> 
                        <?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
                        <div class="controls">  
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'maxDate'=>'d',
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true,
                                'class'=>'dtPicker2',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                            ));
                            ?>
                        </div> 
                    </fieldset>
                </div>
                <div class="span6" id='searching'>
                    <fieldset class="box2">
                        <legend class="rim">Grafik Kunjungan</legend>   
                        <?php echo '<table width=100%>
                                                        <tr>
                                                        <td>' .
                        $form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>';
                        ?>
                    </fieldset>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="row-fluid" id='searching'>
                    <fieldset class="span4">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
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
                                                        <i class="icon-list-alt"></i>
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
                    <fieldset class="span4">
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
                    <fieldset class="span4">
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'big',
//                                    'parent'=>false,
//                                    'disabled'=>true,
//                                    'accordion'=>false, //default
                            'content' => array(
                                'content3' => array(
                                    'header' => 'Berdasarkan Nama Pemeriksaan',
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
                                                        <i class="icon-list-alt"></i>
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
            'name' => 'jenispemeriksaanlab_nama',
            'value' => '$data->jenispemeriksaan->jenispemeriksaanlab_nama',
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