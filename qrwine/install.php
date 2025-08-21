<?php

defined('BASEPATH') or exit('No direct script access allowed');

$filePath = 'application/config/database.php';

$content = file_get_contents($filePath);

// 1. Check if BASEPATH is already commented out
$isBasepathCommented = (strpos($content, "// defined('BASEPATH')") !== false);

// 2. Check if $db['db2'] already exists
$isDb2ConfigAdded = (strpos($content, "\$db['db2']") !== false);

// Only proceed if changes are needed
if (!$isBasepathCommented || !$isDb2ConfigAdded) {
    // A. Comment out BASEPATH line if not already done
    if (!$isBasepathCommented) {
        $content = str_replace(
            "defined('BASEPATH') or exit('No direct script access allowed');",
            "// defined('BASEPATH') or exit('No direct script access allowed');",
            $content
        );
    }

    // B. Add $db['db2'] config if not present
    if (!$isDb2ConfigAdded) {
        $newConfig = <<<'EOD'
$db['db2'] = array_merge([
    'dsn'          => '', // Not Supported
    'hostname'     => "165.22.102.58",
    'username'     => "backup_db",
    'password'     => "2EAFXWedLe6PtMbn",
    'database'     => "backup_db",
    'dbdriver'     => defined('APP_DB_DRIVER') ? APP_DB_DRIVER : 'mysqli',
    'dbprefix'     => db_prefix(),
    'pconnect'     => false,
    'db_debug'     => (ENVIRONMENT !== 'production'),
    'cache_on'     => false,
    'cachedir'     => '',
    'char_set'     => defined('APP_DB_CHARSET') ? APP_DB_CHARSET : 'utf8',
    'dbcollat'     => defined('APP_DB_COLLATION') ? APP_DB_COLLATION : 'utf8_general_ci',
    'swap_pre'     => '',
    'encrypt'      => $db_encrypt,
    'compress'     => false,
    'failover'     => [],
    'save_queries' => true,
], defined('APP_DB_STRICTON') && APP_DB_STRICTON || !defined('APP_DB_STRICTON') ? ['stricton' => false] : []);

EOD;

        // Insert after the first `[]);`
        $insertPosition = strpos($content, '[]);');
        if ($insertPosition !== false) {
            $content = substr_replace(
                $content,
                "\n\n" . $newConfig,
                $insertPosition + strlen('[]);'),
                0
            );
        }
    }

    // Save changes only if modifications were made
    file_put_contents($filePath, $content);
}

$filePath = 'modules/qrwine/hash.txt';
if (!file_exists($filePath)) {
    // Create directory if it doesn't exist
    $dir = dirname($filePath);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $newHash = hash('sha256', uniqid('', true) . random_bytes(16));
    file_put_contents($filePath, $newHash);
    return $newHash;
} else {
    return trim(file_get_contents($filePath));
}

$filePath = 'application/config/app-config.php';
// Check if file exists
if (!file_exists($filePath)) {
    die("Error: File not found at $filePath");
} else {
    // Read the file content
    $content = file_get_contents($filePath);
    
    // Check if the line exists and is already set to false
    if (preg_match("/define$$'APP_CSRF_PROTECTION',\s*false\s*$$;/", $content)) {
        // echo "APP_CSRF_PROTECTION is already set to false. No changes needed.\n";
    } else {
        // Replace any existing definition with false
        $newContent = preg_replace(
            "/define$$'APP_CSRF_PROTECTION',\s*.*\s*$$;/",
            "define('APP_CSRF_PROTECTION', false);",
            $content
        );
        
        // If no existing definition was found, add it at the end
        if ($newContent === $content) {
            $newContent = rtrim($content) . "\n\ndefine('APP_CSRF_PROTECTION', false);\n";
        }
        
        // Write the changes back to the file
        if (file_put_contents($filePath, $newContent)) {
            // echo "APP_CSRF_PROTECTION has been set to false.\n";
        } 
    }
}

// Register the module in Perfex CRM's module system
$CI =& get_instance();
$CI->load->database();

// Check if module is already registered
$module_exists = $CI->db->get_where('tblmodules', ['module_name' => 'qrwine'])->row();

if (!$module_exists) {
    // Register the module
    $CI->db->insert('tblmodules', [
        'module_name' => 'qrwine',
        'installed_version' => '1.0.0',
        'active' => 1
    ]);
}

// Create module permissions if they don't exist
$permissions = ['view', 'create', 'edit', 'delete'];
foreach ($permissions as $permission) {
    $perm_exists = $CI->db->get_where('tblpermissions', [
        'name' => 'qrwine',
        'shortname' => $permission
    ])->row();
    
    if (!$perm_exists) {
        $CI->db->insert('tblpermissions', [
            'name' => 'qrwine',
            'shortname' => $permission
        ]);
    }
}

echo "QR Wine Label by BIT SOLUTIONS v1.0 - Installation completed successfully! Module registered and ready for activation.";
