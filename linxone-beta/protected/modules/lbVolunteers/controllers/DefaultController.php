<?php

class DefaultController extends CLBController
{
	public function actionIndex() {
		LBApplication::render($this, 'index',array());
	}

	public function actionVolunteerInfo() {
		LBApplication::render($this, 'volunteer_info',array());
	}
}