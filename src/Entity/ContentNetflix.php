<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContentNetflixRepository")
 */
class ContentNetflix
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $releasedate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlimage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReleasedate(): ?string
    {
        return $this->releasedate;
    }

    public function setReleasedate(?string $releasedate): self
    {
        $this->releasedate = $releasedate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrlimage(): ?string
    {
        return $this->urlimage;
    }

    public function setUrlimage(string $urlimage): self
    {
        $this->urlimage = $urlimage;

        return $this;
    }
}
