/****************************************
 * Plugin for WICart
 ***************************************/
var 	cssfile=document.createElement("link")
  	cssfile.setAttribute("rel", "stylesheet")
	cssfile.setAttribute("type", "text/css")
	cssfile.setAttribute("href", 'wicart.num.css')
	document.getElementsByTagName("head")[0].appendChild(cssfile);
		
/******************************************
 * глобальный префикс для поля ввода кол-ва
 *****************************************/
var wiNumInputPrefID;
 
function WICartNum(cartName, inputClass, prefID)
		{
		wiNumInputPrefID = prefID;	
			
		$("input[type=text]." + inputClass).each(function() 
 				{
 				var inputID = this.id;
 				
 				$( '<div onclick="WICartNumSub(\'' + inputID + '\')" class="' + inputClass + '_downbutton">-</div>' ).insertBefore( this );	
 				$( '<div onclick="WICartNumAdd(\'' + inputID + '\')" class="' + inputClass + '_addbutton">+</div>' ).insertAfter( this );	
 				
 				});

		}

function WICartNumSub(id)
		{
		var errorMessage = 'Недопустимое значение'; 	
		var minValue = parseInt(  $("#" + id).data("min-value")  );	
		var val = parseInt(  $("#" + id).val() );
				val = (val > minValue) ? val-1 : val;
		$("#" + id).val(val);
		WIitemSum(id);
		
		
		}
 
function WICartNumAdd(id)
		{
		var errorMessage = 'Недопустимое значение'; 	
		var maxValue = parseInt(  $("#" + id).data("max-value")  );	
		var val = parseInt(  $("#" + id).val() );
		val = (val < maxValue) ? val+1 : val;
		$("#" + id).val(val);
		WIitemSum(id);
		}

function WIitemSum(id) // num
		{
		
 			var ud = id.substr( id.indexOf("_") + 1 );
 			
 			if($("#wicartitemsum_" + ud).length) 
 				{
 				$("#wicartitemsum_" + ud).html( parseFloat( $("#" + id).val() * parseFloat($("#wicartprice_" + ud).html() ) ) );	
 				}	
		}
		
/**********************************************
 * Иницилизация начальных значений
 **********************************************/
 
 $(document).ready(function(){
 	
 $( ".wicartnum" ).each(function() 
 			{
 			
			WIitemSum(this.id)
 				
 			});	
 	
});