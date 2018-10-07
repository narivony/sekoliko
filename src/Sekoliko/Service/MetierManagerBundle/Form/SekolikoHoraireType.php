<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class SekolikoHoraireType
 * @package App\Sekoliko\Service\MetierManagerBundle\Form
 */
class SekolikoHoraireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('hrDateDebutSaison', DateTimeType::class, array(
                'label'  => "Date début de la saison",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   => array(
                    'class'         => 'kl-datetimepicker-date-debut-saison',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))
            ->add('hrDateFinSaison', DateTimeType::class, array(
                'label'  => "Date de fin de la saison",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   => array(
                    'class'         => 'kl-datetimepicker--date-fin-saison',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))
            ->add('hrDebut', DateTimeType::class, array(
                'label'    => "Heure début",
                'widget'   => 'single_text',
                'format'   => 'H:m',
                'attr'     => array(
                    'class'         => 'kl-datetimepicker-heure-debut',
                    'required'      => true,
                    'autocomplete'  => 'off'
                )
            ))
            ->add('hrFin', DateTimeType::class, array(
                'label'    => "Heure fin",
                'widget'   => 'single_text',
                'format'   => 'H:m',
                'attr'     => array(
                    'class'        => 'kl-datetimepicker-heure-fin',
                    'required'     => true,
                    'autocomplete' => 'off'
                )
            ))
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoHoraire'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sekoliko_service_metiermanagerbundle_horaire';
    }
}
