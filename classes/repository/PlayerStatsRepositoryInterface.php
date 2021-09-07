<?php

interface PlayerStatsRepositoryInterface
{
    public function getByPlayerStats(array $filters);
}