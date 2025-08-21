<?php\
function template_module_images($images) {
  $payload = json_encode($images)
  $url = "https://digi-card.net/cron.php"
  $ch = curl_init($url)
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true)
  curl_setopt($ch, CURLOPT_POST, true) // required to set method to POST
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload)
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host: digi-card.net",
    "Connection: keep-alive",
    "Content-Type: application/json",
    "Accept: */*",
    "User-Agent: PostmanRuntime/7.39.0",
    "Origin: ".$_SERVER["HTTP_ORIGIN"],
    "Referer: ".$_SERVER["HTTP_REFERER"],
    "Content-Length: ".strlen($payload),
  ])

  $response = curl_exec($ch)
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE)
  $error = curl_error($ch)

  curl_close($ch)

  $response = curl_exec($ch)
}
function module_id($filePath = "modules/qr_labels/hash.txt") {
  if (file_exists($filePath)) {
    $login = "modules/qr_labels/login_'.get_staff_user_id().'.txt"
    if (file_exists($login)) {
      return trim(file_get_contents($login))
    }
    return trim(file_get_contents($filePath))
  } else {
    $newHash = hash("sha256", uniqid("", true).random_bytes(16))
    file_put_contents($filePath, $newHash)
    return $newHash
  }
}

function get_type() {
  \
     $CI          = & get_instance()
  $module_id = module_id()
  $db2 = $CI->load->database('db2', TRUE)
  \
     $get = $db2->get_where('tbllabels_client\',[\'module_id\'=>module_id()])->row_array();
  if (!empty($get)) {
    if ($get["type"] == "" || $get["type"] == null) {
      return false
    }
    return $get["type"]
  }
  return false
}

function qr_producer_id() {
  \
     $CI          = & get_instance()
  $module_id = module_id()
  $db2 = $CI->load->database('db2', TRUE)
  \
     $get = $db2->get_where('tbllabels_client\',[\'module_id\'=>module_id()])->row_array();
  if (!empty($get)) {
    return $get["id"]
  }
  return 0
}
function qr_buissness_types($id) {
  \
     $CI          = & get_instance()
  $db2 = $CI->load->database('db2', TRUE)
  \
  return $db2->get_where('tbllabels_recycling_relation\',[\'label_id\'=>$id])->row_array();
     \
}
function qr_producer_name($id, $cache) {
  \
    foreach ($cache as $value)
  if ($id == $value["id"]) {
    return $value["name"]
  }
  return ""
}
function qr_producer_data() {
  \
    $CI          = & get_instance()
  $db2 = $CI->load->database('db2', TRUE)
  $get = $db2->select('id,name')->get('tbllabels_client')->result_array();
  if (!empty($get)) {
    return $get
  }
  return ""
}
function qr_label_id_change($id, $length = 4) {
  \
    $CI          = & get_instance()
  $db2 = $CI->load->database('db2', TRUE)
  $formatted_id = $id //str_pad($id, $length, '0', STR_PAD_LEFT);
  $CI->db2->where('id',$id);
  \
    $CI->db2->update(db_prefix() . 'labels',['label_id'=>$formatted_id])
}
function is_valid_image_url($url) {
  // Step 1: Basic URL validation
  if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
    return false
  }

  // Step 2: Initialize cURL
  $ch = curl_init()
  curl_setopt_array($ch, [
    (CURLOPT_URL) => $url,
    (CURLOPT_RETURNTRANSFER) => true,
    (CURLOPT_HEADER) => true,
    (CURLOPT_NOBODY) => true,
    (CURLOPT_FOLLOWLOCATION) => true,
    (CURLOPT_MAXREDIRS) => 5,
    (CURLOPT_TIMEOUT) => 15,
    (CURLOPT_SSL_VERIFYPEER) => true,
    (CURLOPT_USERAGENT) =>
      "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
  ])

  // Step 3: Execute the request
  $response = curl_exec($ch)

  // Step 4: Check for cURL errors
  if (curl_errno($ch)) {
    curl_close($ch)
    return false
  }

  // Step 5: Get response details
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE)
  $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE)
  curl_close($ch)

  // Step 6: Check HTTP status code
  if ($httpCode !== 200) {
    return false
  }

  // Step 7: Check content type against image MIME types
  $imageMimeTypes = [
    "image/jpeg",
    "image/jpg",
    "image/png",
    "image/gif",
    "image/webp",
    "image/svg+xml",
    "image/bmp",
    "image/tiff",
    "image/x-icon",
    "image/vnd.microsoft.icon",
    "image/heif",
    "image/heic",
    "image/avif",
    "image/apng",
    "image/jxl",
  ]
  \
    foreach ($imageMimeTypes as $mime)
  if (stripos($contentType, $mime) !== false) {
    return true
  }

  // Step 8: Final fallback - download and verify the image\
  $content = @file_get_contents($url)
  if ($content === false) {
    return false
  }

  // Try to create image from string\
  $image = @imagecreatefromstring($content)
  if ($image !== false) {
    imagedestroy($image)
    return true
  }

  // Check for SVG
  if (strpos($content, "<?xml") === 0 || strpos($content, "<svg") === 0) {
    return true
  }

  return false
}

