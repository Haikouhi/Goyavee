<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

   

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="event")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="event", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Status", mappedBy="event")
     */
    private $statuses;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organizer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="event")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->statuses = new ArrayCollection();
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addEvent($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeEvent($this);
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): self
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses[] = $status;
            $status->setEvent($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->statuses->contains($status)) {
            $this->statuses->removeElement($status);
            // set the owning side to null (unless already changed)
            if ($status->getEvent() === $this) {
                $status->setEvent(null);
            }
        }

        return $this;
    }

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
