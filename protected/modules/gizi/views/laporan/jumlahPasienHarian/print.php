<style>
    table .table td{
        border: 1px #000 solid;
    }
</style>
<?php
    if($caraPrint=='EXCEL'){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$data['judulLaporan'], 'periode'=>'Periode : '.$data['periode'], 'colspan'=>16)); 

    $this->render('gizi.views.laporan.jumlahPasienHarian/_tables',
        array(
            'model'=>$model,
            'models'=>$models,
            'modRekaps'=>$modRekaps,
            'pilihanTab'=>$pilihanTab,
            'caraPrint'=>$caraPrint,
        )
    );
?>
