<legend class = "rim2">Laporan Cara Bayar</legend>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
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