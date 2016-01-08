<style>
    body{
        background: #4DA81F url("<?php echo Yii::app()->getBaseUrl('webroot').'/images/login_mixed.jpg'; ?>")no-repeat fixed top right / cover !important;
        color: #fff !important;
    }
    h1{color:#fff;font-size: 40px;text-shadow: 0 1px 2px #333;}
    p{font-size: 14px;font-weight: bold;line-height: 20px;color: #424242 !important;}
    .realtime{
        margin: 10px auto;
        background: #0093FF;
        color: #ffffff;
        border: 1px solid #ffffff;
        font-weight: bold;
        padding: 5px;width:150px;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
        box-shadow: 0 0 3px #8F8080;
    }
    .kontainer{text-align:center;width:50%;margin:165px auto;}
    .panel{
        background: rgba(255,255,255,0.5);
        border: 1px solid #fff;
        padding: 15px;
        margin: 15px auto;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        box-shadow: 0 0 8px #5D5C5C;
    }
    .btn-login {
        background: #3FA818;
        border: 1px solid #B5ECA0;
        color: #FFF;
        padding: 15px 10px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        width: 230px;
        box-shadow: 0 0 3px #8F8080;
    }
    .btn-login:hover {
        background: #489929;
        border: 1px solid #B5ECA0;
    }
    img{margin: 15px auto 0 auto;}
</style>

<div class="kontainer">
    <h1><marquee>SELAMAT DATANG</marquee></h1>
    <div class="panel">
        <p>
            Selamat datang di bridging system m-Pasien dan m-Dokter <br />
            Untuk mendownload aplikasi mHospital, silakan klik link di bawah ini : 
        </p>
        <div class='realtime'></div>
        <div>
            <?php echo CHtml::link('<i class="icon-white icon-download-alt"></i> Download versi Android',Yii::app()->baseUrl."/data/apk/m-hospital.apk",array('class'=>'btn btn-login','title'=>'Klik untuk download m-hospital versi android','rel'=>'tooltip')) ?>
            <?php echo CHtml::link('<i class="icon-white icon-download-alt"></i> Download versi Windows Phone',Yii::app()->baseUrl."/data/apk/m-hospital.xap",array('class'=>'btn btn-login','title'=>'Klik untuk download m-hospital versi windows phone','rel'=>'tooltip')) ?>
        </div>
        <img src="<?php echo Yii::app()->getBaseUrl('webroot').'/data/images/innova.png'; ?>" alt="Mobile" />
    </div>
</div>