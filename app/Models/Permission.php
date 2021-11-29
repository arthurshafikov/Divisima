<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public const ADMIN_PANEL = 'admin_panel';

    public const PERMISSIONS = [
        self::ADMIN_PANEL,
    ];
}
