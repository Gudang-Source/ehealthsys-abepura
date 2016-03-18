<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>$idDialog,
    'options'=>array(
        'title'=>'Pencarian Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if(isset($_GET['PegawairuanganV'])){
        $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>$idTab,
        'dataProvider'=>$modPegawai->search(),
        'filter'=>$modPegawai,
        'template'=>"{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
                                "id"=>"selectPegawai",
                                "onClick"=>"return setPegawai(\''.$idDialog.'\',".$data->pegawai_id.", \'".$data->nama_pegawai."\'); return false;"
                        ))'
                ),

                array(
                    'name'=>'nama_pegawai',
                  'header'=>'Nama Pegawai',
                  'type'=>'raw',
                  'value'=>'$data->nama_pegawai',
                  'filter'=>Chtml::activeTextField($modPegawai, 'nama_pegawai'),
                ),
                'jeniskelamin',
                'nomorindukpegawai',
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>