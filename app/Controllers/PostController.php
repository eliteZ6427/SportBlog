<?php

namespace App\Controllers;

use App\src\Post as Post;

use App\Services\Services;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class PostController
{
    
    public function index () {
      echo twig()->render('index.html');
      $posts = $this->em()->getRepository('App\src\Post')->findAll();
      echo twig()->render('index.html', compact('posts'));
    }

    public function create () {
      echo twig()->render('posts/post-create.html');  
    }

    public function store () {
      $post = new Post;
      $post->setTitle(request()->get('title'));
      $post->setBody(request()->get('body'));

      em()->persist($post);
      em()->flush();

      return header("Location: /posts/".$post->getId());
    }

    public function show ($id) 
    {
      em()->find('app\src\Post', $id);
      echo twig()->render('posts/post-show.html', compact('post'));
    }

    public function edit ($id)
    {
      $post = $this->em()->find('App\src\Post', $id);
      echo twig()->render('posts/post-edit.html', compact('post'));
    }

    public function update ($id)
    {
      $post = em()->find('App\src\Post', $id);

      $post->getTitle() != request()->get('title') ? $post->setTitle(request()->get('title')) : '';
      $post->getBody() != request()->get('body') ? $post->setBody(request()->get('body')) : '';
      $post->setCreatedAt(new \DateTime('now'));
      em()->merge($post);
      em()->flush();

      return header("Location: /posts/".$post->getId());
    }

    public function delete ($id)
    {
      $post = new Post;
      $post = em()->find('app\src\Post', $id);
      em()->remove($post);
      em()->flush();

      header("Location: /");
    }
}