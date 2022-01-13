<?php


namespace miralsoft\weclapp\customerexport\Traits;


interface IArrayMappable
{
    /**
     * Setzt alle Werte zu den settern, falls Methoden mit gleichen Namen der Schlüsseln vorhanden sind
     *
     * @param array $data Die Werte mit Schlüssel
     * @param bool $camelize Soll der Key korrekt umgewandelt werden
     */
    public function mapFromArray(array $data, $camelize = true);

    /**
     * Gibt alle Parameter als Array zurück
     *
     * @param boolean $withId Wenn false wird die ID nicht mit ausgegeben
     * @param bool $decamelize Soll der Key korrekt umgewandelt werden
     * @return array Alle Werte des Objektes
     */
    public function mapToArray($withId = true, $decamelize = true): array;
}