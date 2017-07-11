<?php
namespace Simseo\ForumBundle\Component;

use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
/**
 * Pagin 
 * Service use knp_paginator for pagination of SimseoForum
 * Service name: simseo.forum.pagin
 * 
 * @package  SimseoForumBundle
 * @author   Simon Cosandey <contact@simseo.ch>
 * @access   public
 */
class Pagin
{
    /*
     * @var object Symfony\Component\HttpFoundation\ParameterBag
     */
    private $request;
    /*
     * @var object Knp\Component\Pager\Paginator
     */
    private $knpPagignator;
    /*
     * @var array configuration for pagination
     */
    private $config;
    /*
     * @var string get page name (url?page=1)
     */
    private $queryName;
    
    /*
     * @param objet $request Symfony\Component\HttpFoundation\RequestStack
     * @param objet $knpPagignator Knp\Component\Pager\Paginator
     * @param array paginationConfig Discutea config pagination
     * @param array $queryName
     */
    public function __construct(RequestStack $request, Paginator $knpPagignator, $paginationConfig, $queryName)
    {
        $this->request = $request->getCurrentRequest()->query;
        $this->knpPagignator = $knpPagignator;
        $this->config = $paginationConfig;
        $this->queryName = $queryName;
    }
    /**
     * 
     * @param string $name name for fetch configuration reference
     * @param objet $collection Doctrine\ORM\PersistentCollection
     * 
     * @return objet Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     * @return objet $collection Doctrine\ORM\PersistentCollection
     */
    public function paginate($name, $collection) {
        if ( (array_key_exists($name, $this->config)) &&  ($this->config[$name]["enabled"] === true)) {
            return $this->knpPagignator->paginate(
                    $collection,
                    $this->request->getInt($this->queryName, 1),
                    $this->config[$name]["per_page"]
                );
        }
       return $collection; 
    }
}