<?php

namespace App\Repository;

use App\Entity\Microservice;
use App\Entity\SearchService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method Microservice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Microservice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Microservice[]    findAll()
 * @method Microservice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroserviceRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Microservice::class);

        $this->paginator = $paginator;
    }

    /**
     * Recupère les annonces en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchService $search): PaginationInterface
    {
        $query = $this->getSearcheQuery($search)->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            16
        );
    }

    /**
     * Recupère le prix min et max corespondant à une recherche
     * @return integer[]
     */
    private function findMinMaxPrice(SearchService $search): array
    {
        $result = $this->getSearcheQuery($search)
            ->select('MIN(a.price) as min', 'MAX(a.price) as max')
            ->getQuery()
            ->getScalarResult();

        return [(int)$result[0]['min'], (int)$result[1]['max']];
    }

    /**
     * //@return QueryBuilder
     */
    private function getSearcheQuery(SearchService $search) //: QueryBuilder
    {
        $query = $this->createQueryBuilder('m')
            ->select('v', 'm')
            ->select('c', 'm')
            ->leftjoin('m.vendeur', 'v')
            ->join('m.categories', 'c')
            ->orderBy('m.created', 'DESC')
            ->andWhere('m.online = 1');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('m.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->minPrice)) {
            $query = $query
                ->andWhere('m.prixMastering >= :minPrice')
                ->setParameter('minPrice', $search->minPrice);
        }

        if (!empty($search->maxPrice)) {
            $query = $query
                ->andWhere('m.prixBeatmaking <= :maxPrice')
                ->setParameter('maxPrice', $search->maxPrice);
        }

        if ($search->getCategories()->count() > 0) {
            $query = $query
                ->andWhere('c.id IN (:categorie)')
                ->setParameter('categorie', $search->categories);
        }

        if (!empty($search->promo)) {
            $query = $query
                ->andWhere('m.promo = 1');
        }

        return $query;
    }

    /*
    public function findOneBySomeField($value): ?Microservice
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Undocumented function
     *
     * @param [type] $lat1
     * @param [type] $lon1
     * @param [type] $lat2
     * @param [type] $lon2
     * @param [type] $unit
     * @return void
     */
    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function findBylocation($userAdresse): array
    {
        return $this->createQueryBuilder('m')
            ->select('v', 'm')
            ->leftjoin('m.vendeur', 'v')
            ->orderBy('m.created', 'DESC')
            ->andWhere('m.online = 1')
            ->andWhere('v.adresse = :adresse')
            ->setParameter('adresse', $userAdresse)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    public function findLasted(): array
    {
        return $this->createQueryBuilder('m')
            ->select('v', 'm')
            ->leftjoin('m.vendeur', 'v')
            ->orderBy('m.created', 'DESC')
            ->andWhere('m.online = 1')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
}
