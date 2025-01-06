jQuery(document).ready(function () {

    /* custom code to open videos on iframe popups if selected option is of url */
    jQuery('.training-item-youtube').magnificPopup({
        //disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });


    /* code open magnific popup with search form */
    // jQuery('.search_top a.elementor-item').magnificPopup({
    //     type:'inline',
    //     midClick: true, // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    //     mainClass: 'mfp-fullscreen' // Adds a class to the root element that allows us to style child element for fullscreen
    // });

    /* custom code to implement pagination on listing of projects */
    var items = jQuery(".summary-table .list-item");
    var numItems = items.length;
    var perPage = 30;
    //console.log(numItems)
    items.slice(perPage).hide();

    jQuery('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            //alert();
            console.log(pageNumber)
            console.log(perPage)
            var showFrom = perPage * (pageNumber - 1);
            // 4 * (2-1) = 4
            console.log(showFrom)
            var showTo = showFrom + perPage;
            // 4 + 4 = 8
            console.log(showTo)
            items.hide().slice(showFrom, showTo).show();
            jQuery('html, body').animate({ scrollTop: jQuery('.table-heading').offset().top - 300 }, 1000);
        }
    });

    /* Custom pagination code to implement on listing of training */
    // var items = jQuery(".events_container .event_box");
    // var numItems = items.length;
    // var perPage = 6;
    // items.slice(perPage).hide();
    // console.log(items);
    // jQuery('#event-pagination').pagination({
    //     items: numItems,
    //     itemsOnPage: perPage,
    //     prevText: "&laquo;",
    //     nextText: "&raquo;",
    //     onPageClick: function (pageNumber) {
    //         var showFrom = perPage * (pageNumber - 1);
    //         var showTo = showFrom + perPage;
    //         items.hide().slice(showFrom, showTo).show();
    //     }
    // });

    var isPopupOpen = false; // Variable to track whether the popup is open
    //Custom functionality to open magnific popup on button click
    // jQuery('#map_view .elementor-widget-container .e-hotspot').magnificPopup({
    //     type: 'ajax',
    //     delegate: '.e-hotspot',
    //     closeOnBgClick: true, // Enable closing on click outside
    //     mainClass: 'custom-maps-layout',
    //     //tClose: '.elementor-widget-container',
    //     callbacks: {
    //         parseAjax: function(mfpResponse) {
    //             mfpResponse.data = jQuery(mfpResponse.data).find('.ajax-content');
    //         },
    //         ajaxContentAdded: function() {
    //             // Additional callbacks or customization after content is added
    //         }
    //     }
    // });

    jQuery('#openHamadNews').on('click', function (e) {
        let newsDetails = jQuery('#alHamadNewsDetails').html();

        var newsSrc = document.createElement('div');
        newsSrc.innerHTML = newsDetails.trim();
        newsSrc.classList.add('ajax-content');

        e.preventDefault();
        jQuery.magnificPopup.open({
            items: {
                src: newsSrc
            },
            mainClass: 'mfp-fade',
            callbacks: {
                beforeOpen: function () {
                    // Disable scrolling when the popup is open
                    jQuery('html').css('overflowY', 'hidden');
                    isPopupOpen = true;
                },
                beforeClose: function () {
                    // Enable scrolling when the popup is closed
                    jQuery('html').css('overflowY', '');

                    isPopupOpen = false;
                },

            }
        });
    });


    jQuery(document).on('click', '.close-popup-hamad', function (e) {
        e.preventDefault();
        jQuery.magnificPopup.close();

    });


    // AJAX request on button click - opening popup with details on indivisual maps
    jQuery('#map_view .elementor-widget-container .e-hotspot').on('click', function (e) {
        e.preventDefault();
        var post_id = jQuery(this).attr('href');
        savedScrollTop = jQuery(window).scrollTop();
        jQuery.ajax({
            type: 'POST',
            url: ArabFundsPublic.ajaxurl,
            data: {
                action: 'fetch_maps',
                post_id: post_id,
                default_lang: ArabFundsPublic.defaultlang
            },
            success: function (response) {
                //alert("trst")
                jQuery.magnificPopup.open({
                    items: {
                        src: '<div class="ajax-content">' + response + '</div>',
                        type: 'inline',


                    },
                    removalDelay: 900,
                    mainClass: 'mfp-fade',
                    callbacks: {
                        beforeOpen: function () {
                            // Disable scrolling when the popup is open
                            jQuery('html').css('overflowY', 'hidden');
                            isPopupOpen = true;
                        },
                        beforeClose: function () {
                            // Enable scrolling when the popup is closed
                            jQuery('html').css('overflowY', '');

                            isPopupOpen = false;
                        },

                    }
                });
            }
        });



    });


    /* Custom code to open training video popups */
    jQuery('.training-item').on('click', function () {
        var videoPath = jQuery(this).data('video-path');
        openVideoPopup(videoPath);
    });

    // Additional check to restore scrolling if the user scrolls while the popup is open
    jQuery(window).on('scroll', function () {
        if (isPopupOpen) {
            jQuery('html, body').scrollTop(savedScrollTop);
        }
    });

    jQuery(document).on('click', '.close-popup', function (e) {
        e.preventDefault();

        // jQuery('.country-card').toggleClass('fadeOut');
        jQuery('.country-card').fadeOut(1000);
        jQuery.magnificPopup.close()

    });



    //Changing country change through dropdown selection
    jQuery(document).on('change', "select[name='country-change']", function () {
        var redirected_url = jQuery(this).val();
        window.location.href = redirected_url;
    });

    //Resetting filter dropdowns based on options changed of project type.
    /*jQuery('input[type=radio][name=arab-project-type]').change(function() {
        jQuery('#arab-sector-filter').prop('selectedIndex', 0);
        jQuery('#arab-country-filter').prop('selectedIndex', 0);
        jQuery('#arab-year-filter').prop('selectedIndex', 0);
    });*/

    //Custom filter projects based on different parameters
    // jQuery(".filter-projects").click(function() {
    //     var countryVal = jQuery("#arab-country-filter").val();
    //     var sectorVal = jQuery("#arab-sector-filter").val();
    //     var yearVal = jQuery("#arab-year-filter").val();

    //     var filter_data = {
    //         'filter_value' : jQuery(this).val(),
    //         'filter_type'  : filter_type,
    //         'filter_selected_type' : selectedType ,
    //         'filter_default_country' : ArabFundsPublic.defaultcountry 
    //     }


    //     jQuery.ajax({
    //         type:"POST",
    //         url : ArabFundsPublic.ajaxurl,
    //         data : {
    //           action: "arab_project_filter",
    //           filter_data:filter_data,

    //         },
    //         success : function(response) {
    //             if ( response.html != ""  ) {
    //                 jQuery(".projects-summary").html(response.html);   
    //             }
    //         }
    //       });



    // });
    /*jQuery(document).on('change',"#arab-year-filter,#arab-sector-filter,#arab-country-filter",function() {
        var selectedFilter = jQuery(this).attr('id');
        var selectedType   = jQuery('input[name="arab-project-type"]:checked').val();
        var filter_type = '';
        if (selectedFilter === 'arab-year-filter') {
            filter_type = 'year';
            //jQuery('#arab-sector-filter').prop('selectedIndex', 0);
            //jQuery('#arab-country-filter').prop('selectedIndex', 0);
        } else if (selectedFilter === 'arab-sector-filter') {
            filter_type = 'sector';
            //jQuery('#arab-year-filter').prop('selectedIndex', 0);
            //jQuery('#arab-country-filter').prop('selectedIndex', 0);
        } else if (selectedFilter === 'arab-country-filter') {
            filter_type = 'country';
            //jQuery('#arab-year-filter').prop('selectedIndex', 0);
            //jQuery('#arab-sector-filter').prop('selectedIndex', 0);
        }
        var filter_data = {
            'filter_value' : jQuery(this).val(),
            'filter_type'  : filter_type,
            'filter_selected_type' : selectedType ,
            'filter_default_country' : ArabFundsPublic.defaultcountry 
        }

        /* Updated when criteria's are set 
       jQuery(".filter-projects").click(function() {
        jQuery.ajax({
            type:"POST",
            url : ArabFundsPublic.ajaxurl,
            data : {
              action: "arab_project_filter",
              filter_data:filter_data,

            },
            success : function(response) {
                if ( response.html != ""  ) {
                    jQuery(".projects-summary").html(response.html);   
                }
            }
          });
       });
    });*/

    /* Here is the updated code for projects filter */
    jQuery('.filter-projects').on('click', function (e) {
        e.preventDefault();
        jQuery("#loader").show();
        var selectedType = jQuery('input[name="arab-project-type"]:checked').val();
        var filter_data = {
            'filter_value': jQuery(this).val(),
            'filter_selected_type': selectedType,
            'current_language': ArabFundsPublic.defaultlang,
            'filter_country': jQuery('#arab-country-filter').val(),
            'filter_sector': jQuery('#arab-sector-filter').val(),
            'filter_year': jQuery('#arab-year-filter').val()
        }

        jQuery.ajax({
            type: "POST",
            url: ArabFundsPublic.ajaxurl,
            data: {
                action: "arab_project_filter",
                filter_data: filter_data,

            },
            success: function (response) {
                if (response.html != "") {
                    jQuery(".projects-summary").html(response.html);
                    /* custom code to implement pagination on listing of projects */
                    var items = jQuery(".summary-table .list-item");
                    var numItems = items.length;
                    var perPage = 30;
                    jQuery("#loader").hide();
                    items.slice(perPage).hide();

                    jQuery('#pagination-container').pagination({
                        items: numItems,
                        itemsOnPage: perPage,
                        prevText: "&laquo;",
                        nextText: "&raquo;",
                        onPageClick: function (pageNumber) {
                            var showFrom = perPage * (pageNumber - 1);
                            var showTo = showFrom + perPage;
                            items.hide().slice(showFrom, showTo).show();
                            jQuery('html, body').animate({ scrollTop: jQuery('.table-heading').offset().top - 300 }, 1000);
                        },
                        onInit: function () {
                            if (numItems <= perPage) {
                                jQuery("#pagination-container").hide(); // Hide pagination container if there's only one page
                            }
                        },
                    });
                }
            }
        });
    });

    jQuery(".reset-project-filters").click(function (e) {
        e.preventDefault();
        jQuery('#arab-country-filter').prop('selectedIndex', 0);
        jQuery('#arab-year-filter').prop('selectedIndex', 0);
        jQuery('#arab-sector-filter').prop('selectedIndex', 0);

    });


    /* Custom code to hide cross button on load */
    jQuery('.search-input').on('keyup', function () {
        // Check if the input field is empty
        if (jQuery(this).val().trim() === '') {
            jQuery("#clear-search").hide();
            jQuery('.search-btn').show();
        } else {
            //jQuery(".clear-icon-container").addClass("clear-icon-right")
            if (jQuery(".clear-icon-container").hasClass('clear-icon-right')) {
                jQuery(".clear-icon-container").removeClass("clear-icon-right")
            }
            jQuery("#clear-search").show();
            //jQuery('.search-btn').hide();

        }
    });

    jQuery('#clear-search').on('click', function (e) {
        jQuery('.search-input').val('');
        jQuery('.clear-icon-container').hide();
        jQuery('.search-btn').show();
        jQuery("#loader-search").show();
        var default_lang = ArabFundsPublic.defaultlang;
        var country_search = jQuery('.search-input').val();
        jQuery.ajax({
            type: "POST",
            url: ArabFundsPublic.ajaxurl,
            data: {
                action: "arab_country_search",
                country_search: country_search,
                lang: default_lang,
            },
            success: function (response) {
                if (response.html != "") {
                    jQuery(".country-cards").html(response.html);
                    jQuery("#loader-search").hide();
                    if (response.count == 1 || response.count == 0) {
                        jQuery("#load-more-btn").hide();
                    } else if (response.count == 8) {
                        jQuery("#load-more-btn").show();
                        // Function to load more items
                        loadMoreBtn.addEventListener('click', function () {
                            const totalItems = itemsList.querySelectorAll('.country-card').length;
                            visibleItems += itemsPerPage;
                            toggleItems();

                            // Hide the "Load More" button if there are fewer than 8 items remaining
                            if (visibleItems >= totalItems) {
                                loadMoreBtn.style.display = 'none';
                            }
                        });
                    }
                }

            }
        });
    });

    jQuery('.search-btn').on('click', function (e) {
        var country_search = jQuery('.search-input').val();
        let language = jQuery(this).data('lang');

        if (country_search == '') {
            jQuery('.valid-msg').text(ArabFundsPublic.no_input);
        } else {
            jQuery('.valid-msg').text('');
            jQuery("#loader-search").show();
            jQuery(this).hide();
            jQuery(".clear-icon-container").addClass("clear-icon-right")

            jQuery.ajax({
                type: "POST",
                url: ArabFundsPublic.ajaxurl,
                data: {
                    action: "arab_country_search",
                    country_search: country_search,
                    lang: language,
                },
                success: function (response) {
                    if (response.html != "") {
                        jQuery(".country-cards").html(response.html);
                        jQuery("#loader-search").hide();
                        if (response.count == 1 || response.count == 0) {
                            jQuery("#load-more-btn").hide();
                        } else if (response.count == 8) {
                            jQuery("#load-more-btn").show();
                            // Function to load more items
                            loadMoreBtn.addEventListener('click', function () {
                                const totalItems = itemsList.querySelectorAll('.country-card').length;
                                visibleItems += itemsPerPage;
                                toggleItems();

                                // Hide the "Load More" button if there are fewer than 8 items remaining
                                if (visibleItems >= totalItems) {
                                    loadMoreBtn.style.display = 'none';
                                }
                            });
                        }
                    }

                }
            });
        }

    }); //END dropdown change event
});

