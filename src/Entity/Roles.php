<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\Role\RoleHierarchyInterface as RoleHierarchyInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\RolesRepository")
 */
class Roles implements RoleHierarchyInterface
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
    private $role;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

	public function getReachableRoles(array $roles)
	{
	}

/*    public function getRoleId(): ?RolesUsers
    {
        return $this->role_id;
    }

    public function setRoleId(?RolesUsers $role_id): self
    {
        $this->role_id = $role_id;

        return $this;
    }*/
}
