<?php

namespace miralsoft\weclapp\customerexport\Traits;

use Webmasters\Doctrine\ORM\Util\StringConverter;

/**
 * Dieser Trait dient dafür, dass man über diese Methode über ein array alle Set-Methoden aufruft
 *
 * @author Michael Tosch
 */
trait ArrayMappableTrait
{

    /**
     * Setzt alle Werte zu den settern, falls Methoden mit gleichen Namen der Schlüsseln vorhanden sind
     *
     * @param array $data Die Werte mit Schlüssel
     * @param bool $camelize Soll der Key korrekt umgewandelt werden
     */
    public function mapFromArray(array $data, $camelize = true)
    {
        if (count($data) > 0) {
            // Alle Werte setzen, falls Methoden dafür vorhanden sind
            foreach ($data as $key => $val) {
                if ($camelize) {
                    $methodName = 'set' . StringConverter::camelize($key);
                } else {
                    $methodName = 'set' . ucfirst($key);
                }

                if (method_exists($this, $methodName)) {
                    $this->$methodName($val);
                }
            }
        }
    }

    /**
     * Gibt alle Parameter als Array zurück
     *
     * @param boolean $withId Wenn false wird die ID nicht mit ausgegeben
     * @param bool $decamelize Soll der Key korrekt umgewandelt werden
     * @return array Alle Werte des Objektes
     */
    public function mapToArray($withId = true, $decamelize = true): array
    {
        $result = [];
        $attributes = get_object_vars($this);

        // Jedes Attribut formatieren
        foreach ($attributes as $key => $val) {
            if ($decamelize) {
                $key = StringConverter::decamelize($key);
            }

            $result[$key] = $val;
        }

        // Wenn keine ID ausgegeben werden soll
        if ($withId === false) {
            unset($attributes['id']);
        }

        return $result;
    }
}
