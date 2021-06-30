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
        // $f3->set('html_title','XXX Home');
        // $f3->set('content','./clases/jobs.php');
        //echo Template::instance()->render('./ui/layout.htm');
    }
);
$f3->route('GET /jobs/*',
    function() {
        echo 'Enough beer! We always end up here.';
    }
);
$f3->route('GET /params/',
    function($f3) {
        require_once("./params.php");
    }
);
$f3->run();