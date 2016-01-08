<div class="white-container">
    <legend class="rim2">Master <b>Rujukan / Perujuk Pasien</b></legend>
    <?php 
    $this->breadcrumbs=array(
            'MasterPerujukPasien'=>array('index'),
            'Manage',
    );
    ?>
    <?php 
    $this->renderPartial($this->path_view.'_tabMenu',array());
    $this->renderPartial($this->path_view.'_jsFunctions',array());
    ?>
    <div>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
    </div>
</div>