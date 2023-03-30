!function(t){"use strict";t(window.jQuery,window,document)}(function(t,e,o,s){"use strict";t.widget("selectBox.selectBoxIt",{VERSION:"3.8.1",options:{showEffect:"none",showEffectOptions:{},showEffectSpeed:"medium",hideEffect:"none",hideEffectOptions:{},hideEffectSpeed:"medium",showFirstOption:!0,defaultText:"",defaultIcon:"",downArrowIcon:"",theme:"default",keydownOpen:!0,isMobile:function(){var t=navigator.userAgent||navigator.vendor||e.opera;return/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/.test(t)},"native":!1,aggressiveChange:!1,selectWhenHidden:!0,viewport:t(e),similarSearch:!1,copyAttributes:["title","rel"],copyClasses:"button",nativeMousedown:!1,customShowHideEvent:!1,autoWidth:!0,html:!0,populate:"",dynamicPositioning:!0,hideCurrent:!1},getThemes:function(){var e=this,o=t(e.element).attr("data-theme")||"c";return{bootstrap:{focus:"active",hover:"",enabled:"enabled",disabled:"disabled",arrow:"caret",button:"btn",list:"dropdown-menu",container:"bootstrap",open:"open"},jqueryui:{focus:"ui-state-focus",hover:"ui-state-hover",enabled:"ui-state-enabled",disabled:"ui-state-disabled",arrow:"ui-icon ui-icon-triangle-1-s",button:"ui-widget ui-state-default",list:"ui-widget ui-widget-content",container:"jqueryui",open:"selectboxit-open"},jquerymobile:{focus:"ui-btn-down-"+o,hover:"ui-btn-hover-"+o,enabled:"ui-enabled",disabled:"ui-disabled",arrow:"ui-icon ui-icon-arrow-d ui-icon-shadow",button:"ui-btn ui-btn-icon-right ui-btn-corner-all ui-shadow ui-btn-up-"+o,list:"ui-btn ui-btn-icon-right ui-btn-corner-all ui-shadow ui-btn-up-"+o,container:"jquerymobile",open:"selectboxit-open"},"default":{focus:"selectboxit-focus",hover:"selectboxit-hover",enabled:"selectboxit-enabled",disabled:"selectboxit-disabled",arrow:"selectboxit-default-arrow",button:"selectboxit-btn",list:"selectboxit-list",container:"selectboxit-container",open:"selectboxit-open"}}},isDeferred:function(e){return t.isPlainObject(e)&&e.promise&&e.done},_create:function(e){var s=this,i=s.options.populate,n=s.options.theme;if(s.element.is("select"))return s.widgetProto=t.Widget.prototype,s.originalElem=s.element[0],s.selectBox=s.element,s.options.populate&&s.add&&!e&&s.add(i),s.selectItems=s.element.find("option"),s.firstSelectItem=s.selectItems.slice(0,1),s.documentHeight=t(o).height(),s.theme=t.isPlainObject(n)?t.extend({},s.getThemes()["default"],n):s.getThemes()[n]?s.getThemes()[n]:s.getThemes()["default"],s.currentFocus=0,s.blur=!0,s.textArray=[],s.currentIndex=0,s.currentText="",s.flipped=!1,e||(s.selectBoxStyles=s.selectBox.attr("style")),s._createDropdownButton()._createUnorderedList()._copyAttributes()._replaceSelectBox()._addClasses(s.theme)._eventHandlers(),s.originalElem.disabled&&s.disable&&s.disable(),s._ariaAccessibility&&s._ariaAccessibility(),s.isMobile=s.options.isMobile(),s._mobile&&s._mobile(),s.options["native"]&&this._applyNativeSelect(),s.triggerEvent("create"),s},_createDropdownButton:function(){var e=this,o=e.originalElemId=e.originalElem.id||"",s=e.originalElemValue=e.originalElem.value||"",i=e.originalElemName=e.originalElem.name||"",n=e.options.copyClasses,r=e.selectBox.attr("class")||"";return e.dropdownText=t("<span/>",{id:o&&o+"SelectBoxItText","class":"selectboxit-text",unselectable:"on",text:e.firstSelectItem.text()}).attr("data-val",s),e.dropdownImageContainer=t("<span/>",{"class":"selectboxit-option-icon-container"}),e.dropdownImage=t("<i/>",{id:o&&o+"SelectBoxItDefaultIcon","class":"selectboxit-default-icon",unselectable:"on"}),e.dropdown=t("<span/>",{id:o&&o+"SelectBoxIt","class":"selectboxit "+("button"===n?r:"")+" "+(e.selectBox.prop("disabled")?e.theme.disabled:e.theme.enabled),name:i,tabindex:e.selectBox.attr("tabindex")||"0",unselectable:"on"}).append(e.dropdownImageContainer.append(e.dropdownImage)).append(e.dropdownText),e.dropdownContainer=t("<span/>",{id:o&&o+"SelectBoxItContainer","class":"selectboxit-container "+e.theme.container+" "+("container"===n?r:"")}).append(e.dropdown),e},_createUnorderedList:function(){var e,o,s,i,n,r,a,l,d,c,u,p,h,b=this,f="",m=b.originalElemId||"",x=t("<ul/>",{id:m&&m+"SelectBoxItOptions","class":"selectboxit-options",tabindex:-1});if(b.options.showFirstOption||(b.selectItems.first().attr("disabled","disabled"),b.selectItems=b.selectBox.find("option").slice(1)),b.selectItems.each(function(m){p=t(this),o="",s="",e=p.prop("disabled"),i=p.attr("data-icon")||"",n=p.attr("data-iconurl")||"",r=n?"selectboxit-option-icon-url":"",a=n?"style=\"background-image:url('"+n+"');\"":"",l=p.attr("data-selectedtext"),d=p.attr("data-text"),u=d?d:p.text(),h=p.parent(),h.is("optgroup")&&(o="selectboxit-optgroup-option",0===p.index()&&(s='<span class="selectboxit-optgroup-header '+h.first().attr("class")+'"data-disabled="true">'+h.first().attr("label")+"</span>")),p.attr("value",this.value),f+=s+'<li data-id="'+m+'" data-val="'+this.value+'" data-disabled="'+e+'" class="'+o+" selectboxit-option "+(t(this).attr("class")||"")+'"><a class="selectboxit-option-anchor"><span class="selectboxit-option-icon-container"><i class="selectboxit-option-icon '+i+" "+(r||b.theme.container)+'"'+a+"></i></span>"+(b.options.html?u:b.htmlEscape(u))+"</a></li>",c=p.attr("data-search"),b.textArray[m]=e?"":c?c:u,this.selected&&(b._setText(b.dropdownText,l||u),b.currentFocus=m)}),b.options.defaultText||b.selectBox.attr("data-text")){var g=b.options.defaultText||b.selectBox.attr("data-text");b._setText(b.dropdownText,g),b.options.defaultText=g}return x.append(f),b.list=x,b.dropdownContainer.append(b.list),b.listItems=b.list.children("li"),b.listAnchors=b.list.find("a"),b.listItems.first().addClass("selectboxit-option-first"),b.listItems.last().addClass("selectboxit-option-last"),b.list.find("li[data-disabled='true']").not(".optgroupHeader").addClass(b.theme.disabled),b.dropdownImage.addClass(b.selectBox.attr("data-icon")||b.options.defaultIcon||b.listItems.eq(b.currentFocus).find("i").attr("class")),b.dropdownImage.attr("style",b.listItems.eq(b.currentFocus).find("i").attr("style")),b},_replaceSelectBox:function(){var e,o,i,n=this,r=n.originalElem.id||"",a=n.selectBox.attr("data-size"),l=n.listSize=a===s?"auto":"0"===a?"auto":+a;return n.selectBox.css("display","none").after(n.dropdownContainer),n.dropdownContainer.appendTo("body").addClass("selectboxit-rendering"),e=n.dropdown.height(),n.downArrow=t("<i/>",{id:r&&r+"SelectBoxItArrow","class":"selectboxit-arrow",unselectable:"on"}),n.downArrowContainer=t("<span/>",{id:r&&r+"SelectBoxItArrowContainer","class":"selectboxit-arrow-container",unselectable:"on"}).append(n.downArrow),n.dropdown.append(n.downArrowContainer),n.listItems.removeClass("selectboxit-selected").eq(n.currentFocus).addClass("selectboxit-selected"),o=n.downArrowContainer.outerWidth(!0),i=n.dropdownImage.outerWidth(!0),n.options.autoWidth&&(n.dropdown.css({width:"auto"}).css({width:n.list.outerWidth(!0)+o+i}),n.list.css({"min-width":n.dropdown.width()})),n.dropdownText.css({"max-width":n.dropdownContainer.outerWidth(!0)-(o+i)}),n.selectBox.after(n.dropdownContainer),n.dropdownContainer.removeClass("selectboxit-rendering"),"number"===t.type(l)&&(n.maxHeight=n.listAnchors.outerHeight(!0)*l),n},_scrollToView:function(t){var e=this,o=e.listItems.eq(e.currentFocus),s=e.list.scrollTop(),i=o.height(),n=o.position().top,r=Math.abs(n),a=e.list.height();return"search"===t?a-n<i?e.list.scrollTop(s+(n-(a-i))):n<-1&&e.list.scrollTop(n-i):"up"===t?n<-1&&e.list.scrollTop(s-r):"down"===t&&a-n<i&&e.list.scrollTop(s+(r-a+i)),e},_callbackSupport:function(e){var o=this;return t.isFunction(e)&&e.call(o,o.dropdown),o},_setText:function(t,e){var o=this;return o.options.html?t.html(e):t.text(e),o},open:function(t){var e=this,o=e.options.showEffect,s=e.options.showEffectSpeed,i=e.options.showEffectOptions,n=e.options["native"],r=e.isMobile;return!e.listItems.length||e.dropdown.hasClass(e.theme.disabled)?e:(n||r||this.list.is(":visible")||(e.triggerEvent("open"),e._dynamicPositioning&&e.options.dynamicPositioning&&e._dynamicPositioning(),"none"===o?e.list.show():"show"===o||"slideDown"===o||"fadeIn"===o?e.list[o](s):e.list.show(o,i,s),e.list.promise().done(function(){e._scrollToView("search"),e.triggerEvent("opened")})),e._callbackSupport(t),e)},close:function(t){var e=this,o=e.options.hideEffect,s=e.options.hideEffectSpeed,i=e.options.hideEffectOptions,n=e.options["native"],r=e.isMobile;return n||r||!e.list.is(":visible")||(e.triggerEvent("close"),"none"===o?e.list.hide():"hide"===o||"slideUp"===o||"fadeOut"===o?e.list[o](s):e.list.hide(o,i,s),e.list.promise().done(function(){e.triggerEvent("closed")})),e._callbackSupport(t),e},toggle:function(){var t=this,e=t.list.is(":visible");e?t.close():e||t.open()},_keyMappings:{38:"up",40:"down",13:"enter",8:"backspace",9:"tab",32:"space",27:"esc"},_keydownMethods:function(){var t=this,e=t.list.is(":visible")||!t.options.keydownOpen;return{down:function(){t.moveDown&&e&&t.moveDown()},up:function(){t.moveUp&&e&&t.moveUp()},enter:function(){var e=t.listItems.eq(t.currentFocus);t._update(e),"true"!==e.attr("data-preventclose")&&t.close(),t.triggerEvent("enter")},tab:function(){t.triggerEvent("tab-blur"),t.close()},backspace:function(){t.triggerEvent("backspace")},esc:function(){t.close()}}},_eventHandlers:function(){var e,o,s=this,i=s.options.nativeMousedown,n=s.options.customShowHideEvent,r=s.focusClass,a=s.hoverClass,l=s.openClass;return this.dropdown.on({"click.selectBoxIt":function(){s.dropdown.trigger("focus",!0),s.originalElem.disabled||(s.triggerEvent("click"),i||n||s.toggle())},"mousedown.selectBoxIt":function(){t(this).data("mdown",!0),s.triggerEvent("mousedown"),i&&!n&&s.toggle()},"mouseup.selectBoxIt":function(){s.triggerEvent("mouseup")},"blur.selectBoxIt":function(){s.blur&&(s.triggerEvent("blur"),s.close(),t(this).removeClass(r))},"focus.selectBoxIt":function(e,o){var i=t(this).data("mdown");t(this).removeData("mdown"),i||o||setTimeout(function(){s.triggerEvent("tab-focus")},0),o||(t(this).hasClass(s.theme.disabled)||t(this).addClass(r),s.triggerEvent("focus"))},"keydown.selectBoxIt":function(t){var e=s._keyMappings[t.keyCode],o=s._keydownMethods()[e];o&&(o(),!s.options.keydownOpen||"up"!==e&&"down"!==e||s.open()),o&&"tab"!==e&&t.preventDefault()},"keypress.selectBoxIt":function(t){var e=t.charCode||t.keyCode,o=s._keyMappings[t.charCode||t.keyCode],i=String.fromCharCode(e);s.search&&(!o||o&&"space"===o)&&s.search(i,!0,!0),"space"===o&&t.preventDefault()},"mouseenter.selectBoxIt":function(){s.triggerEvent("mouseenter")},"mouseleave.selectBoxIt":function(){s.triggerEvent("mouseleave")}}),s.list.on({"mouseover.selectBoxIt":function(){s.blur=!1},"mouseout.selectBoxIt":function(){s.blur=!0},"focusin.selectBoxIt":function(){s.dropdown.trigger("focus",!0)}}),s.list.on({"mousedown.selectBoxIt":function(){s._update(t(this)),s.triggerEvent("option-click"),"false"===t(this).attr("data-disabled")&&"true"!==t(this).attr("data-preventclose")&&s.close(),setTimeout(function(){s.dropdown.trigger("focus",!0)},0)},"focusin.selectBoxIt":function(){s.listItems.not(t(this)).removeAttr("data-active"),t(this).attr("data-active","");var e=s.list.is(":hidden");(s.options.searchWhenHidden&&e||s.options.aggressiveChange||e&&s.options.selectWhenHidden)&&s._update(t(this)),t(this).addClass(r)},"mouseup.selectBoxIt":function(){i&&!n&&(s._update(t(this)),s.triggerEvent("option-mouseup"),"false"===t(this).attr("data-disabled")&&"true"!==t(this).attr("data-preventclose")&&s.close())},"mouseenter.selectBoxIt":function(){"false"===t(this).attr("data-disabled")&&(s.listItems.removeAttr("data-active"),t(this).addClass(r).attr("data-active",""),s.listItems.not(t(this)).removeClass(r),t(this).addClass(r),s.currentFocus=+t(this).attr("data-id"))},"mouseleave.selectBoxIt":function(){"false"===t(this).attr("data-disabled")&&(s.listItems.not(t(this)).removeClass(r).removeAttr("data-active"),t(this).addClass(r),s.currentFocus=+t(this).attr("data-id"))},"blur.selectBoxIt":function(){t(this).removeClass(r)}},".selectboxit-option"),s.list.on({"click.selectBoxIt":function(t){t.preventDefault()}},"a"),s.selectBox.on({"change.selectBoxIt, internal-change.selectBoxIt":function(t,i){var n,r;i||(n=s.list.find('li[data-val="'+s.originalElem.value+'"]'),n.length&&(s.listItems.eq(s.currentFocus).removeClass(s.focusClass),s.currentFocus=+n.attr("data-id"))),n=s.listItems.eq(s.currentFocus),r=n.attr("data-selectedtext"),e=n.attr("data-text"),o=e?e:n.find("a").text(),s._setText(s.dropdownText,r||o),s.dropdownText.attr("data-val",s.originalElem.value),n.find("i").attr("class")&&(s.dropdownImage.attr("class",n.find("i").attr("class")).addClass("selectboxit-default-icon"),s.dropdownImage.attr("style",n.find("i").attr("style"))),s.triggerEvent("changed")},"disable.selectBoxIt":function(){s.dropdown.addClass(s.theme.disabled)},"enable.selectBoxIt":function(){s.dropdown.removeClass(s.theme.disabled)},"open.selectBoxIt":function(){var t,e=s.list.find("li[data-val='"+s.dropdownText.attr("data-val")+"']");e.length||(e=s.listItems.not("[data-disabled=true]").first()),s.currentFocus=+e.attr("data-id"),t=s.listItems.eq(s.currentFocus),s.dropdown.addClass(l).removeClass(a).addClass(r),s.listItems.removeClass(s.selectedClass).removeAttr("data-active").not(t).removeClass(r),t.addClass(s.selectedClass).addClass(r),s.options.hideCurrent&&(s.listItems.show(),t.hide())},"close.selectBoxIt":function(){s.dropdown.removeClass(l)},"blur.selectBoxIt":function(){s.dropdown.removeClass(r)},"mouseenter.selectBoxIt":function(){t(this).hasClass(s.theme.disabled)||s.dropdown.addClass(a)},"mouseleave.selectBoxIt":function(){s.dropdown.removeClass(a)},destroy:function(t){t.preventDefault(),t.stopPropagation()}}),s},_update:function(t){var e,o,s,i=this,n=i.options.defaultText||i.selectBox.attr("data-text"),r=i.listItems.eq(i.currentFocus);"false"===t.attr("data-disabled")&&(e=i.listItems.eq(i.currentFocus).attr("data-selectedtext"),o=r.attr("data-text"),s=o?o:r.text(),(n&&i.options.html?i.dropdownText.html()===n:i.dropdownText.text()===n)&&i.selectBox.val()===t.attr("data-val")?i.triggerEvent("change"):(i.selectBox.val(t.attr("data-val")),i.currentFocus=+t.attr("data-id"),i.originalElem.value!==i.dropdownText.attr("data-val")&&i.triggerEvent("change")))},_addClasses:function(t){var e=this,o=(e.focusClass=t.focus,e.hoverClass=t.hover,t.button),s=t.list,i=t.arrow,n=t.container;e.openClass=t.open;return e.selectedClass="selectboxit-selected",e.downArrow.addClass(e.selectBox.attr("data-downarrow")||e.options.downArrowIcon||i),e.dropdownContainer.addClass(n),e.dropdown.addClass(o),e.list.addClass(s),e},refresh:function(t,e){var o=this;return o._destroySelectBoxIt()._create(!0),e||o.triggerEvent("refresh"),o._callbackSupport(t),o},htmlEscape:function(t){return String(t).replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;")},triggerEvent:function(t){var e=this,o=e.options.showFirstOption?e.currentFocus:e.currentFocus-1>=0?e.currentFocus:0;return e.selectBox.trigger(t,{selectbox:e.selectBox,selectboxOption:e.selectItems.eq(o),dropdown:e.dropdown,dropdownOption:e.listItems.eq(e.currentFocus)}),e},_copyAttributes:function(){var t=this;return t._addSelectBoxAttributes&&t._addSelectBoxAttributes(),t},_realOuterWidth:function(t){if(t.is(":visible"))return t.outerWidth(!0);var e,o=t.clone();return o.css({visibility:"hidden",display:"block",position:"absolute"}).appendTo("body"),e=o.outerWidth(!0),o.remove(),e}});var i=t.selectBox.selectBoxIt.prototype;i.add=function(e,o){this._populate(e,function(e){var s,i,n=this,r=t.type(e),a=0,l=[],d=n._isJSON(e),c=d&&n._parseJSON(e);if(e&&("array"===r||d&&c.data&&"array"===t.type(c.data))||"object"===r&&e.data&&"array"===t.type(e.data)){for(n._isJSON(e)&&(e=c),e.data&&(e=e.data),i=e.length;a<=i-1;a+=1)s=e[a],t.isPlainObject(s)?l.push(t("<option/>",s)):"string"===t.type(s)&&l.push(t("<option/>",{text:s,value:s}));n.selectBox.append(l)}else e&&"string"===r&&!n._isJSON(e)?n.selectBox.append(e):e&&"object"===r?n.selectBox.append(t("<option/>",e)):e&&n._isJSON(e)&&t.isPlainObject(n._parseJSON(e))&&n.selectBox.append(t("<option/>",n._parseJSON(e)));return n.dropdown?n.refresh(function(){n._callbackSupport(o)},!0):n._callbackSupport(o),n})},i._parseJSON=function(e){return JSON&&JSON.parse&&JSON.parse(e)||t.parseJSON(e)},i._isJSON=function(t){var e,o=this;try{return e=o._parseJSON(t),!0}catch(s){return!1}},i._populate=function(e,o){var s=this;return e=t.isFunction(e)?e.call():e,s.isDeferred(e)?e.done(function(t){o.call(s,t)}):o.call(s,e),s},i._ariaAccessibility=function(){var e=this,o=t("label[for='"+e.originalElem.id+"']");return e.dropdownContainer.attr({role:"combobox","aria-autocomplete":"list","aria-haspopup":"true","aria-expanded":"false","aria-owns":e.list[0].id}),e.dropdownText.attr({"aria-live":"polite"}),e.dropdown.on({"disable.selectBoxIt":function(){e.dropdownContainer.attr("aria-disabled","true")},"enable.selectBoxIt":function(){e.dropdownContainer.attr("aria-disabled","false")}}),o.length&&e.dropdownContainer.attr("aria-labelledby",o[0].id),e.list.attr({role:"listbox","aria-hidden":"true"}),e.listItems.attr({role:"option"}),e.selectBox.on({"open.selectBoxIt":function(){e.list.attr("aria-hidden","false"),e.dropdownContainer.attr("aria-expanded","true")},"close.selectBoxIt":function(){e.list.attr("aria-hidden","true"),e.dropdownContainer.attr("aria-expanded","false")}}),e},i._addSelectBoxAttributes=function(){var e=this;return e._addAttributes(e.selectBox.prop("attributes"),e.dropdown),e.selectItems.each(function(o){e._addAttributes(t(this).prop("attributes"),e.listItems.eq(o))}),e},i._addAttributes=function(e,o){var s=this,i=s.options.copyAttributes;return e.length&&t.each(e,function(e,s){var n=s.name.toLowerCase(),r=s.value;"null"===r||t.inArray(n,i)===-1&&n.indexOf("data")===-1||o.attr(n,r)}),s},i.destroy=function(t){var e=this;return e._destroySelectBoxIt(),e.widgetProto.destroy.call(e),e._callbackSupport(t),e},i._destroySelectBoxIt=function(){var e=this;return e.dropdown.off(".selectBoxIt"),t.contains(e.dropdownContainer[0],e.originalElem)&&e.dropdownContainer.before(e.selectBox),e.dropdownContainer.remove(),e.selectBox.removeAttr("style").attr("style",e.selectBoxStyles),e.triggerEvent("destroy"),e},i.disable=function(t){var e=this;return e.options.disabled||(e.close(),e.selectBox.attr("disabled","disabled"),e.dropdown.removeAttr("tabindex").removeClass(e.theme.enabled).addClass(e.theme.disabled),e.setOption("disabled",!0),e.triggerEvent("disable")),e._callbackSupport(t),e},i.disableOption=function(e,o){var s,i,n,r=this,a=t.type(e);return"number"===a&&(r.close(),s=r.selectBox.find("option").eq(e),r.triggerEvent("disable-option"),s.attr("disabled","disabled"),r.listItems.eq(e).attr("data-disabled","true").addClass(r.theme.disabled),r.currentFocus===e&&(i=r.listItems.eq(r.currentFocus).nextAll("li").not("[data-disabled='true']").first().length,n=r.listItems.eq(r.currentFocus).prevAll("li").not("[data-disabled='true']").first().length,i?r.moveDown():n?r.moveUp():r.disable())),r._callbackSupport(o),r},i._isDisabled=function(t){var e=this;return e.originalElem.disabled&&e.disable(),e},i._dynamicPositioning=function(){var e=this;if("number"===t.type(e.listSize))e.list.css("max-height",e.maxHeight||"none");else{var o=e.dropdown.offset().top,s=e.list.data("max-height")||e.list.outerHeight(),i=e.dropdown.outerHeight(),n=e.options.viewport,r=n.height(),a=t.isWindow(n.get(0))?n.scrollTop():n.offset().top,l=o+i+s<=r+a,d=!l;if(e.list.data("max-height")||e.list.data("max-height",e.list.outerHeight()),d)if(e.dropdown.offset().top-a>=s)e.list.css("max-height",s),e.list.css("top",e.dropdown.position().top-e.list.outerHeight());else{var c=Math.abs(o+i+s-(r+a)),u=Math.abs(e.dropdown.offset().top-a-s);c<u?(e.list.css("max-height",s-c-i/2),e.list.css("top","auto")):(e.list.css("max-height",s-u-i/2),e.list.css("top",e.dropdown.position().top-e.list.outerHeight()))}else e.list.css("max-height",s),e.list.css("top","auto")}return e},i.enable=function(t){var e=this;return e.options.disabled&&(e.triggerEvent("enable"),e.selectBox.removeAttr("disabled"),e.dropdown.attr("tabindex",0).removeClass(e.theme.disabled).addClass(e.theme.enabled),e.setOption("disabled",!1),e._callbackSupport(t)),e},i.enableOption=function(e,o){var s,i=this,n=t.type(e);return"number"===n&&(s=i.selectBox.find("option").eq(e),i.triggerEvent("enable-option"),s.removeAttr("disabled"),i.listItems.eq(e).attr("data-disabled","false").removeClass(i.theme.disabled)),i._callbackSupport(o),i},i.moveDown=function(t){var e=this;e.currentFocus+=1;var o="true"===e.listItems.eq(e.currentFocus).attr("data-disabled"),s=e.listItems.eq(e.currentFocus).nextAll("li").not("[data-disabled='true']").first().length;if(e.currentFocus===e.listItems.length)e.currentFocus-=1;else{if(o&&s)return e.listItems.eq(e.currentFocus-1).blur(),void e.moveDown();o&&!s?e.currentFocus-=1:(e.listItems.eq(e.currentFocus-1).blur().end().eq(e.currentFocus).focusin(),e._scrollToView("down"),e.triggerEvent("moveDown"))}return e._callbackSupport(t),e},i.moveUp=function(t){var e=this;e.currentFocus-=1;var o="true"===e.listItems.eq(e.currentFocus).attr("data-disabled"),s=e.listItems.eq(e.currentFocus).prevAll("li").not("[data-disabled='true']").first().length;if(e.currentFocus===-1)e.currentFocus+=1;else{if(o&&s)return e.listItems.eq(e.currentFocus+1).blur(),void e.moveUp();o&&!s?e.currentFocus+=1:(e.listItems.eq(this.currentFocus+1).blur().end().eq(e.currentFocus).focusin(),e._scrollToView("up"),e.triggerEvent("moveUp"))}return e._callbackSupport(t),e},i._setCurrentSearchOption=function(t){var e=this;return(e.options.aggressiveChange||e.options.selectWhenHidden||e.listItems.eq(t).is(":visible"))&&e.listItems.eq(t).data("disabled")!==!0&&(e.listItems.eq(e.currentFocus).blur(),e.currentIndex=t,e.currentFocus=t,e.listItems.eq(e.currentFocus).focusin(),e._scrollToView("search"),e.triggerEvent("search")),e},i._searchAlgorithm=function(t,e){var o,s,i,n,r=this,a=!1,l=r.textArray,d=r.currentText;for(o=t,i=l.length;o<i;o+=1){for(n=l[o],s=0;s<i;s+=1)l[s].search(e)!==-1&&(a=!0,s=i);if(a||(r.currentText=r.currentText.charAt(r.currentText.length-1).replace(/[|()\[{.+*?$\\]/g,"\\$0"),d=r.currentText),e=new RegExp(d,"gi"),d.length<3){if(e=new RegExp(d.charAt(0),"gi"),n.charAt(0).search(e)!==-1)return r._setCurrentSearchOption(o),(n.substring(0,d.length).toLowerCase()!==d.toLowerCase()||r.options.similarSearch)&&(r.currentIndex+=1),!1}else if(n.search(e)!==-1)return r._setCurrentSearchOption(o),!1;if(n.toLowerCase()===r.currentText.toLowerCase())return r._setCurrentSearchOption(o),r.currentText="",!1}return!0},i.search=function(t,e,o){var s=this;o?s.currentText+=t.replace(/[|()\[{.+*?$\\]/g,"\\$0"):s.currentText=t.replace(/[|()\[{.+*?$\\]/g,"\\$0");var i=s._searchAlgorithm(s.currentIndex,new RegExp(s.currentText,"gi"));return i&&s._searchAlgorithm(0,s.currentText),s._callbackSupport(e),s},i._updateMobileText=function(){var t,e,o,s=this;t=s.selectBox.find("option").filter(":selected"),e=t.attr("data-text"),o=e?e:t.text(),s._setText(s.dropdownText,o),s.list.find('li[data-val="'+t.val()+'"]').find("i").attr("class")&&s.dropdownImage.attr("class",s.list.find('li[data-val="'+t.val()+'"]').find("i").attr("class")).addClass("selectboxit-default-icon")},i._applyNativeSelect=function(){var t=this;return t.dropdownContainer.append(t.selectBox),t.dropdown.attr("tabindex","-1"),t.selectBox.css({display:"block",visibility:"visible",width:t._realOuterWidth(t.dropdown),height:t.dropdown.outerHeight(),opacity:"0",position:"absolute",top:"0",left:"0",cursor:"pointer","z-index":"999999",margin:t.dropdown.css("margin"),padding:"0","-webkit-appearance":"menulist-button"}),t.originalElem.disabled&&t.triggerEvent("disable"),this},i._mobileEvents=function(){var t=this;t.selectBox.on({"changed.selectBoxIt":function(){t.hasChanged=!0,t._updateMobileText(),t.triggerEvent("option-click")},"mousedown.selectBoxIt":function(){t.hasChanged||!t.options.defaultText||t.originalElem.disabled||(t._updateMobileText(),t.triggerEvent("option-click"))},"enable.selectBoxIt":function(){t.selectBox.removeClass("selectboxit-rendering")},"disable.selectBoxIt":function(){t.selectBox.addClass("selectboxit-rendering")}})},i._mobile=function(t){var e=this;return e.isMobile&&(e._applyNativeSelect(),e._mobileEvents()),this},i.remove=function(e,o){var s,i,n=this,r=t.type(e),a=0,l="";if("array"===r){for(i=e.length;a<=i-1;a+=1)s=e[a],"number"===t.type(s)&&(l+=l.length?", option:eq("+s+")":"option:eq("+s+")");n.selectBox.find(l).remove()}else"number"===r?n.selectBox.find("option").eq(e).remove():n.selectBox.find("option").remove();return n.dropdown?n.refresh(function(){n._callbackSupport(o)},!0):n._callbackSupport(o),n},i.selectOption=function(e,o){var s=this,i=t.type(e);return"number"===i?s.selectBox.val(s.selectItems.eq(e).val()).change():"string"===i&&s.selectBox.val(e).change(),s._callbackSupport(o),s},i.setOption=function(e,o,s){var i=this;return"string"===t.type(e)&&(i.options[e]=o),i.refresh(function(){i._callbackSupport(s)},!0),i},i.setOptions=function(e,o){var s=this;return t.isPlainObject(e)&&(s.options=t.extend({},s.options,e)),s.refresh(function(){s._callbackSupport(o)},!0),s},i.wait=function(t,e){var o=this;return o.widgetProto._delay.call(o,e,t),o}});