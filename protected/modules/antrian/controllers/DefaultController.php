<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
                $this->layout = '//layouts/column1';
		$this->render('index');
	}
}