<?php

namespace Webaccess\BugtrackerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
	public function getTotalNumber() {
		return $this->createQueryBuilder('t')
			->select('COUNT(t)')
			->getQuery()
			->getSingleScalarResult();
	}

	public function getByUser($userId, $projectId = NULL, $limit, $offset) {
		$qb = $this->createQueryBuilder('t');

   		$qb->orderBy('t.id', 'DESC')
        	->leftJoin('t.project', 'p')
        	->leftJoin('p.users', 'user')
			->andWhere($this->createQueryBuilder('t')->expr()->eq('user.id', $userId));

			if($projectId) {
	        	$qb->andWhere('p.id = :project_id')
	            ->setParameter('project_id', $projectId);
	        }

			$qb->setFirstResult($offset)
			->setMaxResults($limit);

        	return $qb->getQuery()->getResult();
	}
}