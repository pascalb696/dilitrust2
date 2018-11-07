<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentsRepository")
 */
class Documents
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
    private $document_name;

    private $fk_roles_users_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $upload_name;

    /**
     * @ORM\Column(type="time")
     */
    private $creation_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentName(): ?string
    {
        return $this->document_name;
    }

    public function setDocumentName(string $document_name): self
    {
        $this->document_name = $document_name;

        return $this;
    }

    public function getFkRolesUsersId(): ?RolesUsers
    {
        return $this->fk_roles_users_id;
    }

    public function setFkRolesUsersId(?RolesUsers $fk_roles_users_id): self
    {
        $this->fk_roles_users_id = $fk_roles_users_id;

        return $this;
    }

    public function getUploadName(): ?string
    {
        return $this->upload_name;
    }

    public function setUploadName(string $upload_name): self
    {
        $this->upload_name = $upload_name;

        return $this;
    }

    public function getCreationTime(): ?\DateTimeInterface
    {
        return $this->creation_time;
    }

    public function setCreationTime(\DateTimeInterface $creation_time): self
    {
        $this->creation_time = $creation_time;

        return $this;
    }

	public function getRolesList () {
    return $this->createQueryBuilder('roles')
        ->select('id, role')
//        ->innerJoin(Language::class, 'language', 'WITH', 'language.user_id = user.id')
//        ->where('language.language = :langOne AND language.language = :langTwo')
//        ->setParameter('langOne ', $langOne )
//        ->setParameter('langTwo', $langTwo)
        ->getQuery()
        ->getResult();
}
}
