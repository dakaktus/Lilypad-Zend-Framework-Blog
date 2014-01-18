<?php

class Kaktus_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request){

        $navigationConfig = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml','nav');
        $navigation = new Zend_Navigation($navigationConfig);

        Zend_Registry::set('Zend_Navigation',$navigation);

    }

}