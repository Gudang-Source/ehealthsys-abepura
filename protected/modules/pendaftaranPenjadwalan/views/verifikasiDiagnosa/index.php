<script type="text/javascript">
    var id_diagnosax = new Array();
</script>
<?php
$this->breadcrumbs=array(
	'Verifikasi Diagnosa',
);
$this->renderPartial($path_view . '_formDataPasien',array('modPendaftaran'=>$modPendaftaran));

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'id'=>'uraian-diagnosax-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus'=>'#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial($path_view . '_gridDiagnosaICDX',
    array(
        'form' => $form, 
        'modDiagnosa'=>$modDiagnosa,
        'model'=>$model,
        'modPendaftaran'=>$modPendaftaran, 
        'modUraian'=>$modUraian,
        'path_view'=>$path_view
    )
);
?>
<br>
<?php
$this->renderPartial($path_view . '_gridDiagnosaICDIX',
    array(
        'form' => $form, 
        'modDiagnosaix'=>$modDiagnosaix,
        'model'=>$model_ix,
        'modPendaftaran'=>$modPendaftaran, 
        'modUraian'=>$modUraianIx,
        'path_view'=>$path_view
    )
);
?>

<div class="form-actions">
    <?php
        $menu = (isset($_GET['menu']) ? $_GET['menu'] : "");
        if($menu == 'RJ')
        {
            $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRJ" : "InfoKunjunganRJ");
            $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
        }else if($menu == 'RD')
        {
            $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRD" : "InfoKunjunganRJ");
            $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
        }else if($menu == 'RI')
        {
            $action = ((Yii::app()->controller->module->id == 'rekamMedis') ? "InfoPasienRI" : "InfoKunjunganRJ");
            $url = $this->createUrl('/' . Yii::app()->controller->module->id . '/' . $action . '/Index');
        }
        echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
        if($_GET['frame']!=1){
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('index',array('id'=>$modPendaftaran->pendaftaran_id)), array('class'=>'btn btn-danger'));
            echo CHtml::htmlButton(Yii::t('mds','{icon} Back',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),
                array('class'=>'btn btn-primary-blue','onKeypress'=>'return formSubmit(this,event)',
                    'onclick'=>'$("#iframeVerifikasiDiagnosa").attr("src",$(this).attr("href")); window.parent.$("#dialogVerifikasiDiagnosa").dialog("close");return false;'));
        }
        
    ?>
</div>

<?php
    $this->endWidget();
?>