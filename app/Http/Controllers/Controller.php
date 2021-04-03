<?php

namespace App\Http\Controllers;

use app\Libraries\Core;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * our application library
     */
    public $core ;

    public function __construct(){
        
        /** define Core as global Library */
        $this->core = new Core();

    }
        
    /**
     * handling missing Method
     *
     * @return mixed
     */
    public function missingMethod(){

        return $this->core->setResponse();
    }
}
