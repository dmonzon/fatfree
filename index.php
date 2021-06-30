<?php
$f3 = require('lib/base.php');
$f3->set('AUTOLOAD','clases/');
$f3->route('GET /',
    function() {
        $obj = new Grito("Danny");
    }
);

$f3->route('GET /jobs',
    function($f3) {
        require_once("./clases/jobs.php");
    }
);
// $f3->route('GET|POST /jobs/*',
//     function() {
//         echo 'Enough beer! We always end up here.';
//     }
// );
$f3->route('GET /params',
    function($f3) {
        require_once("./clases/params.php");
    }
);
$f3->route('POST /params',
    function($f3){
        include("./clases/params.php");
    }
);
$f3->route('POST /jobs',
    function($f3){
        include("clases/jobs.php");
    }
);
$f3->route('POST /confirm',
    function($f3){
        include("clases/confirm.php");
    }
);
$f3->run();