<?php
/**
 * @author shutin
 */
namespace Phenomena\UrlProtectorBundle\Twig;

use Phenomena\UrlProtectorBundle\Protector\ProtectorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RoutingExtension extends \Twig_Extension {
    /**
     * @var Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    private $generator;

    /**
     * @var \Phenomena\UrlProtectorBundle\Protector\ProtectorInterface
     */
    private $protector;

    public function __construct(ProtectorInterface $protector, UrlGeneratorInterface $generator) {
        $this->generator = $generator;
        $this->protector = $protector;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions() {
        return array(
            'protected_url' => new \Twig_Function_Method($this, 'getUrl'),
            'protected_path' => new \Twig_Function_Method($this, 'getPath'),
        );
    }

    public function getPath($name, $parameters = array(), $subjects = array()) {
        $parameters['checksum'] = $this->protector->generate($subjects);
        return $this->generator->generate($name, $parameters, false);
    }

    public function getUrl($name, $parameters = array(), $subjects = array()) {
        $parameters['checksum'] = $this->protector->generate($subjects);
        return $this->generator->generate($name, $parameters, true);
    }

    public function getName() {
        return "phenomena_urlprotector_routing_extension";
    }
}
