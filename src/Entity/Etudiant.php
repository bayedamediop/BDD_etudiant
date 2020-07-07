<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
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
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @Assert\Regex(
     *     pattern = "/^7[0678]{1}[0-9]{7}+$/",
     *     message= "Numero de telephone '{{ value }}' Invalider!!!!"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     *@Assert\Regex(
     *     pattern = "/^[+a-zA-Z._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i",
     *     message= " le '{{ value }}' N'est pas un bon Adresse Email!!!!"
     * )
     * @ORM\Column(type="string", length=255)

     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_etudiant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_bourse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adrese;

    /**
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="etudiants")
     */
    private $chambre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getTypeEtudiant(): ?string
    {
        return $this->type_etudiant;
    }

    public function setTypeEtudiant(string $type_etudiant): self
    {
        $this->type_etudiant = $type_etudiant;

        return $this;
    }

    public function getTypeBourse(): ?string
    {
        return $this->type_bourse;
    }

    public function setTypeBourse(?string $type_bourse): self
    {
        $this->type_bourse = $type_bourse;

        return $this;
    }

    public function getAdrese(): ?string
    {
        return $this->adrese;
    }

    public function setAdrese(?string $adrese): self
    {
        $this->adrese = $adrese;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }
}
