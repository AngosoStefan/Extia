<?php

namespace TBSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BasketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bFloor',ChoiceType::class, array(
                    'choices' => array(
                    '4th' => '4',
                    '5th' => '5'
                ),
                'required'    => true,
                'placeholder' => 'Choose your floor',
                'empty_data'  => null
                ))
            ->add('bRoom')
            //->add('bDate', 'datetime')
            ->add('bStatus')
            //->add('id')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TBSBundle\Entity\Basket'
        ));
    }
}
