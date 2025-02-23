/*=============== SEARCH ===============*/
const searchButton = document.getElementById('search-button'),
      searchClose = document.getElementById("search-close"),
      searchContent = document.getElementById('search-content')

/*=============== Search Show ========== */
/** Validate if constant exists */
if(searchButton){
    searchButton.addEventListener('click',()=>{
        searchContent.classList.add('show-search')
    })
}
/*=============== Search Hidden ========== */
/** Validate if constant exists */
if(searchClose){
    searchClose.addEventListener('click',()=>{
        searchContent.classList.remove('show-search')
    })
}

var swiper = new Swiper(".default-carousel", {
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: ".swiper-button-prev",
    },
});





/*=============== FEATURED SWIPER ===============*/
let swiperFeatured = new Swiper('.featured__swiper', {
    loop: true,
    spaceBetween: 16,
    grabCursor: true,
    slidesPerView: 'auto',
    centeredSlides: 'auto',

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },

    breakpoints: {
        1150: {
            slidesPerView: 4,
            centeredSlides: false,
        }
    }
  });

/*=============== NEW SWIPER ===============*/
let swiperNew = new Swiper('.new__swiper', {
    loop: true,
    spaceBetween: 16,
    slidesPerView: 'auto',


    breakpoints: {
        1150: {
            slidesPerView: 3,
        }
    }
  });



