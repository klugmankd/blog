<?php

namespace BlogBundle\Entity;


class Post
{
    public function __construct($id)
    {
        $path_to_file = sys_get_temp_dir()."/post_$id.txt";
    }
    /**
     * @param $id
     * @return string
     */
    public function get($id) {
        $file = fopen($path_to_file, "r") or die("Cannot open file: post_$id.txt");
        if ($file)
        {
            $title = "";
            $content = "";
            while (!feof($file))
            {
                if ($title == "") {
                    $title = fgets($file, 999);
                }
                $content .= fgets($file, 999);
            }
            $record = array("id" => $id, "title" => substr($title, 0, strlen($title)-1), "content"=>$content);
        }
        fclose($file);
        return $record;
    }

    /**
     * @param $id
     * @param $title
     * @param $content
     * @return string
     */
    public function add($id, $title, $content) {
        $post_file = fopen(sys_get_temp_dir()."/post_$id.txt", "w");
        $hasWrite = fwrite($post_file, $title."\n".$content);
        if ($hasWrite) {
            $msg = "Post number $id has created";
        } else $msg = "Post number $id hasn't created";
        return $msg;
    }

    /**
     * @param $id
     * @param $newTitle
     * @param $newContent
     * @return string
     */
    public function edit($id, $newTitle, $newContent) {
        $post_file = fopen(sys_get_temp_dir()."/post_$id.txt", "r+");
        if ($post_file) {
            if ($newTitle == "" || $newContent == null) {
                $newTitle = fgets($post_file, 99);
            }
            $hasWrite = fwrite($post_file, $newTitle."\n".$newContent);
            if ($hasWrite) {
                $msg = "Post number $id has updated";
            } else $msg = "Post number $id hasn't update";
        }
        return $msg;
    }

    /**
     * @param $id
     * @return string
     */
    public function remove($id) {
        $hasDelete = unlink(sys_get_temp_dir()."/post_$id.txt");
        if ($hasDelete) {
            $msg = "Post number $id deleted";
        } else $msg = "Post number $id hasn't delete";
        return $msg;
    }
}