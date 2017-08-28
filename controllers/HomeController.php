<?php

class HomeController extends Controller
{
    public function index()
    {
        $this->startSession();
        $title = 'Home';
        $myNews = [];
        $news = App::get('qBuilder')->selectWhere(
            'news',
            'i',
            [
                'is_deleted' => 0
            ]
        );
        $news = array_map(
            function($new) {
                if (isset($new['user'])) {
                    $new['user'] = App::get('qBuilder')->selectFieldsById(
                        'user',
                        [
                            "name",
                            "lastName",
                            "email"
                        ],
                        $new['user']
                    );
                }
                return $new;
            },
            $news
        );

        if (isset($_SESSION['logged'])) {
            $myNews = App::get('qBuilder')->selectWhere(
                'news',
                'ii',
                [
                    'is_deleted' => 0,
                    'user' => $_SESSION['user']['id']
                ]
            );
            $myNews = array_map(
                function($myNew) {
                    if (isset($myNew['user'])) {
                        $myNew['user'] = App::get('qBuilder')->selectFieldsById(
                            'user',
                            [
                                "name",
                                "lastName",
                                "email"
                            ],
                            $myNew['user']
                        );
                    }
                    return $myNew;
                },
                $myNews
            );
        }
        
        return $this->view(
            'index',
            compact(
                'title',
                'news',
                'myNews'
            )
        );
    }

    public function postDetails()
    {
        $this->startSession();
        if (isset($_GET['id'])) {
            $owner = false;
            $qBuilder = App::get('qBuilder');

            $post = $qBuilder->selectById('news', $_GET['id']);
            if ($post['is_deleted']) {
                header('Location: /notFound');                
            }

            if (isset($post['user'])) {
                if (isset($_SESSION['logged'])) {
                    if ($_SESSION['user']['id'] === $post['user']) {
                        $owner = true;
                    }
                }
                $post['user'] = $qBuilder->selectFieldsById(
                    'user',
                    [
                        "name",
                        "lastName",
                        "email"
                    ],
                    $post['user']
                );
            }
            
            $qBuilder->update(
                'news',
                $post['id'],
                'i',
                [
                    'views' => isset($post['views']) ? ++$post['views'] : 0
                ]
            );
            $title = $post['title'] ?? "";
            
            return $this->view(
                'postDetails',
                compact(
                    'post',
                    'title',
                    'owner'
                )
            );
        }
    }

    public function newPost()
    {
        $this->startSession();
        if (!isset($_SESSION['logged'])) {
            header('Location: /login');
        } else {
            return $this->view(
                'newPost',
                [
                    'title' => 'New Post'
                ]
            );
        }
    }

    public function postNewPost()
    {
        $this->startSession();
        
        $errorMessage = array();
        $title = "New Post";
        extract($_POST);
        if (isset($_SESSION['logged'])) {
            $user = $_SESSION['user'];
        
            if (strlen(trim($postTitle)) < 5) {
                $errorMessage[] = "The title must have at least 5 charcters.";
            }
            if (strlen(trim($content)) == 0) {
                $errorMessage[] = "The content is required.";
            }
            if (count($errorMessage) == 0) {

                $postId = App::get('qBuilder')->insert(
                    'news',
                    'ssiss',
                    [
                        'title' => $postTitle,
                        'content' => $content,
                        'user' => $user['id'],
                        'created_at' => (new DateTime())->format('Y-m-d'),
                        'updated_at' => (new DateTime())->format('Y-m-d')
                    ]
                );

                return header("Location: /postDetails?id={$postId}");
            }
            return $this->view(
                'newPost',
                compact(
                    'title',
                    'errorMessage',
                    'postTitle',
                    'content'
                )
            );
            
        }
        return header('Location: /login');
    }

    public function deletePost()
    {
        $this->startSession();
        if (!$_SESSION['logged']) {
            return header('Location: /login');
        }
        if (isset($_GET['id'])) {
            $qBuilder = App::get('qBuilder');

            $post = $qBuilder->selectById('news', $_GET['id']);
            $title = $post['title'] ?? "";
            $owner = true;
            $exist = true;
            
            if (! $post['is_deleted']) {
                if ($post['user'] === $_SESSION['user']['id']) {
                    $qBuilder->update(
                        'news',
                        $post['id'],
                        'i',
                        [
                            'is_deleted' => 1
                        ]
                    );
                } else {
                    $title = "Deleted Post";
                    $owner = false;
                }
            } else {
                $title = "Deleted Post";                
                $exist = false;
            }

            return $this->view(
                'postDeleted',
                compact(
                    'title',
                    'owner',
                    'exist'
                )
            );
        }
    }

    public function editPost()
    {
        $this->startSession();
        if (!isset($_SESSION['logged'])) {
            return header('Location: /login');
        }
        if (isset($_GET['id'])) {
            $qBuilder = App::get('qBuilder');

            $post = $qBuilder->selectById('news', $_GET['id']);
            $id = $post['id'];
            $title = 'Edit Post';
            $postTitle = $post['title'] ?? "";
            $content = $post['content'] ?? "";
            $owner = true;
            $exist = true;
            if (! $post['is_deleted']) {
                if ($post['user'] !== $_SESSION['user']['id']) {
                    $owner = false;
                }
            } else {
                $title = "Post not found";
                $exist = false;
            }

            return $this->view(
                'editPost',
                compact(
                    'title',
                    'owner',
                    'exist',
                    'postTitle',
                    'content',
                    'id'
                )
            );
        }
    }

    public function postEditPost()
    {
        $this->startSession();
        
        if (!isset($_SESSION['logged'])) {
            return header('Location: /login');
        }
        
        $qBuilder = App::get('qBuilder');
        
        $errorMessage = array();
        $title = "Edit Post";
        extract($_POST);
        $post = $qBuilder->selectById('news', $id);
        $owner = true;
        $exist = true;
        if (! $post['is_deleted']) {
            if ($post['user'] != $_SESSION['user']['id']) {
                $owner = false;
            } else {
                if (strlen(trim($postTitle)) < 5) {
                    $errorMessage[] = "The title must have at least 5 charcters.";
                }
                if (strlen(trim($content)) == 0) {
                    $errorMessage[] = "The content is required.";
                }
                if (count($errorMessage) == 0) {
    
                    $qBuilder->update(
                        'news',
                        $post['id'],
                        'sss',
                        [
                            'title' => $postTitle,
                            'content' => $content,
                            'updated_at' => (new DateTime())->format('Y-m-d')
                        ]
                    );
    
                    return header("Location: /postDetails?id={$post['id']}");
                }
            }
        } else {
            $title = "Post not found";
            $exist = false;
        }

        return $this->view(
            'editPost',
            compact(
                'title',
                'owner',
                'exist',
                'postTitle',
                'content',
                'id',
                'errorMessage'
            )
        );
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
