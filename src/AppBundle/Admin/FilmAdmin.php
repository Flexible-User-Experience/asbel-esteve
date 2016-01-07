<?php

namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class FilmAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   David Romaní <david@flux.cat>
 */
class FilmAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Film';
    protected $baseRoutePattern = 'web/film';
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
            ->remove('batch');
    }

    /**
     * Override query list to reduce queries amount on list view (apply join strategy)
     *
     * @param string $context context
     *
     * @return QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $query
            ->select($query->getRootAliases()[0] . ', c')
            ->leftJoin($query->getRootAliases()[0] . '.categories', 'c');

        return $query;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'title',
                null,
                array()
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'enabled',
                'checkbox',
                array(
                    'required' => false,
                )
            )
            ->end();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'title',
                null,
                array()
            )
            ->add(
                'year',
                null,
                array()
            )
            ->add(
                'enabled',
                null,
                array()
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'image',
                'date',
                array(
                    'label'    => 'backend.admin.image',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig'
                )
            )
            ->add(
                'year',
                null,
                array(
                    'editable' => true,
                )
            )
            ->add(
                'title',
                null,
                array(
                    'editable' => true,
                )
            )
            ->add(
                'count',
                null,
                array(
                    'label'    => 'backend.admin.categories_amount',
                    'template' => '::Admin/Cells/list__cell_categories_amount_field.html.twig',
                )
            )
            ->add(
                'enabled',
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
                        'show'   => array(),
                        'edit'   => array(),
                        'delete' => array(),
                    ),
                )
            );
    }
}
