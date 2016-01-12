<div class="row-fluid box2">
    <legend class = "rim2">Laporan <b>Mortalitas</b></legend>
    <?php
    $this->menu=array(
            array('label'=>'Laporan Mortalitas', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    );
    ?>
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
    <hr />
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data'=>$data,'dataProvider' => $dataProvider, 'id' => 'pie')); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('sistemInformasiEksekutif.views._speedo', array('dataProvider'=>$dataProviderSpeedo,'title'=>$data['title'])); ?>
        </div>
    </div>
    <div class="row-fluid">
        <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data'=>$data,'dataProvider' => $dataProvider, 'id' => 'batang')); ?>
    </div>
    <div class="row-fluid">
        <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data'=>$data,'dataProvider' => $dataProviderGaris, 'id' => 'garis')); ?>
    </div>

    <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
</div>