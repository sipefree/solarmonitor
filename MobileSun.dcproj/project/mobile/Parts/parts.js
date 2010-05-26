/* 
 This file was generated by Dashcode and is covered by the 
 license.txt included in the project.  You may edit this file, 
 however it is recommended to first turn off the Dashcode 
 code generator otherwise the changes will be lost. This file
 is for files included by Dashcode directly. It will be replaced
 with an optimized version at deploy time.
*/
var dashcodePartSupport = {
    "core": ["../Parts/core/utilities.js", "../Parts/core/core/base.js", "../Parts/core/core/array-additions.js", "../Parts/core/core/array-additions-ie.js", "../Parts/core/core/set.js", "../Parts/core/core/oop.js", "../Parts/core/core/function-additions.js", "../Parts/core/core/object-additions.js", "../Parts/core/core/regex-additions.js", "../Parts/core/core/local.js", "../Parts/core/core/Error.js", "../Parts/core/core/kvo.js", "../Parts/core/core/Bindable.js", "../Parts/core/core/SortDescriptor.js", "../Parts/core/core/transformers.js", "../Parts/core/core/Binding.js", "../Parts/core/core/kvo-array.js", "../Parts/core/core/kvo-array-operators.js", "../Parts/core/core/model.js", "../Parts/core/core/string-additions.js", "../Parts/core/net/Deferred.js", "../Parts/core/net/XHR.js", "../Parts/core/controllers/Controller.js", "../Parts/core/controllers/SelectionProxy.js", "../Parts/core/controllers/ObjectController.js", "../Parts/core/controllers/ArrayController.js", "../Parts/core/controllers/AjaxController.js", "../Parts/core/controllers/ModeledXMLProxy.js", "../Parts/core/dom/element.js", "../Parts/core/dom/event.js", "../Parts/core/dom/element-ie.js", "../Parts/core/dom/event-ie.js", "../Parts/core/views/view-parts.js", "../Parts/core/views/view-core.js", "../Parts/core/views/Responder.js", "../Parts/core/views/View.js", "../Parts/core/views/ViewController.js", "../Parts/core/views/ImageView.js", "../Parts/core/views/ImageLayout.js", "../Parts/core/views/DashcodePart.js", "../Parts/core/views/FormControl.js", "../Parts/core/views/TextField.js", "../Parts/core/views/ListView.js", "../Parts/core/views/SelectField.js", "../Parts/core/views/ToggleButton.js", "../Parts/core/views/SearchField.js", "../Parts/core/views/Slider.js", "../Parts/core/views/EventLoop.js", "../Parts/core/views/Page.js", "../Parts/core/views/Media.js", "../Parts/core/views/Video.js", "../Parts/core/views/VideoLayout.js", "../Parts/core/views/VideoLegacy.js"],
    "imageBgParts": { "bottomRectangleShape": ["Parts/Images/bottomRectangleShape.png", 12, 12], "rectangleShape": ["Parts/Images/rectangleShape.png", 1, 1], "rectangleShape1": ["Parts/Images/rectangleShape1.png", 1, 1], "topRectangleShape": ["Parts/Images/topRectangleShape.png", 12, 12] },
    "scripts": ["Parts/setup.js", "../Parts/datasources.js", "../Parts/Browser.js", "../Parts/Header.js", "../Parts/List.js", "../Parts/StackLayout.js", "../Parts/Transitions.js", "../Parts/PushButton.js", "../Parts/ActivityIndicator.js"]
};

(function() {
    var scripts = dashcodePartSupport['core'];
    
    scripts = scripts.concat(dashcodePartSupport['scripts']);

    for(var index in scripts) {
        var path = scripts[index];
        var scriptTag = '<script apple-no-regeneration="yes" type="text/javascript" src="' + path + '"></script>';
            
        document.write( scriptTag );
    }    
})();


