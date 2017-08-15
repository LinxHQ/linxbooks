<?php
/**
 * ApplicationConfigBehavior is a behavior for the application.
 * It loads additional config paramenters that cannot be statically 
 * written in config/main
 */
class AppConfigBehavior extends CBehavior
{
    /**
     * Declares events and the event handler methods
     * See yii documentation on behaviour
     */
    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeginRequest'=>'beginRequest',
        ));
    }
 
    /**
     * Load configuration that cannot be put in config/main
     */
    public function beginRequest()
    {
        /* CODE TICH HOP */
//        $cookie_secret_variable_name = 'LINX_SESSION_VAR';
//        if(!isset($_COOKIE[$cookie_secret_variable_name]))
//		{
//            Yii::app()->user->logout();
//		}
    }
}