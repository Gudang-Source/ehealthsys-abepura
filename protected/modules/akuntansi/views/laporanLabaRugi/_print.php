<?php 

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if ($caraPrint == 'GRAFIK') {
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, /* 'periode'=>'Periode : '.$periode, */'colspan'=>10));  
    echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'models' => $models,'data'=>$data, 'caraPrint'=>$caraPrint), true); 
} else { 
?>
    <table style="width:100%">
        <thead>
            <tr>
                <th><?php echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, /* 'periode'=>'Periode : '.$periode, */'colspan'=>4));   ?></th>
            </tr>    
        </thead>
        <tbody>
            <tr>
                <td><?php $this->renderPartial($this->path_view.'_table', array('model'=>$model, 'models' => $models,'caraPrint'=>$caraPrint)); ?></td>
            </tr>    
        </tbody>
    </table>
<?php    
}    