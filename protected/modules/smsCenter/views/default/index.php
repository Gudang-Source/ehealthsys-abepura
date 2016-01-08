<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sie.css" type="text/css" />
<div class="new-container">
    <?php
    $this->breadcrumbs = array(
        $this->module->id,
    );
    ?>
    <?php
    echo CHtml::css(".dashboard .shortcut.active{background-color:#FCE8AB;}");
    ?>
    <div class="dashboard">
        <?php
        $menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id' => Yii::app()->session['modul_id']));

        // var_dump($menu[0]->modulk->icon_modul);
        // exit;
        $jml_menu = count($menu);
        ?>
        <div class="block">
            <h6>SMS Center</h6>
            <table style="width:90%;margin:0 auto;">
                <tr>
                    <td>
                        <?php for ($i = 0; $i < $jml_menu; $i++) { ?>
                            <a class='shortcut2' href="index.php?r=<?php echo $menu[$i]->menu_url ?>"><img src="images/icon_modul/<?php echo $menu[$i]->menu_icon ?>" alt=""><?php echo $menu[$i]->menu_nama ?></a>
                        <?php } ?>
                    </td>
                </tr>
            </table> 
        </div>
        <!-- <div class="block">
            <div><h6>Setting SMS Center</h6></div>
        <?php for ($i = $data['awal']; $i < $data['jumlah']; $i++) : ?>
                    <a href="<?php echo Yii::app()->createUrl($this->route, array('id' => $i)); ?>" class='shortcut' onclick='setUrl(this);return false;'>Step <?= $i; ?></a>
        <?php endfor; ?>    
        </div> -->
    </div>
    <!-- <div id="isiContent" style='width: 100%;'>
    <?php
    if (!empty($step))
        $this->renderPartial('_bawah', array('step' => $step, 'data' => $data));
    ?>
    </div> -->

    <?php Yii::app()->clientScript->registerScript('onhead', '
        function setUrl(obj){
            $(obj).addClass("active");
            url = $(obj).attr("href");
            $.get(url,{},function(hasil){
                $("#isiContent").html(hasil);
            });
        }
    ', CClientScript::POS_HEAD); ?>
</div>