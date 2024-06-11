<?php
require 'src/ConfigService.php';
require 'src/AuthModule.php';
require 'src/TwoFactorModule.php';
require 'src/PasswordStrengthModule.php';
require 'src/SigninModule.php';
require 'src/RegistrationModule.php';
require 'src/AuthService.php';

// Define the path to the configuration file
$configFilePath = __DIR__ . '/config/config.json';

// Load configuration
$configService = new ConfigService($configFilePath);

// Initialize authentication service
$authService = new AuthService($configService);

// Simulate user login
$userCredentials = ["username" => "user1", "password" => "password123"];
$authService->authenticate($userCredentials);
?>
