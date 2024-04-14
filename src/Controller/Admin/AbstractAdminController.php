<?php

namespace App\Controller\Admin;

use App\Entity\AuthorInterface;
use App\Entity\TimestampedEntityInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractAdminController extends AbstractCrudController
{
    protected AdminUrlGeneratorInterface $adminUrlGenerator;

    protected TranslatorInterface $translator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        TranslatorInterface $translator,
    ) {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->translator = $translator;
    }
    public function getConfigurableFields(string $pageName): array
    {
        $fields = [
            IdField::new('id')
                ->hideOnForm(),
        ];

        $entity = static::getEntityFqcn();

        if (is_subclass_of($entity, TimestampedEntityInterface::class)) {
            $fields[] = DateTimeField::new('created')
                ->hideOnForm();
            $fields[] = DateTimeField::new('updated')
                ->hideOnForm();
        }

        if (is_subclass_of($entity, AuthorInterface::class)) {
            $fields[] = AssociationField::new('user')
                    ->setCrudController(UserController::class)
                    ->autocomplete();
        }

        return $fields;
    }

    public function configureFields(string $pageName): iterable
    {
        return $this->getConfigurableFields($pageName);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add('id');

        $entity = static::getEntityFqcn();

        if (is_subclass_of($entity, TimestampedEntityInterface::class)) {
            $filters
                ->add('created')
                ->add('updated');
        }

        if (is_subclass_of($entity, AuthorInterface::class)) {
            $filters->add('user');
        }

        return $filters;
    }
}
