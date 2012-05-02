<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    public function indexAction()
    {
        try {
            $entries = $this->getLocator()->get('Guestbook\Model\EntryProvider', array('shortentries' => 2));
        }
        catch(\PDOException $e) {
            $entries = array();
        }
        //$entries = $this->getLocator()->get('Guestbook\Model\EntryProvider');
        $sidebar = new ViewModel(compact('entries'));
        $sidebar->setTemplate('sidebar/latest');

        $view = new ViewModel();
        $view->addChild($sidebar, 'sidebar');

        return $view;
    }
}
