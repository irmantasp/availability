<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventController extends AbstractAdminController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    final public function getConfigurableFields(string $pageName): array
    {
        $fields = parent::getConfigurableFields($pageName);

        $fields[] = TextField::new('title')
            ->hideOnDetail();
        $fields[] = DateTimeField::new('date');
        $fields[] = AssociationField::new('userGroup');
        $fields[] = TextareaField::new('description')
            ->hideOnIndex();

        return $fields;
    }

    final public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('userGroup')
            ->add('title')
            ->add('date')
            ->add('description');
    }

    final public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_EDIT, function ($entityInstance) {
            return sprintf('Edit "%s"', $entityInstance->getTitle());
        });

        $crud->setPageTitle(Crud::PAGE_DETAIL, function ($entityInstance) {
            return $entityInstance->getTitle();
        });

        return parent::configureCrud($crud); // TODO: Change the autogenerated stub
    }
}
