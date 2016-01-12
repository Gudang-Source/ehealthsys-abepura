<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Bank', 'url'=>$this->createUrl('/sistemAdministrator/bankM/create'),'active'=>true ),
        array('label'=>'Rekening', 'url'=>$this->createUrl('/sistemAdministrator/RekeningBank/create'), ),
            ),
)); 
?>