<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Cara Bayar', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/carabayarM'), 'active'=>true),
        array('label'=>'Penjamin Pasien', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/penjaminpasienM')),
    ),
));
?>