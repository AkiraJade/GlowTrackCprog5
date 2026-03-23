<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Finding JavaScript/JSON Data in Database ===" . PHP_EOL;

try {
    // Get all table names
    $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
    
    echo "📊 Scanning " . count($tables) . " tables for JS/JSON data..." . PHP_EOL;
    
    $suspiciousData = [];
    $totalRows = 0;
    $tablesScanned = 0;
    
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        $tablesScanned++;
        
        echo PHP_EOL . "🔍 Scanning table: {$tableName}" . PHP_EOL;
        
        try {
            // Get table structure
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);
            
            foreach ($columns as $column) {
                // Skip if column doesn't exist
                if (!\Illuminate\Support\Facades\Schema::hasColumn($tableName, $column)) {
                    continue;
                }
                
                // Query for potential JS/JSON content
                $query = "SELECT COUNT(*) as count FROM `{$tableName}` WHERE `{$column}` LIKE '%<script%' OR `{$column}` LIKE '%javascript:%' OR `{$column}` LIKE '%{%' OR `{$column}` LIKE '%[\"%' OR `{$column}` LIKE '%function%' OR `{$column}` LIKE '%alert(%' OR `{$column}` LIKE '%eval(%'";
                
                try {
                    $result = \Illuminate\Support\Facades\DB::select($query);
                    $count = $result[0]->count ?? 0;
                    
                    if ($count > 0) {
                        echo "  ⚠️  Found {$count} suspicious rows in column: {$column}" . PHP_EOL;
                        
                        // Get sample data
                        $sampleQuery = "SELECT `{$column}` FROM `{$tableName}` WHERE `{$column}` LIKE '%<script%' OR `{$column}` LIKE '%javascript:%' OR `{$column}` LIKE '%{%' OR `{$column}` LIKE '%[\"%' LIMIT 5";
                        $samples = \Illuminate\Support\Facades\DB::select($sampleQuery);
                        
                        foreach ($samples as $sample) {
                            $data = array_values((array)$sample)[0];
                            $suspiciousData[] = [
                                'table' => $tableName,
                                'column' => $column,
                                'data' => substr($data, 0, 200) . (strlen($data) > 200 ? '...' : ''),
                                'full_length' => strlen($data)
                            ];
                        }
                    }
                    
                    $totalRows += $count;
                } catch (Exception $e) {
                    // Skip if query fails (column might not support LIKE)
                    continue;
                }
            }
            
            // Also check for common JSON fields that might contain JS
            $commonJsonFields = ['data', 'settings', 'config', 'meta', 'options', 'attributes', 'properties', 'extra'];
            
            foreach ($commonJsonFields as $field) {
                if (in_array($field, $columns)) {
                    $jsonQuery = "SELECT COUNT(*) as count FROM `{$tableName}` WHERE `{$field}` LIKE '%function%' OR `{$field}` LIKE '%eval(%' OR `{$field}` LIKE '%alert(%'";
                    
                    try {
                        $jsonResult = \Illuminate\Support\Facades\DB::select($jsonQuery);
                        $jsonCount = $jsonResult[0]->count ?? 0;
                        
                        if ($jsonCount > 0) {
                            echo "  ⚠️  Found {$jsonCount} suspicious JSON entries in column: {$field}" . PHP_EOL;
                            
                            $jsonSampleQuery = "SELECT `{$field}` FROM `{$tableName}` WHERE `{$field}` LIKE '%function%' OR `{$field}` LIKE '%eval(%' LIMIT 3";
                            $jsonSamples = \Illuminate\Support\Facades\DB::select($jsonSampleQuery);
                            
                            foreach ($jsonSamples as $sample) {
                                $data = array_values((array)$sample)[0];
                                $suspiciousData[] = [
                                    'table' => $tableName,
                                    'column' => $field,
                                    'data' => substr($data, 0, 200) . (strlen($data) > 200 ? '...' : ''),
                                    'full_length' => strlen($data),
                                    'type' => 'JSON Field'
                                ];
                            }
                        }
                        
                        $totalRows += $jsonCount;
                    } catch (Exception $e) {
                        continue;
                    }
                }
            }
            
        } catch (Exception $e) {
            echo "  ❌ Error scanning table {$tableName}: " . $e->getMessage() . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "=== Scan Results ===" . PHP_EOL;
    echo "📊 Tables scanned: {$tablesScanned}" . PHP_EOL;
    echo "⚠️  Suspicious rows found: {$totalRows}" . PHP_EOL;
    echo "📋 Suspicious entries collected: " . count($suspiciousData) . PHP_EOL;
    
    if (count($suspiciousData) > 0) {
        echo PHP_EOL . "=== Suspicious Data Found ===" . PHP_EOL;
        
        foreach ($suspiciousData as $index => $item) {
            echo PHP_EOL . "🔍 Entry #" . ($index + 1) . PHP_EOL;
            echo "  Table: {$item['table']}" . PHP_EOL;
            echo "  Column: {$item['column']}" . PHP_EOL;
            echo "  Type: " . ($item['type'] ?? 'Text') . PHP_EOL;
            echo "  Length: {$item['full_length']} characters" . PHP_EOL;
            echo "  Sample: " . $item['data'] . PHP_EOL;
            echo "  ---" . PHP_EOL;
        }
        
        // Save detailed report
        $reportPath = storage_path('app/js_json_scan_report.json');
        file_put_contents($reportPath, json_encode([
            'scan_timestamp' => now()->toISOString(),
            'tables_scanned' => $tablesScanned,
            'suspicious_rows_total' => $totalRows,
            'suspicious_entries' => $suspiciousData,
            'summary' => [
                'has_suspicious_data' => true,
                'total_suspicious_entries' => count($suspiciousData),
                'affected_tables' => array_unique(array_column($suspiciousData, 'table')),
                'affected_columns' => array_unique(array_column($suspiciousData, 'column')),
            ]
        ], JSON_PRETTY_PRINT));
        
        echo PHP_EOL . "📄 Detailed report saved to: {$reportPath}" . PHP_EOL;
        
        echo PHP_EOL . "=== Recommendations ===" . PHP_EOL;
        echo "🔧 Review all suspicious entries" . PHP_EOL;
        echo "🗑️  Remove JavaScript/JSON injection attempts" . PHP_EOL;
        echo "🔄 Update with clean data" . PHP_EOL;
        echo "🛡️  Implement input sanitization" . PHP_EOL;
        
    } else {
        echo PHP_EOL . "✅ No suspicious JavaScript/JSON data found in database!" . PHP_EOL;
        echo "🎉 Database appears clean!" . PHP_EOL;
    }
    
    echo PHP_EOL . "=== Common Issues to Check ===" . PHP_EOL;
    echo "📝 User input fields with JS" . PHP_EOL;
    echo "🔧 Settings/config fields" . PHP_EOL;
    echo "📋 JSON columns with eval()" . PHP_EOL;
    echo "⚡ Meta/attributes fields" . PHP_EOL;
    echo "📄 Content fields with <script>" . PHP_EOL;

} catch (Exception $e) {
    echo "❌ Scan failed: " . $e->getMessage() . PHP_EOL;
    echo "Stack trace: " . $e->getTraceAsString() . PHP_EOL;
}
