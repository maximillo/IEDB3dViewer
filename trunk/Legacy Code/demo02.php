<script type="text/javascript" src="JSmol.min.js"></script>

<script language="JavaScript">

function showAntibodyPopup() {
	var sURL = "showAntibody.html";
	var popwin = window.open(sURL, "", "width=650,height=600,resizable,status,menubar,scrollbars");
	popwin.focus();
}

function showTCRPopup() {
	var sURL = "showTCR.html";
	var popwin = window.open(sURL, "", "width=650,height=600,resizable,status,menubar,scrollbars");
	popwin.focus();
}

function showMHCPopup() {
	var sURL = "showMHC.html";
	var popwin = window.open(sURL, "", "width=650,height=600,resizable,status,menubar,scrollbars");
	popwin.focus();
}

</script>

<?php

// Retrive all required info from complex table using complex_id
// Test each of the 3 different types of complex:

// Antibody test

$COMPLEXID = '1356528';


// TCR test
// $COMPLEXID = '1354522';

// MHC test
// $COMPLEXID = '1354243';

// Parameters to connect to the iedb_public database, need to change when release it for public use

$servername = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "MAXdev_2015";
$dbname = "iedb_public";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

function parseResidue($a) {

	//Split at ";" if there are multiple chains involved
	$chainList = explode(";",$a);
	$finalList = array();
	for($i=0;$i<count($chainList);$i++) {
		
		//echo $chainList[$i]."<br>";
		$residueList = explode(":",$chainList[$i]);
 		//echo $residueList[0]."<br>";
 		$residueList[0] = preg_replace("/[^a-zA-Z]/", "", $residueList[0]);
 		//echo $residueList[0]."<br>";
 		//echo $residueList[1]."<br>";
		$resnumberList = explode(",",$residueList[1]);

		for ($j=0;$j<count($resnumberList);$j++) {
			// echo $resnumberList[$j]."<br>";
			$resnumberList[$j] = preg_replace("/[^0-9]/", "", $resnumberList[$j]).":".$residueList[0];
			//echo $resnumberList[$j]."<br>";
		} 
		$finalList[$i] = implode(",",$resnumberList);
	}	
	
	$finalString = implode(",",$finalList);
	//echo $finalString."<br><br>";
	return $finalString;
}

// Query the complex table in database to get all the chainIDs and residues
		
$sql = "SELECT complex_id,
		pdb_id,
		type_flag,
		c1_type,
		c2_type,
		mhc_chain1,
		mhc_chain2,
		ab_c1_pdb_chain,
		ab_c2_pdb_chain,
		mhc_c1_pdb_chain, 
		mhc_c2_pdb_chain, 
		tcr_c1_pdb_chain,
		tcr_c2_pdb_chain,
		ant_pdb_chain,
		e_pdb_chain,
		calc_e_residues,
		calc_e_mhc_residues,
		calc_mhc_e_residues,
		calc_e_tcr_residues,
		calc_tcr_e_residues,
		calc_ab_ant_residues
 		FROM complex where complex_id='".$COMPLEXID."'";


// echo $sql."<br>";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {
    
 		# create the hidden form to post the values to the popup window   
