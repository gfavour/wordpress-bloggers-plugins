jQuery(document).ready(function($){
              var owl = $('.owl-carousel');
              owl.owlCarousel({
                margin: 10,
                nav: false,
                loop: true,
				autoplay:true,
                responsive: {
                  0: {
                    items: 1
                  },
                  600: {
                    items: 3
                  },
                  1000: {
                    items: 3
                  }
                }
              });
			  			  
});

$('[data-toggle="tooltip"]').tooltip(); 
