// owlCarousel starts
$(document).ready(function() {
    // Home Banner Slider
    $('.homeBannerSlider').owlCarousel({
        loop: true,
        items: 1,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 1
            },
            991: {
                items: 1
            }
        }
    })

    // Popular Courses Slider
    $('.popCoursesSlider').owlCarousel({
        loop: true,
        items: 1,
        margin: 20,
        nav: true,
        dots: false,
        navText: [
            "<i class='fas fa-angle-left'></i>",
            "<i class='fas fa-angle-right'></i>"
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            991: {
                items: 3
            }
        }
    })

    // Forums Page - Tabs Slider
    $('.tabsSlider').owlCarousel({
        loop: false,
        items: 3,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1,
                stagePadding: 70
            },
            600: {
                items: 3
            },
            991: {
                items: 3
            }
        }
    })

    // Test Page - Tabs Slider
    $('.takeTestSlider').owlCarousel({
        loop: false,
        nav: false,
        margin:5,
        dots: false,
        responsive: {
            0: {
                items: 1,
                stagePadding: 70
            },
            600: {
                items: 3
            },
            991: {
                items: 6
            }
        }
    })

});


// Modal Function
const loginModal = document.getElementById('loginModal');
const registerModal = document.getElementById('registerModal');
const createAccountBtn = document.getElementById('createAccountBtn');
const signInBtn = document.getElementById('signInBtn');

if(createAccountBtn) {
createAccountBtn.addEventListener('click',() => {
    loginModal.style.display = "none";
    loginModal.classList.remove('show');
})
}


if(signInBtn) {
signInBtn.addEventListener('click',() => {
    loginModal.style.display = "block";
    registerModal.style.display = "none";
})
}

/*single course - video iframe modal*/
$(document).ready(function() {
  autoPlayYouTubeModal();
});

function autoPlayYouTubeModal() {
  var trigger = $('.trigger');
  trigger.click(function(e) {
    e.preventDefault();
    var theModal = $(this).data("bs-target");
    var videoSRC = $(this).attr("src");
    var videoSRCauto = videoSRC + "?autoplay=1";
    $(theModal + ' iframe').attr('src', videoSRCauto);
    $(theModal).on('hidden.bs.modal', function(e) {
      $(theModal + ' iframe').attr('src', '');
    });
  });
};

/*single course - video iframe modal Ends*/


// OTP verification 

// let digitValidate = function(ele){
//   console.log(ele.value);
//   ele.value = ele.value.replace(/[^0-9]/g,'');
// }

let tabChange = function(val){
    let ele = document.querySelectorAll('.otp');
    if(ele[val-1].value != ''){
      ele[val].focus()
    }else if(ele[val-1].value == ''){
      ele[val-2].focus()
    }   
 }



