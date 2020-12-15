<?php
echo "JOB BEGIN ". date('Y-m-d H:i:s')."\n";
echo getcwd()."\n";
// chdir(getcwd());
exec('php artisan schedule:run');
echo "JOB END". date('Y-m-d H:i:s')."\n";