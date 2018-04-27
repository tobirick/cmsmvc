<?php
namespace Core;

use Phelium\Component\MySQLBackup;

class Backup {

    public static function startDBBackup() {
        $Dump = new MySQLBackup(getenv('DB_HOST') , getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
        $Dump->setCompress('zip');
        $Dump->setDelete(true);
        $Dump->setDownload(true);
        $Dump->dump();
    }

    public static function startFTPBackup() {

    }
}