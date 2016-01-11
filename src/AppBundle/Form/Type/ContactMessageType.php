<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactMessageType
 *
 * @category FormType
 * @package  AppBundle\Form\Type
 * @author   David Romaní <david@flux.cat>
 */
class ContactMessageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'message',
                'textarea',
                array(
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'rows' => 6,
                        'placeholder' => 'message',
                    ),
                )
            )
            ->add(
                'email',
                'email',
                array(
                    'label' => false,
                    'required' => true,
                    'attr' => array(
                        'placeholder' => 'email',
                    ),
                )
            )
            ->add(
                'send',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn-primary',
                    ),
                )
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact_message';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ContactMessage',
        ));
    }
}
