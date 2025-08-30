$(function(){
    'use strict';
    $('.toggel-info').click(function(){
        $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);
        if($(this).hasClass('selected')){
            $(this).html('<i class="fa fa-minus"></i>')
        }else{
            $(this).html('<i class="fa fa-plus"></i>')
        }
    })
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
    var passField=$('.password');
    $('.show-pass').hover(function(){
    passField.attr('type','text')
    },function(){
    passField.attr('type','password')
    })
$('.confirm').click(function(){
    return confirm('Are you sure you want to delete this item?')
});
$('.cat h3').click(function(){
    $(this).nextAll('.full-view').fadeToggle(500);
});
$('.option span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view') === 'full'){
    $('.cat .full-view').fadeIn(200)
    }else{
        $('.cat .full-view').fadeOut(200)
    }
})
   

});
