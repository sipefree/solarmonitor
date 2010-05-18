/* 
 This file was generated by Dashcode and is covered by the 
 license.txt included in the project.  You may edit this file, 
 however it is recommended to first turn off the Dashcode 
 code generator otherwise the changes will be lost.
 */

// Note: Properties and methods beginning with underbar ("_") are considered private and subject to change in future Dashcode releases.

/*jsl:import DashcodePart.js*/

/**   
 *  @declare DC.PushButton
 *  @extends DC.DashcodePart
 *  
 */
DC.PushButton = Class.create(DC.DashcodePart, {

    exposedBindings: ["sizeToFit","state","text"],

    __viewClassName__: "PushButton",
    partSetup: function(spec) 
    {
        var buttonElement = this.viewElement();
        var _self = this;
        var originalID = spec.originalID ? spec.originalID : buttonElement.originalID;
        if (!buttonElement || !spec)
            return;
                
        // when cloning template, get size from original
        if (originalID) {
            while (buttonElement.firstChild) 
                buttonElement.removeChild(buttonElement.firstChild);
        }
        
        this.enabled = !spec.disabled;
        
        // calculate sizes and margins
        this._initialWidth = spec.initialWidth || 0;
        this._initialHeight = spec.initialHeight || 0;
        this._leftImageWidth = spec.leftImageWidth || 0;
        this._rightImageWidth = spec.rightImageWidth || 0;
        this._noBackground = spec.noBackground || false;
        this._containerLeft = 0;
        this._containerRight = 0;

        // determine URL of background images
        this._pressed = false;
        var imagePrefix = "Parts/Images/" + (originalID?originalID:buttonElement.id);
        this._bgIimageURL = imagePrefix + ".png"
        this._pressedBgImageURL = imagePrefix + "_clicked.png";
        
        // create internal elements
        var style;
        this._backgroundElement = document.createElement("div");
        style = this._backgroundElement.style;
        style.position = "absolute";
        style.top = "0px";
        style.left = "0px";
        style.right = "0px";
        style.bottom = "0px";
        buttonElement.appendChild(this._backgroundElement);
        this._backgroundElementPressed = this._backgroundElement.cloneNode(false);
        style = this._backgroundElementPressed.style;
        style.visibility = "hidden";
        buttonElement.appendChild(this._backgroundElementPressed);
        this._containerElement = this._backgroundElement.cloneNode(false);
        style = this._containerElement.style;
        style.textOverflow = "ellipsis";
        buttonElement.appendChild(this._containerElement);
        this._textElement = document.createElement("span");
        style = this._textElement.style;
        style.display = "inline";
        this._containerElement.appendChild(this._textElement);
        this._imageElement = document.createElement("img");
        style = this._imageElement.style;
        style.display = "inline";
        style.verticalAlign = "middle";
        this._containerElement.appendChild(this._imageElement);
        this._lineBreakElement = document.createElement("br");
        this._containerElement.appendChild(this._lineBreakElement);
        this._eventsElement = this._backgroundElement.cloneNode(false);
        style = this._eventsElement.style;
        buttonElement.appendChild(this._eventsElement);

        // set the text and image values
        this._updateBackgroundImage();
        var text = spec.text || '';
        if (window.dashcode && dashcode.getLocalizedString) text = dashcode.getLocalizedString(text);
        this.setText(text);
        this.setImageURL(spec.customImage || '');
        this.setPressedImageURL(spec.customImagePressed || '');
        var imagePosition = (spec.customImagePosition == undefined) || (spec.customImagePosition.length < 1) ? DC.PushButton.IMAGE_POSITION_NONE : eval(spec.customImagePosition);
        this.setImagePosition(imagePosition);
        
        if (spec.onclick && !dashcode.inDesign) {
            try {
                var onClickHandler = eval(spec.onclick);
                
                if (onClickHandler) {
                    this._setOnClickAsAction(onClickHandler,this._eventsElement);
                }
            } catch (e) {};
        }
    },
    
    onmousedown: function(event)
    {
        if (this.enabled)
            this._setPressed(true);
    },

    onmouseup: function(event)
    {
        if (this.enabled)
            this._setPressed(false);        
    },

    onclick: function(event)
    {
        if (this.enabled && this.action){
            this.sendAction();
        }
    },

    setEnabled: function(enabled)
    {
        // ensure 'enabled' is a boolean
        enabled = !(!enabled);
        
        if (this.enabled == enabled) {
            return;
        } 
        
        this.enabled = enabled;
        var originalOpacity = 1;
        var element = this.viewElement();
        
        var style = Element.getStyles(element, ["opacity"]);
        if (style && style["opacity"] != null) {
            originalOpacity = +style["opacity"];
        }
        
        if (enabled) {
            element.style.opacity = originalOpacity * (1/DC.PushButton.DISABLED_OPACITY);
            element.style.appleDashboardRegion = "dashboard-region(control rectangle)";
        } else {
            element.style.opacity = DC.PushButton.DISABLED_OPACITY * originalOpacity;
            element.style.appleDashboardRegion = "none";
        }
    },
    
    getEnabled: function()
    {
        return this.enabled;
    },
    
    observeEnabledChange: function(change)
    {
        
        if (this.__initialising && (null===change.newValue ||
            'undefined'===change.newValue))
        {
            this.bindings.enabled.setValue(this.enabled);
            return;
        }
            
        this.setEnabled(change.newValue);
    },
    
    observeTextChange: function(change, keyPath, context)
    {
        if (this.__initialising &&
            (null===change.newValue || 'undefined'===typeof(change.newValue)))
        {
            this.bindings.text.setValue(this.getText());
            return;
        }
        
        this.setText(change.newValue);
    },
    
    setText: function(text) 
    {
       this._textElement.innerText = text;
       if (this._sizeToFit)
        this.sizeToFit();
    },
    
    getText: function()
    {
        return this._textElement.innerText;
    },
    
    setSizeToFit: function(sizeToFit) 
    {
        this._sizeToFit = sizeToFit;
        if (sizeToFit)
            this.sizeToFit();
    },
    
    getSizeToFit: function()
    {
        return this._sizeToFit;
    },
    
    sizeToFit: function(minWidth,maxWidth)
    {
        var minWidthToFit = this._widthRequiredToFit();
        
        if( maxWidth && (maxWidth < minWidthToFit) ){
            minWidthToFit = parseInt(maxWidth, 10);
        }else if( minWidth && (minWidth > minWidthToFit) ){
            minWidthToFit = parseInt(minWidth, 10);
        }
        
        this.viewElement().style.width = minWidthToFit + "px";	
        this._layoutElements();
    },
    
    setImagePosition: function(position)
    {
        this._imagePosition = position;
        this._layoutElements();
    },
    
    getImagePosition: function()
    {
        return this._imagePosition;
    },
    
    setImageURL: function(imageURL)
    {
        this._customImageURL = imageURL;
        this._customImageLoaded = false;
        if (this._customImageURL) {
            this._customImage = new Image();
            var _self = this;
            this._customImage.onload = function () {
                _self._customImageLoaded = true;
                _self._setCustomImage();
            }
            this._customImage.src = this._customImageURL;
        }  else {
            this._customImage = null;
            this._setCustomImage();
        }  
    },
    
    getImageURL: function()
    {
         return this._customImageURL;
    },
    
    setPressedImageURL: function(imageURL)
    {
        this._customImagePressedURL = imageURL;
        this._customImagePressedLoaded = false;
        if (this._customImagePressedURL) {
            this._customImagePressed = new Image();
            var _self = this;
            this._customImagePressed.onload = function () {
                _self._customImagePressedLoaded = true;
                _self._setCustomImage();
            }
            this._customImagePressed.src = this._customImagePressedURL;
        }  else {
            this._customImagePressed = null;
            this._setCustomImage();
        }
    },
    
    getPressedImageURL: function()
    {
        return this._customImagePressedURL;
    },
    
    setState: function(state)
    {
        this._pressed = (state == DC.PushButton.STATE_ON);
        // show the normal or pressed background (and custom image)
        if (this._pressed) {
            this._backgroundElement.style.visibility = "hidden";
            this._backgroundElementPressed.style.visibility = "visible";
        } else {
            this._backgroundElement.style.visibility = "visible";
            this._backgroundElementPressed.style.visibility = "hidden";
        }
        this._setCustomImage();
        // Work-around for WebKit issue 5882457, otherwise, sometimes the image position on the button can be incorrect.
        this._imageElement.offsetLeft;
    },
    
    getState: function()
    {
        return this._pressed ? DC.PushButton.STATE_ON : DC.PushButton.STATE_OFF;
    }

    /*********************
     * Private handlers
     *********************/,
    
    _setCustomImage: function()
    {
        var imageStyle = this._imageElement.style;
        if (this._pressed && this._customImagePressed && this._customImagePressedLoaded) {
            this._imageElement.src = this._customImagePressedURL;
            imageStyle.width = this._customImagePressed.width + "px";
            imageStyle.height = this._customImagePressed.height + "px";
        } else if (!this._pressed && this._customImage && this._customImageLoaded) {
            this._imageElement.src = this._customImageURL;
            imageStyle.width = this._customImage.width + "px";
            imageStyle.height = this._customImage.height + "px";
        } else {
            this._imageElement.src = null;
        }
        this._layoutElements();
    },
    
    _setPressed: function(pressed)
    {
        var state = pressed ? DC.PushButton.STATE_ON : DC.PushButton.STATE_OFF;
        this.setState(state);
    },
    
    _updateBackgroundImage: function()
    {
        var style = this._backgroundElement.style;
        var pressedStyle = this._backgroundElementPressed.style;

        // sets background-image or border-image
        if (this._noBackground) {
            Element.set3PiecesBorderImage(this._backgroundElement, null);
            Element.set3PiecesBorderImage(this._backgroundElementPressed, null);
            style.backgroundImage = "";
            pressedStyle.backgroundImage = "";
        } else if (this._leftImageWidth > 0 || this._rightImageWidth > 0) {
            Element.set3PiecesBorderImage(this._backgroundElement, this._bgIimageURL, this._leftImageWidth, this._rightImageWidth);
            Element.set3PiecesBorderImage(this._backgroundElementPressed, this._pressedBgImageURL, this._leftImageWidth, this._rightImageWidth);
            style.backgroundImage = "";
            pressedStyle.backgroundImage = "";
        } else {
            Element.set3PiecesBorderImage(this._backgroundElement, null);
            Element.set3PiecesBorderImage(this._backgroundElementPressed, null);
            style.backgroundImage = "url(" + this._bgIimageURL + ")";
            pressedStyle.backgroundImage = "url(" + this._pressedBgImageURL + ")";
            style.backgroundRepeat = "repeat-x";
            pressedStyle.backgroundRepeat = "repeat-x";
        }

        var minMargin = 2;
        this._containerLeft = +this._leftImageWidth + minMargin;
        this._containerRight = +this._rightImageWidth + minMargin;
        if (this._containerLeft > this._containerRight) {
            this._containerLeft = Math.ceil((this._containerRight + this._containerLeft) / 2);
        } else if (this._containerRight > this._containerLeft) {
            this._containerRight = Math.ceil((this._containerRight + this._containerLeft) / 2);
        }
        this._containerElement.style.marginLeft = this._containerLeft + "px";
        this._containerElement.style.marginRight = this._containerRight + "px";
    },
    
    _layoutElements: function() {
        var position = this._imagePosition;
        if (!this._customImage || (!this._customImageLoaded && !this._customImagePressedLoaded && (position != DC.PushButton.IMAGE_POSITION_CENTER))) {
            position = DC.PushButton.IMAGE_POSITION_NONE;
        }
        var imageStyle = this._imageElement.style;
        var textStyle = this._textElement.style;
        var containerStyle = this._containerElement.style;
        var lineBreakStyle = this._lineBreakElement.style;

        var buttonHeight = this.viewElement().offsetHeight;
        if (buttonHeight < 1) buttonHeight = this._initialHeight;
        var buttonWidth = this.viewElement().offsetWidth;
        if (buttonWidth < 1) buttonWidth = this._initialWidth;

        // if no image
        if (position == DC.PushButton.IMAGE_POSITION_NONE) {
            textStyle.position = "static";
            imageStyle.display = "none";
            textStyle.display = "inline";
            containerStyle.lineHeight = buttonHeight + "px";
            containerStyle.overflow = "hidden";
            containerStyle.marginTop = "";
            lineBreakStyle.display = "none";
        } else {
            // get element dimensions
            var textHeight = this._textElement.offsetHeight;
            if (textHeight < 1) {
                var style = Element.getStyles(this._textElement, ["font-size"]);
                if (style && style["font-size"] != null) {
                    textHeight = parseFloat(style["font-size"]);
                }
            }
            var imageWidth = 0;
            var imageHeight = 0;
            var horizontalSpacing = 5;
            var verticalSpacing = 5;
                            
            if (this._pressed && this._customImagePressed) {
                imageWidth = this._customImagePressed.width;
                imageHeight = this._customImagePressed.height;
            } else if (this._customImage) {
                imageWidth = this._customImage.width;
                imageHeight = this._customImage.height;                            
            }
                            
            // lay out the text and image
            if (position == DC.PushButton.IMAGE_POSITION_LEFT || position == DC.PushButton.IMAGE_POSITION_RIGHT) {
                textStyle.display = "inline";
                imageStyle.display = "inline";
                imageStyle.marginTop = "";
                imageStyle.marginBottom = "";
                containerStyle.marginTop = "";
                containerStyle.lineHeight = buttonHeight + "px";
                containerStyle.overflow = "hidden";
                lineBreakStyle.display = "none";
                if (position == DC.PushButton.IMAGE_POSITION_LEFT) {
                    this._containerElement.insertBefore(this._imageElement, this._textElement);
                    imageStyle.marginLeft = "";
                    imageStyle.marginRight = horizontalSpacing+"px";
                } else {
                    this._containerElement.insertBefore(this._textElement, this._imageElement);
                    imageStyle.marginLeft = horizontalSpacing+"px";
                    imageStyle.marginRight = "";
                }
            } else if(position == DC.PushButton.IMAGE_POSITION_TOP || position == DC.PushButton.IMAGE_POSITION_BOTTOM) {
                textStyle.display = "inline";
                imageStyle.display = "inline";
                imageStyle.marginLeft = "";
                imageStyle.marginRight = "";
                containerStyle.lineHeight = "";
                containerStyle.overflow = "hidden";
                var containerMarginTop = Math.floor((buttonHeight - (textHeight + imageHeight + verticalSpacing)) / 2);
                containerStyle.marginTop = Math.max(containerMarginTop, 0) + "px";
                lineBreakStyle.display = "inline";
                if(position == DC.PushButton.IMAGE_POSITION_TOP) {
                    imageStyle.marginTop = "";
                    imageStyle.marginBottom = verticalSpacing + "px";
                    this._containerElement.insertBefore(this._imageElement, this._textElement);
                    this._containerElement.insertBefore(this._lineBreakElement, this._textElement);
                } else {
                    imageStyle.marginTop = verticalSpacing + "px";
                    imageStyle.marginBottom = "";
                    this._containerElement.insertBefore(this._textElement, this._imageElement);
                    this._containerElement.insertBefore(this._lineBreakElement, this._imageElement);
                }
            } else { // position IMAGE_POSITION_CENTER
                textStyle.display = "none";
                imageStyle.display = "inline";
                containerStyle.lineHeight = buttonHeight + "px";
                containerStyle.overflow = "visible";
                containerStyle.marginTop = "";
                lineBreakStyle.display = "none";
                // if the image is larger than the button, compensate to center
                var horizontalDifference = imageWidth - (buttonWidth - this._containerLeft - this._containerRight);
                var marginLeft = (horizontalDifference > 0) ? -horizontalDifference / 2 : 0;
                var verticalDifference = imageHeight - buttonHeight;
                var marginTop = (verticalDifference > 0) ? -verticalDifference / 2 : 0;
                imageStyle.marginLeft = marginLeft + "px";
                imageStyle.marginTop = marginTop + "px";
                imageStyle.marginRight = "";
                imageStyle.marginBottom = "";
            }        
        }
    },
    
    _widthRequiredToFit: function()
    {
        var textWidth = this._textElement.offsetWidth;
        var width = 0;
        
        // If there is an image
        if(this._imagePosition != DC.PushButton.IMAGE_POSITION_NONE && (this._customImageLoaded || this._customImagePressedLoaded)){
            var imageWidth = this._pressed ? this._customImagePressed.width : this._customImage.width;
            
            switch( this._imagePosition ){
                case DC.PushButton.IMAGE_POSITION_LEFT:
                case DC.PushButton.IMAGE_POSITION_RIGHT:
                    if( this._imageElement.style.marginLeft )
                        width += parseInt(this._imageElement.style.marginLeft, 10);
                    if( this._imageElement.style.marginRight )
                        width += parseInt(this._imageElement.style.marginRight, 10);
                    
                    width += textWidth + imageWidth;
                    break;
                    default:
                    if( textWidth > imageWidth )
                        width += textWidth;
                    else
                        width += imageWidth;
                    break;
            }
            
        }else{ // If there is not an image
            width += textWidth;
        }
        
        width += this._containerLeft + this._containerRight;
        
        return width;
    },
    
    _setNoBackground: function(newValue)
    {
        this._noBackground = newValue;
    }
});

DC.PushButton.DISABLED_OPACITY = 0.5;

DC.PushButton.IMAGE_POSITION_NONE = 0;
DC.PushButton.IMAGE_POSITION_LEFT = 1;
DC.PushButton.IMAGE_POSITION_RIGHT = 2;
DC.PushButton.IMAGE_POSITION_TOP = 3;
DC.PushButton.IMAGE_POSITION_BOTTOM = 4;
DC.PushButton.IMAGE_POSITION_CENTER = 5;

DC.PushButton.STATE_OFF = 0;
DC.PushButton.STATE_ON = 1;

// For backward compatibility
if (!window.PushButton)
    window.PushButton = DC.PushButton;