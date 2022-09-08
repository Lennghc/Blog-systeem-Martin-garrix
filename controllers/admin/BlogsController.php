<?php

namespace Controllers\Admin;

use Exception;
use Classes\Functions;

class BlogsController
{
    public function __construct()
    {
        $this->Blog = new \Models\Blog();
        $this->Display = new \Classes\Display();
        $this->number = !empty($_GET['number']) ? $_GET['number'] : 1;

        //        $this->HomeController = new \Controllers\HomeController();
    }

    public function handleRequest()
    {
        try {
            isset($_GET['con']) === 'admin' ? $_GET['con'] : $_GET['con'] = 'admin';

            $op = isset($_GET['page']) ? $_GET['page'] : '';

            switch ($op) {
                case 'create':
                    $this->create();
                    break;

                case 'update':
                    $this->update();
                    break;

                case 'delete':
                    $this->delete();
                    break;

                case 'view':
                    $this->HomeController->handleRequest();
                    break;

                default:
                    $this->index();
                    break;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function index() {

        if ($_SESSION['user']->admin == 1) {

            $res = $this->Blog->all($this->number, 5);

            $nav = $this->Display->PageNavigation($res[1], $this->number);

            $table = $this->Display->CreateTable($res[0], true, true, true, 'blogtable');

            include 'views/admin/blogs/index.php';
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function create() {
        if ($_SESSION['user']->admin == 1) {

            $user_id = $_SESSION['user']->id;
            $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : null;
            $thumbnail = isset($_REQUEST['thumbnail']) ? $_REQUEST['thumbnail'] : null;
            $content = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;

            if (isset($_REQUEST['createBlog'])) {

                $create =  $this->Blog->create($user_id, $content, $title, $thumbnail);

                if (isset($create)) {

                    Functions::toast('Blog with success created', 'success');
                    header('Location: ' . PATH_DIR . '/admin/blogs');

                }
            }
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function update() {
        if ($_SESSION['user']->admin == 1) {

            $user_id = $_SESSION['user']->id;
            $id = isset($_REQUEST['blog_id']) ? $_REQUEST['blog_id'] : null;
            $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : null;
            $thumbnail = isset($_REQUEST['thumbnail']) ? $_REQUEST['thumbnail'] : null;
            $content = isset($_REQUEST['message']) ? $_REQUEST['message'] : null;

            if (isset($_REQUEST['updatedata'])) {

                $edit = $this->Blog->update($id, $user_id, $content, $title, $thumbnail);

                if (isset($edit)) {
                    Functions::toast('Blog with success updated', 'success');
                    header('Location: ' . PATH_DIR . '/admin/blogs');
                }
            }
        } else {
            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function delete() {


        if ($_SESSION['user']->admin == 1) {

            $id = isset($_REQUEST['blog_id']) ? $_REQUEST['blog_id'] : null;

            if (isset($_REQUEST['deleteBlog'])) {

                $delete = $this->Blog->delete($id);

                if (isset($delete)) {

                    Functions::toast('Blog & Comments with success removed', 'success');
                    
                    header('Location: ' . PATH_DIR . '/admin/blogs');

                }
            }
        } else {
            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }
}
