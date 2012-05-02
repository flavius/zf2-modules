<?php
return array(
    'di' => array(
        'instance' => array(
            // Setup for router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'guestbook_default' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'priority' => 1000,
                            'options' => array(
                                'route'    => '/guestbook/[:controller[/:action]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'Guestbook\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'guestbook_home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'priority' => 1000,
                            'options' => array(
                                'route'    => '/guestbook/',
                                'defaults' => array(
                                    'controller' => 'Guestbook\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'guestbook_view' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'priority' => 1000,
                            'options' => array(
                                'route'    => '/guestbook/view[/:id]',
                                'defaults' => array(
                                    'controller' => 'Guestbook\Controller\IndexController',
                                    'action'     => 'view',
                                ),
                            ),
                        ),
                    ),
                ),
            ),

            'Guestbook\Model\EntryProvider' => array(
                'parameters' => array(
                    'shortentries' => 5,
                    'dbconnection' => 'masterdb',
                ),
            ),

            // Defining where to look for views. This works with multiple paths,
            // very similar to include_path
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'guestbook' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);
