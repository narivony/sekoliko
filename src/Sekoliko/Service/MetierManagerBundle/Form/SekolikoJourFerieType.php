<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Koff\Bundle\I18nFormBundle\Form\Type\TranslationsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class SekolikoJourFerieType
 * @package App\Sekoliko\Service\MetierManagerBundle\Form
 */
class SekolikoJourFerieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jrFerNom', TextType::class, array(
                'label'    => "Nom",
                'required' => true
            ))

            ->add('jrFerDate', DateTimeType::class, array(
                'label'  => "Date",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'   => array(
                    'class'         => 'kl-datetimepicker-simple',
                    'required'      => true,
                    'autocomplete'  => 'off'
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
            'data_class' => 'App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoJourFerie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'Sekoliko_service_metiermanagerbundle_jour_ferie';
    }
}
