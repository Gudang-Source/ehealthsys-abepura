<div class="row-fluid">
    <div class="span6">
        <?php $this->renderPartial('_pieKlp', array('model' => $model,'dataPieChartKlp' => $dataPieChartKlp)); ?>
    </div>
    <div class="span6">
        <?php $this->renderPartial('_stackedKlp', array('model' => $model,'dataStackChartKlp' => $dataStackChartKlp, 'graphsStackKlp' => $graphsStackKlp)); ?>
    </div>
</div>
<div class="row-fluid">
    <!--<div class="span6">
        <?php// $this->renderPartial('_barKlp', array('model' => $model, 'modelKlp' => $modelKlp, 'dataLineChartKlp' => $dataLineChartKlp, 'graphsLineKlp' => $graphsLineKlp)); ?>
    </div>-->
    <div class="span6">
        <?php $this->renderPartial('_tableKlp', array('model' => $model, 'modelKlp' => $modelKlp, 'dataTableKlp' => $dataTableKlp)); ?>
    </div>
</div>
