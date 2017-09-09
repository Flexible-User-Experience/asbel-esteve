<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ContactMessageAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   David Romaní <david@flux.cat>
 */
class ContactMessageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Contact Message';
    protected $baseRoutePattern = 'web/message';
    protected $datagridValues = array(
        '_sort_by'    => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * Configure route collection
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('batch')
            ->add('answer', $this->getRouterIdParameter() . '/answer');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'checked',
                null,
                array()
            )
            ->add(
                'createdAt',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.date',
                    'field_type' => 'sonata_type_date_picker',
                )
            )
            ->add(
                'email',
                null,
                array()
            )
            ->add(
                'message',
                null,
                array()
            )
            ->add(
                'answered',
                null,
                array()
            )
            ->add(
                'description',
                null,
                array(
                    'label' => 'backend.admin.answer',
                )
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add(
                'createdAt',
                'date',
                array(
                    'label'  => 'backend.admin.date',
                    'format' => 'd/m/Y H:i',
                )
            )
            ->add(
                'checked',
                null,
                array()
            )
            ->add(
                'email',
                null,
                array()
            )
            ->add(
                'message',
                'textarea',
                array()
            )
            ->add(
                'answered',
                null,
                array()
            );
        if ($this->getSubject()->getAnswered()) {
            $showMapper
                ->add(
                    'description',
                    'textarea',
                    array(
                        'label' => 'backend.admin.answer',
                    )
                );
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'checked',
                null,
                array()
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label'  => 'backend.admin.date',
                    'format' => 'd/m/Y'
                )
            )
            ->add(
                'email',
                null,
                array()
            )
            ->add(
                'answered',
                null,
                array()
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array(),
                        'answer' => array(
                            'template' => '::Admin/Cells/list__action_answer.html.twig'
                        ),
                        'delete' => array(),
                    ),
                )
            );
    }
}
