<div class="row-fluid">    
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_pieKerja', array('dataPieChartKerja' => $dataPieChartKerja)); ?>
        </div>
        <div class="span6">
            <?php $this->renderPartial('_tableKerja', array('model'=>$model,'dataTableKerja' => $dataTableKerja)); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php $this->renderPartial('_stackedKerja', array('model'=>$model,'dataStackChartKerja' => $dataStackChartKerja,'graphsStackKerja'=>$graphsStackKerja)); ?>
        </div>
    </div>
</div>