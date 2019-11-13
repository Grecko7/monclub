<?php

namespace App\Form;

use App\Entity\JoueurSearch;
use App\Entity\Langage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueurSearchType extends AbstractType
{
        // Création d'un formulaire pour le filtrage 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('minPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => ' Prix minimal'
                ]
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => ' Prix maximal'
                ]
            ])
            ->add('minNiveau', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => ' Potentiel minimal'
                ]
            ])
            ->add('maxNiveau', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => ' Potentiel maximal'
                ]
            ])
            ->add('langages', EntityType::class, [
                'required' => false,
                'label' => 'Langue(s) parlée(s)',
                'class' => Langage::class,
                'choice_label' => 'nom',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JoueurSearch::class,
            // Pour que les utlisateurs puissent partager leurs recherches nous changeons quelques paramètres
            // Nous desactivons aussi la protection csrf car il n'y aura pas besoin de token pour cette requête
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    // Méthode 'magique' pour obtenir une URL plus jolie lors de la recherche avec filtre
    public function getBlockPrefix()
    {
        return '';
    }

}

