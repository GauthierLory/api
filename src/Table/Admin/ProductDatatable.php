<?php


namespace App\Table\Admin;


use App\Entity\Product;
use App\Table\Datatable;
use Omines\DataTablesBundle\Column;

class ProductDatatable extends Datatable
{
    protected static $entityClass = Product::class;

    protected static $type = Datatable::ENTITY_TYPE;

    protected function builder(): void
    {
        $this
            ->add('uuid', Column\TextColumn::class, [
                'label' => 'Action',
                'render' => function (string $value): string {
                    return sprintf('<a href="%s" role="button" title="Modifier"><i class="fas fa-edit"></i></a>'
                        . '<a href="%s" role="button" title="Supprimer"><i class="fas fa-trash"></i></a>',
                        $this->route('bo::product::edit', ['product' => $value]),
                        $this->route('bo::product::delete', ['product' => $value])
                    );
                }
            ])
            ->add('title', Column\TextColumn::class, ['label' => 'Titre'])
            ->add('description', Column\TextColumn::class, ['label' => 'Description'])
            ->add('price', Column\TextColumn::class, ['label' => 'Prix'])
            ->add('createdAt', Column\TextColumn::class, ['label' => 'Date de création']);
    }
}