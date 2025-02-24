<?php

namespace Core\Plugin;

class PluginManager
{
    private static $instance = null;
    private $plugins = [];
    private $hooks = [];
    private $config;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function loadPlugins()
    {
        if (!$this->config['plugins']['enabled']) {
            return;
        }

        $pluginsDir = $this->config['plugins']['directory'];
        if (!is_dir($pluginsDir)) {
            mkdir($pluginsDir, 0755, true);
            return;
        }

        foreach (glob($pluginsDir . '/*', GLOB_ONLYDIR) as $pluginDir) {
            $this->loadPlugin($pluginDir);
        }
    }

    private function loadPlugin($pluginDir)
    {
        $pluginFile = $pluginDir . '/plugin.php';
        if (!file_exists($pluginFile)) {
            return;
        }

        $plugin = require $pluginFile;
        if (!isset($plugin['name']) || !isset($plugin['version'])) {
            return;
        }

        $this->plugins[$plugin['name']] = $plugin;
        
        if (isset($plugin['hooks'])) {
            foreach ($plugin['hooks'] as $hook => $callback) {
                $this->addHook($hook, $callback);
            }
        }
    }

    public function addHook($name, $callback)
    {
        if (!isset($this->hooks[$name])) {
            $this->hooks[$name] = [];
        }
        $this->hooks[$name][] = $callback;
    }

    public function executeHook($name, $params = [])
    {
        if (!isset($this->hooks[$name])) {
            return null;
        }

        $results = [];
        foreach ($this->hooks[$name] as $callback) {
            $results[] = call_user_func_array($callback, [$params]);
        }

        return $results;
    }

    public function getPlugins()
    {
        return $this->plugins;
    }

    public function getPlugin($name)
    {
        return $this->plugins[$name] ?? null;
    }
} 