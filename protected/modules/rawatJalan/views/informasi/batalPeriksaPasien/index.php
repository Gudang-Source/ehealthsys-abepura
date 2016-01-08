<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Batal Periksa</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('daftarpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Pasien <b>Batal Periksa</b></h6>
        <?php $this->renderPartial('rawatJalan.views.informasi.batalPeriksaPasien._table',array('model'=>$model)); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('rawatJalan.views.informasi.batalPeriksaPasien._search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
</div>