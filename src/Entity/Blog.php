<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="datetime")
     * @ORM\Version
     *
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @ORM\OneToMany(targetEntity=CommentBlog::class, mappedBy="id_blog")
     */
    private $commentBlogs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valid;

    public function __construct()
    {
        $this->commentBlogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * @return Collection|CommentBlog[]
     */
    public function getCommentBlogs(): Collection
    {
        return $this->commentBlogs;
    }

    public function addCommentBlog(CommentBlog $commentBlog): self
    {
        if (!$this->commentBlogs->contains($commentBlog)) {
            $this->commentBlogs[] = $commentBlog;
            $commentBlog->setIdBlog($this);
        }

        return $this;
    }

    public function removeCommentBlog(CommentBlog $commentBlog): self
    {
        if ($this->commentBlogs->removeElement($commentBlog)) {
            // set the owning side to null (unless already changed)
            if ($commentBlog->getIdBlog() === $this) {
                $commentBlog->setIdBlog(null);
            }
        }

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}
