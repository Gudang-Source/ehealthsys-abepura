<?php
    class InfoKomposisiBahanMakananController extends MyAuthController
    {
            public function actionIndex()
            {
                    $modKomposisiBahanMakanan = new GZBahanmakananM;
                    
                    if(isset($_REQUEST['GZBahanMakananM'])){
                        $modKomposisiBahanMakanan->attributes=$_REQUEST['GZBahanMakananM'];
                    }
                    $this->render('index',array('modKomposisiBahanMakanan'=>$modKomposisiBahanMakanan));
            }

    }

?>