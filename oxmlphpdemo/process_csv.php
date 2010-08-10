<?php

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';

$amountColumn = 'B'; // The is just the arbtary column which contains the transaction amounts in the csv file 

if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
 
  // redirect output to client browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="myfile.xlsx"');
header('Cache-Control: max-age=0');





//We nead to know what is used to delimit the csv file 
$selected_radio = $_POST['delimiter'];

switch ($selected_radio)
{
case 'comma':
  $delimiter = ',';
  break;  
case semicolon:
 $delimiter = ';';
  break;
  case pipe:
 $delimiter = '|';
  break;
  case tab:
 $delimiter = chr(9);
  break;
default:
// you shouldn't be able to get here, but as a default set the delimiter as a comma ','
$delimiter = ',';
}



//-----Create reader and reading file uploaded by user-----
//This section and the headers ,above and the final two lines are the core of what you need to just take a csv file and convert it to a open xml spread sheet
//The rest is just to make it look snazzy

$objReader = PHPExcel_IOFactory::createReader('CSV');

$objReader->setDelimiter($delimiter); 
$objReader->setEnclosure('');
$objReader->setLineEnding("\r\n");
$objReader->setSheetIndex(0);
$objPHPExcel = $objReader->load($_FILES["file"]["tmp_name"]); //file is uploaded into the temp dir, It will be recycled when the script ends

//Set Metadata

$objPHPExcel->getProperties()->setCreator("Professor X");
$objPHPExcel->getProperties()->setLastModifiedBy("Professor X");
$objPHPExcel->getProperties()->setTitle("Monthly Account Transactions");
$objPHPExcel->getProperties()->setSubject("Monthly Account Transactions");
$objPHPExcel->getProperties()->setDescription("Summary of account activity of the previous month.");
$objPHPExcel->getProperties()->setKeywords("money account spendings");
$objPHPExcel->getProperties()->setCategory("Finance");



//-----Formatting-----//

//Set Print properties
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('Summary of Transactions for the Month'); //Set print header
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //Set printing orentation



//Put an auto filter on the data
$objPHPExcel->getActiveSheet()->setAutoFilter('A1:' . $objPHPExcel->getActiveSheet()->getHighestColumn() . $objPHPExcel->getActiveSheet()->getHighestRow() );


//set the width of the columns

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);//We will put a title in this colunm, so setting the width explicitly

$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn(); //e.g., 'G'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //e.g., 6

for($column =1; $column < $highestColumnIndex; $column++) //start from 1 as columns are 0 indexed, but we dont want to change the first row which we have already set explicitly
{
$objPHPExcel->getActiveSheet()->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column))->setAutoSize(true);
}


//-----Put in some formatting to the table data to make it easer to read-----

$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();
$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
$objPHPExcel->getActiveSheet()->insertNewRowBefore($highestRow + 1, 1);//Add one more row as a footer to the table

//set heading row to bold and put a border on the top and bottom rows
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A' . ($highestRow + 1) )->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//Loop through all of the rows and put in fill and borders on the edges
for($row =1; $row<$highestRow + 2; $row++)
{
//Set the colors, mid blue/grey for the top and bottom rows, with alternating white and light blue/grey
if ($row == 1 || $row ==$highestRow + 1) $color = 'FFCFDAE7'; 
else if ($row%2==0) $color = 'FFFFFFFF';
else $color = 'FFE7EDF5';

 // set the fill type and apply the color
$objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A' . $row)->getFill()->getStartColor()->setARGB($color);

//duplcate the forst cells style (fill plus the top and bottom borders) across the whole row
$objPHPExcel->getActiveSheet()->duplicateStyle( $objPHPExcel->getActiveSheet()->getStyle('A' . $row), 'B' . $row . ':'. $highestColumn . $row); //copy style set in first column to the rest of the row

//Put som borders on the far left and right cells of the row
$objPHPExcel->getActiveSheet()->getStyle('A' . $row )->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('G' . $row )->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
}


//-----Put in a formula, which calculates the Balance of the transactions for the month and set conditional color-----
$highestRow = $objPHPExcel->getActiveSheet()->getHighestRow(); 

$rowToInsert = ($highestRow + 3); 
$columnToInsert = PHPExcel_Cell::columnIndexFromString($amountColumn) -1;
$formula = '=SUM(' . $amountColumn . '2:' . $amountColumn . ($highestRow - 1) .')'; 
 // i.e., if $amountColumn was 'B' and $highestRow was 31 last $formula would be =SUM(B2:B30) which would give the sum of all of the transaction values (in column 'B')

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnToInsert, $rowToInsert, $formula);
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnToInsert, $rowToInsert)->getFont()->setBold(true);

$columnToInsert= $columnToInsert -1 ; //Show what the formula works out, to the left hence: $columnToInsert -1
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowToInsert, 'Balance: '); 
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columnToInsert, $rowToInsert)->getFont()->setBold(true);

//Set colour of the calculated value to red, if values are a negative number

//Setup conditionals
$objConditional1 = new PHPExcel_Style_Conditional();
$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS);
$objConditional1->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN);
$objConditional1->addCondition('0');
$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
$objConditional1->getStyle()->getFont()->setBold(true);

$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle($amountColumn . $rowToInsert)->getConditionalStyles();
array_push($conditionalStyles, $objConditional1);
$objPHPExcel->getActiveSheet()->getStyle($amountColumn . $rowToInsert)->setConditionalStyles($conditionalStyles);
	

//-----Put in a Title-----
$objPHPExcel->getActiveSheet()->insertNewRowBefore(1, 2);//Some empty rows for space
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Transactions for the Month');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18); 


//-----Create a Writer and output the file to the browser-----
$objWriter2007 = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter2007->save('php://output'); 

}

?>