<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>$idDialog,
    'options'=>array(
        'title'=>'Pencarian Pegawai Mengetahui',
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
        $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>$idTab,
        'dataProvider'=>$modPegawai->pegawaiMengetahui(),
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
                    'header' => 'NIP',
                    'name' => 'nomorindukpegawai'
                ),
                array(
                  'name'=>'nama_pegawai',
                  'header'=>'Nama Pegawai',
                  'type'=>'raw',
                  'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                  'filter'=>Chtml::activeTextField($modPegawai, 'nama_pegawai'),
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
                    'filter' => CHtml::dropDownList('PegawairuanganV[jabatan_id]', $modPegawai->jabatan_id, CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = true ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --'))
                ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();
?>