<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use PhpParser\Node\Expr\Yield_;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural(label: 'Categories');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('name');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new(propertyName: 'name', label: 'Nom');
        yield SlugField::new(propertyName: 'slug', label: 'Slug')->setTargetFieldName('slug');
        yield AssociationField::new(propertyName: 'parent', label: 'Parent_id')->autocomplete();
    }
}
