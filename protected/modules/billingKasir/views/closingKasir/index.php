<div class="white-container">
    <legend class="rim2">Closing <b>Kasir</b></legend>
    <div>
        <?php
            $this->renderPartial('_search',
                array(
                    'model'=>$model,
                    'mBuktBayar'=>$mBuktBayar,
                )
            );
        ?>
    </div>
    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'POST',
                'type' => 'horizontal',
                'id' => 'formClosing',
                'focus' => '#BKTandabuktibayarT_ruangan_id',
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data',
                    'onKeyPress' => 'return disableKeyPress(event)',
                    'onsubmit'=>'return requiredCheck(this);'
                ),
            )
        );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Informasi <b>Pembayaran</b></h6>
        <?php
            $this->renderPartial('_table',
                array(
                    'mBuktBayar'=>$mBuktBayar,
                    'form'=>$form,
                )
            );
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim">Data Penutupan</legend>
        <div>
            <?php
                $this->renderPartial('_formClosing',
                    array(
                        'model'=>$model,
                        'informasi'=>$informasi,
                        'rPenerimaanUmum'=>$rPenerimaanUmum,
                        'rPengeluaranUmum'=>$rPengeluaranUmum,
                        'rPecahanUang'=>$rPecahanUang,
                        'mSetorBank'=>$mSetorBank,
                        'form'=>$form,
                        'format'=>$format,
                        'id'=>$id,
                    )
                );
            ?>
        </div>
    </fieldset>
    <?php
        $this->endWidget();
    ?>
</div>