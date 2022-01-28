<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('phone')
            ->add('userCompany', EntityType::class, [
                'class'        => Company::class,
                'choice_label' => 'company_name',
                'multiple'     => false,
                'expanded'     => false,
            ])
            ->add('roles', ChoiceType::class, [
                'required'=> true,
                'multiple' =>false,
                'expanded' =>false,
                'choices'=> [
                    'Admin' => 'ROLE_ADMIN',
                    'Colaborateur' => 'ROLE_PARTNER',
                    'Secretaire' => 'ROLE_EDITOR',
                    'Sous-traitant' => 'ROLE_USER',
                ]
            ])
        ;

        //Data Transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray){
                    // on change l'Array en String
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    //on change le String en Array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
