<?

//Include the PHPWord.php, all other classes were loaded by an autoloader
require_once 'PHPWord.php';

//Create a new PHPWord Object
$PHPWord = new PHPWord();

//Create Document Properties
$properties = $PHPWord->getProperties();
$properties->setCreator('Teacher Name');
$properties->setCompany('Narrabundah College');
$properties->setTitles('Unit Outline');
$properties->setDescription('My Description');

//Create Fonts and Templates
$paragraph_Center = array('align'=>'center');
$PHPWord->addParagraphStyle('paragraphStyle_Center', $paragraph_Center);
$font_Upper = array('size'=>14, 'bold'=>true);
$PHPWord->addFontStyle('fontStyle_Upper', $font_Upper);

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
$section_UnitGoals->addText('


?>
