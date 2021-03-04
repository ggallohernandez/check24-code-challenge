<?php


namespace Blog\Controller;


use Blog\Entity\Article;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface;
use Small\Controller;

class ArticleController extends Controller
{
    public function getPaged(ServerRequestInterface $request, $params = [])
    {
        /**
         * @var EntityManager $em
         */
        $em = $this->getContainer()->get(EntityManager::class);

        $em->getRepository(Article::class)->createQueryBuilder()->getMaxResults();
    }

    public function getPaged(ServerRequestInterface $request, $params = [])
    {
        $this->
    }

    public function create(ServerRequestInterface $request, $params = [])
    {

    }

    public function getDetail(ServerRequestInterface $request, $params = [])
    {

    }

    public function updateArticle(ServerRequestInterface $request, $params = [])
    {

    }

    public function deleteArticle(ServerRequestInterface $request, $params = [])
    {

    }

    public function createComment(ServerRequestInterface $request, $params = [])
    {

    }

    public function deleteComment(ServerRequestInterface $request, $params = [])
    {

    }

    public function deleteComment(ServerRequestInterface $request, $params = [])
    {

    }

    public function createComment(ServerRequestInterface $request, $params = [])
    {

    }

    public function deleteComment(ServerRequestInterface $request, $params = [])
    {

    }

    public function deleteComment(ServerRequestInterface $request, $params = [])
    {

    }

}