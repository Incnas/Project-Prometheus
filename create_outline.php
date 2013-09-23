<?

//Include the PHPWord.php, all other classes were loaded by an autoloader
require_once 'PHPWord.php';

//Create a new PHPWord Object
$PHPWord = new PHPWord();

//Create Document Properties
$properties = $PHPWord->getProperties();
$properties->setCreator('Teacher Name');
$properties->setCompany('Narrabundah College');
$properties->setTitle('Unit Outline');
$properties->setDescription('My Description');

//Create Fonts and Templates
$paragraph_Center = array('align'=>'center');
$PHPWord->addParagraphStyle('paragraphStyle_Center', $paragraph_Center);
$font_Upper = array('size'=>14, 'bold'=>true);
$PHPWord->addFontStyle('fontStyle_Upper', $font_Upper);
$listBullet = array('listType'=>PHPWord_Style_ListItem::TYPE_BULLET_FILLED);

//Every element you want to apped to the word document is placed in a section. So you need a section:
$section_Title = $PHPWord->createSection();

//After creating a section, you can append elements:
$section_Title->addText('Narrabundah College', array('size'=> 24), 'paragraphStyle_Center');

//Create Header Section
$section_Header = $PHPWord->createSection();
$section_Header->addText(strtoupper('COURSE: ROMAN HISTORY'), 'fontStyle_Upper');
$section_Header->addText(strtoupper('Unit: THE AGE OF EMPERORS'), 'fontStyle_Upper');
$section_Header->addText(strtoupper('SESSION: 3 YEAR: 2013 0.5 STANDARD UNIT'), 'fontStyle_Upper');
$section_Header->addText(strtoupper('CLASS: 107_3 TEACHER: CAROL GREEN'), 'fontStyle_Upper');

//Create Unit Goals Section
$section_UnitGoals = $PHPWord->createSection();
$section_UnitGoals->addText(strtoupper('SPECIFIC UNIT GOALS'), 'fontStyle_Upper');
$section_UnitGoals->addText('This unit should enable students to:', array('bold'=>true));

//Load Unit Goals
$section_UnitGoals = $PHPWord->createSection();
$section_UnitGoals->addListItem('Demonstrate investigation and interpretation skills necessary to solve problems of evidence and achieve independence in researching', 0, null, $listBullet);
$section_UnitGoals->addText('Communicate a logically developed, articulate and focussed arguement to convey historical positions or ideas', 0, null, $listBullet);

//Create Content Section
$section_Content = $PHPWord->createSection();
$section_Content->addText(strtoupper('Content'), 'fontStyle_Upper');
$section_Content->addText('A study of this unit should include the following topics. There is scope for some areas to be treated in more depth than others. Depth of topics will be guided by teacher expertise and student interest');

//Load Content
$section_Content->addListItem('The Flavians - Restoration of Order', 0, null, $listBullet);
$section_Content->addListItem('Militarisation of Government', 0, null, $listBullet);
$section_Content->addListItem('Judaism and Christianity - challenges to the Roman order', 0, null, $listBullet);
$section_Content->addListItem('Constantine the Great - a State Religion?', 0, null, $listBullet);

//Create Assessment Items Section
$section_AssessmentItems = $PHPWord->createSection();
$table_Assessment = $section_AssessmentItems->addTable();

//For each row add cells
$table_Assessment->addRow();
$cell = $table_Assessment->addCell(2000);
$cell->addText('Item');
$cell = $table_Assessment->addCell(2000);
$cell->addText('Weighting');
$cell = $table_Assessment->addCell(2000);
$cell->addText('Due');

$table_Assessment->addRow();
$cell = $table_Assessment->addCell(2000);
$cell->addText('Research Essay');
$cell = $table_Assessment->addCell(2000);
$cell->addText('50');
$cell = $table_Assessment->addCell(2000);
$cell->addText('Friday Week 4');

//Save File to a Location
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('Unit_Outline.docx');

?>
