<?php

class QueryBuilder {
    private $query = '';

    public function __call($name, $arguments) {
        $method = strtoupper(preg_replace('/_/', ' ', $name));
        $this->query .= ' ' . $method . ' ' . $arguments[0];

        return $this;
    }

    public function get() {
        $query = trim($this->query);
        $this->query = '';

        return $query;
    }
}