<?php

namespace Phenomena\UrlProtectorBundle\Protector;



class Simple implements ProtectorInterface {

    private $secret;

    public function setSecret($secret) {
        $this->secret = $secret;
    }

    public function verify($checksum,array $subjects) {
        return $checksum === $this->generate($subjects);
    }

    public function generate(array $subjects) {
        $paramstring = '';
        foreach ($subjects as $object) {
            if (!($object instanceof VerificationSubjectInterface)) {
                throw new \Exception(sprintf("Invalid object! %s class required for url verification!"));
            }
            $paramstring .= implode('',$object->getVerificationValues());
        }

        $checksum = sha1($this->addSalt($paramstring));
        return $checksum;
    }

    private function addSalt($paramstring) {
        $result= '';
        for ($i=0;$i<strlen($paramstring);$i++) {
            $result .=$paramstring[$i];
            if (strlen($this->secret) > $i) {
                $result.= $this->secret[$i];
            }
        }

        return $result;
    }
}
