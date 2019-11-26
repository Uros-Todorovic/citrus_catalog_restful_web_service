<?php

class Comment {
    
    public static function submit_comment(){

        $comment = self::set_params();
      
        $parameters = [
            "http"=>[
                "method"=>"POST",
                "content"=>$comment,
                "header"=>"Content-Type: application/json"
            ]
        ];
        $context = stream_context_create($parameters);
        $comment_submit = file_get_contents("http://localhost/citrus_catalog_restful_web_service/CITRUS_API/citrus_comments.php", null, $context);
          /* $comment_submit = json_decode($comment_submit);
        print_r($comment_submit);    */
    }

    public static function set_params(){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $text = trim($_POST['text']);
        
        
        $comment_array = ["name"=>$name,"email"=>$email,"text"=>$text];
        $comment = [];
        foreach ($comment_array as $key => $value) {
        $comment[] = "\"".$key."\"".":"."\"".$value."\"";
        }
        $comment = implode(",",$comment);
        $new_comment = "{".$comment."}"; 
        return $new_comment;
    } 
}  

        
      
