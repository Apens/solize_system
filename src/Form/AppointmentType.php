<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\Customer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_time', DateTimeType::class, [
                'label' => 'Heure du debut',
                'attr'  => [
                    'class' => 'form-control'
                ],
                'hours' => range(9,17),
                'days'  => range(date('d'), 31),
                'months'=> range(date('m'), 12),
                'years' => range(date('Y'), date('Y')+100 )
            ])
            ->add('expected_end', DateTimeType::class, [
                'label' => 'Heure de fin',
                'attr'  => [
                    'class' => 'form-control'
                ],
                'hours' => range(9,17),
                'days'  => range(date('d'), 31),
                'months'=> range(date('m'), 12),
                'years' => range(date('Y'), date('Y')+100 )
            ])
            ->add('end_time', DateTimeType::class, [
                'label' => 'Heure de fin réelle',
                'help'  => 'Inserer l\'heure à laquelle s\'est terminé le rendez-vous ',
                'attr'  => [
                    'class' => 'form-control'
                ],
                'hours' => range(9,24),
                'days'  => range(date('d'), 31),
                'months'=> range(date('m'), 12),
                'years' => range(date('Y'), date('Y')+100 )
            ])
            ->add('approved_by_client', CheckboxType::class, [
                'label'      => 'Approuvé par le Client',
                'required' => false,
                'label_attr' => [
                    'class'  => 'checkbox-switch',
                ]
            ])
            ->add('appointmentReason', TextareaType::class, [
                'label' => 'Objet du Rendez-vous',
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('appointmentAddress', TextType::class,[
                'label' => 'Lieu du Rendez-vous',
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('appointmentZipcode', TextType::class,[
                'label' => 'Code postal',
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('appointmentCity', TextType::class,[
                'label' => 'Ville',
                'attr'  => [
                    'class' => 'form-control'
                ]
            ])
            ->add('is_cancelled', CheckboxType::class, [
                'label'      => 'Rendez-vous annulé ?',
                'required' => false,
                'label_attr' => [
                    'class'  => 'checkbox-switch',
                ]
            ])
            ->add('cancellation_reason')
            ->add('booked_user', EntityType::class, [
                'label'=> 'Collaborateur',
                'class'        => User::class,
                'placeholder'  => 'Selectionner un collaborateur',
                'choice_label' => 'Fullname',
                'attr'         => [
                    'class'    => 'form-control'
                ]
            ])
            ->add('customer', EntityType::class, [
                'label'       => 'Client',
                'class'       => Customer::class,
                'placeholder' => 'Client souhaitant le rendez-vous',
                'choice_label'=> 'CustomerFullname'
            ])
            ->add('service_job')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
