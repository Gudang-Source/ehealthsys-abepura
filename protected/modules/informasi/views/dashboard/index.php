<style type="text/css">
    *{box-sizing: border-box;}
    a,a:hover{text-decoration: none;}
    .icon {
        float:left;
        width:25%;
        display:block;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        color: #837E7C;
        padding:5px 15px;
        margin-bottom: 15px;
    }
    .icon img {
        margin: 10px 5px;
        width:50%;
        border: 1px solid transparent;
        border-radius: 75px;
    }
    .icon>a{
        display: block;
        background: rgba(77,168,31,0.7);
        border: 1px solid #ffffff;
        box-shadow: 0 0 4px #666666;
        padding:10px;
        border-radius: 15px;
        transition: all 0.2s ease-in-out;
        color: #365129;
    }
    .icon>a:hover {
        background: rgb(77,168,31);
        border: 1px solid #ffffff;
        box-shadow: 0 0 4px #666666;
        color: #ffffff;
        text-shadow: 0 1px 1px #333;
    }
    .icon>a:hover img{border: 1px solid #fff;box-shadow: 0 0 4px #333;}
</style>
<div class="white-container">
    <legend class="rim2"><b>Informasi</b></legend>
    <div class="row-fluid">
        <?php
            foreach ($modMenu as $i => $menu) { 
                switch ($menu->menu_nama){
                    case "Tarif" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Tarif.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Kamar" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Kamar.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Antrian Poliklinik" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Antrian Poliklinik.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Antrian Masuk Penunjang (new)" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Antrian Masuk.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Antrian Pendaftaran (new)" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Antrian Pendaftaran.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Antrian Farmasi (new)" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Antrian Farmasi.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Rawat Jalan" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Rawat Jalan.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Rawat Darurat" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Rawat Darurat.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Rawat Inap" : 
                                    echo "<div class='icon'><a href='".Yii::app()->createUrl(isset($menu->menu_url)?$menu->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))."'>"."<img src='data/images/informasi/Rawat Inap.png'><br />$menu->menu_namalainnya</a></div>";
                                    break;
                    case "Keluhan Pasien" : 
                                    echo "<div class='icon'><a href='#'>KELUHAN PASIEN<img src='data/images/informasi/Rawat Inap.png'></a></div>";
                                    break;

                }
            }
        ?>
    </div>
</div>