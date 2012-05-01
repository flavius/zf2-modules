<?php

namespace Guestbook\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $sidebar = new ViewModel(array('type' => 'foo'));
        $sidebar->setTemplate('sidebar/sidebar');

        $template = $sidebar->getTemplate();
        $variables = $sidebar->getVariables();
        $children = $sidebar->getChildren();

        $view = new ViewModel(array('vars' => compact('template', 'variables', 'children')));
        $view->addChild($sidebar, 'sidebar');

        return $view;
    }
}
