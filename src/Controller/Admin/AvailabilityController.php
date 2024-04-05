<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class AvailabilityController extends AbstractAdminController
{
    public static function getEntityFqcn(): string
    {
        return Availability::class;
    }

    final public function getConfigurableFields(string $pageName): array
    {
        $fields = parent::getConfigurableFields($pageName);

        $fields[] = IntegerField::new('year');
        $fields[] = IntegerField::new('month');

        $daysField = ArrayField::new('days');
        if (Crud::PAGE_INDEX === $pageName) {
            $daysField
            ->setLabel('Total days available')
            ->formatValue(static function ($value) {
                if (is_null($value)) {
                    return null;
                }

                $total = count($value);
                if (0 === $total) {
                    return 'Not available';
                }

                return $total;
            });
        }

        $fields[] = $daysField;

        return $fields;
    }

    final public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);

        return $filters
            ->add('year')
            ->add('month');
    }
}