//     	echo "<form name=\"form\" method=\"post\" action=\"showAntibody.html\" onSubmit=\"showAntibodyPopup(); return false\">";
// 		echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
// 		
// 		# iterate through all the chains but the antigen chain
// 		$chainArray = array($row["c1_type"], $row["c2_type"], $row["mhc_chain1"], $row["mhc_chain2"]);
// 		$i = 0;
// 		foreach ($chainArray as $v) {
// 		   	echo $chainArray[$i]."<br>";
// 			echo "<input type=\"hidden\" name=\"Chain1_type\" value=". $chainArray[$i].">";
//    			$i ++;
// 		}
// 		
     	if ($row["type_flag"] == "bcell") {
     	
 			echo "Complex of ID " .$row["complex_id"]. " is an antibody <br>";
 			echo $row["pdb_id"]."<br>";

// 			echo gettype($row["e_residues"])."<br>";
 			$antigenResidues = parseResidue($row["calc_e_residues"]);
			echo $antigenResidues."<br>";
 			$abResidues = parseResidue($row["calc_ab_ant_residues"]);
//			echo $abResidues."<br>";
// 			print_r(explode(":",$row["e_residues"]));
// 			
			
		// Create a hiden form to pass the values to the popup window	
			echo "<form name=\"form\" method=\"post\" action=\"showAntibody.html\" onSubmit=\"showAntibodyPopup(); return false\">";
			echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
			echo "<input type=\"hidden\" name=\"Chain1_type\" value=". $row["c1_type"].">";
			echo "<input type=\"hidden\" name=\"Chain2_type\" value=". $row["c2_type"].">";
			echo "<input type=\"hidden\" name=\"Antibody_Chain1\" value=". $row["ab_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antibody_Chain2\" value=". $row["ab_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antigen_Chain\" value=". $row["ant_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"EpitopeResID\" value=\"". $antigenResidues."\">";
			echo "<input type=\"hidden\" name=\"ReceptorResID\" value=\"". $abResidues."\">";		
			echo "<input type=\"button\" onClick=\"showAntibodyPopup()\" value=\"Load Antibody Structure\">";
			echo "</form>". "<br>";
			
		} elseif ($row["type_flag"] == "tcell") {
			echo "Complex of ID " .$row["complex_id"]. " is an TCR ". "<br>";
			echo $row["pdb_id"]."<br>";

			$epitopeMHCResidues = parseResidue($row["calc_e_mhc_residues"]);
// 			echo $epitopeMHCResidues."<br>";

			$epitopeTCRResidues = parseResidue($row["calc_e_tcr_residues"]);
// 			echo $epitopeTCRResidues."<br>";
			
			$mhcEpitopeResidues = parseResidue($row["calc_mhc_e_residues"]);
// 			echo $mhcEpitopeResidues."<br>";
			
			$tcrEpitopeResidues = parseResidue($row["calc_tcr_e_residues"]);
// 			echo $tcrEpitopeResidues."<br>";
// 			print_r(explode(":",$row["e_residues"]));
			
			
		// Create a hiden form to pass the values to the popup window	
			echo "<form name=\"form\" method=\"post\" action=\"showTCR.html\" onSubmit=\"showTCRPopup(); return false\">";
			echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
			echo "<input type=\"hidden\" name=\"Chain1_type\" value=". $row["c1_type"].">";
			echo "<input type=\"hidden\" name=\"Chain2_type\" value=". $row["c2_type"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain1_type\" value=". $row["mhc_chain1"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain2_type\" value=". $row["mhc_chain2"].">";
			echo "<input type=\"hidden\" name=\"TCR_Chain1_ID\" value=". $row["tcr_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"TCR_Chain2_ID\" value=". $row["tcr_c2_pdb_chain"].">";			
			echo "<input type=\"hidden\" name=\"MHC_Chain1_ID\" value=". $row["mhc_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain2_ID\" value=". $row["mhc_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Epitope_Chain\" value=". $row["e_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"EpitopeMHCResID\" value=\"". $epitopeMHCResidues."\">";
 			echo "<input type=\"hidden\" name=\"EpitopeTCRResID\" value=\"". $epitopeTCRResidues."\">";
			echo "<input type=\"hidden\" name=\"MHCEpitopeResID\" value=\"". $mhcEpitopeResidues."\">";	
 			echo "<input type=\"hidden\" name=\"TCREpitopeResID\" value=\"". $tcrEpitopeResidues."\">";
			echo "<input type=\"button\" onClick=\"showTCRPopup()\" value=\"Load TCR Structure\">";
			echo "</form>". "<br>";
			
			
		} elseif ($row["type_flag"] == "mhc") {
			echo "Complex of ID " .$row["complex_id"]. " is a MHC ". "<br>";
			echo $row["pdb_id"]."<br>";

			$epitopeResidues = parseResidue($row["calc_e_mhc_residues"]);
//			echo $antigenResidues."<br>";
			$MHCResidues = parseResidue($row["calc_mhc_e_residues"]);
//			echo $abResidues."<br>";
// 			print_r(explode(":",$row["e_residues"]));
			
			
		// Create a hiden form to pass the values to the popup window	
			echo "<form name=\"form\" method=\"post\" action=\"showMHC.html\" onSubmit=\"showMHCPopup(); return false\">";
			echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain1_type\" value=". $row["mhc_chain1"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain2_type\" value=". $row["mhc_chain2"].">";		
			echo "<input type=\"hidden\" name=\"MHC_Chain1_ID\" value=". $row["mhc_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain2_ID\" value=". $row["mhc_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Epitope_Chain\" value=". $row["e_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"EpitopeResID\" value=\"". $epitopeResidues."\">";
			echo "<input type=\"hidden\" name=\"MHCResID\" value=\"". $MHCResidues."\">";		
			echo "<input type=\"button\" onClick=\"showMHCPopup()\" value=\"Load MHC Structure\">";
			echo "</form>". "<br>";
		}
		
		break;
    }

    
} else {
    echo "0 results";
}
$conn->close();
?>