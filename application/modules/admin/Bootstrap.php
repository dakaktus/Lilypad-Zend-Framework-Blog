<?php

/**
 * Module's bootstrap file.
 * Notice the bootstrap class' name is "Modulename_"Bootstrap.
 * When creating your own modules make sure that you are using the correct namespace
 */
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _bootstrap()
     {
         //Now let's parse the module specific configuration
         //Path might change however this is probably the one you won't ever need to change...
         //And also don't forget to use the current staging environment by sending the APP_ENV parameter to the Zend_Config
         $_conf = new Zend_Config_Ini(APPLICATION_PATH . "/modules/" . strtolower($this->getModuleName()) . "/config/application.ini", APPLICATION_ENV);
         $this->_options = array_merge($this->_options, $_conf->toArray()); //Let's merge the both arrays so that we can use them together...
         parent::_bootstrap(); //Well our custom bootstrap logic should end with the actual bootstrapping, now that we have merged both configs, we can go on...
     }

     protected function _initAdminModule()
     {
         $_isEnabled = $this->_options['config']['enabled'];
         if ($_isEnabled != 1) {
             throw new Exception($this->_options[$this->_options["language"]["selected"]]["error_message"]);
         }
     }

    protected function _initRouter(){
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $routes = array();

        $routes['admin'] = new Zend_Controller_Router_Route(
            '/admin',
            array(
                'module' => 'admin',
                'controller' => 'index',
                'action' => 'index'
            )
        );

        $routes['admin-login'] = new Zend_Controller_Router_Route(
            '/login',
            array(
                'module' => 'admin',
                'controller' => 'author',
                'action' => 'login'
            )
        );

        $router->addRoutes($routes);
    }

     protected function _initModuleLangArray()
     {
         //Now let's define our language array to the registry so that we can use it...
         //Notice I have added "Admin_" prefix to the registry to avoid any conflicts with other modules...
         Zend_Registry::set("Admin_language", $this->_options[$this->_options["language"]["selected"]]);
     }

    //init Auth Plugin
    protected function _initAclPlugin()
    {
        $this->auth = Zend_Auth::getInstance();
        $this->acl = new Admin_Acl_Acl($this->auth);
        Zend_Controller_Front::getInstance()->registerPlugin(
                new Admin_Acl_Plugin_Acl($this->auth, $this->acl));
    }


 }