<div class="row-fluid box2">
    <?php $this->renderPartial('_search', array('model' => $model, 'kecamatanAsals'=>$kecamatanAsals)); ?>
    <hr />
    <div class="row-fluid box2">
        <?php $this->renderPartial('_map', array('model' => $model, 'dataMap' => $dataMap)); ?>
    </div>
</div>