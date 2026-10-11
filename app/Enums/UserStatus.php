<?php

namespace App\Enums;

enum UserStatus: string
{
    case Activo = 'activo';
    case Inactivo = 'inactivo';
    case Suspendido = 'suspendido';

    /**
     * Todos los estados validos del usuario.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Estado por defecto de una cuenta recien creada.
     */
    public static function default(): self
    {
        return self::Inactivo;
    }
}