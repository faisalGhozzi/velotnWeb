<?php

namespace VelotnBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomprod',TextType::class,array(
                'attr' => ['name' => 'nomprod','class'=>'form-control']
            ))
            ->add('description',TextType::class,array(
                'attr' => ['name' => 'description','class'=>'form-control']
            ))
            ->add('prix',NumberType::class,array(
                'attr' => ['name' => 'prix','class'=>'form-control']
            ))
            ->add('quantite',NumberType::class,array(
                'attr' => ['name' => 'quantite','class'=>'form-control']
            ))
            ->add('imgUrl',TextType::class,array(
                'attr' => ['name' => 'imgUrl','class'=>'form-control','id'=>'imgUrl']
            ))
            ->add('marque',TextType::class,array(
                'attr' => ['name' => 'marque','class'=>'form-control']
            ))
            ->add('type',TextType::class,array(
                'attr' => ['name' => 'type','class'=>'form-control']
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VelotnBundle\Entity\Produits'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'velotnbundle_produits';
    }


}
