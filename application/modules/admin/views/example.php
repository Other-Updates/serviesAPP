<?php
   // include the class

// creates an object instance of the class, and read the excel file data
$excel = new PhpExcelReader;
$excel->read('files/test.xls');

// Excel file data is stored in $sheets property, an Array of worksheets
/*
The data is stored in 'cells' and the meta-data is stored in an array called 'cellsInfo'

Example (firt_sheet - index 0, second_sheet - index 1, ...):

$sheets[0]  -->  'cells'  -->  row --> column --> Interpreted value
         -->  'cellsInfo' --> row --> column --> 'type' (Can be 'date', 'number', or 'unknown')
                                            --> 'raw' (The raw data that Excel stores for that data cell)
*/

// this function creates and returns a HTML table with excel rows and columns data
// Parameter - array with excel worksheet data
function sheetData($sheet) {
  $table = '<table border="1" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">';     // starts html table
	
	if(isset($sheet['cells']) && !empty($sheet['cells']))
	{
		$i=1;
		
		foreach($sheet['cells'] as $val)
		{
			if($i==1)
			{
				$table=$table."<thead><tr>";
				foreach($val as $text)
				{
					$table=$table."<td>".$text."</td>";	
				}
				$table=$table."</tr></thead>";
			}
			else
			{
				$table=$table."<tbody><tr>";
				foreach($val as $key=>$text)
				{
					if($key!=1 && $key!=2)
						$table=$table."<td><input type='text' class='form-control' style='width:100px;' value='".$text."'/></td>";
					else
						$table=$table."<td><input type='text'class='form-control' readonly value='".$text."'/></td>";
				}
				$table=$table."</tr></tbody>";
			}
			$i++;
			
		}
		
	}
	else
	{
		echo "File Upload Error.......";
	}
	$table=$table."</table>";
  return $table;     // ends and returns the html table
}

$nr_sheets = count($excel->sheets);       // gets the number of sheets
$excel_data = '';              // to store the the html tables with data of each sheet

// traverses the number of sheets and sets html table with each sheet data in $excel_data
for($i=0; $i<$nr_sheets; $i++) {
  $excel_data .= '<h4>Uploaded Sales Order</h4>'. sheetData($excel->sheets[$i]) .'<br/>';  
}
?>

<div class="mainpanel">

<div class="contentpanel">
<?php
// displays tables with excel file data
echo $excel_data;
?>    
</div>
</div>