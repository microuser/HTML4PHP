<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/Html4PhpSite.php');

/**
 * Description of configModel
 *
 * @author user
 */
class ConfigModel extends Html4PhpSite {

    public function __construct($title) {
        parent::__construct($title);
    }

    private function generateTableOfEnvironmentTiers($title, $configs) {
        $this->addDiv('<h2>' . $title . '</h2>', "", 'style="width:100%; position:relative; left:-30px;"');
        $values = array();
        foreach ($configs as $key => $config) {
            foreach ($config as $item => $value) {
                $values[] = array($item, $value);
            }

            $this->addTable($key, array('Item', 'Value'), $values);
        }
    }

    public function generateConfigArray() {
        include($this->getConfig('server', 'documentRoot') . '/includes/Html4PhpConfigData.php');

        $this->addDiv('<h2>Current Environment Tier</h2>', "", 'style="width:100%; position:relative; left:-30px;"');
        $this->addDiv('<ul><li><a href="#development">' . $this->getConfig('environment', 'tier') . '</a></li></ul>');

        $this->generateTableOfEnvironmentTiers('<a name="development">Environment Tier: Development</a>', $developmentConfig);
        $this->generateTableOfEnvironmentTiers('<a name="staging">Environment Tier: Staging</a>', $stagingConfig);
        $this->generateTableOfEnvironmentTiers('<a name="production">Environment Tier: Production</a>', $productionConfig);
    }

}
