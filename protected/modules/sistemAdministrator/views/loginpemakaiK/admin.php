<div class="white-container">
    <legend class="rim2">Pengaturan <b>Login Pemakai</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Loginpemakai Ks'=>array('index'),
            'Manage',
    );
    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Login Pemakai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Login Pemakai', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Login Pemakai', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#LoginpemakaiK_nama_pemakai').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('loginpemakai-k-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Login Pemakai</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'loginpemakai-k-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    'loginpemakai_id',
                    array(
                        'header'=>'Nama Login',
                        'value'=>'$data->nama_pemakai',
                        'filter'=>CHtml::activeTextField($model,'nama_pemakai'),
                    ),
                    'katakunci_pemakai',
                    'lastlogin',
                    'tglpembuatanlogin',
                    'tglupdatelogin',
                    /*
                    'statuslogin',
                    'loginpemakai_aktif',
                    */
                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->loginpemakai_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                array(
    //                    'header'=>'Aktif',
    //                    'class'=>  'CCheckBoxColumn',
    //                    'selectableRows'=>0,
    //                    'checked'=>'$data->loginpemakai_aktif',
    //                ),
                    array(
                        'header'=>'Lihat',
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view'=>array(
                                'options'=>array('rel'=>'tooltip','title'=>'Lihat Login Pemakai'),
                            ),
                        ),
                    ),
                    array(
                        'header'=>'Ubah',
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array
                                (
                                    'options'=>array('rel'=>'tooltip','title'=>'Ubah Login Pemakai'),
                                ),
                            ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->loginpemakai_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->loginpemakai_id)",array("id"=>"$data->loginpemakai_id","rel"=>"tooltip","title"=>"Menonaktifkan Login Pemakai"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->loginpemakai_id)",array("id"=>"$data->loginpemakai_id","rel"=>"tooltip","title"=>"Hapus Login Pemakai")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->loginpemakai_id)",array("id"=>"$data->loginpemakai_id","rel"=>"tooltip","title"=>"Hapus Login Pemakai"));',
                        'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
                    ),
					array(
					   'header'=>'Klon',
					   'type'=>'raw',
					   'value'=>'CHtml::link("<i class=\'icon-form-copy\'></i>",  Yii::app()->controller->createUrl("/sistemAdministrator/loginpemakaiK/klon",array("id"=>$data->loginpemakai_id)) , array("title"=>"Klik untuk klon / menggandakan","target"=>"grid-frame", "onclick"=>"$(\"#grid-dialog\").dialog(\"open\");", "rel"=>"tooltip"))',
						'htmlOptions'=>array(
							'style'=>'text-align: center',
					   )
					),		

            ),
					
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Login Pemakai', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/loginpemakaiK/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);


$js = <<< JSCRIPT
           function cekForm(obj)
{
    $("#loginpemakai-m_search :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
         window.open("${urlPrint}/"+$('#loginpemakai-m_search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('loginpemakai-k-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
		});
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('loginpemakai-k-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
		});
    }
    $('.filters #LoginpemakaiK_nama_pemakai').focus();
	
	function clearFrameSrc()
	{
		$('#grid-klon').attr('src', '');
	}
	function dialog_kertas()
    {
    $('#grid-klon').dialog('open');
    }	
</script>

<?php
//    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
//    'id'=>'grid-klon',
//    'options'=>array(
//        'title'=>'Klon Login Pemakai',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>750,
//        'height'=>800,
//		'close'=>'js:function(){ clearFrameSrc(); }',
//    ),
//    ));
?>
<!--<iframe id="grid-frame" width="100%" height="100%"></iframe>-->
<?php 
//	$this->endWidget();
?>
<?php
/** Dialog Widget Start With IFrame **/
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'grid-dialog',
    'options'=>array(
        'title'=>'Klon Peran Pemakai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>650,
        'height'=>450,
		'close'=>"js:function(){ 
			clearFrameSrc(); 
			$.fn.yiiGridView.update('loginpemakai-k-grid');
		}",
    ),
    ));
?>
<iframe src="" name="grid-frame" width="100%" height="100%"></iframe>
<?php 
$this->endWidget();
/** Dialog Widget End **/
?>
