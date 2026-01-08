<?php

namespace App\SystemFunctions;
class SystemFunctions{
    public function get_storage_used_size(){
        $command = 'du -sh ../storage';
        $result = strtok(shell_exec($command), "\t");
        return $result;
    }
}