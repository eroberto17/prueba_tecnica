<?php

namespace Test\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastName')
            ->add('email', 'email')
            ->add('observation', 'textarea')
            //->add('createdAt')
            //->add('updatedAt')

            ->add('groupclient', 'entity', array(
                'class' => 'TestClientBundle:GroupClient',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('g');
                },
                'choice_label' => 'getDescription',
                'multiple' => true
            ))

            ->add('save', 'submit', array('label' => 'Registrar'))

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Test\ClientBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'test_clientbundle_client';
    }


}
