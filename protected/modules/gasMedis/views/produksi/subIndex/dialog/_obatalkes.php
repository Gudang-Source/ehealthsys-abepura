<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogGasMedis',
    'options' => array(
        'title' => 'Daftar Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));

$modGasMedis = new ObatalkesM();
$modGasMedis->unsetAttributes();
$modGasMedis->jenisobatalkes_id = Params::JENISOBATALKES_ID_GASMEDIS;
$format = new MyFormatter();
if (isset($_GET['ObatalkesM'])) {
    $modGasMedis->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gasmedis-m-grid',
    'dataProvider' => $modGasMedis->searchObatFarmasi(),
    'filter' => $modGasMedis,
    'template' => "{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"setGasMedis(".$data->obatalkes_id.",\'".$data->obatalkes_nama."\'); $(\'#dialogGasMedis\').dialog(\'close\'); return false;",
               ))'
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'name' => 'satuankecil_id',
            'header' => 'Satuan Kecil',
            'value' => '$data->satuankecil->satuankecil_nama',
            'filter' => CHtml::dropDownList('ObatalkesM[satuankecil_id]', $modGasMedis->satuankecil_id, CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif=TRUE ORDER BY satuankecil_nama'), 'satuankecil_id', 'satuankecil_nama'), array('empty'=>'-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>