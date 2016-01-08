<?php 
    if(($tab)!='luar'){ 
        $model=$modelRS;
    }
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
        $template = "{summary}\n{items}\n{pager}";
    }
    ?>
<div id="div_rujukanLuar">
    <?php
        if(isset($caraPrint)){
       
        }else{
       ?>
            <legend class="rim">Tabel Pemeriksaan Rujukan - Dari Luar</legend>
       <?php } ?>
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'tableRujukanLuar',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'mergeColumns' => array(
                'no',
                'no_pendaftaran',
            ),            
            'columns'=>array(
                array(
                    'header' => '<center>No.</center>',
                    'name'=>'no',
                    'type'=>'raw',
                    'value' => $row,
                    'htmlOptions'=>array('style'=>'text-align:center'),
                    /*
                    'footerHtmlOptions'=>array('colspan'=>5,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                     * 
                     */
                ),
                array(
                    'header' => '<center>No. Pendaftaran Lab</center>',
                    'name'=>'no_pendaftaran',
                    'type'=>'raw',
                    'value' => '$data->no_pendaftaran'
                ),
                array(
                    'header' => '<center>Tanggal</center>',
                    'type'=>'raw',
					'value'=>'date("d/m/Y H:i:s", strtotime($data->tglmasukpenunjang))',
                ),
                array(
                    'header' => '<center>Kode</center>',
                    'type'=>'raw',
                    'value' => '$data->daftartindakan_kode'
                ),
                array(
                    'header' => '<center>Jenis Pemeriksaan</center>',
                    'type'=>'raw',
                    'value' => '$data->daftartindakan_nama'
                ),
                array(
                    'header' => '<center>Tarif</center>',
                    'name'=>'tarif_satuan',
                    'type'=>'raw',
                    'value' => 'number_format($data->tarif_satuan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right'),
                    /*
                    'footerHtmlOptions'=>array('style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'sum(tarif_satuan)',
                     * 
                     */
                ),
            ),
        )); ?> 
</div>