<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, array(
            'label'=>'Nom :'
        ))
            ->add('lastname', TextType::class, array(
                'label'=>'Prénom :'
            ))
            ->add('phone', TextType::class, array(
                'label'=>'Téléphone fixe :'
            ))
            ->add('portable', TextType::class, array(
                'label'=>'Téléphone portable :'
            ))
            ->add('departement', EntityType::class, array('required' => true,
                'placeholder' => 'Choisir une option',
                'class' => 'AppBundle\Entity\Departement',
                'label'=>'Département :',
                'multiple'=>false,
                'expanded' => false,
                'choice_label'=> 'name'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }


}
