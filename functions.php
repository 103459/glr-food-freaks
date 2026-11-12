<?php
$difficultyOptions = ['Easy Peasy', 'Gemiddeld', 'Chef-ish'];

function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function current_url()
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function form_value($fieldName, $default = '')
{
    global $old;
    return (string) ($old[$fieldName] ?? $default);
}

function melding($type, $message)
{
    $_SESSION['melding'] = ['type' => $type, 'message' => $message];
}

function terug_met_fout($message, $location)
{
    $oldValues = $_POST;
    unset($oldValues['password'], $oldValues['csrf']);
    $_SESSION['old'] = $oldValues;
    melding('error', $message);
    header('Location: ' . $location);
    exit;
}

function csrf_token()
{
    if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function check_csrf()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals(csrf_token(), (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Ongeldige aanvraag. Vernieuw de pagina en probeer opnieuw.');
    }
}

function current_user($conn)
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    $stmt = $conn->prepare('SELECT id, username, email, role, is_active FROM users WHERE id = :id');
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();
    if (!$user || $user['is_active'] == 0) {
        unset($_SESSION['user_id']);
        return null;
    }
    return $user;
}

function is_owner_or_admin($recipe, $user)
{
    if ($user === null) {
        return false;
    }
    return $user['role'] === 'admin' || (int) $recipe['user_id'] === (int) $user['id'];
}

function recipe_by_id($conn, $id)
{
    $stmt = $conn->prepare(
        "SELECT r.*, c.name AS category_name, COALESCE(u.username, 'GLR Food Freaks') AS author_name
         FROM recipes r
         JOIN categories c ON c.id = r.category_id
         LEFT JOIN users u ON u.id = r.user_id
         WHERE r.id = :id"
    );
    $stmt->execute([':id' => $id]);
    $recipe = $stmt->fetch();
    return $recipe ?: null;
}

function ingredient_lines($conn, $recipeId)
{
    $stmt = $conn->prepare('SELECT ingredient_line FROM recipe_ingredients WHERE recipe_id = :id ORDER BY position');
    $stmt->execute([':id' => $recipeId]);
    $lines = [];
    foreach ($stmt->fetchAll() as $row) {
        $lines[] = $row['ingredient_line'];
    }
    return $lines;
}

function list_recipes($conn, $search = '', $categoryId = 0, $limit = 40)
{
    $query = "SELECT r.*, c.name AS category_name, COALESCE(u.username, 'GLR Food Freaks') AS author_name
              FROM recipes r
              JOIN categories c ON c.id = r.category_id
              LEFT JOIN users u ON u.id = r.user_id
              WHERE 1 = 1";
    $values = [];

    if ($search !== '') {
        $query .= ' AND (r.title LIKE :search1 OR r.summary LIKE :search2
                    OR r.id IN (SELECT recipe_id FROM recipe_ingredients WHERE ingredient_line LIKE :search3))';
        $values[':search1'] = '%' . $search . '%';
        $values[':search2'] = '%' . $search . '%';
        $values[':search3'] = '%' . $search . '%';
    }
    if ($categoryId > 0) {
        $query .= ' AND r.category_id = :category';
        $values[':category'] = $categoryId;
    }

    $query .= ' ORDER BY r.created_at DESC, r.id DESC LIMIT ' . (int) $limit;
    $stmt = $conn->prepare($query);
    $stmt->execute($values);
    return $stmt->fetchAll();
}

function all_categories($conn)
{
    return $conn->query('SELECT * FROM categories ORDER BY id')->fetchAll();
}

function category_overview($conn)
{
    return $conn->query(
        'SELECT c.id, c.name, COUNT(r.id) AS recipe_count
         FROM categories c
         LEFT JOIN recipes r ON r.category_id = c.id
         GROUP BY c.id, c.name
         ORDER BY c.id'
    )->fetchAll();
}

function text_lines($text)
{
    $lines = [];
    foreach (explode("\n", $text) as $line) {
        $line = trim($line);
        if ($line !== '') {
            $lines[] = $line;
        }
    }
    return $lines;
}

function delete_uploaded_image($imagePath)
{
    if (str_starts_with($imagePath, 'uploads/') && is_file(__DIR__ . '/' . $imagePath)) {
        unlink(__DIR__ . '/' . $imagePath);
    }
}
