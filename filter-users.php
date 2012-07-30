<?php
/*
** Template name: json-filter-users
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

$search = $_GET['search'];

$terms = explode(' ', $search);

$fields = array(array('prefix' => 'F', 'name' => 'first_name'), array('prefix' => 'L', 'name' => 'last_name'));

$columns = array();
$joins = array();
$wheres = array();
$matches = array();
foreach($fields as $field) :
$columns[] = $field['prefix'].'.meta_value '.$field['name'];
$joins[] = 'INNER JOIN icps_usermeta '.$field['prefix']
	.' ON (S.user_id = '.$field['prefix'].'.user_id)'; 
$wheres[] = $field['prefix'].'.meta_key = "'.$field['name'].'"';
foreach($terms as $term) :
$matches[] = $field['prefix'].'.meta_value LIKE "%'.$term.'%"';
endforeach;
endforeach;

$head = 'SELECT S.user_id, ';
$from = ' FROM icps_usermeta S ';
$statusjoin = ' INNER JOIN icps_usermeta A'
	.' ON (S.user_id = A.user_id)';
$where = ' WHERE ';
$and = ' AND (';
$tail = ') ';
$statuswhere = ' AND A.meta_key = "application_status" AND A.meta_value > 3';
$group = ' GROUP BY user_id ';

$query = $head . implode(', ', $columns) . $from . implode(' ', $joins) . $statusjoin . $where . implode(' AND ', $wheres) . $and . implode(' OR ', $matches) . $tail . $statuswhere . $group;

$rows = $wpdb->get_results($query, ARRAY_A);

echo json_encode($rows);

