function safe_add(combo,text,value)
{
    try {
        combo.add(new Option(text,value),null);
    } catch (ex) {
        combo.add(new Option(text,value)); // I.E. sux
    }
}

var faculties = new Array (<?php
$faculties = ClassTablePeer::getFaculties();
$size = count($faculties)-1;
    foreach ($faculties as $key=>$f)
    {
	echo "\"".$f."\"";
	if ($key<$size) echo ",";
    }
?>
);
var professions = new Array ();
<?php
   foreach ($faculties as $f)
   {
// 	$f = $faculty->getFaculty();
	echo "professions[\"".$f."\"]=new Array();";
	$c = new Criteria();
	$c->add(ClassTablePeer::FACULTY,$f);
	$professions = ClassTablePeer::doSelect($c);
	$profs = '';
	foreach ($professions as $profession)
	{
	    $profs.="\"".$profession->getName()."\"";
	    echo "professions[\"".$f."\"][\"".$profession->getId()."\"]=\"".$profession->getName()."\";";
	}
   }
?>
// // not used yet (refactoring to BE, cause there are two queries to get faculties)
function draw_fac()
{
    var fac = document.getElementById("faculty");
    for (var i=0; i<6; ++i)
    {
        safe_add(fac, faculties[i], faculties[i]);
    }
}
function resubmit()
{
    var pr = document.getElementById("user_profession");
    var fac = document.getElementById("user_faculty");

    var choice = fac.selectedIndex;
    var facname = faculties[choice];
    while (pr.length > 0)	//remove all
	pr.remove(0);

    for (i in professions[facname])	//and add what are necessary
    {
    	safe_add(pr, professions[facname][i], i);
    }
}
// XXX needing such hardcoding - ?
var dependencies = new Array();
dependencies["passport"] = new Array(document.getElementById("passport"));
dependencies["reader_card"] = new Array(document.getElementById("reader_card"));
dependencies["student_card"] = new Array(document.getElementById("student_card"));

function draw_status_dependencies()
{
    var class = document.getElementById("status");
    var choice = class.selectedIndex;

	if (choice==0 || choice==1) {
		dependecies["passport"].readOnly = true;
	} else if (choice==2 || choice==6) {
		dependecies["passport"].readOnly = true;
		dependecies["reader_card"].readOnly = true;
	} else if (choice==3 || choice==4) {
		dependecies["student_card"].readOnly = true;
	} else if (choice==5 || choice==7) {
		dependecies["student_card"].readOnly = true;
		dependecies["reader_card"].readOnly = true;
	}
}
