<?php
$f3 = require('lib/base.php');
$f3->set('AUTOLOAD','clases/');
$f3->route('GET /',
    function() {
        $obj = new Grito("Danny");
    }
);
$f3->route('GET /about',
    function() {
        echo 'Donations go to a local charity... us!';
    }
);
$f3->route('GET /jobs',
    function($f3) {
        //$obj = new jobs($f3->get('PARAMS.count'));
        require_once("./clases/jobs.php");
        
    }
);
$f3->route('GET /jobs/*',
    function() {
        echo 'Enough beer! We always end up here.';
    }
);
$f3->route('GET /grito/@count',
    function($f3) {
        $obj = new Grito($f3->get('PARAMS.count'));
        
        echo "<br>el maldito numero es $obj->get_name($f3->get('PARAMS.count')) ";
    }
);
$f3->run();