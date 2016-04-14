<?php

namespace ArsThanea\KunstmaanAlgoliaBundle\Search;

use AlgoliaSearch\Client;
use AlgoliaSearch\Index;
use Kunstmaan\SearchBundle\Provider\SearchProviderInterface;

class AlgoliaSearchProvider implements SearchProviderInterface
{
    /**
     * @var Index[]
     */
    private $indexes = [];

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * Returns a unique name for the SearchProvider
     *
     * @return string
     */
    public function getName()
    {
        return 'Algolia';
    }

    /**
     * Return the client object
     *
     * @return mixed
     */
    public function getClient()
    {
        return null;
    }

    /**
     * Create an index
     *
     * @param string $indexName Name of the index
     */
    public function createIndex($indexName)
    {
        $this->initIndex($indexName)->setSettings([
            'attributesForFaceting' => ['type'],
            'ranking'               => [
                'typo',
                'geo',
                'words',
                'filters',
                'proximity',
                'attribute',
                'exact',
                'custom'
            ],
            'customRanking'         => [
                'desc(_boost)'
            ]
        ]);
    }

    /**
     * Return the index object
     *
     * @param $indexName
     *
     * @return mixed
     */
    public function getIndex($indexName)
    {
        return null; // nope!
    }

    /**
     * Create a document
     *
     * @param string $uid
     * @param mixed  $document
     * @param string $indexName
     * @param string $indexType
     *
     * @return mixed
     */
    public function createDocument($uid, $document, $indexName = '', $indexType = '')
    {
        return ['objectID' => $uid] + $document;
    }

    /**
     * Add a document to the index
     *
     * @param string $indexName Name of the index
     * @param string $indexType Type of the index to add the document to
     * @param array  $document  The document to index
     * @param string $uid       Unique ID for this document, this will allow the document to be overwritten by new data
     *                          instead of being duplicated
     */
    public function addDocument($indexName, $indexType, $document, $uid)
    {
        $this->initIndex($indexName)->addObject($document, $uid);
    }

    /**
     * Add a collection of documents at once
     *
     * @param mixed  $documents
     * @param string $indexName Name of the index
     * @param string $indexType Type of the index the document is located
     *
     * @return mixed
     */
    public function addDocuments($documents, $indexName = '', $indexType = '')
    {
        $this->initIndex($indexName)->addObjects($documents);
    }

    /**
     * delete a document from the index
     *
     * @param string $indexName Name of the index
     * @param string $indexType Type of the index the document is located
     * @param string $uid       Unique ID of the document to be delete
     */
    public function deleteDocument($indexName, $indexType, $uid)
    {
        /** @noinspection PhpParamsInspection */
        $this->initIndex($indexName)->deleteObject($uid);
    }

    /**
     * @param string $indexName
     * @param string $indexType
     * @param array  $ids
     */
    public function deleteDocuments($indexName, $indexType, array $ids)
    {
        $this->initIndex($indexName)->deleteObjects($ids);
    }

    /**
     * Delete an index
     *
     * @param string $indexName Name of the index to delete
     */
    public function deleteIndex($indexName)
    {
        $this->initIndex($indexName)->clearIndex();
    }

    /**
     * @param string $indexName
     * @return Index
     */
    private function initIndex($indexName)
    {
        if (false === isset($this->indexes[$indexName])) {
            $this->indexes[$indexName] = $this->client->initIndex($indexName);
        }

        return $this->indexes[$indexName];
    }


}
