<?php 
$module = '/'.$this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Persalinan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this, 1);'), 'active'=>true),
        array('label'=>'Pemeriksaan Obsterikus', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this, 2);')),
    ),
    'htmlOptions'=>array(
        'id'=>'tabber',
    )
));
?>