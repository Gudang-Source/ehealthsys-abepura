<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
                array('label'=>'Propinsi', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/propinsiM'), 'active'=>true),
        array('label'=>'Kabupaten', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/kabupatenM'),),
        array('label'=>'Kecamatan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/kecamatanM'),),
        array('label'=>'Kelurahan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/kelurahanM'),),

    ),
));
?>