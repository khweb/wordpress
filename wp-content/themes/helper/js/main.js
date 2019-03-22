
jQuery(function($){ 

//Карусель готовые решения    
  $('.solutions-carousel').owlCarousel({
      margin:5,
      nav:true,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:3
          },
          1000:{
              items:4
          }
      }
  }); 

//Карусель наши работы
  $('.portfolio-carousel').owlCarousel({
      margin:1,
      nav:true,
      items:1
      
  });

//Скрол в начало
  $('#my-scroll-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });

//Модальное окно 1
  $('.popap-1').click(function(e) {
    e.preventDefault();
    $('#popap-1').bPopup({
          speed: 650,
          transition: 'slideIn',
          transitionClose: 'slideBack'
    });
  });



//Ajax perpage
  $('.perpage a').click(function(e){
        e.preventDefault();
        

        $('.device-grid ').addClass('opacityFx');

        setTimeout(function () { 
          $('.device-grid ').removeClass('opacityFx');
        }, 1000);

        var page_id = $(this).data('id'); 
        var per_page = $(this).data('page'); 
        var key = $(this).data('key');

        if ( per_page == '24') {
          $('a.load-more').addClass('show_less');
          $('a.load-more').data('page' , '6');
        } else {
          $('a.load-more').removeClass('show_less');
          $('a.load-more').data('page' , '24');
        }

        var val = $('.sort .value');
        val.html(per_page); 

        //console.log(page_id, per_page, key);
        
        $.ajax({
            type: "POST",
            url: window.wp_data.ajax_url,
            data : {
                action: 'get_product',
                page_id : page_id,
                per_page : per_page,
                key : key
            },
            success: function (data) {
                
                $('.device-grid').html(data);
            }
        });
  });

  $('a.load-more').click(function(e){
        e.preventDefault();

        $attr = $(this).data('page');

        if ($attr == 6) {
          
          $('.pager-6').click();
          $(this).data('page' , '24');
        }

        if ($attr == 24) {
          $('.pager-24').click();
          $(this).data('page' , '6');
          
        }

        if ($('.sort-arrow .value').text() == '24') {
          $('a.load-more').addClass('show_less');
        } else {
          $('a.load-more').removeClass('show_less');
        }


    });



  

}); 


jQuery(document).ready(function($){

  //console.log('js is ready master!');

}); 






