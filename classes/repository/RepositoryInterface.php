<?php

interface RepositoryInterface
{
    //Typical functionalities
    public function find(int $id);
    public function findAll();
}