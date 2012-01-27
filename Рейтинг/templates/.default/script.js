$(function(){
    $('.a_expand').mouseenter(function(){
        $(this).find('.expand').show();
    }).mouseleave(function(){
        $(this).find('.expand').hide();
    });


function RatingPreSet(){
        $('.setratingstars > div.star').bind('mouseenter',function(){
            $(this).addClass("sact").prevAll().addClass("sact");
            $(this).nextAll().removeClass("sact");
        }).bind('mouseleave', function(){
            $('.setratingstars > div.star').removeClass('sact');
        }).click(function(){
            var mark = $(this).prevAll().length + 1;
            var id = parseInt($(this).parents('.ratingContainer').attr('id').replace('rating',''))
            $.ajax({
                url: '/setrating.php?ID='+id+'&MARK='+mark,
                success: function(data){
                    result = $.parseJSON(data);
                    RatingSet(result.RatingSet, result.Rating, id);
                }
            })
        });
    }

    RatingPreSet();
    $('.RatingSet_popup').hide();

    $('.RatingSet_revote').click(function(){
        RatingPreSet();
        var id = parseInt($(this).parents('.ratingContainer').attr('id').replace('rating',''))
        var thisrating = $('#rating'+id);

        thisrating.find('.star, .setratingstars').removeClass('nopointer');
        thisrating.find('.RatingSet_label').text('Проголосовать')
        thisrating.find('.RatingSet_popup').hide();

    })

});

function RatingSet(setmark, rating, id){
     setmark = parseFloat(setmark);
     rating = parseFloat(rating);

    var thisrating = $('#rating'+id);

    thisrating.find('.ratingstars > div.star').removeClass('sact').removeClass('shalf');

    var i=5;var j=0;

    for(; i > 0; i--, j++){
        if(rating > 0.75)
            thisrating.find('.ratingstars > div.star').eq(j).addClass('sact');
        else if(rating > 0.25)
            thisrating.find('.ratingstars > div.star').eq(j).addClass('shalf');
        rating--;
    }

    if(setmark){
        thisrating.find('.setratingstars > div.star').removeClass("sact").eq(setmark - 1).prevAll().addClass("sact");
        thisrating.find('.setratingstars > div.star').eq(setmark -1).addClass("sact");
        thisrating.find('.RatingSet_label').text('Вы проголосовали')
        thisrating.find('.RatingSet_popup').show(300);
        thisrating.find('.setratingstars > div.star').unbind();
        thisrating.find('.star, .setratingstars').addClass('nopointer');
    }

}