// 'use strict';



// View More //

document.addEventListener('DOMContentLoaded', function () {
    const itemsList = document.querySelector('.country-cards');
    const loadMoreBtn = document.getElementById('load-more-btn');
    const itemsPerPage = 4; // Number of items to load per click after the initial 8
    let visibleItems = 8; // Number of items on first load

    // Function to toggle visibility of items
    /*function toggleItems() {
        const items = Array.from(itemsList.querySelectorAll('.country-card'));
        if( items ) {
          // Check if items array is not empty
          if (items.length > 0) {
            items.forEach((item, index) => {
                if (index < visibleItems) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
          }    
       }  
    } */

    // Initially show the first 8 items
    // toggleItems();

    // Function to load more items
    /*loadMoreBtn.addEventListener('click', function () {
        const totalItems = itemsList.querySelectorAll('.country-card').length;
        visibleItems += itemsPerPage;
        toggleItems();

        // Hide the "Load More" button if there are fewer than 8 items remaining
        if (visibleItems >= totalItems) {
            loadMoreBtn.style.display = 'none';
        }
    }); */

    // Hide the "Load More" button if there are initially fewer than 8 items
    /*const totalItems = itemsList.querySelectorAll('.country-card').length;
    if (totalItems <= visibleItems) {
        loadMoreBtn.style.display = 'none';
    } */
    const searchBarContainerEl = document.querySelector(".search-bar-container");
    const magnifierEl = document.querySelector(".magnifier");
    if (searchBarContainerEl && magnifierEl) {
        const isMobile = window.matchMedia("(max-width: 768px)").matches;
        if (!isMobile) {
            searchBarContainerEl.classList.remove("active");
        }
    }




    // function toggleActiveClass() {

    //     if (isMobile) {
    //         searchBarContainerEl.classList.toggle("active");
    //     }
    // }

    // magnifierEl.addEventListener("click", toggleActiveClass);
});



