<?php

namespace GamesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DeveloperRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DeveloperRepository extends EntityRepository
{
    const COUNTRIES = [
        'United States' => 'USA',
        'Poland' => 'POL',
        'Germany' => 'GER',
        'Ukraine' => 'UKR',
        'United Kingdom' => 'UK',
    ];

}
