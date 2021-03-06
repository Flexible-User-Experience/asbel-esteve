<?php

namespace AppBundle\Admin;

use AppBundle\Repository\CategoryRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class FilmAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   David Romaní <david@flux.cat>
 */
class FilmAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Content';
    protected $baseRoutePattern = 'web/content';
    protected $datagridValues = array(
        '_sort_by'    => 'publishedAt',
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
            ->select($query->getRootAliases()[0] . ', c, i')
            ->leftJoin($query->getRootAliases()[0] . '.categories', 'c')
            ->leftJoin($query->getRootAliases()[0] . '.images', 'i');

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
                'imageFile',
                'file',
                array(
                    'label'    => 'backend.admin.image',
                    'help'     => $this->getImageHelperFormMapperWithThumbnail(),
                    'required' => false,
                )
            )
            ->add(
                'publishedAt',
                'sonata_type_date_picker',
                array(
                    'label'  => 'backend.admin.published_date',
                    'format' => 'd/M/y',
                )
            )
            ->add(
                'year',
                null,
                array()
            )
            ->add(
                'urlVimeo',
                null,
                array(
                    'label' => 'backend.admin.vimeo',
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'categories',
                null,
                array(
                    'query_builder' => function (CategoryRepository $repository) {
                        return $repository->findAllSortedByTitleQB();
                    },
                )
            )
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
            ->add(
                'bootstrapColumns',
                null,
                array(
                    'label' => 'backend.admin.bootstrapcolumns',
                    'help'  => 'backend.admin.bootstrapcolumnshelp',
                )
            )
            ->add(
                'enabled',
                'checkbox',
                array(
                    'required' => false,
                )
            )
            ->end()
            ->with('backend.admin.content', $this->getFormMdSuccessBoxArray(12))
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
            ->end();
        if ($this->id($this->getSubject())) { // is edit mode, disable on new subjects
            $formMapper
                ->with('backend.admin.images', $this->getFormMdSuccessBoxArray(12))
                ->add(
                    'images',
                    'sonata_type_collection',
                    array(
                        'label'              => ' ',
                        'required'           => false,
                        'cascade_validation' => true,
                    ),
                    array(
                        'edit'     => 'inline',
                        'inline'   => 'table',
                        'sortable' => 'position',
                    )
                )
                ->end();
            $formMapper->setHelps(
                array('images' => 'up to 10MB with format PNG, JPG or GIF. min. width 1200px.')
            );
        }
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
                'categories',
                null,
                array()
            )
            ->add(
                'publishedAt',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.published_date',
                    'field_type' => 'sonata_type_date_picker',
                    'format'     => 'd-m-Y',
                )
            )
            ->add(
                'year',
                null,
                array()
            )
            ->add(
                'description',
                null,
                array()
            )
            ->add(
                'urlVimeo',
                null,
                array(
                    'label' => 'backend.admin.vimeo',
                )
            )
            ->add(
                'metaKeywords',
                null,
                array(
                    'label' => 'backend.admin.metakeywords',
                )
            )
            ->add(
                'metaDescription',
                null,
                array(
                    'label' => 'backend.admin.metadescription',
                )
            )
            ->add(
                'bootstrapColumns',
                null,
                array(
                    'label' => 'backend.admin.bootstrapcolumns',
                )
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
                null,
                array(
                    'label'    => 'backend.admin.image',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig'
                )
            )
            ->add(
                'publishedAt',
                'date',
                array(
                    'label'    => 'backend.admin.published_date',
                    'format'   => 'd/m/Y',
                    'editable' => true,
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
