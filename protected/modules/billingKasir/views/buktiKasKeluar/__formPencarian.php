<fieldset>
    <legend class="rim">Pencarian Kas Keluar</legend>
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'caripasien-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'method'=>'GET',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            )
        );    
    ?>
    <?php
        $this->endWidget();
    ?>
</fieldset>