<?php

namespace App\Entity;

use App\Repository\CommentBlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentBlogRepository::class)
 */
class CommentBlog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Blog::class, inversedBy="commentBlogs")
     */
    private $id_blog;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="datetime")
     * @ORM\Version
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $signaler;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBlog(): ?Blog
    {
        return $this->id_blog;
    }

    public function setIdBlog(?Blog $id_blog): self
    {
        $this->id_blog = $id_blog;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSignaler(): ?int
    {
        return $this->signaler;
    }

    public function setSignaler(?int $signaler): self
    {
        $this->signaler = $signaler;

        return $this;
    }
}
