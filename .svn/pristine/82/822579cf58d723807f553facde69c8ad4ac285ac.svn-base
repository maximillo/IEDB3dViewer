<script type="text/javascript" src="JSmol.min.js"></script>
<script language="JavaScript">
function showpopup() {
	var sURL = "showAntibody.html";
	var popwin = window.open(sURL, "", "width=650,height=600,resizable,status,menubar,scrollbars");
	popwin.focus();
}
</script>


<?php

//Change this PDBID or retrive it from webpage or database, whichever it fits the application the best
//This will have to be changed in the real implementation, as the link will start from an epitope table
//Start with the epitope ID to retrieve the corresponding information from the new complex table.

$PDBID = "1NL0";

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

$sql = "SELECT pdb_id, 
		ab_c1_pdb_chain,
		ab_c2_pdb_chain, 
		mhc_c1_pdb_chain, 
		mhc_c2_pdb_chain, 
		tcr_c1_pdb_chain, 
		tcr_c2_pdb_chain, 
		ant_pdb_chain,
		calc_e_residues,
		calc_ab_ant_residues
		FROM complex where pdb_id='".$PDBID."'";
		

//echo $sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	if ($row["ab_c1_pdb_chain"] != NULL || $row["ab_c2_pdb_chain"] != NULL)  {
    	
			echo "PDB ID: " .$row["pdb_id"]. " is antibody <br>";

// 			echo gettype($row["e_residues"])."<br>";
			$antigenResidues = parseResidue($row["calc_e_residues"]);
//			echo $antigenResidues."<br>";
			$abResidues = parseResidue($row["calc_ab_ant_residues"]);
//			echo $abResidues."<br>";
// 			print_r(explode(":",$row["e_residues"]));
			
			
		// Create a hiden form to pass the values to the popup window	
			echo "<form name=\"form\" method=\"post\" action=\"showAntibody.html\" onSubmit=\"showpopup(); return false\">";
			echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
			echo "<input type=\"hidden\" name=\"Antibody_Chain1\" value=". $row["ab_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antibody_Chain2\" value=". $row["ab_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antigen_Chain\" value=". $row["ant_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"EpitopeResID\" value=\"". $antigenResidues."\">";
			echo "<input type=\"hidden\" name=\"ReceptorResID\" value=\"". $abResidues."\">";		
			echo "<input type=\"button\" onClick=\"showpopup()\" value=\"Load Antibody Structure\">";
			echo "</form>". "<br>";
			
		} elseif ($row["tcr_c1_pdb_chain"] != NULL || $row["tcr_c2_pdb_chain"] != NULL) {
			echo "PDB ID: " .$row["pdb_id"]. " is TCR ". "<br>";

			$antigenResidues = parseResidue($row["calc_e_residues"]);
//			echo $antigenResidues."<br>";
			$abResidues = parseResidue($row["calc_ab_ant_residues"]);
//			echo $abResidues."<br>";
// 			print_r(explode(":",$row["e_residues"]));
			
			
		// Create a hiden form to pass the values to the popup window	
			echo "<form name=\"form\" method=\"post\" action=\"showAntibody.html\" onSubmit=\"showpopup(); return false\">";
			echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
			echo "<input type=\"hidden\" name=\"TCR_Chain1\" value=". $row["mhc_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"TCR_Chain2\" value=". $row["mhc_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain1\" value=". $row["mhc_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"MHC_Chain2\" value=". $row["mhc_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antigen_Chain\" value=". $row["ant_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"EpitopeResID\" value=\"". $antigenResidues."\">";
			echo "<input type=\"hidden\" name=\"ReceptorResID\" value=\"". $abResidues."\">";		
			echo "<input type=\"button\" onClick=\"showpopup()\" value=\"Load TCR Structure\">";
			echo "</form>". "<br>";
			
			
		} elseif ($row["mhc_c1_pdb_chain"] != NULL || $row["mhc_c2_pdb_chain"] != NULL) {
			echo "PDB ID: " .$row["pdb_id"]. " is MHC ". "<br>";

			$antigenResidues = parseResidue($row["calc_e_residues"]);
//			echo $antigenResidues."<br>";
			$abResidues = parseResidue($row["calc_ab_ant_residues"]);
//			echo $abResidues."<br>";
 			print_r(explode(":",$row["e_residues"]));
			
			
		// Create a hiden form to pass the values to the popup window	
			echo "<form name=\"form\" method=\"post\" action=\"showAntibody.html\" onSubmit=\"showpopup(); return false\">";
			echo "<input type=\"hidden\" name=\"PDB_ID\" value=". $row["pdb_id"].">";
			echo "<input type=\"hidden\" name=\"Antibody_Chain1\" value=". $row["ab_c1_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antibody_Chain2\" value=". $row["ab_c2_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"Antigen_Chain\" value=". $row["ant_pdb_chain"].">";
			echo "<input type=\"hidden\" name=\"EpitopeResID\" value=\"". $antigenResidues."\">";
			echo "<input type=\"hidden\" name=\"ReceptorResID\" value=\"". $abResidues."\">";		
			echo "<input type=\"button\" onClick=\"showpopup()\" value=\"Load MHC Structure\">";
			echo "</form>". "<br>";
		}
		
		break;
    }

    
} else {
    echo "0 results";
}
$conn->close();
?>