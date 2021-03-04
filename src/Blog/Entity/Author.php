<?php


namespace Blog\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="authors")
 */
class Author
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
    protected string $name;

    /**
     * @ORM\Column(type="string")
     */
    protected string $position;

    /**
     * @ORM\Column(type="string")
     */
    protected string $biography;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $creationDate;

    /**
     *
     * @ORM\OneToMany(targetEntity="Article", mappedBy="author", cascade={"all"}, orphanRemoval=true)
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $articles;

    /**
     *
     * @ORM\OneToOne(targetEntity="UserAccount")
     * @ORM\JoinColumn(name="user_account_id", referencedColumnName="id")
     */
    protected UserAccount $account;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Author
     */
    public function setName(string $name): Author
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     * @return Author
     */
    public function setPosition(string $position): Author
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string
     */
    public function getBiography(): string
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     * @return Author
     */
    public function setBiography(string $biography): Author
    {
        $this->biography = $biography;
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
     * @return Author
     */
    public function setCreationDate(\DateTime $creationDate): Author
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles(): ArrayCollection
    {
        return $this->articles;
    }

    /**
     * @param ArrayCollection $articles
     * @return Author
     */
    public function setArticles(ArrayCollection $articles): Author
    {
        $this->articles = $articles;
        return $this;
    }

    /**
     * @return UserAccount
     */
    public function getAccount(): UserAccount
    {
        return $this->account;
    }

    /**
     * @param UserAccount $account
     * @return Author
     */
    public function setAccount(UserAccount $account): Author
    {
        $this->account = $account;
        return $this;
    }
}