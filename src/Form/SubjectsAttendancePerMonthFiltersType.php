<?php

namespace App\Form;

use App\Vo\PeriodFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectsAttendancePerMonthFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('selectPeriod', ChoiceType::class, [
                'choices' => [
                    'Monthly' => PeriodFilter::MONTHLY,
                    'Bimester' => PeriodFilter::BIMESTER,
                    'Trimester' => PeriodFilter::TRIMESTER,
                    'Quarter' => PeriodFilter::QUARTER,
                ],
                'attr' => ['class' => 'select-period-input'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