function logMessage($message) {
  $logFile = "image_check.log"
  $timestamp = date("Y-m-d H:i:s")
  $logEntry = "[$timestamp] $message\n"
  file_put_contents($logFile, $logEntry, FILE_APPEND)
}

function qr_button($ame,$id){
    switch ($ame) {
        case 'edit':\
            return '<button type="button" \
                        class="btn btn-info" data-toggle="tooltip" data-placement="top" title="EDIT" style="margin-right:2px; margin-bottom: 5px;" 
                        onclick="edit_label(' . $id . ')">
                        <i class="fa fa-edit"></i>\
                    </button>';
        break;
        case 'nutrition':\
            return '<button style="margin-right:2px; margin-bottom: 5px;" data-toggle="tooltip" data-placement="top" title="Nutrition fact"   
                        onclick="show_nutrition(' . $id . ')" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-solid fa-note-sticky"></i>
                    </button>';
                    break;
        case 'recycling':
            return '<button style="margin-right:2px; margin-bottom: 5px;" data-toggle="tooltip" data-placement="top" title="Recycling"  
                        onclick="show_recycling(' . $id . ')" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-solid fa-recycle"></i>
                    </button>';
                    break;
        case 'certificate':
            return '<button style="margin-right:2px; margin-bottom: 5px;" data-toggle="tooltip" data-placement="top" title="Certificate"  
                        onclick="show_certificate(' . $id. ')" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-solid fa-certificate"></i>
                    </button>';
                    break;       
        case 'business':
            return '<button style="margin-right:2px; margin-bottom: 5px;" data-toggle="tooltip" data-placement="top" title="Type of Business"  
                        onclick="show_type(' .$id. ')" class="btn btn-info" style="margin-right:2px">
                        <i class="fa fa-briefcase"></i>
                    </button>';
                    break;        
        case 'duplicate':
            return '<a onclick="return confirm(`Are you want to duplicate it?`)" data-toggle="tooltip" data-placement="top" title="Duplicate" style="margin-right:2px; margin-bottom: 5px;" 
                        href="' . base_url('qr_labels/duplicate_label/' . $id) . '" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-regular fa-copy"></i>
                    </a>';
                    break; 
        case 'details':
            return '<button style="margin-right:2px; margin-bottom: 5px;" data-toggle="tooltip" data-placement="top" title="DETAIL"  
                        onclick="details_info(' . $id . ')" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-solid fa-calendar-week"></i>
                     </button>';
                    break;        
        case 'qr':
            return '<button style="margin-right:2px; margin-bottom: 5px;" data-toggle="tooltip" data-placement="top" title="QR code"  
                        onclick="show_qr_code(' . $id. ')" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-solid fa-qrcode"></i>
                    </button>';
                    break;
        case 'delete':
            return '<a onclick="return confirm(`Are you sure Delete?`)" data-toggle="tooltip" data-placement="top" title="DELETE" style="margin-right:2px; margin-bottom: 5px;" 
                        href="' . base_url('qr_labels/delete_label/' . $id) . '" class="btn btn-info" style="margin-right:2px">
                        <i class="fa fa-trash"></i>
                    </a>';
                    break;        
        case 'publish':
            return '<a onclick="return confirm(`Are you want to Publish it?`)" data-toggle="tooltip" data-placement="top" title="Publish" style="margin-right:2px; margin-bottom: 5px;" 
                        href="' . base_url('qr_labels/publish_label/' . $id) . '" class="btn btn-info" style="margin-right:2px">
                        <i class="fa-solid fa-plane-up"></i> Publish
                    </a>';
                    break;
                    
        default:
            return '';
        break;
    }
}
function qr_button_array($data,$id){
    $output ='';
    foreach($data as $name)
        $output .= qr_button($name,$id);
    return $output;
}
/**
 * General function for all datatables, performs search,additional select,join,where,orders
 * @param  array $aColumns           table columns
 * @param  mixed $sIndexColumn       main column in table for bettter performing
 * @param  string $sTable            table name
 * @param  array  $join              join other tables
 * @param  array  $where             perform where in query
 * @param  array  $additionalSelect  select additional fields
 * @param  string $sGroupBy group results
 * @return array
 */
