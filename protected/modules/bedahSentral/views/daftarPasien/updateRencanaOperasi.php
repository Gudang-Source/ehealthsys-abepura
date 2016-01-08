<script>
    var items = [];
</script>
<div class="white-container">
    <?php
        $this->widget('application.extensions.moneymask.MMask',array(
            'element'=>'.currency',
            'currency'=>'PHP',
            'config'=>array(
                'symbol'=>'Rp. ',
        //        'showSymbol'=>true,
        //        'symbolStay'=>true,
                'defaultZero'=>true,
                'allowZero'=>true,
                'precision'=>0
            )
        ));
    ?>
    <?php
        $this->widget('bootstrap.widgets.BootAlert'); 
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');    
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'updaterencanaoperasi-form',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#BSRencanaOperasiT_kamarruangan_id',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)',
                    'onsubmit'=>'return cekInput();'
                ),
            )
        );
    ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <?php
        echo $form->errorSummary(
            array(
                $modRencanaOperasiAttrib,
                $modAnastesi,
                $modTindakanPelayanan,
                $modTindakanKomponen)
        );
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
        }
    ?>

    <?php
        echo $this->renderPartial('_formDataPasien',
            array(
                'form'=>$form,
                'modPasienPenunjang'=>$modPasienPenunjang
            )
        );
    ?>


    <?php
        echo $this->renderPartial('_formRencanaOperasi',
            array(
                'form'=>$form,
                'modRencanaOperasi'=>$modRencanaOperasi,
                'modRencanaOperasiAttrib'=>$modRencanaOperasiAttrib,
                'modPenunjang'=>$modPenunjang,
                'modPasienPenunjang'=>$modPasienPenunjang,
                'modKegiatanOperasi'=>$modKegiatanOperasi,
                'modOperasi'=>$modOperasi,
                'modAnastesi'=>$modAnastesi,
                'modRO'=>$modRO,
                'modTindakanPelayanan'=>$modTindakanPelayanan,
                'modTindakanKomponen'=>$modTindakanKomponen,
                'modViewBahan'=>$modViewBahan,
                'modViewBmhp'=>$modViewBmhp,
				'format'=>$format
            )
        );
    ?>


    <div class='form-actions'>
            <?php
                $cek = $modRencanaOperasiAttrib->statusoperasi;
                if($cek == 'SELESAI'){
                echo CHtml::htmlButton(
                    $modRO->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array(
                        'id'=>'BSTindakanPelayananT_tombolsimpan',
                        'disabled'=>true,
                        'class'=>'btn btn-primary', 
                        'type'=>'submit',
                        'onKeypress'=>'return formSubmit(this,event)'
                    )
                );
                echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(
                    $modRO->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array(
                        'id'=>'BSTindakanPelayananT_tombolsimpan',
                        'class'=>'btn btn-primary', 
                        'type'=>'submit',
                        'onKeypress'=>'return formSubmit(this,event)'
                    )
                );
                    echo "&nbsp;";
                }
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('updateRencana',
                        array(
                            'id'=>$modPasienPenunjang->pasienmasukpenunjang_id)
                    ),
                    array(
                        'class'=>'btn btn-danger'
                    )
                );
                echo "&nbsp;";
                $this->widget('UserTips',array('type'=>'transaksi','content'=>'penjelasan transaksi'));
            ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    $('#formPeriksaBedah').tile({widths : [200]});
    function cekInput(){
        $('.currency').each(function(){this.value = unformatNumber(this.value)});
        return true;
    }
    
</script>
