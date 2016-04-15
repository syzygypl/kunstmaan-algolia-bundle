<?php

namespace ArsThanea\KunstmaanAlgoliaBundle\Twig;

class AlgoliaTwigExtension extends \Twig_Extension
{
    private $settings = [];

    public function __construct($applicationId, $apiKey, $indexPrefix, $indexName)
    {
        $this->settings = [
            'id'    => $applicationId,
            'key'   => $apiKey,
            'index' => $indexPrefix.$indexName,
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('algolia_settings', [$this, 'getAlgoliaSettings'])
        ];
    }

    /**
     * @return array
     */
    public function getAlgoliaSettings()
    {
        return $this->settings;
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'algolia_settings';
    }
}
