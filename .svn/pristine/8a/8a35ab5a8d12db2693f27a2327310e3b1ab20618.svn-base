
function showAntibody(PDB_ID, epitopeResID, curEpitopeResID, receptorResID, curReceptorResID, chain1_ID, chain2_ID, chain1_type, chain2_type, antigenChain) {
	
	var PDBurl = getPDBurl(PDB_ID);
	
	//construct the interactive residue array (selection, name, color) to pass it to showComplex()
	var interactiveResID = [[epitopeResID,"Antigen to Antibody (Epitope)","#0000FF"],[receptorResID,"Antibody to Antigen (Paratope)","#FFD700"]];
	
	var curInteractiveResID = [[curEpitopeResID,"Antigen to Antibody (Epitope)","#0000FF"],[curReceptorResID,"Antibody to Antigen (Paratope)","#FFD700"]];
	
	//construct the chain array (selection, name, color) to pass it to showComplex()
	var chain = [[chain1_ID, chain1_type, "#800000"],[chain2_ID, chain2_type, "#00CED1"],[antigenChain,"Antigen","#B0C4DE"]];

	showComplex(PDBurl, interactiveResID, curInteractiveResID, chain);

};

function showTCR(PDB_ID, epitopeMHCResID, curEpitopeMHCResID, epitopeTCRResID, curEpitopeTCRResID, mhcEpitopeResID, curMhcEpitopeResID, tcrEpitopeResID, curTcrEpitopeResID, chain1_ID, chain2_ID, mhc_chain1_ID, mhc_chain2_ID, chain1_type, chain2_type, mhc_chain1_type, mhc_chain2_type, epitopeChain) {
	
	var PDBurl = getPDBurl(PDB_ID);
	
	var interactiveResID = [[epitopeMHCResID,"MHC to epitope","#0000FF"],[epitopeTCRResID,"TCR to epitope","#0000FF"],[mhcEpitopeResID,"epitope to MHC","#FFD700"],[tcrEpitopeResID,"epitope to TCR","#FFD700"]];
	
	var curInteractiveResID = [[curEpitopeMHCResID,"MHC to epitope","#0000FF"],[epitopeTCRResID,"TCR to epitope","#0000FF"],[mhcEpitopeResID,"epitope to MHC","#FFD700"],[tcrEpitopeResID,"epitope to TCR","#FFD700"]];

	var chain = [[mhc_chain1_ID, "MHC-" + mhc_chain1_type, "#FF00FF"],[mhc_chain2_ID, "MHC-" + mhc_chain2_type, "#006400"],[chain1_ID, "TCR-" + chain1_type, "#800000"],[chain2_ID, "TCR-" + chain2_type, "#00CED1"],[epitopeChain,"Epitope Chain","#B0C4DE"]];
	
	showComplex(PDBurl, interactiveResID, curInteractiveResID, chain);
	
};

function showMHC(PDB_ID, epitopeResID, curEpitopeResID, mhcResID, curMhcResID, mhc_chain1_ID, mhc_chain2_ID, mhc_chain1_type, mhc_chain2_type, epitopeChain) {
	
	var PDBurl = getPDBurl(PDB_ID);
	
	var interactiveResID = [[epitopeResID,"Epitope to MHC","#0000FF"],[mhcResID,"MHC to epitope","#FFD700"]];
	
	var curInteractiveResID = [[curEpitopeResID,"Epitope to MHC","#0000FF"],[curMhcResID,"MHC to epitope","#FFD700"]];
	
	var chain = [[mhc_chain1_ID, "MHC-" + mhc_chain1_type, "#FF00FF"],[mhc_chain2_ID, "MHC-" + mhc_chain2_type, "#006400"],[epitopeChain,"Epitope Chain","#B0C4DE"]];
	
	showComplex(PDBurl, interactiveResID, curInteractiveResID, chain);
	
};

function getPDBurl(PDB_ID) {
	var PDBurl;
	if (PDB_ID.length == 4) {
		PDBurl = 'http://www.rcsb.org/pdb/files/' + PDB_ID + '.pdb';
//		PDBurl = 'http://www.rcsb.org/view/' + PDB_ID + '.pdb';
	} else if (PDB_ID.length == 5) {
// 			Placeholder for PIGS url decoration such as: PDBurl = ''
	} else {alert("invalid PDB ID")}
	return PDBurl;
};


