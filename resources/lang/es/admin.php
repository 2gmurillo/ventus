<?php

return [
    'panel' => [
        'title' => 'Pánel de administración'
    ],
    'users' => [
        'title' => 'Usuarios',
        'empty' => 'No hay usuarios disponibles',
        'fields' => [
            'id' => 'ID',
            'name' => 'Nombre',
            'email' => 'Correo',
            'status' => 'Estado',
            'verified' => 'Verificado',
            'actions' => 'Acciones',
            'password' => 'Contraseña',
            'password-confirm' => 'Confirmación de contraseña',
        ],
        'create-button' => 'Crear un nuevo usuario',
        'created' => 'Usuario creado exitosamente',
        'enabled' => 'Usuario habilitado',
        'disabled' => 'Usuario inhabilitado',
        'question' => '¿Seguro deseas eliminar al usuario? Esta acción no podrá ser revertida.',
        'deleted' => 'Usuario eliminado exitosamente',
        'edit' => 'Editar al usuario',
        'updated' => 'Usuario actualizado exitosamente',
    ],
    'products' => [
        'title' => 'Productos',
        'empty' => 'No hay productos disponibles',
        'fields' => [
            'id' => 'ID',
            'name' => 'Nombre',
            'photo' => 'Foto',
            'price' => 'Precio',
            'category' => 'Categoría',
            'actions' => 'Acciones',
            'stock' => 'Stock',
            'status' => 'Estado',
        ],
        'create-button' => 'Crear un nuevo producto',
        'created' => 'Producto creado exitosamente',
        'enabled' => 'Disponible',
        'disabled' => 'No disponible',
        'question' => '¿Seguro deseas eliminar el producto? Esta acción no podrá ser revertida.',
        'deleted' => 'Producto eliminado exitosamente',
        'edit' => 'Editar el producto',
        'updated' => 'Producto actualizado exitosamente',
    ],
];
