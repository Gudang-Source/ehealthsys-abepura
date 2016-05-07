<div class="white-container">
    <legend class="rim2">Informasi <b>Presensi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Kppresensi Ts'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('#kppresensi-t-search').submit(function(){
            $.fn.yiiGridView.update('kppresensi-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $this->widget('bootstrap.widgets.BootAlert');

    //
    //$arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Presensi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    ////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPresensiT', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Presensi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                
    //$this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="form-horizontal">
        <?php
		if(!Yii::app()->user->getState('isotomatispresensi')){  //RND-7741
			$konfigFinger = AlatfingerM::model()->findAll();
			if (is_array($konfigFinger)){    
				echo '<div class="control-group "><label for="KPPresensiT_no_fingerprint" class="control-label required">No. Finger Print <span class="required">*</span></label>
						<div class="controls">';
				echo CHtml::dropDownList('finger', '', CHtml::listData($konfigFinger,'alatfinger_id', 'namaalat'), array('empty'=>'-- Pilih --'));
				echo CHtml::button("connect",array("id"=>"connect","class"=>'btn btn-primary','style'=>'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick'=>'aktifkanFinger(this, false);'));
				echo CHtml::button("info",array("class"=>'btn btn-info','style'=>'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick'=>'$("#infokoneksi").slideToggle();'));
				echo '</div>';
				echo '</div>';
			}
		}
        ?>
        <style>
            #overlay {
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                right: 0;
                background: #000;
                opacity: 0.8;
                filter: alpha(opacity=80);
                z-index:9999;
                overflow:auto;
            }
            #loading {
                position: absolute;
                top: 50%;
                left: 50%;
                margin: -28px 0 0 -25px;
            }

            #infokoneksi{
                margin-left:80px;
                display: none;
                width:400px;
                border:1px solid #cccccc;
                padding:5px;
                -webkit-border-radius: 2px;
                -moz-border-radius: 2px;
                border-radius: 2px;
                margin-bottom:10px;
            }
            #infokoneksi .control-label{
                width:50px;
            }
            #infokoneksi .controls{
                margin-left: 70px;
            }
            </style>
        <div id="infokoneksi">
            <div class="control-group "><label for="KPPresensiT_no_fingerprint" class="control-label required">Status </label>
                <div class="controls" id="status-connection">

                </div>
            </div>
            <div class="control-group "><label for="KPPresensiT_no_fingerprint" class="control-label required">IP </label>
                <div class="controls" id="ip-connection">

                </div>
            </div>
            <div class="control-group "><label for="KPPresensiT_no_fingerprint" class="control-label required">Lokasi </label>
                <div class="controls" id="lokasi-connection">

                </div>
            </div>
        </div>
    </div>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Presensi</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kppresensi-t-grid',
            'dataProvider'=>$model->searchInformasiPresensi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    'no_fingerprint',
                    'pegawai.kelompokpegawai.kelompokpegawai_nama',
                    'pegawai.nomorindukpegawai',
                    'pegawai.nama_pegawai',
                    'pegawai.jabatan.jabatan_nama',
                    //'statusscan.statusscan_nama',

                    array(
                        'name'=>'tglpresensi',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpresensi);'
                    ),
                    array(
                        'header'=>'Masuk',
                        'value'=>function($data) use (&$cr) {
                            $cr = new CDbCriteria();
                            $cr->compare('tglpresensi::date', $data->tglpresensi);
                            $cr->compare('pegawai_id', $data->pegawai_id);
                            $cr->addCondition('statusscan_id=:p1');
                            $cr->params[':p1'] = 1;
                            $pr = PresensiT::model()->find($cr);
                            if (empty($pr)) return "-";
                            return date('H:i:s', strtotime($pr->tglpresensi));
                        },
                    ),
                    array(
                        'header'=>'Keluar',
                        'value'=>function($data) use (&$cr) {
                            $cr->params[':p1'] = 3;
                            $pr = PresensiT::model()->find($cr);
                            if (empty($pr)) return "-";
                            return date('H:i:s', strtotime($pr->tglpresensi));
                        },
                    ),
                    array(
                        'header'=>'Datang',
                        'value'=>function($data) use (&$cr) {
                            $cr->params[':p1'] = 4;
                            $pr = PresensiT::model()->find($cr);
                            if (empty($pr)) return "-";
                            return date('H:i:s', strtotime($pr->tglpresensi));
                        },
                    ),
                    array(
                        'header'=>'Pulang',
                        'value'=>function($data) use (&$cr) {
                            $cr->params[':p1'] = 2;
                            $pr = PresensiT::model()->find($cr);
                            if (empty($pr)) return "-";
                            return date('H:i:s', strtotime($pr->tglpresensi));
                        },
                    ),
                    
                    'statuskehadiran.statuskehadiran_nama',
                                /*
                    array(
                        'name'=>'verifikasi',
                    ),
                                 * 
                                 */
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_search',array(
            'model'=>$model,
        )); ?>
    </fieldset>
