<div class="white-container">
    <legend class="rim2">Informasi <b>Penggantian Kacamata</b></legend>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $modul  = $this->module->name; 
    $control = $this->id;

    $urlTindakLanjut = Yii::app()->createUrl('actionAjax/pasienRujukRI');
    Yii::app()->clientScript->registerScript('search', "
            $(document).ready(function(){
            $('#caridata-form').submit(function(){
            $('#daftargantikacamata-v-grid').addClass('animation-loading');
                    $.fn.yiiGridView.update('daftargantikacamata-v-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
    });         
    ");
    ?>
    <?php echo $this->renderPartial('_table', array('model'=>$model));  ?> 
    <?php $this->renderPartial('_search',array('model'=>$model)); ?>

    <?php echo $this->renderPartial('_jsFunctions',array()); ?>
</div>