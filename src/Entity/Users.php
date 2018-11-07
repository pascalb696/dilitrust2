<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM; 
use \Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $password;

	/**
	 * @var Collection|Roles[]
	 * @ORM\ManyToMany(targetEntity="Roles")
	 * @ORM\JoinTable(
	 *      name="roles_users	",
	 *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
	 * )
	 */
	private $roles;

	public function __construct()
	{
	    $this->roles = new ArrayCollection();
	}

	public function setRoles(Collection $roles)
	{
    	$this->roles = $roles;
	}

	public function getRoles()
	{
    	//return $this->roles->toArray();
    	return ['ROLE_ADMIN', 'ROLE_USER'];
	}

	public function addRole(Role $role)
	{
    	$this->roles->add($role);
	}

	public function removeRole(Role $role)
	{
    	$this->roles->removeElement($role);
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /*
    public function getRoles($originalRoles)
	{
    	$roles = array();


    	foreach ($originalRoles as $originalRole => $inheritedRoles) {
        	foreach ($inheritedRoles as $inheritedRole) {
            	$roles[$inheritedRole] = array();
	        }

    	    $roles[$originalRole] = array();
	    }


    	foreach ($roles as $key => $role) {
        	$roles[$key] = $this->getInheritedRoles($key, $originalRoles);
	    }

    	return $roles;
	}*/
    
    public function getSalt()
    {
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsername()
    {
	    return $this->username;
    }
    
    public function eraseCredentials()
    {
    }

	public function serialize()
	{
		return serialize([
			$this->id,
			$this->username,
			$this->password
		]);
	}
	public function unserialize($string)
	{
		list($this->id,
			$this->username,
			$this->password) = unserialize($string, ['allowed_classes' => false]);
	}
/*    public function getUserId(): ?RolesUsers
    {
        return $this->user_id;
    }

    public function setUserId(?RolesUsers $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }*/
}
