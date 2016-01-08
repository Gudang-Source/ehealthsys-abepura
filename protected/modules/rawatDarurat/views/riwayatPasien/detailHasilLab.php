<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>

<table width='100%'>
    <tr>
        <td width="50%">
             <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</b>
            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
            <br />
             <b><?php echo CHtml::encode($modPasien->getAttributeLabel('no_rekam_medik')); ?>:</b>
            <?php echo CHtml::encode($modPasien->no_rekam_medik); ?>
             <br/>
             <b><?php echo CHtml::encode($modPasien->getAttributeLabel('nama_pasien')); ?>:</b>
            <?php echo CHtml::encode($modPasien->nama_pasien); ?>
            <br />
             <b><?php echo CHtml::encode($modPasien->getAttributeLabel('jeniskelamin')); ?>:</b>
            <?php echo CHtml::encode($modPasien->jeniskelamin); ?>
            <br />
        </td>
        <td width="50%">
            <div style='float:right;'>
              <b><?php echo CHtml::encode($modHasilLab->getAttributeLabel('tglhasilpemeriksaanlab')); ?>:</b>
            <?php echo CHtml::encode($modHasilLab->hasilpemeriksaanlab_id); ?>
            <br />
             <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</b>
            <?php echo CHtml::encode($modPendaftaran->umur); ?>
            <br />
             <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('carabayar_id')); ?>:</b>
            <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?>
            <br />
             <b><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('penjamin')); ?>:</b>
            <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
            <br />
            </div>
             
        </td>
    </tr>   
</table>
<hr/><?php //echo $idHasillab;exit; ?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjdetailhasilpemeriksaanlab-t-grid', 
    'dataProvider'=>$modDetailHasil->searchDetailHasilLab($idHasillab), 
    'filter'=>$model, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        ////'detailhasilpemeriksaanlab_id',
        array( 
                        'name'=>'No', 
                        'value'=>'$data->detailhasilpemeriksaanlab_id', 
                        'filter'=>false, 
                ),
        'pemeriksaanlab.pemeriksaanlab_nama',
        'hasilpemeriksaan',
        'hasilpemeriksaan_metode',
        'nilairujukan',
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 


<?php if (!isset($caraPrint)){

            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
            echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
            // $this->widget('UserTips',array('type'=>'admin'));

    $pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print&id='.$pendaftaran_id);//


 
JSCRIPT;
Yii::app()->clientScript->registerScript('alert',$js,CClientScript::POS_BEGIN);

$js = <<< JSCRIPT
    function print(obj)
    {
    window.open("${urlPrint}"+$('#sajenis-carabayar-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
        
    
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        

}

?>