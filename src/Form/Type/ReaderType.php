<?php

namespace App\Form\Type;

use App\Entity\Reader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ip',IntegerType::class,['label'=>'IP','attr' => [
                'min' => 0,
                'max' => 255
            ]])
            ->add('timingPoint',TextType::class,['label'=>'Timing point'])
            ->add('readingStatus',CheckboxType::class, ['label'=>'Enabled?'])
        ;
        $builder->get('readingStatus')
            ->addModelTransformer(new CallbackTransformer(
                function ($value) {
                    return (bool)$value;
                },
                function ($value) {
                    return (int)$value;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reader::class,
        ]);
    }
}
