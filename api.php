<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

try {
    require_once __DIR__ . '/config.php';
    $hostSetting = getenv('SS_CARS_DB_HOST') ?: DB_HOST;
    [$host, $port] = array_pad(explode(':', $hostSetting, 2), 2, '3306');
    $database = getenv('SS_CARS_DB_NAME') ?: DB_NAME;
    $username = getenv('SS_CARS_DB_USER') ?: DB_USER;
    $password = getenv('SS_CARS_DB_PASS') ?: DB_PASSWORD;
    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    $resource = $_GET['resource'] ?? '';
    if ($resource === 'categories') {
        $rows = $pdo->query("SELECT category_name AS name FROM ss_mst_category WHERE category_status = 'Active' AND category_name IS NOT NULL ORDER BY category_name")->fetchAll();
        respond($rows);
    }

    if ($resource === 'brands') {
        $rows = $pdo->query("SELECT TRIM(SUBSTRING_INDEX(car_name, ' ', 1)) AS name, COUNT(*) AS car_count FROM ss_mst_car WHERE status = 'Active' AND car_name IS NOT NULL AND car_name <> '' GROUP BY name ORDER BY name")->fetchAll();
        respond($rows);
    }

    if ($resource === 'cars') {
        $conditions = ["c.status = 'Active'"];
        $params = [];
        if (!empty($_GET['query'])) {
            $conditions[] = '(c.car_name LIKE :name_query OR c.features LIKE :feature_query)';
            $searchTerm = '%' . trim($_GET['query']) . '%';
            $params['name_query'] = $searchTerm;
            $params['feature_query'] = $searchTerm;
        }
        if (!empty($_GET['brand'])) {
            $conditions[] = "TRIM(SUBSTRING_INDEX(c.car_name, ' ', 1)) = :brand";
            $params['brand'] = trim($_GET['brand']);
        }
        if (!empty($_GET['category'])) {
            $conditions[] = 'category.category_name = :category';
            $params['category'] = trim($_GET['category']);
        }
        if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
            $conditions[] = 'c.price <= :max_price';
            $params['max_price'] = (float) $_GET['max_price'];
        }
        $sql = "SELECT c.car_id AS id, c.car_name AS name, c.year, c.price, c.features, c.mieleage AS mileage, model.model_name AS model, category.category_name AS category, TRIM(SUBSTRING_INDEX(c.car_name, ' ', 1)) AS brand
            FROM ss_mst_car c
            LEFT JOIN ss_mst_models model ON model.model_id = c.model_id
            LEFT JOIN ss_mst_category category ON category.category_id = model.category_id
            WHERE " . implode(' AND ', $conditions) . ' ORDER BY c.car_name';
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        respond($statement->fetchAll());
    }

    if ($resource === 'services') {
        $statement = $pdo->query("SELECT service.service_id AS id, service.service_date, service.service_type, service.service_cost, service.feedback, car.car_name, customer.customer_name
            FROM ss_rpt_service service
            LEFT JOIN ss_mst_car car ON car.car_id = service.car_id
            LEFT JOIN ss_trn_customer customer ON customer.customer_id = service.customer_id
            ORDER BY service.service_date DESC, service.service_id DESC LIMIT 100");
        respond($statement->fetchAll());
    }

    respond(['error' => 'Unknown resource.'], 404);
} catch (Throwable $error) {
    error_log('SS Cars API: ' . $error->getMessage());
    respond(['error' => 'Unable to load data. Check the MySQL connection and database schema.'], 500);
}