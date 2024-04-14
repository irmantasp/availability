<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\GroupMembersFilter;
use App\Entity\Availability;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

final class AvailabilityController extends AbstractAdminController
{
    public static function getEntityFqcn(): string
    {
        return Availability::class;
    }

    public function getConfigurableFields(string $pageName): array
    {
        $fields = parent::getConfigurableFields($pageName);

        $fields[] = IntegerField::new('year');
        $fields[] = IntegerField::new('month');

        $daysField = ArrayField::new('days');
        if (Crud::PAGE_INDEX === $pageName) {
            $daysField
            ->setLabel($this->translator->trans('availability.list.days.label'))
            ->formatValue(function ($value) {
                if (is_null($value)) {
                    return null;
                }

                $total = count($value);
                if (0 === $total) {
                    return $this->translator->trans('availability.list.days.empty.label');
                }

                return $total;
            });
        }

        $fields[] = $daysField;

        return $fields;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);

        return $filters
            ->add('year')
            ->add('month')
            ->add(GroupMembersFilter::new('group', 'Group'));
    }
}
