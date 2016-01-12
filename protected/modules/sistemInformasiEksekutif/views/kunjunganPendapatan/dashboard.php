<div class="row-fluid box2">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
    <hr />
    <div class="row-fluid box2">
        <div class="col-md-6">
            <?php $this->renderPartial('_bubble', array('model' => $model,'dataBubbleChart' => $dataBubbleChart)); ?>
        </div>
        <div class="col-md-6">
            <?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>
        </div>
    </div>
</div>