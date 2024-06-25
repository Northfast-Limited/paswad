<?php
class ConfigService {
    private $configFilePath;

    public function __construct($configFilePath) {
        $this->configFilePath = $configFilePath;
    }

    private function loadConfig() {
        if (file_exists($this->configFilePath)) {
            $json = file_get_contents($this->configFilePath);
            return json_decode($json, true);
        } else {
            throw new Exception("Config file not found.");
        }
    }

    public function getConfig() {
        return $this->loadConfig();
    }

    public function getFeature($feature) {
        $config = $this->loadConfig();
        return $config['features'][$feature] ?? null;
    }

    public function getModule($module) {
        $config = $this->loadConfig();
        return $config['modules'][$module] ?? null;
    }

    public function getApiUrl($endpoint) {
        $config = $this->loadConfig();
        return $config['api']['urls'][$endpoint] ?? null;
    }

    public function getOtherInfo($info) {
        $config = $this->loadConfig();
        return $config['otherInfo'][$info] ?? null;
    }
}
?>
