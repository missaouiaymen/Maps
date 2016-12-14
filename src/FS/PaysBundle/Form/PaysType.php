<?php

namespace FS\PaysBundle\Form;

use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\DependencyInjection\Tests\Compiler\F;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('population')
            ->add('drapeaux', drapeauxType::class)
            ->add('capitale')
            ->add('superficie')
            ->add('continent',EntityType::class, array(
            'class' => 'FSPaysBundle:Continent',
            'choice_label' => 'nom',))
            ->add('save' ,SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FS\PaysBundle\Entity\Pays'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fs_paysbundle_pays';
    }


}
