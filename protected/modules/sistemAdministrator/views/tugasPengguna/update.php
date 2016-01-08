<?php
$this->breadcrumbs=array(
	'Satugaspengguna Ks'=>array('index'),
	$model->tugaspengguna_id=>array('view','id'=>$model->tugaspengguna_id),
	'Update',
);

?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'data'=>$data)); ?>
<?php $this->renderPartial('_jsFunctions',array()); ?>

<script type="text/javascript">
	function checkModul(){
        var modul = [
            <?php 
            foreach ($moduls as $i => $modul) {
                echo "'".$modul->modul->url_modul."',";
            }
            ?>
        ];
        total = modul.length;
        i=0;
        modul.forEach(function(data) {
            $('#'+data).prop("checked", true);
        });
    }

	function checkController(){
        var controller = [
            <?php 
            foreach ($controllers as $i => $controller) {
                echo "['".$controller->controller_nama."','".$controller->modul->url_modul."'],";
            }
            ?>
        ];

        controller.forEach(function(data){
            $('input[modul="'+data[1]+'"][value="'+data[0]+'"]').prop("checked",true);
        });
    }

    function checkAction(){
        var action = [
            <?php 
            foreach ($actions as $i => $action) {
                echo "['".$action->action_nama."','".$action->controller_nama."'],";
            }
            ?>
        ];

        action.forEach(function(data){
            $('input[controller="'+data[1]+'"][value="'+data[0]+'"]').prop("checked",true);
        });
    }

	checkModul();
	checkController();
	checkAction();
</script>