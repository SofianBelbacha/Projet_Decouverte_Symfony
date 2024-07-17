<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use App\Enum\BookStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('ISBN', TextType::class, [
                'label' => 'Code du livre',
            ])
            ->add('Cover', UrlType::class, [
                'label' => 'URL de la couverture',
            ])
            ->add('EditedAt', DateType::class, [
                'label' => 'Date d\'édition',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('Plot', TextareaType::class, [
                'label' => 'résumé',

            ])
            ->add('PageNumber', NumberType::class, [
                'label' => 'Nombre de pages',
            ])
            ->add('status', EnumType::class, [
                'class' => BookStatus::class,
            ])

            ->add('editor', EntityType::class, [
                'label' => 'Editeurs',
                'class' => Editor::class,
                'choice_label' => 'name',
            ])
            ->add('authors', EntityType::class, [
                'label' => 'Les auteurs',
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
