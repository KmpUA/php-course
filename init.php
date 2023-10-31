<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
use Phpfastcache\CacheManager;
use Phpfastcache\Drivers\Files\Config;
use Phpfastcache\Exceptions\PhpfastcacheDriverCheckException;
use Phpfastcache\Exceptions\PhpfastcacheDriverException;
use Phpfastcache\Exceptions\PhpfastcacheDriverNotFoundException;
use Phpfastcache\Exceptions\PhpfastcacheInvalidArgumentException;
use Phpfastcache\Exceptions\PhpfastcacheInvalidConfigurationException;
use Phpfastcache\Exceptions\PhpfastcacheInvalidTypeException;
use Phpfastcache\Exceptions\PhpfastcacheLogicException;

require_once("vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
require_once("util/database_model.php");
$db = new DatabaseModel();
session_start();
$cache_config = new Config();
global $cache;
try {
    $cache_config = new Config([
        'path' => realpath(__DIR__) . '/cache',
        'preventCacheSLams' => true,
        "cacheSlamsTimeout" => 20,
        'secureFileManipulation' => true
    ]);
} catch (PhpfastcacheInvalidConfigurationException|PhpfastcacheInvalidTypeException $e) {
}
try {
    CacheManager::setDefaultConfig($cache_config);
} catch (PhpfastcacheInvalidArgumentException $e) {
}
try {
    $cache = CacheManager::getInstance('Files');
} catch (PhpfastcacheDriverCheckException|PhpfastcacheDriverNotFoundException|PhpfastcacheDriverException|PhpfastcacheLogicException $e) {
}

/**
 * @throws PhpfastcacheInvalidArgumentException
 */
function cacheTours(): array
{
    global $db, $cache;
    $db->use_table("tours");
    $cache_instance = $cache->getItem('tours');
    if(is_null($cache_instance->get())){
        echo "Db";
        $tours = $db->get("src", "price", "title", "region", "discount", "description", "author_id", "visible", "rating");
        $cache_instance->set($tours)->expiresAfter(1000);
        $cache->save($cache_instance);
        return $tours;
    } else{
        echo "Cache";
        return $cache_instance->get();
    }
}

/**
 * @throws PhpfastcacheInvalidArgumentException
 */
function cacheUsers(): array
{
    global $db, $cache;
    $db->use_table("users");
    $cache_instance = $cache->getItem('users');
    if(is_null($cache_instance->get())){
        echo "Db";
        $users = $db->get("src", "price", "title", "region", "discount", "description", "author_id", "visible", "rating");
        $cache_instance->set($users)->expiresAfter(1000);
        $cache->save($cache_instance);
        return $users;
    } else{
        echo "Cache";
        return $cache_instance->get();
    }
}
