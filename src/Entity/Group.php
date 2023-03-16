<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;


#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private string $name;

    #[Groups(['read', 'write'])]
    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column]
    private bool $isDeleted;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'members')]
    private Collection $users;

    #[Groups(['read'])]
    #[ORM\OneToMany(mappedBy: 'group_related', targetEntity: user::class)]
    private Collection $owner_id;

    #[ORM\OneToMany(mappedBy: 'group', targetEntity: Thread::class)]
    private Collection $threads;

    #[ORM\OneToMany(mappedBy: 'group', targetEntity: GroupRequest::class)]
    private Collection $groupRequests;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->owner_id = new ArrayCollection();
        $this->threads = new ArrayCollection();
        $this->groupRequests = new ArrayCollection();
        $this->isDeleted = false;
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function isIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addMember($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeMember($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getOwnerId(): Collection
    {
        return $this->owner_id;
    }

    public function addOwnerId(user $ownerId): self
    {
        if (!$this->owner_id->contains($ownerId)) {
            $this->owner_id->add($ownerId);
            $ownerId->setGroupRelated($this);
        }

        return $this;
    }

    public function removeOwnerId(user $ownerId): self
    {
        if ($this->owner_id->removeElement($ownerId)) {
            // set the owning side to null (unless already changed)
            if ($ownerId->getGroupRelated() === $this) {
                $ownerId->setGroupRelated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Thread>
     */
    public function getThreads(): Collection
    {
        return $this->threads;
    }

    public function addThread(Thread $thread): self
    {
        if (!$this->threads->contains($thread)) {
            $this->threads->add($thread);
            $thread->setGroup($this);
        }

        return $this;
    }

    public function removeThread(Thread $thread): self
    {
        if ($this->threads->removeElement($thread)) {
            // set the owning side to null (unless already changed)
            if ($thread->getGroup() === $this) {
                $thread->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupRequest>
     */
    public function getGroupRequests(): Collection
    {
        return $this->groupRequests;
    }

    public function addGroupRequest(GroupRequest $groupRequest): self
    {
        if (!$this->groupRequests->contains($groupRequest)) {
            $this->groupRequests->add($groupRequest);
            $groupRequest->setGroup($this);
        }

        return $this;
    }

    public function removeGroupRequest(GroupRequest $groupRequest): self
    {
        if ($this->groupRequests->removeElement($groupRequest)) {
            // set the owning side to null (unless already changed)
            if ($groupRequest->getGroup() === $this) {
                $groupRequest->setGroup(null);
            }
        }

        return $this;
    }
}
