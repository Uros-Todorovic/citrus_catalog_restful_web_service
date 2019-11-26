<?php

class Comment  {

   
    public static function aproove_comment($id){
        $comment = self::set_params($id);
      
        $parameters = [
            "http"=>[
                "method"=>"PUT",
                "content"=>$comment,
                "header"=>"Content-Type: application/json"
            ]
        ];
        $context = stream_context_create($parameters);
        $comment_submit = file_get_contents("http://localhost/citrus_catalog_restful_web_service/CITRUS_API/citrus_comments.php", null, $context);
    }

    public static function set_params($id){
        
        $comment_array = ["id"=>$id];
        $comment = [];
        foreach ($comment_array as $key => $value) {
        $comment[] = "\"".$key."\"".":"."\"".$value."\"";
        }
        $comment = implode(",",$comment);
        $new_comment = "{".$comment."}"; 
        return $new_comment;
    } 
}