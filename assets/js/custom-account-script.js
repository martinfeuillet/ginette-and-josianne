///Login/register
jQuery(document).ready(function($) {
    $('#switch_to_register').on('click', function(e) {
        e.preventDefault();  
        $('.u-column1').toggle(); 
        $('.u-column2').toggle(); 
    });

    $('#switch_to_login').on('click', function(e) {
        e.preventDefault(); 
        $('.u-column1').toggle(); 
        $('.u-column2').toggle(); 
    });
});

////points ring 
document.addEventListener('DOMContentLoaded', function() {
  var $originalCircle = jQuery('.circlediag').html();
  jQuery('.circlediag2').html($originalCircle);

  var points = parseInt(jQuery('.points-title strong').text(), 10);
  var totalPoints = 150;
  var percentage = (points / totalPoints) * 100;

  jQuery('.circle').css('stroke-dasharray', `${percentage}, 100`);
});


///accordions
document.addEventListener('DOMContentLoaded', function() {
    var dropdowns = document.querySelectorAll('.fidelity-dropdown .dropdown-title');

    dropdowns.forEach(function(title) {
        title.addEventListener('click', function() {
            this.classList.toggle('active');
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });
});

///min points msg
document.addEventListener('DOMContentLoaded', function() {
    var pointsElement = document.querySelector('.points-title strong');
    if (pointsElement) {
        var points = parseInt(pointsElement.textContent, 10);
        if (points < 150) {
            var pointsMsgElement = document.querySelector('.pointsmsg');
            if (pointsMsgElement) {
                pointsMsgElement.textContent = 'Le montant minimum à convertir est de 150 points.';
            }
        }
    }
});

jQuery(document).ready(function($) {
    initToggleMenuClassButton()
    function toggleMenuClass() {
        console.log('toggle class');
        $('.gj-account-custom-mobile-header-menu').toggleClass('custom-mobile-header-active-menu');
        $('#my-account-menu').toggleClass('my-account-menu-active');
        $('.woocommerce').toggleClass('my-account-body-active');
        initToggleMenuClassButton()
    }
    
    function initToggleMenuClassButton() {
        console.log('init button')
        $('.gj-account-custom-mobile-header-menu').off('click').on('click', toggleMenuClass)
        $('.gj-my-account-breadcrumb-trail').off('click').on('click', toggleMenuClass)
    }
});

jQuery(document).ready(function($) {
    $('a.insta').on('click', function(e) {
        e.preventDefault(); 
        var linkUrl = $(this).attr('href'); 

        var newTab = window.open(linkUrl, '_blank');

        $.ajax({
            type: "POST",
            url: myAjax.ajaxurl,
            data: {
                action: 'increase_points_and_log'
            },
            success: function(response) {
                alert(response); 
            }
        });
    });
});