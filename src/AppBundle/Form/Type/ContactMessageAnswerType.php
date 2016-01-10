<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class ContactMessageAnswerType
 *
 * @category FormType
 * @package  AppBundle\Form\Type
 * @author   David Romaní <david@flux.cat>
 */
class ContactMessageAnswerType extends ContactMessageType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'message',
                'textarea',
                array(
                    'required'  => false,
                    'read_only' => true,
                    'attr'      => array(
                        'rows' => 6,
                    ),
                )
            )
            ->add(
                'email',
                'email',
                array(
                    'required'  => false,
                    'read_only' => true,
                )
            )
            ->add(
                'description',
                'textarea',
                array(
                    'label'    => 'backend.admin.answer',
                    'required' => true,
                    'attr'     => array(
                        'rows' => 6,
                    ),
                )
            )
            ->add(
                'send',
                'submit',
                array(
                    'attr'  => array(
                        'class' => 'btn-violet',
                    ),
                )
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact_message_answer';
    }
}
