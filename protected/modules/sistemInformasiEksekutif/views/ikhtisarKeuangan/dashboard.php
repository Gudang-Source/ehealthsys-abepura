<div class="row-fluid box2">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
    <hr />
    <div class="row-fluid box2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <?php $this->renderPartial('_linePendapatan', array('model' => $model, 'dataChartPendapatan' => $dataChartPendapatan)); ?>
                </div>
                <div class="col-md-6">
                    <?php $this->renderPartial('_lineLabaRugi', array('model' => $model, 'dataChartLabaRugi' => $dataChartLabaRugi)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?php $this->renderPartial('_lineAset', array('model' => $model, 'dataChartAset' => $dataChartAset)); ?>
                </div>
                <div class="col-md-6">
                    <?php $this->renderPartial('_lineLiabilitas', array('model' => $model, 'dataChartLiabilitas' => $dataChartLiabilitas)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php $this->renderPartial('_lineEkuitas', array('model' => $model, 'dataChartEkuitas' => $dataChartEkuitas)); ?>
                </div>
            </div>
        </div>
    </div>
</div>