function showComplex(url, interactiveResID, curInteractiveResID, chain) {
	
	// Declare the jsmol object, set up in HTML table, below
	var jmolApplet; 

	var resIDScript = [];
	
	var curResIDScript = [];
	
	var chainScript = [];
	
	// Scripts act on chains from molecule 1
	
	for (i = 0; i < chain.length; i++) { 
		chainScript[i] = 'select MODEL=1.1 and :' + chain[i][0] + '; wireframe off; cartoon; cpk off; color \"' + chain[i][2] + '\";';
	}	
	
	// Scripts act on calculated residues from molecule 2
	for (i = 0; i < interactiveResID.length; i++) { 
 		resIDScript[i] = 'select MODEL=2.1 and (' + interactiveResID[i][0] + '); spacefill only; spacefill 40%; wireframe 0.4; color \"' + interactiveResID[i][2] + '\";';
 	}
	
	// Scripts act on curated residues from molecule 3, to be functioning upon fixing the contact curation from complex table
	for (i = 0; i < curInteractiveResID.length; i++) { 
		curResIDScript[i] = 'select MODEL=3.1 and ' + curInteractiveResID[i][0] + '; spacefill only; spacefill 40%; wireframe 0.4; color \"' + curInteractiveResID[i][2] + '\";';
	}
	

	// Developers: The _debugCode flag is checked in j2s/core/core.z.js, 
	// and, if TRUE, skips loading the core methods, forcing those
	// to be read from their individual directories. Set this
	// true if you want to do some code debugging by inserting
	// System.out.println, document.title, or alert commands
	// anywhere in the Java or Jmol code.

	//Jmol._debugCode = (xxxx.indexOf("debugcode") >= 0);

	jmol_isReady = function(applet) {
		Jmol._getElement(applet, "appletdiv").style.border="2px solid gray"
	}

	// The following section load default structure with default representation upon page loading

	script = 'h2oOn=true;'
	
// 	+'set animframecallback "jmolscript:if (!selectionHalos) {select model=_modelNumber}";'
// 	+'set errorCallback "myCallback";'
// 	+'set defaultloadscript "isDssp = false;'
// 	+'set defaultVDW babel;if(!h2oOn){display !water}";'
// 	+'set zoomlarge false;'
	+'set echo top left;'
	+'echo loading structure;'
	+'refresh; load FILES "'
	
	//load multiple molecules for different layers of representation
	+ url + '" "' + url
	+ '";'
	//turn everything off
	+ 'cartoon off; wireframe off; spacefill off;'
	+ 'center :' + chain[0][0] + ';'

	//activate all models/molecules been loaded
	+ 'frame ALL;'
	
	for (i = 0; i < chain.length; i++) {
	script += chainScript[i];
	}
	
	function infoClass() {
		this.width = 450;
		this.height = 450;
		this.debug = false;
		this.color = "white";
		this.addSelectionOptions = false;
		this.serverURL = "php/jsmol.php";
		this.use = "HTML5";  	// logic is set by indicating order of USE -- default is HTML5 for this test page, though JAVA HTML5 WEBGL IMAGE  are all options
		this.j2sPath = "j2s";
		this.readyFunction = jmol_isReady;
		this.script = script;
		this.disableInitialConsole = true;
	}

	var Info = new infoClass();
	
	// these are conveniences that mimic behavior of Jmol.js
	function jmolCheckbox(script1, script0, text, ischecked) {Jmol.jmolCheckbox(jmolApplet,script1, script0, text, ischecked)}
	function jmolButton(script, text) {Jmol.jmolButton(jmolApplet,script,text)}
	function jmolHtml(s) { document.write(s) }
	function jmolBr() { jmolHtml("<br>") }
	function jmolMenu(a) {Jmol.jmolMenu(jmolApplet, a)}

	jmolApplet = Jmol.getApplet("jmolApplet", Info)


// 	Jmol.setButtonCss(null,"style='width:120px'")
// 	jmolButton("select all; color chain","Default Color")
// 	jmolButton("select all; trace only","Trace only")
// 	jmolButton("select all; cartoon only","Cartoon Only")
// 	jmolButton("select all; backbone only", "Backbone Only")
// 	jmolButton("select all; spacefill only; spacefill 23%; wireframe 0.15","Ball&Stick")


	
	/*	
	for (i = 0; i < chain.length; i++) {
		var styleText = 'style=\'width:120px; color:' + chain[i][2] + '\'';
		Jmol.setButtonCss(null,styleText);
		jmolButton(chainScript[i],chain[i][1]);
	}
	
	for (i = 0; i < interactiveResID.length; i++) {
		var styleText = 'style=\'width:120px; color:' + interactiveResID[i][2] + '\'';
		Jmol.setButtonCss(null,styleText);
		jmolButton(resIDScript[i],interactiveResID[i][1]);
	}
*/
	jmolBr()
	jmolHtml("Chains: ")
	
	for (i = 0; i < chain.length; i++) {
		//var styleText = 'style=\'width:120px; color:' + chain[i][2] + '\'';
		//Jmol.setCheckboxCss(null,styleText); //somehow the setCheckbox does not work for color so I had to adopt the
		var styleText = '\<font color=\"' + chain[i][2] + '\">' + chain[i][1] + '\<\/font\>';
		
		jmolCheckbox(chainScript[i] + 'display displayed or selected;', chainScript[i] + 'hide not displayed or selected;', styleText, true);

	}	

	jmolBr()
	jmolHtml("Calculated Contacts: ")
	
	for (i = 0; i < interactiveResID.length; i++) {
		var styleText = '\<font color=\"' + interactiveResID[i][2] + '\">' + interactiveResID[i][1] + '\<\/font\>';
		//Jmol.setCheckboxCss(null,styleText);
		jmolCheckbox(resIDScript[i] + 'display displayed or selected;', resIDScript[i] + 'hide not displayed or selected;', styleText, false);

	}	

	jmolBr()
	
//Currently commented out due the flaws in the format of curated contacts
	
// 	jmolHtml("Curated Contacts: ")
// 	for (i = 0; i < curInteractiveResID.length; i++) {
// 		var styleText = '\<font color=\"' + curInteractiveResID[i][2] + '\">' + curInteractiveResID[i][1] + '\<\/font\>';
// 		//Jmol.setCheckboxCss(null,styleText);
// 		jmolCheckbox(curResIDScript[i] + 'display displayed or selected', curResIDScript[i]+ 'hide not displayed or selected;', styleText, false);
// 	}	
// 
// 	jmolBr()

};