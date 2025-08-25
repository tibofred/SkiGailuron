<?php



use Symfony\Component\HttpKernel\Kernel;

use Symfony\Component\Config\Loader\LoaderInterface;



class AppKernel extends Kernel

{

    public function registerBundles()

    {

        $bundles = [

            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),

            new Symfony\Bundle\SecurityBundle\SecurityBundle(),

            new Symfony\Bundle\TwigBundle\TwigBundle(),

            new Symfony\Bundle\MonologBundle\MonologBundle(),

            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),

            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new AppBundle\AppBundle(),

            new VW\BaseBundle\VWBaseBundle(),

            new VW\ContactBundle\VWContactBundle(),

            new VW\UserBundle\VWUserBundle(),

            new FOS\UserBundle\FOSUserBundle(),

            new VW\SeoBundle\VWSeoBundle(),

            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),

            new Welp\MailchimpBundle\WelpMailchimpBundle(),

            new VW\ClientBundle\VWClientBundle(),

            new VW\AbonnementBundle\VWAbonnementBundle(),

            new PaymentBundle\PaymentBundle(),

            new Payum\Bundle\PayumBundle\PayumBundle(),

            new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),

            new JMS\TranslationBundle\JMSTranslationBundle(),

        ];



        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {

            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();

            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();

            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();

            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();			$bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();

        }



        return $bundles;

    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }

    // IMPORTANT en container: écrire cache/logs dans /tmp
    public function getCacheDir()
    {
        return sys_get_temp_dir().'/symfony/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/symfony/logs';
    }
}
