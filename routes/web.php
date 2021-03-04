<?php

$router = new \Small\Router\Router();

$router->map('GET','/', 'Blog\Controller\ArticleController::getPaged');
$router->map('GET','/articles', 'Blog\Controller\ArticleController::getPaged');
$router->map('GET','/articles/:page', 'Blog\Controller\ArticleController::getPaged');
$router->map('POST','/article', 'Blog\Controller\ArticleController::create');

$router->map('GET','/article/:id', 'Blog\Controller\ArticleController::getDetail');
$router->map('PUT','/article/:id', 'Blog\Controller\ArticleController::updateArticle');
$router->map('DELETE','/article/:id', 'Blog\Controller\ArticleController::deleteArticle');

$router->map('POST','/article/:id/comment', 'Blog\Controller\ArticleController::createComment');
$router->map('PUT','/article/:id/comment', 'Blog\Controller\ArticleController::deleteComment');
$router->map('DELETE','/article/:id/comment', 'Blog\Controller\ArticleController::deleteComment');

$router->map('POST','/article/:id/comment', 'Blog\Controller\ArticleController::createComment');
$router->map('PUT','/article/:id/comment', 'Blog\Controller\ArticleController::deleteComment');
$router->map('DELETE','/article/:id/comment', 'Blog\Controller\ArticleController::deleteComment');

$router->map('GET','/authors', 'Blog\Controller\AuthorController::getPaged');
$router->map('GET','/author/:id', 'Blog\Controller\AuthorController::getDetail');
$router->map('PUT','/author/:id', 'Blog\Controller\AuthorController::updateAuthor');

$router->map('GET','/account', 'Blog\Controller\UserAccountController::getDetail');
$router->map('PUT','/account', 'Blog\Controller\UserAccountController::updateAccount');
$router->map('DELETE','/login', 'Blog\Controller\UserAccountController::login');
$router->map('DELETE','/logout', 'Blog\Controller\UserAccountController::logout');

return $router;