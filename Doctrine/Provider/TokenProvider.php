<?php

namespace Bazinga\OAuthServerBundle\Doctrine\Provider;

use Bazinga\OAuthServerBundle\Model\Provider\TokenProvider as BaseTokenProvider;
use Bazinga\OAuthServerBundle\Model\TokenInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Robin van der Vleuten <robinvdvleuten@gmail.com>
 */
class TokenProvider extends BaseTokenProvider
{
    /**
     * @var string
     */
    private $requestTokenClass;

    /**
     * ObjectRepository
     */
    private $requestTokenRepository;

    /**
     * @var string
     */
    private $accessTokenClass;

    /**
     * ObjectRepository
     */
    private $accessTokenRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Constructor
     *
     * @param ObjectManager $objectManager A ObjectManager instance.
     * @param string        $accessTokenClass
     * @param string        $requestTokenClass
     */
    public function __construct(ObjectManager $objectManager, $requestTokenClass, $accessTokenClass)
    {
        $this->objectManager = $objectManager;
        $this->requestTokenClass = $requestTokenClass;
        $this->accessTokenClass = $accessTokenClass;

        $this->requestTokenRepository = $objectManager->getRepository($requestTokenClass);
        $this->accessTokenRepository = $objectManager->getRepository($accessTokenClass);
    }

    /**
     * {@inheritDoc}
     */
    public function getRequestTokenClass()
    {
        return $this->requestTokenClass;
    }

    /**
     * {@inheritDoc}
     */
    public function getAccessTokenClass()
    {
        return $this->accessTokenClass;
    }

    /**
     * {@inheritDoc}
     */
    public function loadRequestTokenBy(array $criteria)
    {
        return $this->requestTokenRepository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function loadRequestTokens()
    {
        return $this->requestTokenRepository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function loadAccessTokenBy(array $criteria)
    {
        return $this->accessTokenRepository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function loadAccessTokens()
    {
        return $this->requestTokenRepository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteToken(TokenInterface $token)
    {
        $this->objectManager->remove($token);
        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function updateToken(TokenInterface $token)
    {
        $this->objectManager->persist($token);
        $this->objectManager->flush();
    }
}
