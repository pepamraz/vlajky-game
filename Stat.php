<?php

class Stat{
    public string $id;
    public string $stat;
    public string $obrazek;

    public function __construct($id, $stat,$obrazek)
    {
        $this->id = $id;
        $this->stat = $stat;
        $this->obrazek = $obrazek;
    }
}