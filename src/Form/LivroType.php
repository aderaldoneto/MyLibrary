<?php

namespace App\Form;

use App\Entity\Assunto;
use App\Entity\Autor;
use App\Entity\Livro;
use App\Form\DataTransformer\CentavosParaMoedaTransformer;
use App\Repository\AssuntoRepository;
use App\Repository\AutorRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class LivroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, ['label' => 'Título', 'attr' => ['maxlength' => 40]])
            ->add('editora', TextType::class, ['label' => 'Editora', 'attr' => ['maxlength' => 40]])
            ->add('edicao', IntegerType::class, ['label' => 'Edição', 'attr' => ['min' => 1]])
            ->add('anoPublicacao', TextType::class, [
                'label' => 'Ano de publicação', 
                'help' => 'Ex.: ' . date('Y'),
                'attr' => ['maxlength' => 4, 'inputmode' => 'numeric', 'pattern' => '\\d{4}']])
            ->add('valor', TextType::class, [
                'label' => 'Valor',
                'attr' => ['data-currency-mask' => true, 'inputmode' => 'numeric', 'autocomplete' => 'off'],
            ])
            ->add('autores', EntityType::class, [
                'class' => Autor::class, 'choice_label' => 'nome', 'label' => 'Autores', 'multiple' => true, 'by_reference' => false,
                'query_builder' => static fn (AutorRepository $repository) => $repository->createQueryBuilder('autor')->orderBy('autor.nome', 'ASC'),
            ])
            ->add('assuntos', EntityType::class, [
                'class' => Assunto::class, 'choice_label' => 'descricao', 'label' => 'Assuntos', 'multiple' => true, 'by_reference' => false,
                'query_builder' => static fn (AssuntoRepository $repository) => $repository->createQueryBuilder('assunto')->orderBy('assunto.descricao', 'ASC'),
            ]);

        $builder->get('valor')->addModelTransformer(new CentavosParaMoedaTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Livro::class]);
    }
}
