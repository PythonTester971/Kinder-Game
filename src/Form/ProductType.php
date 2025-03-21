<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class, ['label' => 'Nom du jeu', 'required' => true])
            ->add('price', NumberType::class, ['label' => 'Prix du jeu', 'required' => true])
            ->add('description', TextareaType::class, ['label' => 'Description du jeu', 'required' => true])
            ->add('media', TextType::class, ['label' => "URL de l'image"])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'required' => true,
            ])
            // ->add('is_reduced', null, ['required' => false, 'empty_data' => 0])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