//Group Tabs
var tablinks = document.getElementsByClassName("tab-links");
var tabcontents = document.getElementsByClassName("tab-contents");

function opentab(tabname) {
    if (tablinks) {
        Array.from(tablinks).forEach(function (tablink) {
            tablink.classList.remove("active-link");
        });

        Array.from(tabcontents).forEach(function (tabcontent) {
            tabcontent.classList.remove("active-tab");
        });

        event.currentTarget.classList.add("active-link");
        document.getElementById(tabname).classList.add("active-tab");

    }

}


// Accordion
document.addEventListener('DOMContentLoaded', function () {
    const accordionButtons = document.querySelectorAll('.accordion-button');
    if (accordionButtons[0]) {
        const firstContent = accordionButtons[0].nextElementSibling;
        firstContent.classList.add('show');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function () {
                const content = this.nextElementSibling;
                accordionButtons.forEach(otherButton => {
                    if (otherButton !== button) {
                        otherButton.nextElementSibling.classList.remove('show');
                    }
                });
                content.classList.toggle('show');
            });
        });

    }
});

/**Start New load more implementation for countries */

jQuery(document).ready(function () {
    var currentPage = 1;
    jQuery('#load-more-btn').click(function () {

        currentPage++;
        jQuery("#loader").show();
        let language = jQuery(this).data('lang');
        jQuery.ajax({
            type: 'POST',
            url: ajaxObject.ajaxurl, // Use ajaxObject.ajaxurl
            dataType: 'json',
            data: {
                action: 'arab_funds_load_more_countries',
                paged: currentPage,
                lang: language,
            },
            success: function (res) {
                if (currentPage >= res.max) {
                    jQuery('#load-more-btn').hide();
                    jQuery("#loader").hide();
                }
                jQuery('.country-cards').append(res.html);
                jQuery("#loader").hide();
            }
        });
    });

    /* Custom code for Component Tabbing video layout */
    jQuery('ul.topic-wrap li').click(function () {
        var tab_id = jQuery(this).attr('data-tab');
        var training_id = jQuery(this).attr('data-training-id');

        jQuery('ul.topic-wrap li').removeClass('current');
        jQuery('.tab-content').removeClass('current');

        jQuery(this).addClass('current');
        jQuery("#" + tab_id).addClass('current');

        /* Updated when criteria's are set */
        jQuery.ajax({
            type: "POST",
            url: ArabFundsPublic.ajaxurl,
            data: {
                action: "arab_trainings",
                section_id: tab_id,
                training_id: training_id

            },
            success: function (response) {
                if (response.html != "") {
                    jQuery("#" + tab_id).html(response.html);
                    // var items = jQuery(".events_container .event_box");
                    // var numItems = items.length;
                    // var perPage = 6;
                    // items.slice(perPage).hide();
                    // console.log(numItems);
                    // jQuery('#event-pagination').pagination({
                    //     items: numItems,
                    //     itemsOnPage: perPage,
                    //     prevText: "&laquo;",
                    //     nextText: "&raquo;",
                    //     onPageClick: function (pageNumber) {
                    //         var showFrom = perPage * (pageNumber - 1);
                    //         var showTo = showFrom + perPage;
                    //         items.hide().slice(showFrom, showTo).show();
                    //     },
                    //     onInit: function (){
                    //         if (numItems <= perPage) {
                    //             jQuery("#event-pagination").hide(); // Hide pagination container if there's only one page
                    //         }
                    //     },
                    // });
                    setTimeout(() => {
                        /*var items = jQuery(".events_container .event_box");
                        var numItems = response.count;
                        var perPage = 6;
                        items.slice(perPage).hide();
                        //alert(numItems);
                        jQuery('#event-pagination').pagination({
                            items: numItems,
                            itemsOnPage: perPage,
                            prevText: "&laquo;",
                            nextText: "&raquo;",
                            /*onPageClick: function (pageNumber) {    
                                var showFrom = perPage * (pageNumber - 1);
                                var showTo = showFrom + perPage;
                                items.hide().slice(showFrom, showTo).show();
                            },
                            onInit: function (){
                                if (numItems <= perPage) {
                                    jQuery("#event-pagination").hide(); // Hide pagination container if there's only one page
                                }
                            },
                        });*/
                    }, 2000);

                    /* Custom code to open training video popups */
                    jQuery('.training-item').on('click', function () {
                        var videoPath = jQuery(this).data('video-path');
                        openVideoPopup(videoPath);
                    });

                    /* custom code open video in iframe if it's youtube url */
                    jQuery('.training-item-youtube').magnificPopup({
                        disableOn: 700,
                        type: 'iframe',
                        mainClass: 'mfp-fade',
                        removalDelay: 160,
                        preloader: false,
                        fixedContentPos: false
                    });
                }
            }
        });


    })

});

/**End New load more implementation for countries */
function openVideoPopup(videoPath) {
    jQuery('#video-popup video').attr('src', videoPath);
    jQuery.magnificPopup.open({
        items: {
            src: '#video-popup',
            type: 'inline'
        },
        callbacks: {
            open: function () {
                // Triggered when the popup is open
                // You can perform additional actions here
            }
        }
    });
}


jQuery(document).ready(function ($) {
    var headingCaptionH2 = $('.heading-caption h2');
    if (headingCaptionH2.length > 0) {
        // Get the HTML content of the element
        var span = headingCaptionH2.html();
        // Check if the content is not empty
        if (span) {
            // Replace '&nbsp;' with an empty string
            span = span.replace(/&nbsp;/g, '');
            // Set the updated HTML content back to the element
            headingCaptionH2.html(span);
        }
    }
});
