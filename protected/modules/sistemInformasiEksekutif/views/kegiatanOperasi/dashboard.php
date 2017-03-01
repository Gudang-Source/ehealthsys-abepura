<div class="row-fluid box2">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
    <hr />
    <div class="row-fluid box2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?php $this->renderPartial('_bar', array('model' => $model, 'dataKegOperasi' => $dataKegOperasi, 'dataBarLineChart' => $dataBarLineChart)); ?>                    
                </div>
                <div class="col-md-6">
                    <?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php $this->renderPartial('_pie', array('model' => $model, 'dataPieChart' => $dataPieChart)); ?>
                </div>
            </div>
        </div>
    </div>
</div>