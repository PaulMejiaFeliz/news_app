<?php

class HomeController extends Controller
{
    public function index()
    {
        return $this->view(
            'index',
            [
                'title' => 'Home'
            ]
        );
    }

    public function postDetails()
    {
        if (isset($_GET['id'])) {
            $qBuilder = App::get('qBuilder');

            $post = $qBuilder->selectById('news', $_GET['id']);
            if (isset($post['user'])) {
                $post['user'] = $qBuilder->selectById('user', $post['user']);
                unset($post['user']['password']);
            }
            
            $qBuilder->update(
                'news',
                $post['id'],
                'i',
                [
                    'views' => ++$post['views']
                ]
            );
            var_dump($post);
        }
    }

    public function notFound()
    {
        return $this->view(
            'notFound',
            [
                'title' => 'Page Not Found'
            ]
        );
    }
}
