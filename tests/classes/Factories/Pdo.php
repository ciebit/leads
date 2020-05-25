<?php

declare(strict_types=1);

namespace Ciebit\Leads\Tests\Factories;

use PDO as PdoNative;

class Pdo
{
    private static ?PdoNative $pdo = null;

    public function constructor(): PdoNative
    {
        $dataSourceName = "mysql:dbname=leads;host=db;port=3306;charset=utf8";
        $user = 'root';
        $password = 'root';

        return new PdoNative($dataSourceName, $user, $password);
    }

    public function create(): PdoNative
    {
        if (self::$pdo == null) {
            self::$pdo = $this->constructor();
        }

        return self::$pdo;
    }
}
