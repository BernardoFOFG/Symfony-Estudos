<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProdutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nomeproduto',
                TextType::class,
                [
                    'label' => 'Nome do produto: ',
                    'required' => false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'O Produto não pode ser nulo.',
                        ]),
                        new Length([
                            'min' => 4,
                            'max' => 50,
                            'minMessage' => 'O nome do produto tem que ter no mínimo {{ limit }} caracteres',
                            'maxMessage' => 'O nome do produto tem que ter no máximo {{ limit }} caracteres'
                        ])
                    ]
                ]
            )

            ->add('valor', TextType::class, [
                'label' => 'Valor: ',
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan([
                        'value' => -1,
                        'message' => 'O valor inserido deve positivo!'
                    ]),
                ]
            ],)
            ->add('categoria', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'descricaocategoria',
                'label' => 'Categoria: '
            ])
            ->add('Salvar', SubmitType::class);
    }
}
