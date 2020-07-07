<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Etudiant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')
            ->add('date_naissance')
            ->add('type_etudiant',ChoiceType::class, [
                'choices' => [
                    'Type d Etudiant' => [
                        'rien' => 'null',
                        'Boursier' => 'boursier',
                        'Non Boursier' => 'nonboursier'
                    ],
                ],
            ])
            ->add('type_bourse',ChoiceType::class, [
                'choices' => [
                    'Type de Bourse' => [
                        'rien' => 'null',
                        'Demi Boursier' => '2000',
                        'Pension' => '4000'
                    ],
                ],
                ])
            ->add('adrese')
            ->add('chambre',EntityType::class, [
                'class' => Chambre::class,
                'choice_label' => function($chambre){
                    return $chambre->getNumeroChambre()." ".$chambre->getType();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
