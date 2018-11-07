<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RolesUsersRepository")
 */
class RolesUsers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="user_id", orphanRemoval=true)
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Roles", mappedBy="role_id", orphanRemoval=true)
     */
    private $role_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->role_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(Users $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->setUserId($this);
        }

        return $this;
    }

    public function removeUserId(Users $userId): self
    {
        if ($this->user_id->contains($userId)) {
            $this->user_id->removeElement($userId);
            // set the owning side to null (unless already changed)
            if ($userId->getUserId() === $this) {
                $userId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Roles[]
     */
    public function getRoleId(): Collection
    {
        return $this->role_id;
    }

    public function addRoleId(Roles $roleId): self
    {
        if (!$this->role_id->contains($roleId)) {
            $this->role_id[] = $roleId;
            $roleId->setRoleId($this);
        }

        return $this;
    }

    public function removeRoleId(Roles $roleId): self
    {
        if ($this->role_id->contains($roleId)) {
            $this->role_id->removeElement($roleId);
            // set the owning side to null (unless already changed)
            if ($roleId->getRoleId() === $this) {
                $roleId->setRoleId(null);
            }
        }

        return $this;
    }
}