</div>
<?php
//.'/images/ajax-loader.gif'
$url_image = Yii::app()->getBaseUrl('webroot');

Yii::app()->clientScript->registerScript('onheadfungsi','
        var interval;
    function updateTable(){
        $.fn.yiiGridView.update("kppresensi-t-grid", {
                data: $(".search-form form").serialize()
        });
    }
    
    function setAuto(){
        if ($("#atur").is(":checked")){
            atur = $("#atur").val();
        }else{
            atur = 0;
        }
        $.post("'.Yii::app()->createUrl('actionAjax/turnAutoRefresh').'",{atur:atur},function(data){
        });
    }
    
    function ambilData(ip,key){
        $.post("'.Yii::app()->createUrl('kepegawaian/presensiT/ambilData').'",{ip:ip,key:key},function(data){
            if (data == 1){
                updateTable();
                hideLoadingMsg();
                $("#finger").val("");
            }
        });
    }
    
    function beat(){
        $.post("'.Yii::app()->createUrl('kepegawaian/presensiT/ambilData').'",{},function(data){
            if (data == 1){
                updateTable();
            }
        });
    }
    
    function statusOff()
    {
        setInterval(function(){
            hideLoadingMsg();
        },10000);
        
    }
    
    function showLoadingMsg()
    {
        var over = \'<div id="overlay">\' + \'<img id="loading" src="images/ajax-loader.gif">\' + \'</div>\';
        $(over).appendTo(\'body\');
    }
    
    function hideLoadingMsg()
    {
        $(\'#overlay\').remove();
        aktifkanFinger($("#is_disconnect"), true);
    }    
    
function aktifkanFinger(obj,disconnect){
    var idAlat = $("#finger").val();
    var data = {idAlat:idAlat};

    if (disconnect){
        data = {idAlat:idAlat,disconnect:true};
    }
    
    if (jQuery.isNumeric(idAlat)){
        $(obj).parents(".controls").find("select, input#connect").attr("disabled","disabled");
        $.ajax({
            dataType:"json",
            data: data,
            success:function(data){

                if (disconnect){
                   if (data.success == true){
                        clearInterval(interval);
                        if ($("#infokoneksi").not(":hidden")){
                            $("#infokoneksi").slideUp();
                        }
                        $("#status-connection").html("");
                        $("#ip-connection").html("");
                        $("#lokasi-connection").html("");
                        $("select#finger, input#connect").removeAttr("disabled");
                        //clearInterval(interval);
                    }
                }else{
                    if ($("#infokoneksi").is(":hidden")){
                        $("#infokoneksi").slideDown();
                    }
                    var statusKoneksi;
                    if(data.success == 1 && data.connection == true){
                        showLoadingMsg();
                        //interval = setInterval(function(){ambilData(data.data.ipfinger, data.data.keyfinger);},5000);
                        statusKoneksi = "Connect ("+data.time+") <a onclick=\"aktifkanFinger(this, true);\" id=\"is_disconnect\" style=\"line-height:8px;\" class=\"btn btn-danger\">disconnect</a>";
                        ambilData(data.data.ipfinger, data.data.keyfinger);
                    }
                    else{
                        $(obj).parents(".controls").find("select, input#connect").removeAttr("disabled");
                        statusKoneksi = "<div class=\'error\'>Failed";
                    }
                    $("#status-connection").html(statusKoneksi);
                    $("#ip-connection").html("<div class=\'control-label\' style=\'width:0px;\'>"+data.data.ipfinger+"</div>");
                    $("#lokasi-connection").html("<div class=\'control-labe\' style=\'width:0px;\'>"+data.data.lokasifinger+"</div>");
                }
            }
        });
    }
    
    return false;
}
', CClientScript::POS_HEAD); ?>