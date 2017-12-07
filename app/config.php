<?php
declare(strict_types=1);

// This file contains a list of global configuration settings.

return [
    'title' => 'Cyblerlink',
    'database_path' => sprintf('sqlite:%s/database/database.db', __DIR__),
    'dateFormat' => 'Y-m-d @ H:i:s',
    'spacer' => '<span>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</span>',
];
