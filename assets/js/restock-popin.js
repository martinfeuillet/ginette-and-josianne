document.addEventListener('DOMContentLoaded', function () {
    console.log('Restock Popin Script Loaded !');
    const closePopin = document.querySelector('div.uagb-block-0f0532dc');
    const body = document.querySelector('body');
    const popin = document.querySelector('div.uagb-block-bd6454cc');
    const popinContent = popin.firstChild;
    const form = document.getElementById('wpforms-form-29573');

    // Manage event on close popin button
    if (closePopin) {
        closePopin.addEventListener('click', closePopinEvent);
    }

    // Manage event on click outside the popin
    document.addEventListener('click', function (event) {
        let isClickInsidePopin = popinContent.contains(event.target);

        if (!isClickInsidePopin) {
            body.classList.remove('restock-popin-active');
            popin.classList.remove('restock-popin-active');
        }
    });

    form.addEventListener('submit', closePopinEvent);

    function closePopinEvent() {
        body.classList.remove('restock-popin-active');
        popin.classList.remove('restock-popin-active');
    }
});


