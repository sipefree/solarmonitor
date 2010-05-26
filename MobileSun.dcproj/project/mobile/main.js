/* 
 This file was generated by Dashcode.  
 You may edit this file to customize your widget or web page 
 according to the license.txt file included in the project.
 */

//
// Function: load()
// Called by HTML body element's onload event when the web application is ready to start
//
function load()
{
    dashcode.setupParts();
    }

// ye gods this is an awful hack
var justZoomed = false;
var hideDetailImg = true;

//
// Function: itemClicked()
// Called when an item from the items list is selected to navigate to the detail view
//
function mainMenuSelect(event)
{
    var list = document.getElementById("menu").object;
    var browser = document.getElementById('browser').object;
    var selectedObjects = list.selectedObjects();
    
    if (selectedObjects && (1 == selectedObjects.length)){
        // The Browser's goForward method is used to make the browser push down to a new level.
        // Going back to previous levels is handled automatically.
        var name = selectedObjects[0].valueForKey("name");
        if(name == "Current Images") {
            browser.goForward(document.getElementById('cImageSelectSource'), selectedObjects[0].valueForKey("name"));
        }
        else if(name == "Forecast") {
            browser.goForward(document.getElementById('forecastLevel'), selectedObjects[0].valueForKey("name"));
        }
    }    
}

function imageSourceSelect(event)
{
    var list = document.getElementById("sourceList").object;
    var browser = document.getElementById('browser').object;
    var ds = dashcode.getDataSource('imageDetail');
    var selectedObjects = list.selectedObjects();
    var type = selectedObjects[0].type;
    hideDetailImg = true;
    ds.setValueForKeyPath(type, 'parameters.type');
    browser.goForward(document.getElementById('detailLevel'), "Detail");
}


function testGotoDetail(event) {
    var browser = document.getElementById('browser').object;
    browser.goForward(document.getElementById('detailLevel'), "Detail");
}

function testGotoImage(event) {
    window.location = "http://solarmonitor.org/data/20100518/pngs/seit/seit_00171_fd_20100518_010014.png";
    
}
function testGotoMovie(event) {
    window.location = "http://10.0.2.1/seit.m4v";
}

function viewFullRes(event)
{
    var browser = document.getElementById('browser').object;
    browser.goForward(document.getElementById('highDefLevel'), "High Definition");
    document.getElementById('stackLayout').style.overflow = "visible";
}

function imageDetailPrevWeek(event) {
    hideDetailImg = false;
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    var date = ds.valueForKeyPath('content.prevWeek');
    ds.setValueForKeyPath(date, 'parameters.date');
    ds2.setValueForKeyPath(date, 'parameters.date');
}
function imageDetailPrevDay(event) {
    alert("prevDay");   
    hideDetailImg = false;
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    var date = ds.valueForKeyPath('content.prevDay');
    ds.setValueForKeyPath(date, 'parameters.date');
    ds2.setValueForKeyPath(date, 'parameters.date');
}   
function imageDetailPrevRot(event) {
    hideDetailImg = false;
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    var date = ds.valueForKeyPath('content.prevRot');
    ds.setValueForKeyPath(date, 'parameters.date');
    ds2.setValueForKeyPath(date, 'parameters.date');
}
function imageDetailNextWeek(event) {
    hideDetailImg = false;
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    var date = ds.valueForKeyPath('content.nextWeek');
    ds.setValueForKeyPath(date, 'parameters.date');
    ds2.setValueForKeyPath(date, 'parameters.date');
}
function imageDetailNextDay(event) {
    hideDetailImg = false;
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    var date = ds.valueForKeyPath('content.nextDay');
    ds.setValueForKeyPath(date, 'parameters.date');
    ds2.setValueForKeyPath(date, 'parameters.date');
}
function imageDetailNextRot(event) {
    hideDetailImg = false;
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    var date = ds.valueForKeyPath('content.nextRot');
    ds.setValueForKeyPath(date, 'parameters.date');
    ds2.setValueForKeyPath(date, 'parameters.date');
}

function imageDetailNow(event) {
    var ds = dashcode.getDataSource('imageDetail');
    var ds2 = dashcode.getDataSource('imageSources');
    ds.setValueForKeyPath('default', 'parameters.date');
    ds2.setValueForKeyPath('default', 'parameters.date');
    hideDetailImg = false;
}


booleanInvert = Class.create(DC.ValueTransformer,{
    transformedValue: function(value){
        // Insert Code Here
		return !value;
    }
    // Uncomment to support a reverse transformation
    
    ,
    reverseTransformedValue: function(value){
        return !value;
    }
   
});



function zoomHighDef(event)
{
    var image = document.getElementById("image4");
    if(document.defaultView.getComputedStyle(image, "").getPropertyValue("width") == "320px") {
        image.style.width = "1500px";
        image.style.height = "1500px";
        image.firstChild.style.width = "1500px";
        image.firstChild.style.height = "1500px";
    } else {
        image.style.width = "320px";
        image.style.height = "320px";
        image.firstChild.style.width = "320px";
        image.firstChild.style.height = "320px";
    }
}

prettyDate = Class.create(DC.ValueTransformer,{
    transformedValue: function(value){
        var strDate = value.toString();
        var year = strDate.substr(0, 4);
        var month = strDate.substr(4, 2);
        var day = strDate.substr(6, 2);
        return "Date: " + year + "-" + month + "-" + day;
    }
    // Uncomment to support a reverse transformation
    /*
    ,
    reverseTransformedValue: function(value){
        return value;
    }
   */
});




shouldHideDetailImg = Class.create(DC.ValueTransformer,{
    transformedValue: function(value){
        // Insert Code Here
		return !value || !hideDetailImg;
    }
    // Uncomment to support a reverse transformation
    /*
    ,
    reverseTransformedValue: function(value){
        return value;
    }
   */
});

