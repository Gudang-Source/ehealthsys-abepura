<div class="row-fluid">
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_barUmur', array('model'=>$model,'dataBarChartUmur' => $dataBarChartUmur)); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('_tableUmur', array('dataTableUmur' => $dataTableUmur)); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_pieUmur', array('dataPieChartUmur' => $dataPieChartUmur)); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('_pieJk', array('dataPieChartJk' => $dataPieChartJk)); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_stackedUmur', array('model'=>$model,'dataStackChartUmur' => $dataStackChartUmur, 'graphsStackUmur' => $graphsStackUmur)); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('_stackedJk', array('model'=>$model,'dataStackChartJk' => $dataStackChartJk)); ?>
        </div>
    </div>
</div>