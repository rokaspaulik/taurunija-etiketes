<?php

namespace App\Form;

use App\Entity\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType as SymfonyFileType;

class MyFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', SymfonyFileType::class, array('label' => 'Duomenų lentelė (Excel failas)'))
            ->add('submit', SubmitType::class, array('label' => 'Importuoti', 'attr' => array(
                'style' => 'margin-top: 12em',
                'class' => 'btn btn-success btn-block btn-lg'
            )));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => File::class
        ));
    }
}
