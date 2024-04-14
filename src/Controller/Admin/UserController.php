<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;

final class UserController extends AbstractAdminController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function getConfigurableFields(string $pageName): array
    {
        $fields = parent::getConfigurableFields($pageName);

        $fields[] = EmailField::new('email');
        $fields[] = ArrayField::new('roles');

        return $fields;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);

        return $filters
            ->add(
                ArrayFilter::new('roles')
            );
    }

    public function configureActions(Actions $actions): Actions
    {
        $userGroups = Action::new('showUserGroups', 'Show groups')
        ->linkToUrl(function (User $user) {
            return $this
                ->adminUrlGenerator
                ->setController(GroupController::class)
                ->setAction(Action::INDEX)
                ->set('filters[members][value][]', $user->getId())
                ->set('filters[members][comparison]', '=')
                ->generateUrl();
        });

        $actions->add(Crud::PAGE_INDEX, $userGroups);
        $actions->add(Crud::PAGE_DETAIL, $userGroups);
        $actions->add(Crud::PAGE_EDIT, $userGroups);

        $userAvailabilities = Action::new('showUserAvailabilities', 'Show availabilities')
            ->linkToUrl(function (User $user) {
                return $this
                    ->adminUrlGenerator
                    ->setController(AvailabilityController::class)
                    ->setAction(Action::INDEX)
                    ->set('filters[user][value]', $user->getId())
                    ->set('filters[user][comparison]', '=')
                    ->generateUrl();
            });

        $actions->add(Crud::PAGE_INDEX, $userAvailabilities);
        $actions->add(Crud::PAGE_DETAIL, $userAvailabilities);
        $actions->add(Crud::PAGE_EDIT, $userAvailabilities);


        return parent::configureActions($actions);
    }
}
