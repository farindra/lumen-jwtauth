<?php
namespace app\Libraries;

use Illuminate\Support\Facades\Log;

class Core
{
    /**
     * Custom Response HTTP
     * 
     * @param string $type type of response ['success','error', etc]
     * @param string $message response message
     * @param array $data response data
     * @param boolean $is_array if set true, array return will given
     * @param int $code header code of response
     * @return mixed array|json
     */
    public function setResponse( $type = 'not_found',$message = "Not Found", $data = [], $is_array = FALSE, $code = null ){

        switch($type){

            case 'success':
                $status = "success";
                $message = $message;
                $body = 'data' ;
                $code = $code ?? 200;
                break;
            case 'error':
                $status = "error";
                $message = $message;
                $body = 'error_info' ;
                $code = $code ?? 400;
                break;
            default:
                $status = $type;
                $message = $message;
                $body = $data ;
                $code = 404;
        
        }

        $response =  [ $status  => $message ,$body => $data ];


        if ($is_array) {

            return  $response;

        }


        return response()->json( $response , $code);

    }

    /**
     * custom log for loops
     * 
     * @param string $type type of log 
     * @param string $message log message
     * @param boolean $force force create log avoid config
     * @return string error ref.
     */
    public function log($type = 'debug', $message = null, $force = false ){

        $error_ref =  $this->generateRandomString(7);

        try{

            if ( config( 'appindex.logs.' . $type . '_active' ) || $force ) {

                Log::{$type}("[$error_ref] $message");
            }

        }catch(\Exception $e){
            
            Log::warning("[$error_ref]::log($type, $message) : " . $e->getMessage() );

        }

        return $error_ref;

    
    }


    /**
     * render Routes files
     *
     * @param  string $folder folder under routes/*
     * @param  object $router
     * @return void
     */
    public static function renderRoutes($folder, $router){

        foreach (glob( app()->basePath() . "/routes/{$folder}/*.php") as $filename)
        {
            require $filename;
        }
    }
    
    /**
     * generate Random String
     *
     * @param  integer $length max character length
     * @return string
     */
    public static function generateRandomString($length = 5) {

        $characters = config('erm.error.random_string', 'ABCDEFGHJKLMNPQRTUVWXYZ') ;
        
        $charactersLength = strlen($characters);
        
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
        
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        
        }
        
        return $randomString;
    }

}