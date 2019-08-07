<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
//    'filter'=>$model,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'mergeColumns' => array('instalasi_nama'),
    'columns'=>array(
        array(
            'header' =>'No',
            'value' => '$row+1'
        ),
        array(
            'header'=>'Tgl Keanggotaan/ <br/>No Anggota',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTImeForUser(date("d/m/Y",strtotime($data->tglkeanggotaaan)))."/ <br>".$data->nokeanggotaan',
          //  'headerHtmlOptions'=>array('style'=>'color:#373E4A'),
            ),
            array(
                'header' => 'Nama Pegawai',
                'value'=>'$data->namaLengkap',
            ),
            array(
                'header' => 'Jenis Kelamin',
                'value'=>'$data->jeniskelamin',
            ),
            array(
                'header' => 'Alamat',
                'value'=>'$data->alamat_pegawai',
            ),
          
            array(
                    'header' => 'Golongan',
                    'value'=>'$data->golonganpegawai_nama',
            ),
            array(
                    'header' => 'Pangkat',
                    'value'=>'$data->pangkat_nama',
            ),
            array(
                    'header' => 'Jabatan',
                    'value'=>'$data->jabatan_nama',
            ),
            array(
                    'header'=>'Tanggal Berhenti',
                    'value'=>'empty($data->tglberhenti)?"-":MyFormatter::formatDateTimeForUser(date("d/m/Y",strtotime($data->tglberhenti)))'
            ),
        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 

