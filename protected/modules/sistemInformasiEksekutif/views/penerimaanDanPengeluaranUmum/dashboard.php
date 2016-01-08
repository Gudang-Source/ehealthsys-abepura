<div class="row-fluid box2">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
    <hr />
    <div class="row-fluid box2">
        <div class="col-md-6">

            <?php $this->renderPartial('_pie', array('dataPieChart' => $dataPieChart)); ?>
        </div>
        <div class="col-md-6">
            <?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>
        </div>
    </div>
    <div class="row-fluid box2">
        <div class="col-md-12">
            <?php $this->renderPartial('_line', array('model' => $model,'dataBarLineChart' => $dataBarLineChart)); ?>
        </div>
    </div>
</div>