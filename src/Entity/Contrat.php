<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity(fields: ['numero'], message: 'Un Contrat existe déjà avec ce numéro.  Changez de numéro.')]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'security' => "is_granted('ROLE_USER')",
            'security_message' => "Action non autorisée",
        ]
    ],
    itemOperations: [
        'get' => [
            'security' => "is_granted('ROLE_SUPER_ADMIN')",
            'security_message' => "Action non autorisée",
        ],
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'numero' => 'exact', 'titre_contrat' => 'partial'])]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre_contrat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(nullable: false)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\OneToMany(mappedBy: 'contrat', targetEntity: Site::class)]
    private Collection $sites;

    public function __construct()
    {
        $uuid = Uuid::v4();
        $this->numero = $uuid->__toString();
        $this->sites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $now = new \DateTimeImmutable();
        $this->setUpdatedAt($now);
        if ($this->getId() === null) {
            $this->setCreatedAt($now);
        }
    }

    public function getTitreContrat(): ?string
    {
        return $this->titre_contrat;
    }

    public function setTitreContrat(?string $titre_contrat): self
    {
        $this->titre_contrat = $titre_contrat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(int $string): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites[] = $site;
            $site->setContrat($this);
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getContrat() === $this) {
                $site->setContrat(null);
            }
        }

        return $this;
    }

    public function hasSite(Site $site) : bool
    {
        if($this->sites->contains($site)) {
            return true;
        }
        else{
            return false;
        }
    }

    public function canStart(Site $site) : bool
    {
        if($this->sites->contains($site)) {
            $now = new \DateTime();
            if($this->date_debut <= $now) {
                return true;
            }
            else {
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function IsExpired(Site $site) : bool
    {
        if($this->sites->contains($site)) {
            $now = new \DateTime();
            if($this->date_fin > $now) {
                return true;
            }
            else {
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function getDisplayName(): string
    {
        $dateFormat = 'd-m-Y';
        $displayName = "N° : " . $this->numero . " | ";
        $displayName .= "Client : " . $this->getClient()->getNom() . " | ";
        $displayName .= "Date Début : " . $this->date_debut->format($dateFormat) . " | ";
        $displayName .= "Date Fin : " . $this->date_fin->format($dateFormat);
        return $displayName;
    }

    public function getDisplayNameV2(): string
    {
        $dateFormat = 'd-m-Y';
        $displayName = $this->numero . " | ";
        $displayName .= $this->getClient()->getNom() . " | ";
        $displayName .= $this->date_debut->format($dateFormat) . " | ";
        $displayName .= $this->date_fin->format($dateFormat);
        return $displayName;
    }
}
