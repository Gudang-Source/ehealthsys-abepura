<div class="new-container">
    <div class="dashboard">
            <div class="block">
                    <div><h6><?php echo $this->module->id; ?></h6></div>
                    <?php 
                    $menus = $this->module->menu;
                    foreach($menus AS $i => $menu){
                        if($menu->kelmenu_id == Params::KELMENU_ID_DASHBOARD){
                            echo "<a href=".Yii::app()->createUrl($menu->menu_url,array('modul_id'=>$menu->modul_id))." class='shortcut'>";
                            echo "<img height='48' width='48' alt='' src='".Params::urlIconModulDirectory().(empty($menu->menu_icon) ? "tampilAntrian.png" : $menu->menu_icon)."'>";
                            echo "$menu->menu_namalainnya</a>";
                        }
                    } ?>
            </div>
    </div>
</div>