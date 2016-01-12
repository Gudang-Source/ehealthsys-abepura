<div class="row-fluid">    
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_piePdk', array('dataPieChartPdk' => $dataPieChartPdk)); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('_tablePdk', array('model'=>$model,'dataTablePdk' => $dataTablePdk)); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_stackedPdk', array('model'=>$model,'dataStackChartPdk' => $dataStackChartPdk,'graphsStackPdk'=>$graphsStackPdk)); ?>
        </div>
    </div>
</div>