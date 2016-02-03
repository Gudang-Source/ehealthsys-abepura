<fieldset class="box">
    <legend class="rim">Ubah Akses Pemakai</legend>
    <?php
    $this->breadcrumbs=array(
            'saaksespengguna Ks'=>array('index'),
            $model->aksespengguna_id=>array('view','id'=>$model->aksespengguna_id),
            'Update',
    );

    ?>

    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'data'=>$data, 'modPeran'=>$modPeran)); ?>

    <?php $this->renderPartial('_jsFunctions',array()); ?>
</fieldset>
<script type="text/javascript">
	function checkModul(){
        var modul = [
            <?php 
            foreach ($moduls as $i => $modul) {
                echo "['".$modul->peranpengguna_id."','".$modul->modul_id."'],";
            }
            ?>
        ];
        total = modul.length;
        i=0;
        modul.forEach(function(data) {
            $('#modul_'+data[0]+'[value="'+data[1]+'"]').prop("checked", true);
        });
    }

	function checkPeran(){
        var controller = [
            <?php 
            foreach ($perans as $i => $peran) {
                echo "'".$peran->peranpengguna_id."',";
            }
            ?>
        ];

        controller.forEach(function(data){
            $("#row_peran_" + data).find('input[value="'+data[0]+'"]').prop("checked",true);
        });
    }

	checkModul();
	checkPeran();
</script>