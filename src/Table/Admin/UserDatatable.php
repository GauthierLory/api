<?php

namespace App\Table\Admin;

use App\Entity\User;
use App\Table\Datatable;
use Omines\DataTablesBundle\Column;

class UserDatatable extends Datatable
{
    protected static $entityClass = User::class;

    protected static $type = Datatable::ENTITY_TYPE;

    protected function builder(): void
    {
        $this
            ->add('firstName', Column\TextColumn::class, ['label' => 'Nom'])
            ->add('lastName', Column\TextColumn::class, ['label' => 'Prénom'])
            ->add('uuid', Column\TextColumn::class, [
                'label' => 'Action',
                'render' => function (string $value): string {
                    return sprintf('<a href="%s" role="button" title="Modifier"><i class="fas fa-edit"></i></a>'
                            . '<a href="%s" role="button" title="Supprimer"><i class="fas fa-trash"></i></a>',
                            $this->route('bo::user::edit', ['user' => $value]),
                            $this->route('bo::user::delete', ['user' => $value])
                    );
                }
            ])
            ->add('email', Column\TextColumn::class, ['label' => 'login']);
    }
}