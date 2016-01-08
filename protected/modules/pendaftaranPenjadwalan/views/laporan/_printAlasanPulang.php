<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>$periode));  

if ($caraPrint != 'GRAFIK')
$this->renderPartial('pendaftaranPenjadwalan.views.laporan._tableAlasanPulang', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('pendaftaranPenjadwalan.views.laporan._grafikKabupaten', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint, 'colspan'=>9), true); 




echo $this->renderPartial('application.views.headerReport.footerDefault',array());
?>