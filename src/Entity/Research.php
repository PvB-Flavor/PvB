<?php

namespace App\Entity;

use App\Repository\ResearchRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResearchRepository::class)
 */
class Research
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The title of the research
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $title;

    /**
     * The description of the research
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $description;

    /**
     * If the research is still ongoing
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $ongoing;

    /**
     * The link to the form
     * @ORM\Column(type="string")
     * @Assert\Url
     * @Assert\Type("string")
     */
    private $formLink;

    /**
     * The path to research image
     * @ORM\Column(type="string", nullable=true, options={"default": "placeholder.jpg"})
     * @Assert\Type("string")
     */
    private $image;

    /**
     * The path to the company image
     * @ORM\Column(type="string", nullable=true, options={"default": "placeholder.jpg"})
     * @Assert\Type("string")
     */
    private $companyImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getOngoing()
    {
        return $this->ongoing;
    }

    /**
     * @param mixed $ongoing
     */
    public function setOngoing($ongoing): void
    {
        $this->ongoing = $ongoing;
    }

    /**
     * @return mixed
     */
    public function getFormLink()
    {
        return $this->formLink;
    }

    /**
     * @param mixed $formLink
     */
    public function setFormLink($formLink): void
    {
        $this->formLink = $formLink;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getCompanyImage()
    {
        return $this->companyImage;
    }

    /**
     * @param mixed $companyImage
     */
    public function setCompanyImage($companyImage): void
    {
        $this->companyImage = $companyImage;
    }
}
