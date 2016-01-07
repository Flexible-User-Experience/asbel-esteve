<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class FilmImageAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   David Romaní <david@flux.cat>
 */
class FilmImageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Film Image';
    protected $baseRoutePattern = 'web/film-image';
    protected $datagridValues = array(
        '_sort_by'    => 'position',
        '_sort_order' => 'asc',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'film',
                null,
                array(
                    'required' => true,
                    'attr'     => array(
                        'hidden' => true,
                    ),
                )
            )
            ->add(
                'imageFile',
                'file',
                array(
                    'label'       => 'backend.admin.image',
                    'required'    => false,
                    'help'        => $this->getImageHelperFormMapperWithThumbnail(),
                    'sonata_help' => $this->getImageHelperFormMapperWithThumbnail(),
                )
            )
            ->add(
                'position',
                null,
                array(
                    'required' => true,
                )
            )
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
                'film',
                null,
                array()
            )
            ->add(
                'position',
                null,
                array(
                    'editable' => true,
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
                        'edit'   => array(),
                        'delete' => array(),
                    ),
                )
            );
    }
}
