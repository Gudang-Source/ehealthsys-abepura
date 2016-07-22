<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');       
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$data['judulLaporan'], 'periode'=>'Periode : '.$data['periode'], 'colspan'=>16)); 

if ($caraPrint != 'GRAFIK')
$this->renderPartial('konsulGiziRekap/_table', array('model'=>$model,'models'=>$models, 'data'=>$data, 'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 


?>