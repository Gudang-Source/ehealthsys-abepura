<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Cara Bayar', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/carabayarM/Admin')),
        array('label'=>'Penjamin Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'pendaftaranPenjadwalan/penjaminpasienM/Admin')),
    	
    ),
));
?>