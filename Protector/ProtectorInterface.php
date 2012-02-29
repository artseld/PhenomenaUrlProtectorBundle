<?php
/**
 * @author shutin
 */

namespace Phenomena\UrlProtectorBundle\Protector;

interface ProtectorInterface {

    /**
     * Verifies that checksum are correct for specified subjects
     * @abstract
     * @param $checksum
     * @param array $subjects
     */
    public function verify($checksum,array $subjects);

    /**
     * Generates verification checksum based on verification subjects
     * @abstract
     * @param array $subjects
     */
    public function generate(array $subjects);

}
