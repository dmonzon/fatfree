<?php
$f3 = require('lib/base.php');
$f3->set('AUTOLOAD','clases/');
$f3->route('GET /',
    function($f3) {
        require_once("./ui/header.php");
    });
$f3->route('GET /jobs',
    function($f3) {
        include("./ui/header.php");
        require_once("./clases/jobs.php");
    }
);
$f3->route('GET /jobs/@count',
    function($f3) {
        //$f3->logs = $f3->get('PARAMS.count');
        include("./ui/header.php");
        require("./clases/jobs.php");
    }
);
$f3->route('GET /params',
    function($f3) {
        include("./ui/header.php");
        require_once("./clases/params.php");
    }
);
$f3->route('POST /params',
    function($f3){
        include("./ui/header.php");
        require_once("./clases/params.php");
    }
);
$f3->route('POST /jobs',
    function($f3){
        include("./ui/header.php");
        require_once("clases/jobs.php");
    }
);
$f3->route('POST /confirm',
    function($f3){
        include("./ui/header.php");
        include("clases/confirm.php");
    }
);

$f3->run();