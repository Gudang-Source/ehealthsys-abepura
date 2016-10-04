<?php 
    $modPelaksana = new SupirambulansV;
    $modPelaksana->unsetAttributes();
    $modPelaksana->ruangan_id = Params::RUANGAN_ID_AMBULANCE;
    if(isset($_GET['SupirambulansV'])){
        $modPelaksana->attributes = $_GET['SupirambulansV'];
        $modPelaksana->ruangan_id = Params::RUANGAN_ID_AMBULANCE;
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supir-t-grid',
        'dataProvider'=>$modPelaksana->searchSupirAmbulans(),
        'filter'=>$modPelaksana,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputPelaksana($data->pegawai_id,
                                 \'$data->nama_pegawai\');return false;"))',
            ),
            array(
                'header' => 'NIP',
                'name' => 'nomorindukpegawai',
                'value' => '$data->nomorindukpegawai',
                'filter' => Chtml::activeTextField($modPelaksana,'nomorindukpegawai',array('class'=>'numbers-only'))
            ),
            array(
                'header' => 'Nama Pegawai',
                'name' => 'nama_pegawai',
                'value' => '$data->NamaLengkap',
                'filter' => Chtml::activeTextField($modPelaksana,'nama_pegawai',array('class'=>'hurufs-only'))
            ),
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'value' => function($data){
                    $j = JabatanM::model()->findByPk($data->jabatan_id);
                    
                    return (count($j)>0)?$j->jabatan_nama:'-';
                },
                'filter' => Chtml::activeDropDownList($modPelaksana,'jabatan_id', Chtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --','class'=>'hurufs-only'))
            ),  
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . ' $(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });'
        . '}',
    )); 
?> 
