<?php

namespace Drupal\dvel_101\Controller;

class DbController{

    public function custom_behavior()
    {  
        $output = '';
        
        $output = [  
            '#markup' => "this id a put request",    
            "#theme"=>"cust_behavior",
            "#params" => ["name"=> "shiv"],
            '#attached' => [
                'library' => [
                  'dvel_101/cuddly-slider',
                ]
            ]
        ];
        return $output;
    }
}