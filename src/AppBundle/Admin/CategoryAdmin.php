<?php

namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class CategoryAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   David Romaní <david@flux.cat>
 */
class CategoryAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Category';
    protected $baseRoutePattern = 'web/category';
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
            ->select($query->getRootAliases()[0] . ', f')
            ->leftJoin($query->getRootAliases()[0] . '.films', 'f');

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
                'films',
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
                'title',
                null,
                array()
            )
            ->add(
                'films',
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
                    'label'    => 'backend.admin.films_amount',
                    'template' => '::Admin/Cells/list__cell_films_amount_field.html.twig',
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
