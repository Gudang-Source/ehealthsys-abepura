<?php
	if(count($modPencarianMenu)>0){
			foreach ($modPencarianMenu as $i =>$menuDetail){
			echo "<a href=".Yii::app()->createUrl(isset($menuDetail->menu_url)?$menuDetail->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))." class='shortcut2'>";
			echo "<i class='icon-th-list'></i><br><br>";
			echo "$menuDetail->menu_nama";  
			echo "</a>";
			}
	}
?>