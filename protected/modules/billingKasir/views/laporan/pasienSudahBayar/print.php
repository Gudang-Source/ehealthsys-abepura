<?php
if (isset($data['caraPrint'])){
    $pagination = false;
    if($data['caraPrint'] == 'EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
        $headerDefault = "";
    }
    
    if($data['caraPrint'] == 'PDF'){
        $headerDefault = $this->renderPartial('application.views.headerReport.headerLaporan', array('width'=>1024));
    }
    
    if($data['caraPrint'] == 'PRINT'){
        $headerDefault = $this->renderPartial('application.views.headerReport.headerLaporan');
    }
}else{
    $pagination = true;
}
?>
<table>
    <tr>
        <td><?php echo $headerDefault; ?></td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px;">
            <div><b><?php echo $data['judulLaporan']; ?></b></div>
            <div>Periode : <?php echo date("d-m-Y", strtotime($model->tgl_awal)); ?> s/d <?php echo date("d-m-Y", strtotime($model->tgl_akhir)); ?></div>
        </td>
    </tr>
    <tr>
        <td>
            <?php
                $dataProvider = null;
                if($data['filter'] == 'all')
                {
                    $dataProvider = $model->searchPrintPasienSudahBayar();
                }
                else if($data['filter'] == 'p3')
                {
                    $dataProvider = $model->searchPrintPasienBerdasarkanPenjamin();
                }
                else if($data['filter'] == 'umum')
                {
                    $dataProvider = $model->searchPrintPasienBerdasarkanUmum();
                }

                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id'=>'semua_pencarianpasien_grid',
                    'dataProvider'=>$dataProvider,
                    'template'=>"{items}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                            'header'=>'No',
                            'name'=>'tglbuktibayar',
                            'type'=>'raw',
                            'value'=>'$row+1',
                            'footerHtmlOptions'=>array('colspan'=>13, 'style'=>'text-align:right;font-style:italic;'),
                            'footer'=>'Jumlah Total',                            
                        ),
                        array(
                            'header'=>'Tanggal Bukti Bayar / No. Bukti Bayar',
                            'name'=>'tglbuktibayar',
                            'type'=>'raw',
                            'value'=>'(isset($data->tandabuktibayar->tandabuktibayar_id)?date("d/m/Y H:i:s",strtotime($data->tandabuktibayar->tglbuktibayar)):"-")."<br>".(isset($data->tandabuktibayar->tandabuktibayar_id)?$data->tandabuktibayar->nobuktibayar:"")',
                        ),
                        array(
                            'name'=>'instalasi',
                            'type'=>'raw',
                            'value'=>'(isset($data->pendaftaran->pendaftaran_id)?$data->pendaftaran->instalasi->instalasi_nama:"-")',
                        ),
                        array(
                            'header'=>'No. Pendaftaran / No. Rekam Medik',
                            'value'=>'(isset($data->pendaftaran->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:"-")." / ".(isset($data->pasien->pasien_id)?$data->pasien->no_rekam_medik:"-")',
                        ),
                        array(
                            'name'=>'nama_pasien',
                            'type'=>'raw',
                            'value'=>'$data->pasien->nama_pasien." / ".$data->pasien->nama_bin',
                        ),
                        array(
                            'name'=>'alamat_pasien',
                            'type'=>'raw',
                            'value'=>'$data->pasien->alamat_pasien',
                        ),
                        array(
                            'header'=>'Cara Bayar | Penjamin',
                            'name'=>'carabayar_nama',
                            'type'=>'raw',
                            'value'=>'(isset($data->pendaftaran->pendaftaran_id)?$data->pendaftaran->carabayar->carabayar_nama:"")."<br>".(isset($data->pendaftaran->pendafataran_id)?$data->pendaftaran->penjamin->penjamin_nama:"")',
                        ),
                        array(
                            'name'=>'total_tagihan',
                            'type'=>'raw',
                            'value'=>'"Rp. ".number_format($data->totalbiayapelayanan,0,"",".")',
                        ),
                        array(
                            'header'=>'Subsidi Asuransi',
                            'name'=>'subsidi_asuransi',
                            'type'=>'raw',
                            'value'=>'number_format($data->totalsubsidiasuransi,0,"",".")',
                        ),
                        array(
                            'header'=>'Subsidi RS / Klinik',
                            'name'=>'subsidi_rs',
                            'type'=>'raw',
                            'value'=>'number_format($data->totalsubsidirs,0,"",".")',
                        ),
                        array(
                            'header'=>'Biaya',
                            'name'=>'iur_biaya',
                            'type'=>'raw',
                            'value'=>'"Rp. ".number_format($data->totaliurbiaya,0,"",".")',
                        ),
                        array(
                            'header'=>'Disc',
                            'name'=>'discount',
                            'type'=>'raw',
                            'value'=>'number_format($data->totaldiscount,0,"",".")',
                        ),
                        array(
                            'header'=>'Pembebasan',
                            'type'=>'raw',
                            'value'=>'number_format($data->totalpembebasan,0,"",".")',
                        ),
                        array(
                            'header'=>'Jumlah Pembayaran',
                            'name'=>'totalbayartindakan',
                            'type'=>'raw',
                            'value'=>'"Rp. ".number_format($data->totalbayartindakan,0,"",".")',
                            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                            'footer'=>'sum(totalbayartindakan)',                            
                        ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));
            ?>            
        </td>
    </tr>
</table>