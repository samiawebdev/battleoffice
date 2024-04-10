<?php

namespace App\Entity;

use App\Repository\ShippingAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShippingAddressRepository::class)]
class ShippingAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $addressLine2 = null;

    #[ORM\Column]
    private ?int $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'shippingAddress')]
    private Collection $clients;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstNameShippingAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastNameShippingAddress = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneShippingAddress = null;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setAddressLine2(string $addressLine2): static
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setShippingAddress($this);
        }

        return $this;
    }

    public function removeClient(Client $client): static
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getShippingAddress() === $this) {
                $client->setShippingAddress(null);
            }
        }

        return $this;
    }

    public function getFirstNameShippingAddress(): ?string
    {
        return $this->firstNameShippingAddress;
    }

    public function setFirstNameShippingAddress(?string $firstNameShippingAddress): static
    {
        $this->firstNameShippingAddress = $firstNameShippingAddress;

        return $this;
    }

    public function getLastNameShippingAddress(): ?string
    {
        return $this->lastNameShippingAddress;
    }

    public function setLastNameShippingAddress(?string $lastNameShippingAddress): static
    {
        $this->lastNameShippingAddress = $lastNameShippingAddress;

        return $this;
    }

    public function getPhoneShippingAddress(): ?string
    {
        return $this->phoneShippingAddress;
    }

    public function setPhoneShippingAddress(?string $phoneShippingAddress): static
    {
        $this->phoneShippingAddress = $phoneShippingAddress;

        return $this;
    }
}
