<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Form\Dto\PostCreateDto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

final class PostCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('body', TextareaType::class, ['required' => false])
            ->add('shortDescription', TextType::class)
            ->add('category', EntityType::class, [
                'class'        => Category::class,
                'choice_label' => 'title',
            ])
//            ->add('image', TextType::class)
            ->add('image', FileType::class, [
                'mapped'      => false,
                'required'    => false,
                'constraints' =>
                    new File([
                        'maxSize'          => '1024k',
                        'mimeTypes'        => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (.jpg, .jpeg, .png, )',
                    ]),
            ])
            ->add('publish', CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostCreateDto::class,
        ]);
    }
}