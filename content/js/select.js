(function($){
		  
$.fn.extend({

 	subjectStyle1 : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {

			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="select1"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
			});

	  });
	  }
	}
 });



$.fn.extend({

 	selageStyle1 : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {

			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="select2"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
			});

	  });
	  }
	}
 });
		  
 $.fn.extend({

 	countryStyle1 : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {

			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="select3"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
			});

	  });
	  }
	}
 });
 
 $.fn.extend({

 	ageStyle1 : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {

			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="select4"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
			});

	  });
	  }
	}
 });
 
 $.fn.extend({

 	cusStyle1Date : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {

			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="select5"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
			});

	  });
	  }
	}
 });
  
$.fn.extend({

 	cusStyle1Month : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {

			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="select6"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($('option:selected',this).text()).parent().addClass('changed');
			});

	  });
	  }
	}
 });
 
  
})(jQuery);

	

