// ===================================================================
// Author: Matt Kruse <matt@mattkruse.com>
// WWW: http://www.mattkruse.com/
// Modified by Son Nguyen
// ===================================================================

// CONSTRUCTOR
// Pass in the name of the element, then the names of the lists it depends on, order by (2,1);(3,1,2);(4,1,2,3)
function DynamicOptionList() {
	if (arguments.length < 2) { alert("Not enough arguments in DynamicOptionList()"); }
	// Name of the list containing dynamic values
	this.target = arguments[0];
	// Set the lists that this dynamic list depends on
	this.dependencies = new Array();
	for (var i=1; i<arguments.length; i++) {
		this.dependencies[this.dependencies.length] = arguments[i];
	} // for

	// The form this list belongs to
	this.form = null;
	// Place-holder for currently-selected values of dependent select lists
	this.dependentValues = new Object();
	// Hold default values to be selected for conditions
	this.defaultValues = new Object();
	// Storage for the dynamic values
	this.options = new Object();
	// Delimiter between dependent values
	this.delimiter = "|";
	// Logest string currently a potential options (for Netscape)
	this.longestString = "";
	// The total number of options that might be displayed, to build dummy options (for Netscape)
	this.numberOfOptions = 0;
	// Method mappings
	this.addOptions = DynamicOptionList_addOptions;
	this.populate = DynamicOptionList_populate;
	this.setDelimiter = DynamicOptionList_setDelimiter;
	this.setDefaultOption = DynamicOptionList_setDefaultOption;
	this.printOptions = DynamicOptionList_printOptions;
	this.init = DynamicOptionList_init;
}

// Set the delimiter to something other than | when defining condition values
function DynamicOptionList_setDelimiter(val) {
	this.delimiter = val;
}

// Set the default option to be selected when the list is painted
function DynamicOptionList_setDefaultOption(condition, val) {
	this.defaultValues[condition] = val;
}

// Init call to map the form to the object and populate it
function DynamicOptionList_init(formId) {
	if (!formId) formId = 'frmEdit';
	this.form = document.getElementById(formId);
	this.populate();
}

// Add options to the list.
// Pass the condition string, then the list of text/value pairs that populate the list	
function DynamicOptionList_addOptions(dependentValue) {
	if (typeof this.options[dependentValue] != "object") { this.options[dependentValue] = new Array(); }
	for (var i=1; i<arguments.length; i+=2) {
		// Keep track of the longest potential string, to draw the option list
		if (arguments[i].length > this.longestString.length) {
			this.longestString = arguments[i];
		} // if
		this.numberOfOptions++;
		this.options[dependentValue][this.options[dependentValue].length] = arguments[i];
		this.options[dependentValue][this.options[dependentValue].length] = arguments[i+1];
	} // for
}

// Print dummy options so Netscape behaves nicely
function DynamicOptionList_printOptions() {
	// Only need to write out "dummy" options for Netscape
    if ((navigator.appName == 'Netscape') && (parseInt(navigator.appVersion) <= 4)){
		var ret = "";
		for (var i=0; i<this.numberOfOptions; i++) { 
			ret += "<option>";
		} // for
		ret += "<option>"
		for (var i=0; i<this.longestString.length; i++) {
			ret += "_";
		} // for
		document.writeln(ret);
	} // if
}

// Populate the list
function DynamicOptionList_populate() {
	var theform = this.form;
	var i,j,obj,obj2;
	// Get the current value(s) of all select lists this list depends on
	this.dependentValues = new Object;
	var dependentValuesInitialized = false;
	//init form rudimentary patch but it works ... cgrecu, July 27
	if (!theform) theform = document.getElementById('frmEdit');
	for (i=0; i<this.dependencies.length;i++) {
		var sel = document.getElementById(this.dependencies[i]);
		// If this is the first dependent list, just fill in the dependentValues
		if (!dependentValuesInitialized) {
			dependentValuesInitialized = true;
			for (j=0; j<sel.options.length; j++) {
				if (sel.options[j].selected) {
					this.dependentValues[sel.options[j].value] = true;
				} // if
			} // for
		} // if
		// Otherwise, add new options for every existing option
		else {
			var tmpList = new Object();
			var newList = new Object();
			for (j=0; j<sel.options.length; j++) {
				if (sel.options[j].selected) {
					tmpList[sel.options[j].value] = true;
				}
			}
			for (obj in this.dependentValues) {
				for (obj2 in tmpList) {
					newList[obj + this.delimiter + obj2] = true;
				} // for
			} // for
			this.dependentValues = newList;
		} // else
	} // for

	var targetSel = theform[this.target];
		
	// Store the currently-selected values of the target list to maintain them (in case of multiple select lists)
	var targetSelected = new Object();
	for (i=0; i<targetSel.options.length; i++) {
		if (targetSel.options[i].selected) {
			targetSelected[targetSel.options[i].value] = true;
		} // if
	} // for
	targetSel.options.length = 0; // Clear all target options

	for (i in this.dependentValues) {
		if (typeof this.options[i] == "object") {
			var o = this.options[i];
			for (j=0; j<o.length; j+=2) {
				var text = o[j];
				var val = o[j+1];
	
				targetSel.options[targetSel.options.length] = new Option(text, val, false, false);
				if (this.defaultValues[i] == val) {
					targetSelected[val] = true;
				} // if
			} // for
		} // if
	} // for
	targetSel.selectedIndex=-1;
	
	// Select the options that were selected before
	for (i=0; i<targetSel.options.length; i++) {
		if (targetSelected[targetSel.options[i].value] != null && targetSelected[targetSel.options[i].value]==true) {
			targetSel.options[i].selected = true;
		} // if
	} // for
}

// added some more stuff - MBAA related

/** copy option from one list to another list */
function copyOptions(theSelFromName, theSelToName) {
	var theSelFrom = document.getElementById(theSelFromName);
	var theSelTo = document.getElementById(theSelToName);

	for(i=0;i<theSelFrom.length;i++) {
		if(theSelFrom.options[i].selected && theSelFrom.options[i].value!='') {
			addOption(theSelTo,theSelFrom.options[i].text,theSelFrom.options[i].value);
		} // if
	} // for
	
}
/** remove selected option from list */
function removeSelectedOption(theSelName) {
	var theSel = document.getElementById(theSelName);
	deleteOption(theSel,theSel.selectedIndex);
}


/** add new option into theSel */
function addOption(theSel, theText, theValue) {
	var newOpt = new Option(theText, theValue);
	var selLength = theSel.length;
	theSel.options[selLength] = newOpt;
}

/** delete option from theSel */
function deleteOption(theSel, theIndex) {
	var selLength = theSel.length;
	if(selLength>0) { theSel.options[theIndex] = null; }
}

/** get the string for display as the status */
function getSelected(numLists) {
	var curText = document.getElementById('CurText');
	var curID = document.getElementById('CurID');

	for (i=1;i<=numLists;i++) {
		var s = document.getElementById('list'+i);
		for (j=0; j<s.options.length; j++) {
			if (s.options[j].selected) {
				// only get the latest valid id
				if (s.options[j].value!='' && s.options[j].value!=-1) {
					curID.value = s.options[j].value;//alert( s.options[j].value);
				} // if
				
				// append / if not the first list
				if (i==1) {
					curText.innerHTML = s.options[j].text;
				} else if (s.options[j].value!='' && s.options[j].value!=-1) {
					curText.innerHTML += "/" + s.options[j].text;
				} // else
				
			} // if
		} // for
	} // for

}