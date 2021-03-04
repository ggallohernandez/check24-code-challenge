<?php


namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_accounts")
 */
class UserAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /** @ORM\Column(type="integer") */
    protected int $failedLoginAttemp = 0;

    /** @ORM\Column(type="string") */
    protected string $username;

    /** @ORM\Column(type="string") */
    protected string $passwordHash;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $creationDate;

    /** @ORM\Column(type="datetime") */
    protected \DateTime $lastSeenDate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserAccount
     */
    public function setId(int $id): UserAccount
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getFailedLoginAttemp(): int
    {
        return $this->failedLoginAttemp;
    }

    /**
     * @param int $failedLoginAttemp
     * @return UserAccount
     */
    public function setFailedLoginAttemp(int $failedLoginAttemp): UserAccount
    {
        $this->failedLoginAttemp = $failedLoginAttemp;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserAccount
     */
    public function setUsername(string $username): UserAccount
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     * @return UserAccount
     */
    public function setPasswordHash(string $passwordHash): UserAccount
    {
        $this->passwordHash = $passwordHash;
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
     * @return UserAccount
     */
    public function setCreationDate(\DateTime $creationDate): UserAccount
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastSeenDate(): \DateTime
    {
        return $this->lastSeenDate;
    }

    /**
     * @param \DateTime $lastSeenDate
     * @return UserAccount
     */
    public function setLastSeenDate(\DateTime $lastSeenDate): UserAccount
    {
        $this->lastSeenDate = $lastSeenDate;
        return $this;
    }
}