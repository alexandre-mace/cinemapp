<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17/04/19
 * Time: 20:19
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterMovieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filterByAvailability', CheckboxType::class, [
                'required' => false,
                'label' => 'find available movies'
            ])
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Search a movie by his name'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Search'
            ])
        ;
    }
}