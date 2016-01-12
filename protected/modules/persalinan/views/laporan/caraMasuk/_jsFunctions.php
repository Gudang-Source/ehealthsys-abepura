<?php
$url = Yii::app()->createUrl($this->route);
$urlModule = Yii::app()->createUrl($this->module->id);
$urlGrafik = Yii::app()->createUrl($this->module->id."/".$this->id."/UpdateGrafik");
$js = <<< JS
    ubahJnsPeriode();
JS;

Yii::app()->clientScript->registerScript('diagram',$js, CClientScript::POS_READY)
?>
<script type="text/javascript">
    function refreshForm(){
        window.location.href = "<?php echo $url;?>";
    }
    function konfirmasiBatal(){
        myConfirm('Apakah anda akan membatalkan ini?', 'Perhatian!', function(r){
            if(r){
                window.location.href = "<?php echo $urlModule;?>&modul_id=39";
            }
        });
    }
    function ubahJnsPeriode(){
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
        if(obj.val() == 'hari'){
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        }else if(obj.val() == 'bulan'){
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        }else if(obj.val() == 'tahun'){
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }
    
    function cek_all_rujukan(obj){
        if($(obj).is(':checked')){
            $("#rujukan").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#rujukan").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
    function cek_all_instalasi(obj){
        if($(obj).is(':checked')){
            $("#instalasi").find("input[type=\'checkbox\']").attr("checked", "checked");
        }else{
            $("#instalasi").find("input[type=\'checkbox\']").attr("checked", false);
        }
    }
    
</script>