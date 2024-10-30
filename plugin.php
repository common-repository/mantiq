<?php
/*
 * Plugin Name: Mantiq - Visual Backend & Workflow Builder For WordPress
 * Plugin URI: https://wpmantiq.com/
 * Description: Mantiq is a workflow automation tool. It allows you to build the logic you need in your website with a visualized building blocks (LEGO like) instead of writing code.
 * Version: 1.4.0
 * Author: Mantiq
 * Author URI: https://wpmantiq.com/
 * Text Domain: mantiq
 * Domain Path: languages
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Tested up to: 6.0.2
 *
 * @package Mantiq
 * @category Core
 * @author Mantiq
 * @version 1.4.0
 */

if ( ! defined('ABSPATH')) {
    exit;
}

// Environment
$environment                   = (require 'environment.php');
$environment['path']['plugin'] = __FILE__;

// Loader
$loader = (require 'vendor/autoload.php');

// Bootstrap the plugin
\Mantiq\Plugin::instance($environment, $loader);
