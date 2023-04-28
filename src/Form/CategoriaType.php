<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricaocategoria', TextType::class, [
                'label' => 'Descricao da categoria: ',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'A categoria não pode ser nula.',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'A categoria deve ser o nome de no mínimo {{ limit }} caracteres',
                        'maxMessage' => 'A categoria deve ser o nome de no mínimo {{ limit }} caracteres'
                    ])
                ]
            ])
            ->add('Salvar', SubmitType::class);
    }
}
