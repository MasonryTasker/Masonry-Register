<?php
/**
 * ModuleRegister.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Config
 */

namespace Foundry\Masonry\ModuleRegister;

use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegister as ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinition as WorkerModuleDefinitionInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ModuleRegister
 * @package Masonry-Config
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Config
 */
class ModuleRegister implements ModuleRegisterInterface
{

    protected $fileLocation = __DIR__.'/../register/register.yaml';

    /**
     * @var WorkerModuleDefinitionInterface[]
     */
    protected $workerModules = [];

    /**
     * ModuleRegister constructor.
     * @param string|null $fileLocation
     */
    protected function __construct($fileLocation = null)
    {
        if($fileLocation) {
            $this->fileLocation = $fileLocation;
        }
    }

    /**
     * @return WorkerModuleDefinitionInterface[]
     */
    public function getWorkerModuleDefinitions()
    {
        return $this->workerModules;
    }

    /**
     * @param WorkerModuleDefinitionInterface $module The definition of the module to be added
     * @throws \Exception If a problem occurs.
     * @return $this
     */
    public function addWorkerModule(WorkerModuleDefinitionInterface $module)
    {
        $this->workerModules[$module->getModuleName()] = $module;
    }

    /**
     * @throws \Exception If the file can not be saved.
     * @return $this
     */
    public function save()
    {
        $dumper = new Dumper();
        $data = $dumper->dump($this->toArray());
        file_put_contents($this->fileLocation, $data);
        return $this;
    }

    /**
     * @param string $filename Which file to load from
     * @throws \Exception If the file can not be loaded.
     * @return $this
     */
    public static function load($filename = null)
    {
        $register = new static($filename);

        // Check the file exists. If not, create it
        if(!file_exists($register->fileLocation)) {
            touch($register->fileLocation);
        }

        // Import the data to the object
        $data = (array)Yaml::parse(file_get_contents($register->fileLocation));
        foreach ($data as $key => $value) {
            if (property_exists($register, $key)) {
                $register->$key = $value;
            }
        }

        return $register;
    }

    /**
     * @return array
     */
    protected function toArray()
    {
        return get_object_vars($this);
    }

}
