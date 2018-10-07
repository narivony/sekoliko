<?php

namespace  App\Sekoliko\Service\UserBundle\Form;

use App\Sekoliko\Service\MetierManagerBundle\Utils\RoleName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('usrLastname', TextType::class, array(
                'label' => 'Nom',
                'required' => true,
                'attr'     => array(
                    'class' => "form-control"
                )
            ))

            ->add('usrFirstname', TextType::class, array(
                'label'    => "Prénom",
                'required' => true,
                'attr'     => array(
                    'class' => "form-control"
                )
            ))

            ->add('usrAddress', TextType::class, array(
                'label'    => "Adresse",
                'required' => false,
                'attr'     => array(
                    'class' => "form-control"
                )
            ))

            ->add('usrPhone', TextType::class, array(
                'label'    => "Téléphone",
                'attr'     => array(
                    'pattern' => "[0-9 ]{2,}",
                    'class'   => "form-control"
                    ),
                'required' => false
            ))

            ->add('email', EmailType::class, array(
                'label'    => "Adresse email",
                'attr'     => array(
                    'pattern' => "[^@]+@[^@]+\.[a-zA-Z]{2,}",
                    'class'  => "form-control"

                ),
                'required' => true
            ))

            ->add('usrColor', TextType::class, array(
                'label' => "Code couleur",
                'attr'  => array(
                    'class'        => 'jscolor {hash:true}  form-control',
                    'required'     => true,
                    'autocomplete' => 'off'
                )
            ))

            ->add('usrPhoto', FileType::class, array(
                'label'    => 'Photo de profil (max : 1Mo)',
                'mapped'   => false,
                'attr'     => array(
                    'accept' => 'image/*',
                    'class' => 'form-control'
                ),
                'required' => false,
            ))

            ->add('enabled', CheckboxType::class, array(
                'label'    => "Actif",
                'required' => false
            ))

            ->add('plainPassword',RepeatedType::class, array(
                'type'            => PasswordType::class,
                'options'         => array('translation_domain' => 'FOSUserBundle'),
                'first_options'   => array(
                    'label' => 'form.password',
                    'attr'  => array(
                        'minleght' => 6,
                        'class'    => "form-control"
                    )
                ),
                'second_options'  => array(
                    'label' => 'form.password_confirmation',
                    'attr'  => array(
                        'class' => 'form-control'
                    )
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Sekoliko\Service\UserBundle\Entity\User',
            'user_role'  => null
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sekoliko_userbundle_user';
    }
}
