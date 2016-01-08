<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $dataProvider = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        
        echo $this->renderPartial('application.views.headerReport.headerLaporan',
            array(
                'judulLaporan'=>$data['judulLaporan'],
                'periode'=>$data['periode']
            )
        );        
    } else{
        $dataProvider = $model->searchPasien();
        $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableLaporanCaraBayar',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeColumns' => array('penjamin_nama'),
            'columns'=>array(
                array(
                  'header'=>'No',
                  'type'=>'raw',
                  'value'=>'$row+1',
                ),
                'penjamin_nama',
                array(
                  'header'=>'Reg. No',
                  'type'=>'raw',
                  'value'=>'$data->no_pendaftaran',
                ),
                array(
                  'header'=>'Tanggal Reg',
                  'type'=>'raw',
                  'value'=>'date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran))',
                ),
                array(
                  'header'=>'Nama Lengkap',
                  'type'=>'raw',
                  'value'=>'$data->nama_pasien',
                ),
                array(
                  'header'=>'Alamat',
                  'type'=>'raw',
                  'value'=>'$data->alamat_pasien',
                ),
                array(
                  'header'=>'Cara Masuk',
                  'type'=>'raw',
                  'value'=>'$data->statusmasuk',
                ),
                array(
                  'header'=>'Instalasi',
                  'type'=>'raw',
                  'value'=>'$data->instalasi_nama',
                ),
                array(
                  'header'=>'Unit Pelayanan',
                  'type'=>'raw',
                  'value'=>'$data->ruangan_nama',
                ),
                array(
                  'header'=>'Nama Dokter',
                  'type'=>'raw',
                  'value'=>'$data->getNamaDokter()',
                ),
                array(
                  'header'=>'Tanggal Keluar',
                  'type'=>'raw',
                  'value'=>'$data->getTglKeluar()',
                ),                
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );