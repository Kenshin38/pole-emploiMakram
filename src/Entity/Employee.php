<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
    public function __construct()
    {
        $this->setEmployementDate(new \DateTime());
        $this->childs = new ArrayCollection();
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Lastname;

    /**
     * @ORM\Column(type="date")
     */
    private $employement_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): self
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getEmployementDate(): ?\DateTimeInterface
    {
        return $this->employement_date;
    }

    public function setEmployementDate(\DateTimeInterface $employement_date): self
    {
        $this->employement_date = $employement_date;

        return $this;
    }

    public function getEmployee(): ?Job
    {
        return $this->Employee;
    }

    public function setEmployee(?Job $Employee): self
    {
        $this->Employee = $Employee;

        return $this;
    }
}
