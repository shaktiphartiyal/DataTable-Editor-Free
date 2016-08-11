<?php
mysql_connect("localhost", "root", "password") or die('Connection Error');
mysql_select_db("test") or die("Database Connection Error");

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$row=$_REQUEST['row'];
	$col=$_REQUEST['col'];
	$val=mysql_real_escape_string($_REQUEST['val']);
	$sql="UPDATE test SET $col='$val' WHERE id='$row';";
	$res = mysql_query($sql);
	echo $res;
}
else
{
	$start 	= $_REQUEST['iDisplayStart'];
	$length = $_REQUEST['iDisplayLength'];
	$sSearch = $_REQUEST['sSearch'];

	$col = $_REQUEST['iSortCol_0'];

	$arr = array(0 => 'id',1 => 'name', 2 => 'email');

	$sort_by = $arr[$col];
	$sort_type = $_REQUEST['sSortDir_0'];
		
	$qry = "select * from test where name LIKE '%".$sSearch."%' or email LIKE '%".$sSearch."%' ORDER BY ".$sort_by." ".$sort_type." LIMIT ".$start.", ".$length;
	$res = mysql_query($qry);
	while($row = mysql_fetch_assoc($res))
	{
		$data[] = $row;
	}

	$qry = "select count(id) as count from test";
	$res = mysql_query($qry);

	while($row =  mysql_fetch_assoc($res))
	{
		$iTotal = $row['count'];
	}

	$rec = array(
		'iTotalRecords' => $iTotal,
		'iTotalDisplayRecords' => $iTotal,
		'aaData' => array()
	);

	$k=0;
	if (isset($data) && is_array($data)) {

		foreach ($data as $item) {
			$rec['aaData'][$k] = array(
				'0' => $item['id'],
				'1' => '<span class="editors"><input for-field="name" for-row="'.$item['id'].'" class="form-control editable" type="text" id="name-'.$k.'" value="'.$item['name'].'"/></span><span class="originals">'.$item['name'].'</span>',
				'2' => '<span class="editors"><input for-field="email" for-row="'.$item['id'].'" class="form-control editable" type="email" id="email-'.$k.'" value="'.$item['email'].'"/></span><span class="originals">'.$item['email'].'</span>',
			);
			$k++;
		}
	}

	echo json_encode($rec);
}
?>