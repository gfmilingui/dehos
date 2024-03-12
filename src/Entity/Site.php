<?php

namespace App\Entity;

use App\Service\AvailableOptions;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity(fields: ['nom', 'client'], message: 'Un Site existe déjà avec le nom saisi. Changez le nom.')]
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
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'nom' => 'partial', 'ville' => 'partial', 'pays' => 'partial'])]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $quartier = null;

    #[ORM\Column]
    private ?int $nombre_bennes = null;

    #[ORM\ManyToOne(inversedBy: 'sites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Benne::class)]
    private Collection $bennes;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Demande::class)]
    private Collection $demandes;

    #[ORM\ManyToOne(inversedBy: 'sites')]
    private ?Contrat $contrat = null;

    public function __construct()
    {
        $this->statut = AvailableOptions::getStatutSitesAffectation()["Affecter"];
        $this->bennes = new ArrayCollection();
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
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

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): self
    {
        $this->quartier = $quartier;

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

    /**
     * @return Collection<int, Benne>
     */
    public function getBennes(): Collection
    {
        return $this->bennes;
    }

    public function addBenne(Benne $benne): self
    {
        if (!$this->bennes->contains($benne)) {
            $this->bennes[] = $benne;
            $benne->setSite($this);
        }

        return $this;
    }

    public function removeBenne(Benne $benne): self
    {
        if ($this->bennes->removeElement($benne)) {
            // set the owning side to null (unless already changed)
            if ($benne->getSite() === $this) {
                $benne->setSite(null);
            }
        }

        return $this;
    }

    /**
     * C'est le nombre_bennes_allouee.
     */
    public function getNombreBennes(): ?int
    {
        return $this->nombre_bennes;
    }

    public function setNombreBennes(int $nombre_bennes): self
    {
        $this->nombre_bennes = $nombre_bennes;

        return $this;
    }

    /**
     * C'est le nombre_bennes_affectee.
     */
    public function getNumBenneAffected(): int
    {
        return count($this->getBennes());
    }

    /**
     * C'est le nombre_bennes_libre.
     */
    public function getNumberBenneAvailabled(): int
    {
        $numBenneAvailabled = $this->getNombreBennes() - $this->getNumBenneAffected();
        return $numBenneAvailabled;
    }

    /**
     * Check is still free benne regarding requested benne.
     */
    public function hasFreeBenne($requestedBennes) : bool
    {
        $freeBenne = ($this->nombre_bennes - $this->getNumBenneAffected() - $requestedBennes);
        if($freeBenne >= 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setSite($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getSite() === $this) {
                $demande->setSite(null);
            }
        }

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    public function hasContrat(): bool
    {
        if(empty($this->contrat)) {
            return false;
        }
        else{
            return true;
        }
    }
}
