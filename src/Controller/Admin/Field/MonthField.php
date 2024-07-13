<?php

namespace App\Controller\Admin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

final class MonthField implements FieldInterface
{
    use FieldTrait;

    public static function new(
        string $propertyName,
        ?string $label = null
    ): FieldInterface {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/month')
            ->setFormType(CollectionType::class)
            ->addCssClass('field-month');
    }
}
