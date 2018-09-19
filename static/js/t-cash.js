/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2015-12-23 17:34:59
 * @version $Id$
 */

 // 弹框高度封装
function alertH(id){
	var a=$(id).height();
    $(id).css({'marginTop':-a/2});  
}


$(function(){
	alertH("#t-bomb_box");
$(".form-control").each(function(){
			var $span = $(this).next(".t-icon-close");//删除按钮
			$(this).bind('input propertychange', function() { 
 				if($(this).val()!=''){
					$span.fadeIn();
				}
			}).blur(function(){
					if($(this).val()!=''){
						var $input = $(this);
						$span.click(function(){
							$input.val("").focus();
							setTimeout(function(){
								$span.fadeOut()
							},1000)
						});
						setTimeout(function(){
							if($("input").not($(this))){
								$span.fadeOut()
							}
						},1000);
					}else{
						$span.fadeOut();
					};

				
			});
		});

})

// input关闭封装

//  $("#t-input").focus(function(){
//   $("#t-icon-close").addClass("t-icon-close");
//   $("#t-icon-close").click(function(){
//   	 $(this).val("");  
//   })

//   } 

//  }).blur(function(){
// 	 $("#t-icon-close").removeClass("t-icon-close");
//      }
// });
