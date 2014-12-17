<?php
namespace ProjetWeb\ClassiqueBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use ProjetWeb\ClassiqueBundle\Entity\Musicien as MusicienEntity;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class Album extends EntityRepository {

    /**
     * @param Musicien $musicien
     *
     * @return array
     */
    public function findByMusicien( MusicienEntity $musicien ) {
        $query = $this->createQueryBuilder( "a" );
        $query->join( "a.codeGenre", "g" );
        $query->join( "g.musiciens", "m" );
        $query->where( "m.codeMusicien = :musicien" );
        $query->setParameter( "musicien", $musicien );
        $query->setMaxResults(10);
        return $query->getQuery()->getResult();
    }

    public function findByMusicienAdapter( MusicienEntity $musicien ) {
        $query = $this->createQueryBuilder( "a" );
        $query->join( "a.codeGenre", "g" );
        $query->join( "g.musiciens", "m" );
        $query->where( "m.codeMusicien = :musicien" );
        $query->setParameter( "musicien", $musicien );
        $pagerfanta = new Pagerfanta( new DoctrineORMAdapter( $query ) );
        return $pagerfanta;
    }

    public function findByCompositeur(MusicienEntity $musicien) {
        $query = $this->createQueryBuilder('a');
        $query->join("a.disques","d");
        $query->join("d.compositiondisques","cd");
        $query->join("cd.codeMorceau","enr");
        $query->join("enr.codeComposition","cc");
        $query->join("cc.compositionoeuvres","co");
        $query->join("co.codeOeuvre","o");
        $query->join("o.composers","c");
        $query->join("c.codeMusicien","m");
        $query->where("m.codeMusicien = :musicien");
        $query->setParameter("musicien",$musicien);

        $pagerfanta = new Pagerfanta( new DoctrineORMAdapter( $query ) );
        return $pagerfanta;
    }

    public function findByInterprete(MusicienEntity $musicien) {
        $query = $this->createQueryBuilder('a');
        $query->join("a.disques","d");
        $query->join("d.compositiondisques","cd");
        $query->join("cd.codeMorceau","enr");
        $query->join("enr.interpreters","i");
        $query->join("i.codeMusicien","m");
        $query->where("m.codeMusicien = :musicien");
        $query->setParameter("musicien",$musicien);

        $pagerfanta = new Pagerfanta( new DoctrineORMAdapter( $query ) );
        return $pagerfanta;
    }

}