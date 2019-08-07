<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Perda Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/PerdatarifM/admin')),
        array('label'=>'Jenis Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/JenistarifM/admin')),
        array('label'=>'Kelompok Komponen Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KelompokkomponentarifM/admin')),
    	array('label'=>'Komponen Tarif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/KomponentarifM/admin')),
    	array('label'=>'Tarif Tindakan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'sistemAdministrator/TarifTindakan/admin')),
    ),
));
?>