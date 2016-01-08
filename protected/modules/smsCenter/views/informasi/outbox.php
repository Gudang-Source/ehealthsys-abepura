<div class="white-container">
    <legend class="rim2">Pesan <b>Keluar</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Outboxes'=>array('index'),
        'Manage',
    );

    $arrMenu = array();
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>' Pesan Keluar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('outbox-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form" style="display:none">
    <?php 

    ?>
    </div><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <B>Pesan Keluar</b> <?php echo CHtml::link('<i class="icon-trash icon-small icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'deleteSms(); return false;')); ?> </h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'outbox-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Delete',
                    'type'=>'raw',
                    'value'=>'CHtml::checkBox(\'delete[cekList][i]\', \'\', array(\'onclick\'=>\'renameInput($("#outbox-grid"))\', \'class\'=>\'cekList\')).
                    Chtml::hiddenField(\'delete[id][i]\', $data->ID)',
                ),
                'UpdatedInDB',
                'InsertIntoDB',
                'SendingDateTime',
                'TextDecoded',
                'DestinationNumber',
                'SenderID',
                'SendingTimeOut',

            ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
</div>
<?php 
 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#outbox-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?> 

<script type="text/javascript">
//   setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
//     function(){
//         $.fn.yiiGridView.update('outbox-grid', {   // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
//         data: $(this).serialize()
//     });
//      return false;
//  }, 
//  10000  // fungsi di eksekusi setiap 10 detik sekali
// );
function deleteSms(){
    var jumlah = 0;
    $('.cekList').each(function(){
        if ($(this).is(':checked')){
            jumlah++;
        }
    });
    if(jumlah==0){
        myAlert('Cek list terlebih dahulu!');
        return false;
    }
    data = $('input').serialize();
    $.ajax({
        url : '<?php echo $this->createUrl("deleteSms"); ?>',
        type : "post",
        dataType : "json",
        data : data,
        success : function(data){
            if(data.result=='success'){
                $.fn.yiiGridView.update('outbox-grid', {   // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
                    data: $(this).serialize()
                });
                myAlert('Sms berhasil dihapus!');
            }else{
                myAlert('Sms gagal dihapus!');
            }
        }
    });
}

function renameInput(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find('input').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]"+"["+row+"]");
            }
        });
        row++;
    });
    
}

</script>
