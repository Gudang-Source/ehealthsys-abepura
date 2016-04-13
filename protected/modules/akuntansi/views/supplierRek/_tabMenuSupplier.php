<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
		array('label'=>'Jurnal Rekening Penerimaan', 'url'=>$this->createUrl('/akuntansi/JurnalRekPenerimaan/Admin')),
		array('label'=>'Jurnal Rekening Pengeluaran', 'url'=>$this->createUrl('/akuntansi/JurnalRekPengeluaran/Admin') ),
                array('label'=>'Jurnal Rekening Penjamin', 'url'=>$this->createUrl('/akuntansi/JurnalRekPenjamin/Admin'),'active'=>true ),
            ),
)); 
?>
