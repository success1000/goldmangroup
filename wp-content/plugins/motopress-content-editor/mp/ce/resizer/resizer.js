steal("jquery/class",function($){$.Class("CE.Resizer",{myThis:null},{minHeight:30,spaceMinHeight:10,gmapMinHeight:150,handle:null,addedStyleProperties:["position","top","left","width","height","background-position","background-repeat"],emptySpan:$("<div />",{"class":"motopress-span motopress-empty mp-hidden-phone"}),splitter:$("<div />",{"class":"motopress-splitter"}),oldWidth:null,emptySpanNumber:0,init:function(){CE.Resizer.myThis=this;$(window).on("resize",function(e){if(e.target===this){CE.Resizer.myThis.proxy("updateHandle")}})},getMinHeight:function(obj){var shortcode=obj.find(".motopress-block-content > [data-motopress-shortcode]");if(shortcode.length){var shortcodeName=shortcode.attr("data-motopress-shortcode");if(shortcodeName===CE.LeftBar.myThis.library.other.objects.mp_gmap.id){return this.gmapMinHeight}}return(obj.hasClass(CE.DragDrop.myThis.spaceClass))?this.spaceMinHeight:this.minHeight},makeResizable:function(obj){var $this=this;var rowWidthPiece=obj.parent(".mp-row-fluid.motopress-row").width()/100;var colWidth=rowWidthPiece*CE.Grid.myThis.columnWidthPiece;var colMargin=rowWidthPiece*CE.Grid.myThis.columnMarginPiece;var gridX=colWidth+colMargin;var colHalfWidth=Math.round(colWidth/4);colHalfWidth=(colHalfWidth<colWidth)?colHalfWidth:0;obj.not("[data-motopress-wrapper-id], .motopress-empty").each(function(){$(this).resizable({grid:[gridX,10],handles:"e, s, w, se, sw",helper:false,minWidth:colWidth-colHalfWidth,minHeight:CE.Resizer.myThis.getMinHeight($(this)),zIndex:1002,create:function(){$(this).resizable("option","maxWidth",$(this).width());$(this).children(".ui-resizable-handle").hide()},start:function(e,ui){CE.LeftBar.myThis.disable();$this.hideSplitters();$this.hideEmptySpans();$(".motopress-content-wrapper > .motopress-handle-middle-in:last").height("");$(this).find(".motopress-handle-bottom-in").css({bottom:"",height:""});if(CE.Dialog.myThis.element.dialog("isOpen")){CE.Dialog.myThis.element.dialog("close")}CE.Resizer.myThis.handle=$(e.originalEvent.target);$this.oldWidth=ui.originalSize.width;var handleClass=parent.MP.Utils.getHandleClass(CE.Resizer.myThis.handle.prop("class").split(" "));var empty=null,emptySpanWidth=0;if(handleClass==="ui-resizable-e"||handleClass==="ui-resizable-se"){empty=ui.element.next(".motopress-empty")}else{empty=ui.element.prev(".motopress-empty")}var spanClass=parent.MP.Utils.getSpanClass(ui.element.prop("class").split(" "));var spanNumber=parent.MP.Utils.getSpanNumber(spanClass);var emptySpanNumber=0;if(empty&&empty.length){var emptySpanClass=parent.MP.Utils.getSpanClass(empty.prop("class").split(" "));emptySpanNumber=parent.MP.Utils.getSpanNumber(emptySpanClass);emptySpanWidth=empty.width()}CE.Resizer.myThis.maxSpanNumber=spanNumber+emptySpanNumber;ui.element.resizable("option","maxWidth",ui.element.width()+emptySpanWidth+gridX/2);CE.Resizer.myThis.handle.addClass("motopress-resizable-handle-hover");ui.element.css({position:"relative",top:0,left:0});if(!$(this).parent(".motopress-content-wrapper > .mp-row-fluid.motopress-row").length){var handleMiddleLast=$(this).parent(".mp-row-fluid.motopress-row").nextAll(".motopress-handle-middle-in:last");var minHeight=parseInt(handleMiddleLast.css("min-height"));handleMiddleLast.height(minHeight)}},stop:function(e,ui){CE.LeftBar.myThis.enable();$this.showSplitters();$this.showEmptySpans();CE.Resizer.myThis.handle.removeClass("motopress-resizable-handle-hover");var resetAddedStyleProperties={};for(var i=0;i<CE.Resizer.myThis.addedStyleProperties.length;i++){resetAddedStyleProperties[CE.Resizer.myThis.addedStyleProperties[i]]=""}ui.element.css(resetAddedStyleProperties);if($(this).hasClass("ce_controls")&&!CE.Dialog.myThis.element.dialog("isOpen")){var dragHandle=ui.element.find(".motopress-drag-handle");CE.Dialog.myThis.open(dragHandle)}var prevEmptySpan=ui.element.prev(".motopress-empty");var nextEmptySpan=ui.element.next(".motopress-empty");CE.DragDrop.myThis.makeEditableEmptySpan(prevEmptySpan.add(nextEmptySpan));$this.updateSplittableOptions(prevEmptySpan,null,null);$this.updateSplittableOptions(nextEmptySpan,null,null);CE.Resizer.myThis.updateBottomInHandleMiddle();CE.Resizer.myThis.updateSplitterHeight(obj,"resize");CE.Resizer.myThis.updateHandle();parent.CE.Save.changeContent()},resize:function(e,ui){var handleClass=parent.MP.Utils.getHandleClass(CE.Resizer.myThis.handle.prop("class").split(" "));switch(handleClass){case"ui-resizable-s":CE.Resizer.myThis.verticalResize(ui);break;case"ui-resizable-w":CE.Resizer.myThis.horizontalResize(handleClass,ui,gridX);break;case"ui-resizable-e":CE.Resizer.myThis.horizontalResize(handleClass,ui,gridX);break;case"ui-resizable-sw":CE.Resizer.myThis.verticalResize(ui);CE.Resizer.myThis.horizontalResize(handleClass,ui,gridX);break;case"ui-resizable-se":CE.Resizer.myThis.verticalResize(ui);CE.Resizer.myThis.horizontalResize(handleClass,ui,gridX);break}}});var shortcode=$(this).find(".motopress-block-content > [data-motopress-shortcode]");if(shortcode.length){var resize=shortcode.attr("data-motopress-resize");if(typeof resize==="undefined"){var groupName=shortcode.attr("data-motopress-group");var shortcodeName=shortcode.attr("data-motopress-shortcode");resize=CE.LeftBar.myThis.library[groupName].objects[shortcodeName].resize}switch(resize){case"none":$(this).children(".ui-resizable-handle").addClass("motopress-hide");break;case"horizontal":$(this).children('.ui-resizable-handle:not(".ui-resizable-e, .ui-resizable-w")').addClass("motopress-hide");break;case"vertical":$(this).children('.ui-resizable-handle:not(".ui-resizable-s")').addClass("motopress-hide");break}}})},horizontalResize:function(handleClass,ui,gridX){var newSpanWidth=ui.size.width;ui.element.css({top:0,left:0});if(newSpanWidth!==this.oldWidth){var empty=null,direction;var originalSpanClass=parent.MP.Utils.getSpanClass(ui.element.prop("class").split(" "));var originalSpanNumber=parent.MP.Utils.getSpanNumber(originalSpanClass);var oldSpanNumber=Math.round(this.oldWidth/gridX);var newSpanNumber=Math.round(newSpanWidth/gridX);var diff=newSpanNumber-oldSpanNumber;if(originalSpanNumber+diff<=this.maxSpanNumber){ui.element.removeClass(originalSpanClass).addClass("mp-span"+(originalSpanNumber+diff));if(handleClass==="ui-resizable-e"||handleClass==="ui-resizable-se"){direction="east";empty=ui.element.next(".motopress-empty")}else{direction="west";empty=ui.element.prev(".motopress-empty")}if(empty&&empty.length){var originalEmptyClass=parent.MP.Utils.getSpanClass(empty.prop("class").split(" "));var originalEmptyNumber=parent.MP.Utils.getSpanNumber(originalEmptyClass);if(diff<originalEmptyNumber){empty.removeClass(originalEmptyClass).addClass("mp-span"+(originalEmptyNumber-diff))}else{empty.remove()}}else{var emptySpanClone=CE.Resizer.myThis.emptySpan.clone();emptySpanClone.addClass("mp-span"+Math.abs(diff)).addClass("motopress-empty-hide");if(direction==="east"){ui.element.after(emptySpanClone)}else{ui.element.before(emptySpanClone)}}ui.element.css({width:""});this.oldWidth=newSpanWidth}}},verticalResize:function(ui){var minHeight=parseInt(ui.element.css("min-height"));if(minHeight===ui.element.height()){ui.element.css("min-height","")}var newSpanHeight=ui.element.height();ui.element.css("min-height",newSpanHeight)},makeSplittable:function(obj){if(!obj.length){return false}var $this=this;var splitter=(obj.hasClass("motopress-splitter"))?obj:obj.find(".motopress-splitter");var oldUIPosLeft,removableBlock,triggerStop,area;var rowWidthPiece=obj.closest(".mp-row-fluid.motopress-row").width()/100;var colWidth=rowWidthPiece*CE.Grid.myThis.columnWidthPiece;var colMargin=rowWidthPiece*CE.Grid.myThis.columnMarginPiece;var gridX=Math.round(colWidth+colMargin);splitter.draggable({axis:"x",cursor:"col-resize",grid:[gridX,0],helper:"clone",zIndex:1,start:function(e,ui){ui.helper.hide();$this.hideSplitters($(this));$this.hideEmptySpans();$(".motopress-content-wrapper > .motopress-handle-middle-in:last").height("");oldUIPosLeft=null,triggerStop=false,area=false;CE.LeftBar.myThis.disable();$(this).addClass("motopress-splitter-hover");if(CE.Dialog.myThis.element.dialog("isOpen")){CE.Dialog.myThis.element.dialog("close")}ui.helper.closest(".mp-row-fluid.motopress-row").find(".motopress-drag-handle").css("cursor","col-resize")},stop:function(e,ui){CE.LeftBar.myThis.enable();$this.showSplitters();$this.showEmptySpans();ui.helper.closest(".mp-row-fluid.motopress-row").find(".motopress-drag-handle").css("cursor","move");$(this).removeClass("motopress-splitter-hover");var currentBlock=$(this).closest('[class*="mp-span"].motopress-span');CE.Resizer.myThis.updateBottomInHandleMiddle();CE.Resizer.myThis.updateSplitterHeight(currentBlock,"split");CE.Resizer.myThis.updateSplittableOptions(currentBlock,null,null,"split");CE.Resizer.myThis.updateHandle();if(triggerStop&&removableBlock.length){removableBlock.remove()}parent.CE.Save.changeContent()},drag:function(e,ui){var curUIPosLeft=ui.offset.left;if(oldUIPosLeft===null){oldUIPosLeft=curUIPosLeft}if(curUIPosLeft!==oldUIPosLeft){triggerStop=false;var currentBlock=$(this).closest('[class*="mp-span"].motopress-span');var nextBlock=currentBlock.prev('[class*="mp-span"].motopress-span');var curBlockOldSpan=parent.MP.Utils.getSpanNumber(parent.MP.Utils.getSpanClass(currentBlock.prop("class").split(" ")));var nextBlockOldSpan=parent.MP.Utils.getSpanNumber(parent.MP.Utils.getSpanClass(nextBlock.prop("class").split(" ")));var curBlockLeft=currentBlock.offset().left;var curBlockWidth=currentBlock.width();var nextBlockLeft=nextBlock.offset().left;var condition;if(area){condition=(curUIPosLeft>=(nextBlockLeft+gridX)&&curUIPosLeft<=(curBlockLeft+curBlockWidth-gridX))}else{condition=(curUIPosLeft>=nextBlockLeft&&curUIPosLeft<=(curBlockLeft+curBlockWidth+colMargin))}if(condition){area=false;if(curUIPosLeft>oldUIPosLeft){if(curBlockOldSpan<=1){if(currentBlock.hasClass("motopress-empty")){removableBlock=currentBlock;triggerStop=true;nextBlock.removeClass("mp-span"+nextBlockOldSpan).addClass("mp-span"+(nextBlockOldSpan+1))}}else{currentBlock.removeClass("mp-span"+curBlockOldSpan).addClass("mp-span"+(curBlockOldSpan-1));nextBlock.removeClass("mp-span"+nextBlockOldSpan).addClass("mp-span"+(nextBlockOldSpan+1))}}else{if(curUIPosLeft<oldUIPosLeft){if(nextBlockOldSpan<=1){if(nextBlock.hasClass("motopress-empty")){removableBlock=nextBlock;triggerStop=true;currentBlock.removeClass("mp-span"+curBlockOldSpan).addClass("mp-span"+(curBlockOldSpan+1))}}else{currentBlock.removeClass("mp-span"+curBlockOldSpan).addClass("mp-span"+(curBlockOldSpan+1));nextBlock.removeClass("mp-span"+nextBlockOldSpan).addClass("mp-span"+(nextBlockOldSpan-1))}}}}else{area=true;if(curUIPosLeft>(curBlockLeft+curBlockWidth-gridX)){if(currentBlock.hasClass("motopress-empty")){removableBlock=currentBlock;triggerStop=true;nextBlock.removeClass("mp-span"+nextBlockOldSpan).addClass("mp-span"+(curBlockOldSpan+nextBlockOldSpan))}else{currentBlock.removeClass("mp-span"+curBlockOldSpan).addClass("mp-span1");nextBlock.removeClass("mp-span"+nextBlockOldSpan).addClass("mp-span"+(nextBlockOldSpan+curBlockOldSpan-1))}}else{if(curUIPosLeft<(nextBlockLeft+gridX)){if(nextBlock.hasClass("motopress-empty")){removableBlock=nextBlock;triggerStop=true;currentBlock.removeClass("mp-span"+curBlockOldSpan).addClass("mp-span"+(curBlockOldSpan+nextBlockOldSpan))}else{currentBlock.removeClass("mp-span"+curBlockOldSpan).addClass("mp-span"+(curBlockOldSpan+nextBlockOldSpan-1));nextBlock.removeClass("mp-span"+nextBlockOldSpan).addClass("mp-span1")}}}}oldUIPosLeft=curUIPosLeft;var rowHeight=$(this).closest(".mp-row-fluid").height();$(this).height(rowHeight);if(triggerStop){e.preventDefault()}}}})},calcSplitterOptions:function(obj,type){var elements=null;var rowWidth=null;var spanWidth=null;var spanMargin=null;var spanWidthMargin=null;var splitter=null;var splitterWidth=null;var splitterMargin=null;if(type==="column"){rowWidth=obj.parent(".mp-row-fluid.motopress-row").width();elements=obj}else{if(type==="row"){rowWidth=obj.width();elements=obj.children('[class*="mp-span"].motopress-span')}else{return false}}var rowWidthPiece=rowWidth/100;spanWidth=rowWidthPiece*CE.Grid.myThis.columnWidthPiece;spanMargin=rowWidthPiece*CE.Grid.myThis.columnMarginPiece;spanWidthMargin=spanWidth+spanMargin;splitterWidth=rowWidthPiece*CE.Grid.myThis.splitterWidthPiece+spanMargin;splitterMargin=-(rowWidthPiece*CE.Grid.myThis.splitterMarginPiece+spanMargin/2);elements.each(function(){splitter=$(this).find(".motopress-helper > .motopress-splitter");CE.Resizer.myThis.makeSplittable(splitter);splitter.width(splitterWidth);splitter.css("margin-left",splitterMargin+"px");if(!$(this).children(".mp-row-fluid.motopress-row").length){CE.Resizer.myThis.makeResizable($(this))}})},updateSplittableOptions:function(block,rowFrom,rowTo,action){if(typeof action==="undefined"){action="default"}if(action==="init"||action==="split"){var rows=null;if(action==="init"){rows=$(".motopress-content-wrapper .mp-row-fluid.motopress-row")}else{if(action==="split"){var necessaryRow=block.parents(".mp-row-fluid.motopress-row, .motopress-content-wrapper").eq(-2);if(typeof necessaryRow!=="undefined"){rows=$.merge($.merge([],necessaryRow),necessaryRow.find(".mp-row-fluid.motopress-row"))}}}if(rows&&typeof rows!=="undefined"){$.each(rows,function(){CE.Resizer.myThis.calcSplitterOptions($(this),"row")})}}else{if(block){this.calcSplitterOptions(block,"column")}if(rowFrom){$.each($.merge($.merge([],rowFrom),rowFrom.find(".mp-row-fluid.motopress-row")),function(){CE.Resizer.myThis.calcSplitterOptions($(this),"row")})}if(rowTo){$.each($.merge($.merge([],rowTo),rowTo.find(".mp-row-fluid.motopress-row")),function(){CE.Resizer.myThis.calcSplitterOptions($(this),"row")})}}},updateSplitterHeight:function(obj,action){var t=setTimeout(function(){var necessaryRow=null;necessaryRow=$(".motopress-content-wrapper .mp-row-fluid.motopress-row");$.each(necessaryRow.get().reverse(),function(){var spans=$(this).children('[class*="span"].motopress-span');var emptySpanHeight=Math.max.apply(Math,spans.not(".motopress-empty").map(function(){return $(this).height()}).get());spans.filter(".motopress-empty").height(emptySpanHeight)});$.each(necessaryRow,function(){var spans=$(this).children('[class*="span"].motopress-span');var spanMargin=$(this).width()/100*CE.Grid.myThis.columnMarginPiece;spans.find(".motopress-splitter").height($(this).height());spans.find(".motopress-handle-intermediate").css({width:spanMargin,height:$(this).height(),left:-spanMargin})});clearTimeout(t)},50)},hideSplitters:function(exclude){exclude=(typeof exclude==="undefined")?exclude=false:exclude;var splitters=$('.motopress-content-wrapper [class*="mp-span"] .motopress-splitter');if(!exclude){splitters.addClass("motopress-hide")}else{splitters.not(exclude).addClass("motopress-hide")}},showSplitters:function(){$('.motopress-content-wrapper [class*="mp-span"] .motopress-splitter').removeClass("motopress-hide")},hideEmptySpans:function(){$('.motopress-content-wrapper [class*="mp-span"].motopress-empty').addClass("motopress-empty-hide").height(1)},showEmptySpans:function(){$('.motopress-content-wrapper [class*="mp-span"].motopress-empty').removeClass("motopress-empty-hide")},updateHandle:function(){var t=setTimeout(function(){if(!CE.DragDrop.myThis.isEmptyScene()){var spanOffset=$('.motopress-content-wrapper [class*="span"].motopress-span:first').offset();var leftBarWidth=CE.LeftBar.myThis.leftBar.width();var handleWrapperWidth=$(".motopress-handle-wrapper-left:first, .motopress-handle-wrapper-right:first").width();var handleOffset=spanOffset.left-leftBarWidth-(parent.CE.Navbar.myThis.scrollWidth/2);var handleWidth=handleOffset-handleWrapperWidth;$(".motopress-content-wrapper > .mp-row-fluid.motopress-row").each(function(){var handleHeight=$(this).height();$(this).children('[class*="span"].motopress-span:first, [class*="span"].motopress-span:last').each(function(){$(this).children(".motopress-wrapper-helper, .motopress-helper").each(function(){var width=($(this).hasClass("motopress-wrapper-helper"))?handleWidth:handleOffset;$(this).find(".motopress-handle-left, .motopress-handle-right").each(function(){var side=($(this).hasClass("motopress-handle-left"))?"left":"right";var properties={width:width,height:handleHeight};properties[side]=-handleOffset;$(this).css(properties)})})})});var container=$("#motopress-container");var handleMiddleWidth=container.parent().width()-parent.CE.Navbar.myThis.scrollWidth;var handleMiddleFirst=$(".motopress-content-wrapper > .motopress-handle-middle-in:first");var handleMiddleLast=$(".motopress-content-wrapper > .motopress-handle-middle-in:last");var handleMiddlePrevLast=handleMiddleLast.prevAll(".motopress-handle-middle-in:first");if(handleMiddlePrevLast[0]!==handleMiddleFirst[0]){handleMiddlePrevLast.css({width:"",left:"",height:""})}var htmlHeight=$("html").height();var containerTop=parseInt(container.css("top"));var handleMiddleLastHeight=htmlHeight-handleMiddleLast.offset().top;if(htmlHeight<containerTop+container.outerHeight(true)){handleMiddleLastHeight+=containerTop}handleMiddleFirst.css({width:handleMiddleWidth,left:-handleOffset});handleMiddleLast.css({width:handleMiddleWidth,left:-handleOffset,height:handleMiddleLastHeight});var handleMoreDisable=$(".motopress-content-wrapper > .motopress-handle-more-disable");handleMoreDisable.css({width:handleMiddleWidth,left:-handleOffset})}clearTimeout(t)},50)},updateBottomInHandleMiddle:function(){var t=setTimeout(function(){if(!CE.DragDrop.myThis.isEmptyScene()){$(".motopress-content-wrapper > .mp-row-fluid.motopress-row").each(function(){CE.Resizer.myThis.setHandleHeight($(this))})}clearTimeout(t)},50)},setHandleHeight:function(row){var minHeight=parseInt(row.find(".motopress-handle-middle-in:last").css("min-height"));row.find(".motopress-handle-middle-in").each(function(){$(this).height(minHeight)});row.children('[class*="span"].motopress-span:not(".motopress-empty")').each(function(){var childRow=$(this).children(".mp-row-fluid.motopress-row");var rowHeight=null;var spanHeight=null;var minHeight=null;var space=0;var height=null;if(childRow.length){var handleMiddleLast=$(this).children(".motopress-handle-middle-in:last");minHeight=parseInt(handleMiddleLast.css("min-height"));rowHeight=row.height();spanHeight=$(this).height();if(spanHeight<rowHeight){space=rowHeight-spanHeight}height=space+minHeight;handleMiddleLast.height(height);childRow.each(function(){CE.Resizer.myThis.setHandleHeight($(this))})}else{var bottomIn=$(this).find(".motopress-handle-bottom-in");minHeight=parseInt(bottomIn.css("min-height"));rowHeight=row.height();spanHeight=$(this).height();if(spanHeight<rowHeight){space=rowHeight-spanHeight}height=space+minHeight;bottomIn.css({bottom:-space,height:height})}})}})});