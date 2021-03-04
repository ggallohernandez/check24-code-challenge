<?php


namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /** @ORM\Column(type="text") */
    protected string $content;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected Article $article;
    /**
     * @ORM\ManyToOne(targetEntity="UserAccount")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected Author $author;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $creationDate;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $lastModifiedDate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Comment
     */
    public function setTitle(string $title): Comment
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Comment
     */
    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return Comment
     */
    public function setArticle(Article $article): Comment
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * @param Author $author
     * @return Comment
     */
    public function setAuthor(Author $author): Comment
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     * @return Comment
     */
    public function setCreationDate(\DateTime $creationDate): Comment
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastModifiedDate(): \DateTime
    {
        return $this->lastModifiedDate;
    }

    /**
     * @param \DateTime $lastModifiedDate
     * @return Comment
     */
    public function setLastModifiedDate(\DateTime $lastModifiedDate): Comment
    {
        $this->lastModifiedDate = $lastModifiedDate;
        return $this;
    }
}