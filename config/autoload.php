<?php

// models
require "models/Admin.php";
require "models/Category.php";
require "models/Prestation.php";
require "models/Role.php";
require "models/User.php";

// managers
require "managers/AbstractManager.php";
require "managers/AdminManager.php";
require "managers/CategoryManager.php";
require "managers/PrestationManager.php";
require "managers/RoleManager.php";
require "managers/UserManager.php";

// controllers
require "controllers/AbstractController.php";
require "controllers/AdminController.php";
require "controllers/AuthController.php";
require "controllers/HomeController.php";
require "controllers/PortfolioController.php";
require "controllers/PrestationsController.php";
require "controllers/UserController.php";

// services
require "services/Router.php";