<?php

class Kaktus_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request){

        $navigationConfig = new Zend_Config_Xml(APPLICATION_PATH.'/configs/navigation.xml','nav');
        $navigation = new Zend_Navigation($navigationConfig);

        if (Zend_Registry::isRegistered('Zend_Acl')){
            $role = 'guest';
            if (Zend_Auth::getInstance()->hasIdentity()){
                $role = Zend_Auth::getInstance()->getIdentity()->role;
            }
            $acl = Zend_Registry::get('Zend_Acl');
            /* @var $acl Zend_Acl */
            Zend_Debug::dump($acl->isAllowed('guest','admin','view'));
            Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
            Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($role);
        }

        Zend_Registry::set('Zend_Navigation',$navigation);

    }

}