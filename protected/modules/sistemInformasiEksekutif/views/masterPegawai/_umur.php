
<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid">
            <?php $this->renderPartial('_pieUmur', array('model' => $model,'dataPieChartUmur' => $dataPieChartUmur, 'dataPieChartUmurDet'=>$dataPieChartUmurDet)); ?>

        </div>
        <div class="rrow-fluid">
            <?php $this->renderPartial('_barUmur', array('model' => $model,'dataBarChartUmur' => $dataBarChartUmur)); ?>
        </div>
    </div>
    <div class="span6">
        <?php $this->renderPartial('_tableUmur', array('model' => $model, 'modelUmur' => $modelUmur, 'dataTableUmur' => $dataTableUmur)); ?>
    </div>
</div>
