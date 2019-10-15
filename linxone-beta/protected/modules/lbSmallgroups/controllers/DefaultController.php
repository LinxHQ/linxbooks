<?php

class DefaultController extends CLBController
{
	public function actionIndex() {
		LBApplication::render($this, 'index',array());
	}

	public function actionDetailSmallGroup(){
		LBApplication::render($this, 'detail_small_group',array());
	}
}