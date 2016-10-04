<?php
    $modParamedis = new ParamedisV;
    $modParamedis->unsetAttributes();
    if(isset($_GET['ParamedisV'])){
        $modParamedis->attributes = $_GET['ParamedisV'];
    }
    echo CHtml::hiddenField('paramedisKe','',array('readonly'=>true));
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'paramedis-t-grid',
        'dataProvider'=>$modParamedis->searchParamedis(),
        'filter'=>$modParamedis,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputParamedis1($data->pegawai_id,
                                \'$data->nama_pegawai\');return false;"))',
            ),
            array(
                        'header' => 'NIP',
                        'name' => 'nomorindukpegawai',
                        'value' => '$data->nomorindukpegawai',
                        'filter' => Chtml::activeTextField($modParamedis,'nomorindukpegawai',array('class'=>'numbers-only'))
                    ),
                    array(
                        'header' => 'Nama Pegawai',
                        'name' => 'nama_pegawai',
                        'value' => '$data->NamaLengkap',
                        'filter' => Chtml::activeTextField($modParamedis,'nama_pegawai',array('class'=>'hurufs-only'))
                    ),
                    array(
                        'header' => 'Jabatan',
                        'name' => 'jabatan_id',
                        'value' => function($data){
                            $j = JabatanM::model()->findByPk($data->jabatan_id);

                            return (count($j)>0)?$j->jabatan_nama:'-';
                        },
                        'filter' => Chtml::activeDropDownList($modParamedis,'jabatan_id', Chtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --','class'=>'hurufs-only'))
                    ),  
                ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                . ' $(".numbers-only").keyup(function() {
                        setNumbersOnly(this);
                    });
                    $(".hurufs-only").keyup(function() {
                        setNumbersOnly(this);
                    });'
                . '}',
    )); 
?> 
    
