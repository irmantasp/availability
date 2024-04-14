<?php

namespace App\Controller\Admin\Filter;

use App\Entity\Group;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\EntityFilterType;

final class GroupMembersFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $property, string $value): FilterInterface
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($property)
            ->setLabel($value)
            ->setFormType(EntityFilterType::class)
            ->setFormTypeOption('value_type_options', [
                'class' => Group::class,
                'multiple' => true,
            ]);
    }
    public function apply(
        QueryBuilder $queryBuilder,
        FilterDataDto $filterDataDto,
        ?FieldDto $fieldDto,
        EntityDto $entityDto
    ): void
    {
        $groupsCollection = $filterDataDto->getValue();
        $members = [];
        foreach ($groupsCollection as $group) {
            $groupMembers = $group->getMembers();
            foreach ($groupMembers as $member) {
                $members[] = $member->getId();
            }
        }

        $queryBuilder
            ->andWhere('entity.user IN (:members)')
            ->setParameter('members', $members);
    }
}
