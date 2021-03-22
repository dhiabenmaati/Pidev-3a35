<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('desc_rec',TextareaType::class,
                [
                     'attr' => ['class' => 'form-control form-control-lg'
                     ,
                         'rows'=>'5'
                     ],


                ])
            ->add('type', ChoiceType::class,
                [
                'choices' => [
                    'Produit' => 'Produit',
                    'Vendeur' => 'Vendeur',
                    'Livarison' => 'Livarison',
                    'Enchere' => 'Enchere',
                    'Autres' => 'Autres',
                ],
                    'attr' => ['class'=>'form-control'],

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
