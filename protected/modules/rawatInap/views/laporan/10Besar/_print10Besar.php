 <style>
    
    @media screen {
    #whiteBg {
        display: none;
    }
}

@media print {
   #footer {
     width:100%;  
     position: fixed;
     bottom: 0;
   }
     
   
   body {
     margin: 0px 0px 0px 0px;
}
}
</style>
<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode, 'colspan'=>10));

if ($caraPrint != 'GRAFIK')
$this->renderPartial('10Besar/_table10Besar', array('model'=>$model, 'caraPrint'=>$caraPrint)); 

if ($caraPrint == 'GRAFIK')
echo $this->renderPartial('_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); 


?>
 <div id="footer" style = "width:100%;">
     <div style = "display:inline-block;float:left;text-align:left;" >
         <i><b>Generated By Ehealthsys</b></i>
     </div>
     <div style = "text-align:right;float:right;">
         <i><b>Print Count :</b></i>
     </div>
 </div>