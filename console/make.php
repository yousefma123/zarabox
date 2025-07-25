<?php

    $controllerName = $argv[2] ?? null;
    if (!$controllerName) {
        echo "❌ Please provide a controller name (e.g., Admin/UserController)\n";
        exit;
    }
    $baseDir    = dirname(__DIR__) . '/App/Controllers';
    $controllerName     = str_replace('\\', '/', $controllerName); 
    $controllerParts    = explode('/', $controllerName);
    $className  = array_pop($controllerParts); 
    $subPath    = implode('/', $controllerParts); 

    $controllerDir = $baseDir . ($subPath ? "/$subPath" : '');

    $controllerPath = "$controllerDir/{$className}.php";

    $namespace = 'App\\Controllers' . ($subPath ? '\\' . str_replace('/', '\\', $subPath) : '');

    if (!is_dir($controllerDir)) {
        mkdir($controllerDir, 0777, true);
    }

    if (file_exists($controllerPath)) {
        echo "⚠️  Controller already exists at $controllerPath\n";
        exit;
    }

    $template = <<<PHP
    <?php

    namespace $namespace;

    use App\Database\Connection;
    use App\Helpers\Alert;

    class $className
    {
        protected \$conn;
        protected \$alert;

        public function __construct()
        {
            \$this->conn  = (new Connection())->DB;
            \$this->alert = new Alert();
        }

        public function index()
        {
            //
        }

        public function create()
        {
            //
        }

        public function delete()
        {
            //
        }

        public function update()
        {
            //
        }
    }
    PHP;

    file_put_contents($controllerPath, $template);
    echo "✅ Controller created: $controllerPath\n";
