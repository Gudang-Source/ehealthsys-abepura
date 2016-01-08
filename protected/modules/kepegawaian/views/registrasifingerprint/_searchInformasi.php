<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'sapegawai-m-search',
            'type'=>'horizontal',
    )); ?>
    <table width="100%">
        <tr>
            <td>
                <?php echo $form->textFieldRow($model,'nomorindukpegawai',array('class'=>'span3','maxlength'=>30)); ?>
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>50)); ?>
            </td>
            <td>
                <?php echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true'), 'jabatan_id', 'jabatan_nama'),array('class'=>'span3','maxlength'=>50, 'empty'=>'-- Pilih --')); ?>
                <?php echo $form->dropDownListRow($model,'kelompokpegawai_id',CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true'), 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
            </td>
        </tr>
    </table>

    <div class="form-actions">
                            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                                    <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/Registrasifingerprint/informasi'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>

    </div>
</fieldset>
<?php $this->endWidget(); ?>

<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $content = $this->renderPartial('../tips/master',array(),true);
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Informasiprint');
       // $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/Printinformasi');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapegawai-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>