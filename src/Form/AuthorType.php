<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('DateOfBirth', DateType::class, [
                'label' => 'Date de naissance',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('DateOfDeath', DateType::class, [
                'label' => 'Date de déces',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('Nationality', TextType::class, [
                'label' => 'Nationalité',
                'required' => false,
            ])
            ->add('books', EntityType::class, [
                'label' => 'Livre(s) écrit(s)',
                'class' => Book::class,
                'choice_label' => 'Title',
                'multiple' => true,
                'required' => false,
            ])
            ->add('Nationality', TextType::class, [
                'label' => 'Nationalité',
                'required' => false,
            ])
            ->add('Validation', checkboxType::class, [
                'label' => 'Je certifie de l\'exactitude des donnée fournies',
                'mapped' => false,
                'constraints' => [
                    new IsTrue(message: "Vous devez cocher la case"),
                ],    
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
