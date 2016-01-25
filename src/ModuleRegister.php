<?php
/**
 * ModuleRegister.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Register
 */

namespace Foundry\Masonry\ModuleRegister;

use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegister as ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinition as WorkerModuleDefinitionInterface;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ModuleRegister
 * This is the register itself. This implementation stores everything in a yaml file.
 * @package Masonry-Register
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Register
 */
class ModuleRegister implements ModuleRegisterInterface
{

    protected $fileLocation;

    /**
     * @var WorkerModuleDefinitionInterface[]
     */
    protected $workerModules = [];

    /**
     * ModuleRegister constructor.
     * @param string|null $fileLocation
     */
    public function __construct($fileLocation)
    {
        $this->fileLocation = $fileLocation;
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
     * @param WorkerModuleDefinitionInterface[] $modules An array of modules to be added
     * @throws \Exception If a problem occurs.
     * @return $this
     */
    public function addWorkerModules(array $modules)
    {
        foreach($modules as $module) {
            $this->addWorkerModule($module);
        }
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
        // Check the file exists. If not, create it
        if(!file_exists($filename)) {
            touch($filename);
        }

        // Import the data to the object
        $data = (array)Yaml::parse(file_get_contents($filename));

        $register = new static($filename);
        $register->fromArray($data);

        return $register;
    }

    /**
     * @return array
     */
    protected function toArray()
    {
        $workerModules = [];
        foreach($this->workerModules as $module) {
            $workerModules[$module->getModuleName()] = [
                WorkerModuleDefinition::KEY_WORKERS => $module->getWorkers(),
                WorkerModuleDefinition::KEY_DESCRIPTIONS => $module->getDescriptions(),
                WorkerModuleDefinition::KEY_CONFIG => $module->getConfigurationKeys(),
            ];
        }
        return [
            'workerModules' => $workerModules
        ];
    }

    /**
     * @param array $array
     */
    protected function fromArray(array $array)
    {
        if(
            array_key_exists('workerModules', $array)
            && is_array($array['workerModules'])
        ) {
            foreach($array['workerModules'] as $name => $module) {
                $this->workerModules[$name] = new WorkerModuleDefinition(
                    (array)$module[WorkerModuleDefinition::KEY_WORKERS],
                    (array)$module[WorkerModuleDefinition::KEY_DESCRIPTIONS],
                    (array)$module[WorkerModuleDefinition::KEY_CONFIG]
                );
            }
        }
    }

}
