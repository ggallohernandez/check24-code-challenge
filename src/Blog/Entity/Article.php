<?php


namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="articles")
 */
class Article
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
    protected string $url;

    /**
     * @ORM\Column(type="string")
     */
    protected string $imgUrl;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /**
     * @ORM\ManyToOne(targetEntity="Author", cascade={"all"}, fetch="EAGER")
     */
    protected Author $author;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $creationDate;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $lastModifiedDate;

    /**
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", cascade={"all"}, orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $comments;

    /** @ORM\Column(type="text") */
    protected string $content;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Article
     */
    public function setUrl(string $url): Article
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    /**
     * @param string $imgUrl
     * @return Article
     */
    public function setImgUrl(string $imgUrl): Article
    {
        $this->imgUrl = $imgUrl;
        return $this;
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
     * @return Article
     */
    public function setTitle(string $title): Article
    {
        $this->title = $title;
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
     * @return Article
     */
    public function setAuthor(Author $author): Article
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
     * @return Article
     */
    public function setCreationDate(\DateTime $creationDate): Article
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
     * @return Article
     */
    public function setLastModifiedDate(\DateTime $lastModifiedDate): Article
    {
        $this->lastModifiedDate = $lastModifiedDate;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     * @return Article
     */
    public function setComments(ArrayCollection $comments): Article
    {
        $this->comments = $comments;
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
     * @return Article
     */
    public function setContent(string $content): Article
    {
        $this->content = $content;
        return $this;
    }
}