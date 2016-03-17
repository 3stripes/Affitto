<?php

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'documento' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/documento',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Documento',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,

                'child_routes' => array(
                    'id' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:id',

                            'constraints' => array(
                                'id' => '[0-9]*'
                            ),
                        ),
                        'may_terminate' => false,

                        'child_routes' => array(
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit',
                                    'defaults' => array(
                                        'action' => 'edit',
                                    ),
                                ),
                                'may_terminate' => true
                            ),

                            'download' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/download',
                                    'defaults' => array(
                                        'action' => 'download',
                                    ),
                                ),
                                'may_terminate' => true
                            ),

                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),
                                ),
                                'may_terminate' => true
                            ),


                        )
                    ),

                    'create' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'action' => 'create',
                            ),

                        ),

                    ),

                    'categoryDocumento' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/categoryDocumento',
                            'defaults' => array(
                                'controller' => 'Application\Controller\CategoryDocumento',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'save' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/save',
                                    'defaults' => array(
                                        'action' => 'save',
                                    ),

                                ),

                            ),
                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),

                                ),

                            ),
                        )

                    ),
                )

            ),

            'convenzione' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/convenzione',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Convenzione',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,

                'child_routes' => array(
                    'id' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:id',

                            'constraints' => array(
                                'id' => '[0-9]*'
                            ),
                        ),
                        'may_terminate' => false,

                        'child_routes' => array(
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit',
                                    'defaults' => array(
                                        'action' => 'edit',
                                    ),
                                ),
                                'may_terminate' => true
                            ),

                            'view' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/view',
                                    'defaults' => array(
                                        'action' => 'view',
                                    ),
                                ),
                                'may_terminate' => true
                            ),

                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),
                                ),
                                'may_terminate' => true
                            ),

                            'download' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/download',
                                    'defaults' => array(
                                        'action' => 'download',
                                    ),
                                ),
                                'may_terminate' => true
                            ),
                        )
                    ),

                    'create' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'action' => 'create',
                            ),

                        ),

                    ),

                    'categoryConvenzione' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/categoryConvenzione',
                            'defaults' => array(
                                'controller' => 'Application\Controller\CategoryConvenzione',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'save' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/save',
                                    'defaults' => array(
                                        'action' => 'save',
                                    ),

                                ),

                            ),
                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),

                                ),

                            ),
                        )

                    ),
                )
            ),
            'news' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/news',
                    'defaults' => array(
                        'controller' => 'Application\Controller\News',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'id' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:id',
                            'constraints' => array(
                                'id' => '[0-9]*'
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'view' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/view',
                                    'defaults' => array(
                                        'action' => 'view',
                                    ),
                                ),
                                'may_terminate' => true
                            ),

                        )
                    ),

                    'create' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'action' => 'create',
                            ),

                        ),

                    ),
                    'delete' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/delete',
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                        ),
                        'may_terminate' => true
                    ),

                )

            ),


        ),
    ),

        'service_manager' => array(
            'abstract_factories' => array(
                'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
                'Zend\Log\LoggerAbstractServiceFactory',
            ),
            'factories' => array(
                'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
                'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            ),
        ),
        'controllers' => array(
            'invokables' => array(
                'Application\Controller\Index' => Controller\IndexController::class,
                'Application\Controller\Documento' => Controller\DocumentoController::class,
                'Application\Controller\Convenzione' => Controller\ConvenzioneController::class,
                'Application\Controller\CategoryConvenzione' => Controller\CategoryConvenzioneController::class,
                'Application\Controller\CategoryDocumento' => Controller\CategoryDocumentoController::class,
                'Application\Controller\News' => Controller\NewsController::class

            ),
        ),
        'view_manager' => array(
            'display_not_found_reason' => true,
            'display_exceptions' => true,
            'doctype' => 'HTML5',
            'not_found_template' => 'error/404',
            'exception_template' => 'error/index',
            'template_map' => array(
                'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
                'error/404' => __DIR__ . '/../view/error/404.phtml',
                'error/index' => __DIR__ . '/../view/error/index.phtml',
            ),
            'template_path_stack' => array(
                __DIR__ . '/../view',
            ),
            'strategies' => array(
                'ViewJsonStrategy',
            ),
        ),
        // Placeholder for console routes
        'console' => array(
            'router' => array(
                'routes' => array(),
            ),
        ),
        'doctrine' => array(
            'driver' => array(
                'application' => array(
                    'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                    'cache' => 'array',
                    'paths' => array(__DIR__ . '/../src/Application/Entity')
                ),
                'orm_default' => array(
                    'drivers' => array(
                        'Application\Entity' => 'application'
                    ),
                ),
            ),
        ),
        'navigation' => array(
            'default' => array(
                array(
                    'label' => 'Home',
                    'route' => 'home',
                ),
                array(
                    'label' => 'Documenti',
                    'route' => 'documento',
                    'pages' => array(
                        array(
                            'label' => 'Documenti',
                            'route' => 'documento',
                        ),
                        array(
                            'label' => 'Category',
                            'route' => 'documento/categoryDocumento',
                        ),
                    ),
                ),
                array(
                    'label' => 'Convenzioni',
                    'route' => 'convenzione',
                    'pages' => array(
                        array(
                            'label' => 'Convenzioni',
                            'route' => 'convenzione',
                        ),
                        array(
                            'label' => 'Category',
                            'route' => 'convenzione/categoryConvenzione',
                        ),
                    ),
                ),
                array(
                    'label' => 'News',
                    'route' => 'news',
                ),
            ),
        ),

    );
