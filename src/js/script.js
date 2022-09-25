
// (function($) {
//     var sections = [];
//     var id = false;
//     var $navbara = $('#scrollEffect a');

//     $navbara.click(function(e) {
//         e.preventDefault();
//         $('html, body').animate({
//             scrollTop: $($(this).attr('href')).offset().top - 0
//         }, 80);
//         hash($(this).attr('href'));
//     });



//     $navbara.each(function() {
//         if ($($(this).attr('href')).length != 0) {
//             sections.push($($(this).attr('href')));
//         }

//     })

//     $(window).scroll(function(e) {
//         var scrollTop = $(this).scrollTop() + ($(window).height() / 2);
//         for (var i in sections) {
//             var section = sections[i];
//             if (scrollTop > section.offset().top) {
//                 var scrolled_id = section.attr('id');
//             }
//         }

//         if (scrollTop > section.offset().top) {
//             var scrolled_id = section.attr('id');
//         }
//         if (scrolled_id !== id) {
//             id = scrolled_id;
//             for (let i = 0; i < $($navbara).length; i++) {
//                 let parentRemove = $($navbara)[i].parentElement;
//                 parentRemove.classList.remove('active');
//             }
//             let gooIndex = document.getElementById('goo-index');
//             let parentSpan = $('#scrollEffect a[href="#' + id + '"]')['0'].parentElement;
//             let indexId = $('#scrollEffect a[href="#' + id + '"]')[0].id;
//             gooIndex.style.top = 60 * indexId[indexId.length - 1] + 'px';
//             parentSpan.classList.add('active');
//             parentSpan.click();

//         }
//     })
// })(jQuery);

