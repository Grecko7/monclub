<?php

namespace App\Form;

use App\Entity\Joueur;
use App\Entity\Langage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Nom')
        ->add('Caract', null, ['label' => 'Carctéristique(s)'])
        ->add('Age')
        ->add('Taille')
        ->add('Niveau')
        ->add('Libre', ChoiceType::class, [
            'choices'=>$this->getLibreString(),
            'label' => 'Statut'])
        ->add('langages', EntityType::class, [
            'class' => Langage::class,
            'required' => false,
            'choice_label' => 'nom',
            'multiple' => true
        ])
        ->add('imageFile', FileType::class, [
            'required' => false
        ])
        ->add('Prix')
            ;
        }
        
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults([
                'data_class' => Joueur::class,
                ]);
            }
            
            private function getLibreString()
            {
                $choices = Joueur::LIBRE;
                $output = [];
                foreach($choices as $key => $value){
                    $output[$value] = $key;
                }
                return $output;
            }
        }
