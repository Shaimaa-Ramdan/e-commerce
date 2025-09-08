$(function(){
    'use strict';
   
  $('.login-form h1 span').click(function () {
  // ضيفي selected على اللي اتداس عليه
  $(this).addClass('selected').siblings().removeClass('selected');

  // اخفي كل الفورمات
  $('.login-form form').hide();

  // أظهر الفورم المناسب حسب الـ data-class
  $('.' + $(this).data('class')).fadeIn(200);
});
  

   
     $("select").selectBoxIt({
        autoWidth:false
     });
    $('[placeholder]').focus(function(){
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    $('input').each(function(){
       if($(this).attr('required')==='required'){
        $(this).after('<span class="asterisk">*</span>');
       } 
    });
    
$('.confirm').click(function(){
    return confirm('Are you sure you want to delete this item?')
});

 $('.live').keyup(function(){
    $($(this).data('class')).text($(this).val())
 })  
 

});
