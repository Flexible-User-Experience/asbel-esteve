<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class PageAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   David Romaní <david@flux.cat>
 */
class PageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Category';
    protected $baseRoutePattern = 'web/page';
    protected $datagridValues = array(
        '_sort_by'    => 'title',
        '_sort_order' => 'asc',
    );

    /**
     * Configure route collection
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch')
            ->remove('create')
            ->remove('delete');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(8))
            ->add(
                'title',
                null,
                array()
            )
            ->add(
                'description',
                'ckeditor',
                array(
                    'config_name' => 'my_config',
                    'required'    => true,
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(4))
            ->add(
                'metaKeywords',
                null,
                array(
                    'label' => 'backend.admin.metakeywords',
                    'help'  => 'backend.admin.metakeywordshelp',
                )
            )
            ->add(
                'metaDescription',
                null,
                array(
                    'label' => 'backend.admin.metadescription',
                )
            )
            ->end();
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'title',
                null,
                array(
                    'editable' => true,
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                    ),
                )
            );
    }
}
