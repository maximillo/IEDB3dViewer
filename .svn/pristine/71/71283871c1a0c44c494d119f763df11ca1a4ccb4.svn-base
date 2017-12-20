
function showAntibody(PDB_ID, epitopeResID, receptorResID, heavyChain, lightChain, antigenChain) {

	var interactiveResID = [[epitopeResID,"Epitope Residues","#0000FF"],[receptorResID,"Receptor Residue","#FFD700"]];
	var chain = [[heavyChain,"Heavy Chain","#800000"],[lightChain,"Light Chain","#00CED1"],[antigenChain,"Antigen Chain","#B0C4DE"]];
	showComplex(PDB_ID, interactiveResID, chain);
	
};

function showTCR(PDB_ID, epitopeResID, receptorResID, MHC_alpha, MHC_beta, TCR_alpha, TCR_beta, antigenChain) {
	
	
	var interactiveResID = [[epitopeResID,"Epitope Residues","#0000FF"],[receptorResID,"Receptor Residue","#FFD700"]];
	
	var chain = [[MHC_alpha,"MHC alpha-chain","#FF00FF"],[MHC_beta,"MHC beta-chain","#006400"],[TCR_alpha,"TCR alpha-chain","#800000"],[TCR_beta,"TCR beta-chain","#00CED1"],[antigenChain,"Antigen Chain","#B0C4DE"]];
	
	showComplex(PDB_ID, interactiveResID, chain);
	
};

function showMHC(PDB_ID, epitopeResID, receptorResID, MHC_alpha, MHC_beta, antigenChain) {
	
	var interactiveResID = [[epitopeResID,"Epitope Residues","#0000FF"],[receptorResID,"Receptor Residue","#FFD700"]];
	
	var chain = [[MHC_alpha,"MHC alpha-chain","#FF00FF"],[MHC_beta,"MHC beta-chain","#006400"],[antigenChain,"Antigen Chain","#B0C4DE"]];
	
	showComplex(PDB_ID, interactiveResID, chain);
	
};

function showComplex(PDB_ID, interactiveResID, chain) {
	
	
	var jmolApplet; // Declare the jsmol object, set up in HTML table, below

	var xxxx = document.location.search;
	
	var resIDScript = [];
	
	var chainScript = [];
	
	for (i = 0; i < interactiveResID.length; i++) { 
		resIDScript[i] = 'select ' + interactiveResID[i][0] + '; spacefill only; spacefill 40%; wireframe 0.4; color \"' + interactiveResID[i][2] + '\"; select;';
	}
	
	for (i = 0; i < chain.length; i++) { 
		chainScript[i] = 'select :' + chain[i][0] + '; wireframe off; cartoon; cpk off; color \"' + chain[i][2] + '\"; select;';
	}
	

	// Developers: The _debugCode flag is checked in j2s/core/core.z.js, 
	// and, if TRUE, skips loading the core methods, forcing those
	// to be read from their individual directories. Set this
	// true if you want to do some code debugging by inserting
	// System.out.println, document.title, or alert commands
	// anywhere in the Java or Jmol code.

	Jmol._debugCode = (xxxx.indexOf("debugcode") >= 0);

	jmol_isReady = function(applet) {
		Jmol._getElement(applet, "appletdiv").style.border="2px solid gray"
	}

	// The following section load default structure with default representation upon page loading
	if (xxxx.length == 5 || xxxx.length == 0) {
		xxxx = (xxxx + PDB_ID).substring(0,4)
		script = 'h2oOn=true;'
		+'set animframecallback "jmolscript:if (!selectionHalos) {select model=_modelNumber}";'
		+'set errorCallback "myCallback";'
		+'set defaultloadscript "isDssp = false;'
		+'set defaultVDW babel;if(!h2oOn){display !water}";'
		+'set zoomlarge false;'
		+'set echo top left;'
		+'echo loading XXXX;'
		+'refresh;'
		+'load "http://www.rcsb.org/pdb/files/XXXX.pdb";'
		+'set echo top left;echo XXXX;'
		+'spacefill off;'
		+'wireframe off;'
		+'cartoons on;'
		
		for (i = 0; i < chain.length; i++) {
		script += chainScript[i];
		}
		
		script = script.replace(/XXXX/g, xxxx);

	} else {
		script = unescape(xxxx.substring(1))
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
	jmolBr()

	Jmol.setButtonCss(null,"style='width:120px'")
	jmolButton("Color Chain","Default Color")
	jmolButton("Trace Only")
	jmolButton("Cartoon Only")
	jmolButton("Backbone Only")
	jmolButton("spacefill only; spacefill 23%; wireframe 0.15","Ball&Stick")
	
	jmolBr()
	
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


	jmolBr()

};