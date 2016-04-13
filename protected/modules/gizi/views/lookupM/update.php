<fieldset class="box row-fluid">
    <?php
        if ($model->lookup_type == 'jenisbahanmakanan'):      
            echo "<legend class='rim'>Ubah <b>Jenis Bahan Makanan</b></legend>"; 
            $pengaturan = CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Bahan Makanan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/gizi/JenisBahanMakanan/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));            
            $ulang = CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/JenisBahanMakanan/create'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        else:   
            echo "<legend class='rim'>Ubah <b>Kelompok Bahan Makanan</b></legend>";
            $pengaturan = CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Bahan Makanan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('/gizi/KelompokBahanMakanan/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));            
             $ulang = CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/kelompokBahanMakanan/create'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        endif;
    ?>  
    <?php
    $this->breadcrumbs=array(
            'Lookup Ms'=>array('index'),
            $model->lookup_id=>array('view','id'=>$model->lookup_id),
            'Update',
    );

    $this->menu=array(
    //        array('label'=>Yii::t('mds','Update').' Satuan Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Lookup', 'icon'=>'file', 'url'=>array('create')),
    //	array('label'=>Yii::t('mds','View').' Lookup', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->lookup_id)),
    //	array('label'=>Yii::t('mds','Manage').' Satuan Barang', 'icon'=>'folder-open', 'url'=>array('admin')),
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model, 'pengaturan'=>$pengaturan, 'ulang'=>$ulang)); ?>
</fieldset>