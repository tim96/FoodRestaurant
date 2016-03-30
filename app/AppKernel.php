<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    const ADMIN = 'admin';
    const API = 'api';
    const FRONTEND = 'frontend';

    protected $application = null;

    protected $bundleList = array();

    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);

        $this->application = $this->getApplicationType();
    }

    public function registerBundles()
    {
        $this->bundleList = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        ];

        // main bundle
        $this->addBundle(new Tim\FoodRestaurantBundle\TimFoodRestaurantBundle());

        // backend bundles
        $this->addBundle(new FOS\UserBundle\FOSUserBundle());
        $this->addBundle(new \Sonata\CoreBundle\SonataCoreBundle());
        $this->addBundle(new \Sonata\BlockBundle\SonataBlockBundle());
        $this->addBundle(new \Knp\Bundle\MenuBundle\KnpMenuBundle());
        $this->addBundle(new \Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle());
        $this->addBundle(new \Sonata\AdminBundle\SonataAdminBundle());
        $this->addBundle(new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'));

        $this->addBundle(new Application\Sonata\UserBundle\ApplicationSonataUserBundle());

//        // todo: rewrite this solutions !!!
//        if ($this->isNeedLoadAllBundles() || $this->application === self::FRONTEND) {
//        }
//
//        if ($this->isNeedLoadAllBundles() || $this->application === self::ADMIN) {
//        }
//
//        if ($this->isNeedLoadAllBundles() || $this->application === self::API) {
//        }

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $this->addBundle(new Symfony\Bundle\DebugBundle\DebugBundle());
            $this->addBundle(new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle());
            $this->addBundle(new Sensio\Bundle\DistributionBundle\SensioDistributionBundle());
            $this->addBundle(new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle());
        }

        return $this->bundleList;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }

    protected function addBundle($bundle)
    {
        if (in_array($bundle, $this->bundleList)) {
            return false;
        }
        $this->bundleList[] = $bundle;
        return true;
    }

    protected function isNeedLoadAllBundles()
    {
        // if (in_array($this->getEnvironment(), array('dev', 'test')) ||
        if (in_array($this->getEnvironment(), array('test')) ||
            $_SERVER['SCRIPT_NAME'] == 'app/console' ||
            strstr($_SERVER['SCRIPT_NAME'], 'phpunit')
        ) {
            return true;
        } else {
            return false;
        }
    }

    protected function getApplicationType()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
            // this line check subdomain
            // if (strstr($_SERVER['HTTP_HOST'], 'admin.')) {
            if ($this->isRequestStartsWith($url, '/' . self::ADMIN)) {
                return self::ADMIN;
            } elseif ($this->isRequestStartsWith($url, '/' . self::API)) {
                return self::API;
            }
        }

        return self::FRONTEND;
    }

    private function isRequestStartsWith($haystack, $needle) {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
}
