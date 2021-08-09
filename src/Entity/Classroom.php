<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Inflector\Inflector;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Inflector\NoopWordInflector;

/**
 * @ORM\Entity(repositoryClass=ClassroomRepository::class)
 */
class Classroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParameters(array $params): Classroom
    {
        $inflector = new Inflector(new NoopWordInflector(), new NoopWordInflector());

        foreach ($params as $key => $value) {

            $field = $inflector->camelize($key);

            if (property_exists($this, $key)) {
                $this->{'set' . ucfirst($field)}($value);
            }
        }

        return $this;
    }
}
