// function showTCR_or_MHC
function showTCR_or_MHC(PDB_ID, epitopeResID, receptorResID, chain1_ID, chain2_ID, chain3_ID, chain4_ID, chain5_ID) {
	
	var tcrPDB = PDB_ID;
	var tcrEpitopeResID = epitopeResID;
	var tcrReceptorResID = receptorResID;
	
	var mhcChain1 = chain1_ID;
	var mhcChain1Name = "MHC alpha-Chain";
	var mhcChain1Color = "#FF00FF";
	
	var mhcChain2 = chain2_ID;
	var mhcChain2Name = "MHC beta-Chain";
	var mhcChain2Color = "#006400";
	
	var tcrChain1 = chain3_ID;
	var tcrChain1Name = "TCR alpha-Chain";
	var tcrChain1Color = "#800000";
	
	var tcrChain2 = chain4_ID;
	var tcrChain2Name = "TCR beta-Chain";
	var tcrChain2Color = "#00CED1";
	
	var antigenChain = chain5_ID;
	var antigenChainName = "Antigen Chain";
	var antigenChainColor = "#B0C4DE";
	
	showComplex(tcrPDB, tcrEpitopeResID, tcrReceptorResID, mhcChain1, mhcChain1Name, mhcChain1Color, mhcChain2, mhcChain2Name, mhcChain2Color, tcrChain1, tcrChain1Name, tcrChain1Color, tcrChain2, tcrChain2Name, tcrChain2Color, antigenChain, antigenChainName, antigenChainColor);
	
};


function showAntibody(PDB_ID, epitopeResID, receptorResID, chain1_ID, chain2_ID, chain3_ID) {
	
	var antibodyPDB = PDB_ID;
	var antibodyEpitopeResID = epitopeResID;
	var antibodyReceptorResID = receptorResID;
	var heavyChain = chain1_ID;
	var heavyChainName = "Heavy Chain";
	var heavyChainColor = "#800000";
	var lightChain = chain2_ID;
	var lightChainName = "Light Chain";
	var lightChainColor = "#00CED1";
	var antigenChain = chain3_ID;
	var antigenChainName = "Antigen Chain";
	var antigenChainColor = "#B0C4DE";
	
	showComplex(antibodyPDB, antibodyEpitopeResID, antibodyReceptorResID, heavyChain, heavyChainName, heavyChainColor, lightChain, lightChainName, lightChainColor, antigenChain, antigenChainName, antigenChainColor);
	
};


function showComplex(PDB_ID, epitopeResID, receptorResID, chain1_ID, chain1_name, chain1_color, chain2_ID, chain2_name, chain2_color, chain3_ID, chain3_name, chain3_color, chain4_ID, chain4_name, chain4_color, chain5_ID, chain5_name, chain5_color) {
	
	
	// Declare the jsmol object, set up in HTML table, below
	var jmolApplet; 

	// logic is set by indicating order of USE -- default is HTML5 for this test page, though
	// JAVA HTML5 WEBGL IMAGE  are all options
	var use = "HTML5" 
	var xxxx = document.location.search;

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
		+'color chain;'

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
		this.use = "HTML5";
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

	Jmol.setButtonCss(null,"style='width:120px'")
	jmolBr()
	//jmolHtml("B Cell Examples:")

	jmolButton("Color Chain")
	jmolButton("Trace Only")
	jmolButton("Cartoon Only")
	jmolButton("Backbone Only")
	jmolButton("spacefill only; spacefill 23%; wireframe 0.15","Ball&Stick")
	jmolBr()

	
	//var chain1_Script = 'select :' + chain1_ID + '; wireframe off; cartoon; cpk off; color \"#800000\"; select;';
	var chain1_Script = 'select :' + chain1_ID + '; wireframe off; cartoon; cpk off; color \"' + chain1_color + '\"; select;';
	jmolButton(chain1_Script, chain1_name);
	
	//var chain2_Script = 'select :' + chain2_ID + '; wireframe off; cartoon; cpk off; color \"#00CED1\"; select;';
	var chain2_Script = 'select :' + chain2_ID + '; wireframe off; cartoon; cpk off; color \"'+ chain2_color + '\"; select;';
	jmolButton(chain2_Script, chain2_name)
	
	//var chain3_Script = 'select :' + chain3_ID + '; wireframe off; cartoon; cpk off; color \"#B0C4DE\"; select;';
	var chain3_Script = 'select :' + chain3_ID + '; wireframe off; cartoon; cpk off; color \"'+ chain3_color + '\"; select;';
	jmolButton(chain3_Script, chain3_name)
	
	if (!(chain4_ID === undefined)) {
		var chain4_Script = 'select :' + chain4_ID + '; wireframe off; cartoon; cpk off; color \"'+ chain4_color + '\"; select;';
		jmolButton(chain4_Script, chain4_name);
	}
	
	if (!(chain5_ID === undefined)) {
		var chain5_Script = 'select :' + chain5_ID + '; wireframe off; cartoon; cpk off; color \"'+ chain5_color + '\"; select;';
		jmolButton(chain5_Script, chain5_name);
	}
	
	var epitopeResIDScript = 'select ' + epitopeResID + '; wireframe off; cpk on; color \"#0000FF\"; select;';
	var receptorResIDScript = 'select ' + receptorResID + '; wireframe off; cpk on; color \"#FFD700\"; select;';
	
	
	jmolButton(epitopeResIDScript, "Epitope Residues")
	jmolButton(receptorResIDScript, "Receptor Residues")
	jmolBr()

};