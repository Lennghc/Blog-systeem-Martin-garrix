<?php

namespace Controllers;

use Classes\Functions;

class BlogController
{
    protected $page;

    public function __construct() {
        $this->Blog = new \Models\Blog();
        $this->Comment = new \Models\Comment();
        $this->Display = new \Classes\Display();
        $this->page = !empty($_GET['page']) ? $_GET['page'] : 0;
    }

    public function index() {
        $result = $this->Blog->all($this->page, 4);
        $html = $this->Display->createBlogCard($result, 0, PATH_DIR . '/blog');
        include('views/blog/blogs.php');
    }

    public function read($id) {
        if (!empty($id) && is_numeric($id)) {
            $result = $this->Blog->read($id);

            if($result) {
                $date = new \DateTime($result['created_at']);
                include 'views/blog/blog.php';
                exit;
            }
        }

        //Add toast
        Functions::toast('This blog post does not exist!', 'info');
        header('location: ' . PATH_URL);
    }

    public function getComments($id) {
        if (!empty($id) && is_numeric($id)) {
            $result = $this->Blog->read($id);

            if($result) {
                $resultComments = $this->Comment->all($result['id'], $this->page, 5);
                header('Content-Type: application/json');
                echo json_encode($resultComments);
                exit;
            }
        }

        http_response_code(404);
    }

    public function createComment() {
        if (!empty($_POST['blog_id']) && is_numeric($_POST['blog_id']) &&
            !empty($_POST['user_id']) && is_numeric($_POST['user_id']) &&
            !empty($_POST['message'])) {

            $result = $this->Blog->read($_POST['blog_id']);

            if($result) {

                //Optional
                $reply_id = !empty($_POST['reply_id']) ? $_POST['reply_id'] : null;

                $resultComment = $this->Comment->create($_POST['user_id'], $_POST['blog_id'], $_POST['message'], $reply_id);

                if($resultComment) {
                    header('Content-Type: application/json');
                    echo json_encode($resultComment);
                }

                exit;
            }
        }

//
//        echo Functions::toJSON(array(
//            'errors' => !$success ? $validation->result() : (!empty($result->errors) ? $result->errors : null)
//        ));
    }
}