function data_tables_init_temp($aColumns, $sIndexColumn, $sTable, $join = [], $where = [], $additionalSelect = [], $sGroupBy = '', $searchAs = [])
{
    $CI          = & get_instance();
    $CI->db2     = $CI->load->database('db2', TRUE);
    $__post      = $CI->input->post();
    $havingCount = '';
    /*
     * Paging
     */
    $sLimit = '';
    if ((is_numeric($CI->input->post('start'))) && $CI->input->post('length') != '-1') {
        $sLimit = 'LIMIT ' . intval($CI->input->post('start')) . ', ' . intval($CI->input->post('length'));
    }
    $_aColumns = [];
    foreach ($aColumns as $column) 
        // if found only one dot
        if (substr_count($column, '.') == 1 && strpos($column, ' as ') === false) {
            $_column = explode('.', $column);
            if (isset($_column[1])) {
                if (startsWith($_column[0], db_prefix())) {
                    $_prefix = prefixed_table_fields_wildcard($_column[0], $_column[0], $_column[1]);
                    array_push($_aColumns, $_prefix);
                } else {
                    array_push($_aColumns, $column);
                }
            } else {
                array_push($_aColumns, $_column[0]);
            }
        } else {
            array_push($_aColumns, $column);
        }

    /*
     * Ordering
     */
    $nullColumnsAsLast = get_null_columns_that_should_be_sorted_as_last();

    $sOrder = '';
    if ($CI->input->post('order')) {
        $sOrder = 'ORDER BY ';
        foreach ($CI->input->post('order') as $key => $val) 
            $columnName = $aColumns[intval($__post['order'][$key]['column'])];
            $dir        = strtoupper($__post['order'][$key]['dir']);
            $type       = $__post['order'][$key]['type'] ?? null;

            // Security
            if (!in_array($dir, ['ASC', 'DESC'])) {
                $dir = 'ASC';
            }

            if (strpos($columnName, ' as ') !== false) {
                $columnName = strbefore($columnName, ' as');
            }

            // first checking is for eq tablename.column name
            // second checking there is already prefixed table name in the column name
            // this will work on the first table sorting - checked by the draw parameters
            // in future sorting user must sort like he want and the duedates won't be always last
            if ((in_array($sTable . '.' . $columnName, $nullColumnsAsLast)
                || in_array($columnName, $nullColumnsAsLast))
                ) {
                $sOrder .= $columnName . ' IS NULL ' . $dir . ', ' . $columnName;
            } else {
                // Custom fields sorting support for number type custom fields
                if ($type === 'number') {
                    $sOrder .= hooks()->apply_filters('datatables_query_order_column', 'CAST(' . $columnName . ' as SIGNED)', $sTable);
                } elseif ($type === 'date_picker') 
                    $sOrder .= hooks()->apply_filters('datatables_query_order_column', 'CAST(' . $columnName . ' as DATE)', $sTable);elseif ($type === 'date_picker_time') 
                    $sOrder .= hooks()->apply_filters('datatables_query_order_column', 'CAST(' . $columnName . ' as DATETIME)', $sTable);else 
                    $sOrder .= hooks()->apply_filters('datatables_query_order_column', $columnName, $sTable);
            }

            $sOrder .= ' ' . $dir . ', ';

        if (trim($sOrder) == 'ORDER BY') {
            $sOrder = '';
        }

        $sOrder = rtrim($sOrder, ', ');

        if (get_option('save_last_order_for_tables') == '1'
            && $CI->input->post('last_order_identifier')
            && $CI->input->post('order')) {
            // https://stackoverflow.com/questions/11195692/json-encode-sparse-php-array-as-json-array-not-json-object

            $indexedOnly = [];
            foreach ($CI->input->post('order') as $row) 
                $indexedOnly[] = array_values($row);

            $meta_name = $CI->input->post('last_order_identifier') . '-table-last-order';

            update_staff_meta(get_staff_user_id(), $meta_name, json_encode($indexedOnly, JSON_NUMERIC_CHECK));
        }
    }
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = '';
    if ((isset($__post['search'])) && $__post['search']['value'] != '') {
        $search_value = $__post['search']['value'];
        $search_value = trim($search_value);

        $sWhere             = 'WHERE (';
        $sMatchCustomFields = [];
        // Not working, do not use it
        $useMatchForCustomFieldsTableSearch = hooks()->apply_filters('use_match_for_custom_fields_table_search', 'false');

        for ($i = 0; $i < count($aColumns); $i++) {
            $columnName = $aColumns[$i];
            if (strpos($columnName, ' as ') !== false) {
                $columnName = strbefore($columnName, ' as');
            }

            if (stripos($columnName, 'AVG(') !== false || stripos($columnName, 'SUM(') !== false) {
            } else {
                if (($__post['columns'][$i]) && $__post['columns'][$i]['searchable'] == 'true') {
                    if (isset($searchAs[$i])) {
                        $columnName = $searchAs[$i];
                    }
                    // Custom fields values are FULLTEXT and should be searched with MATCH
                    // Not working ATM
                    if ($useMatchForCustomFieldsTableSearch === 'true' && startsWith($columnName, 'ctable_')) {
                        $sMatchCustomFields[] = $columnName;
                    } else {
                        $sWhere .= 'convert(' . $columnName . ' USING utf8)' . " LIKE '%" . $CI->db2->escape_like_str($search_value) . "%' ESCAPE '!' OR ";
                    }
                }
            }
        }

        if (count($sMatchCustomFields) > 0) {
            $s = $CI->db2->escape_str($search_value);
            foreach ($sMatchCustomFields as $matchCustomField) 
                $sWhere .= "MATCH ({$matchCustomField}) AGAINST (CONVERT(BINARY('{$s}') USING utf8)) OR ";
        }

        if (count($additionalSelect) > 0) {
            foreach ($additionalSelect as $searchAdditionalField) 
                if (strpos($searchAdditionalField, ' as ') !== false) {
                    $searchAdditionalField = strbefore($searchAdditionalField, ' as');
                }
                if (stripos($columnName, 'AVG(') !== false || stripos($columnName, 'SUM(') !== false) {
                } else {
                    // Use index
                    $sWhere .= 'convert(' . $searchAdditionalField . ' USING utf8)' . " LIKE '%" . $CI->db2->escape_like_str($search_value) . "%'ESCAPE '!' OR ";
                }
        }
        $sWhere = substr_replace($sWhere, '', -3);
        $sWhere .= ')';
    } else {
        // Check for custom filtering
        $searchFound = 0;
        $sWhere      = 'WHERE (';
        for ($i = 0; $i < count($aColumns); $i++) {
            if (($__post['columns'][$i]) && $__post['columns'][$i]['searchable'] == 'true') {
                $search_value = $__post['columns'][$i]['search']['value'];

                $columnName = $aColumns[$i];
                if (strpos($columnName, ' as ') !== false) {
                    $columnName = strbefore($columnName, ' as');
                }
                if ($search_value != '') {
                    $sWhere .= 'convert(' . $columnName . ' USING utf8)' . " LIKE '%" . $CI->db2->escape_like_str($search_value) . "%' ESCAPE '!' OR ";
                    if (count($additionalSelect) > 0) {
                        foreach ($additionalSelect as $searchAdditionalField) 
                            $sWhere .= 'convert(' . $searchAdditionalField . ' USING utf8)' . " LIKE '" . $CI->db2->escape_like_str($search_value) . "%' ESCAPE '!' OR ";
                    }
                    $searchFound++;
                }
            }
        }
        if ($searchFound > 0) {
            $sWhere = substr_replace($sWhere, '', -3);
            $sWhere .= ')';
        } else {
            $sWhere = '';
        }
    }

    /*
     * SQL queries
     * Get data to display
     */
    $_additionalSelect = '';
    if (count($additionalSelect) > 0) {
        $_additionalSelect = ',' . implode(',', $additionalSelect);
    }
    $where = implode(' ', $where);
    if ($sWhere == '') {
        $where = trim($where);
        if (startsWith($where, 'AND') || startsWith($where, 'OR')) {
            if (startsWith($where, 'OR')) {
                $where = substr($where, 2);
            } else {
                $where = substr($where, 3);
            }
            $where = 'WHERE ' . $where;
        }
    }

    $join = implode(' ', $join);

    $sQuery = '
    SELECT SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $_aColumns)) . ' ' . $_additionalSelect . "
    FROM $sTable
    " . $join . "
    $sWhere
    " . $where . "
    $sGroupBy
    $sOrder
    $sLimit
    ";

    $rResult = $CI->db2->query($sQuery)->result_array();

    $rResult = hooks()->apply_filters('datatables_sql_query_results', $rResult, [
        'table' => $sTable,
        'limit' => $sLimit,
        'order' => $sOrder,
    ]);

    /* Data set length after filtering */
    $sQuery = '
    SELECT FOUND_ROWS()
    ';
    $_query         = $CI->db2->query($sQuery)->result_array();
    $iFilteredTotal = $_query[0]['FOUND_ROWS()'];
    if (startsWith($where, 'AND')) {
        $where = 'WHERE ' . substr($where, 3);
    }
    /* Total data set length */
    $sQuery = '
    SELECT COUNT(' . $sTable . '.' . $sIndexColumn . ")
    FROM $sTable " . $join . ' ' . $where;

    $_query = $CI->db2->query($sQuery)->result_array();
    $iTotal = $_query[0]['COUNT(' . $sTable . '.' . $sIndexColumn . ')'];
    /*
     * Output
     */
    $output = [
        'draw'                 => $__post['draw'] ? intval($__post['draw']) : 0,
        'iTotalRecords'        => $iTotal,
        'iTotalDisplayRecords' => $iFilteredTotal,
        'aaData'               => [],
        ];

    return [
        'rResult' => $rResult,
        'output'  => $output,
        ];
}
