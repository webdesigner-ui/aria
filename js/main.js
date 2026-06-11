(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Initiate the wowjs
    new WOW().init();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm scrolled');
            $('.logo').attr('src', 'img/KPCL -Aria-Logo-Copper.png'); // change image
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm scrolled');
            $('.logo').attr('src', 'img/KPCL -Aria-Logo-White.png'); // original image
        }
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });

})(jQuery);

// --------------Send Mail enquire now and connect with us Start-----------------------------

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("contactForm");

    if (form) {

        form.addEventListener("submit", function (e) {

            e.preventDefault();

            let formData = new FormData(form);

            // Loading popup
            Swal.fire({
                title: 'Sending...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch("send.php", {
                method: "POST",
                body: formData
            })

                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        });
                        form.reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Mail not sent'
                        });
                    }
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong'
                    });

                });

        });
    }
});
// --------------Send Mail enquire now and connect with us End-----------------------------

// --------------Send Mail request a Quote Start-----------------------------

document.addEventListener("DOMContentLoaded", function () {

    const forms = document.querySelectorAll(".quoteForm");

    forms.forEach((form) => {

        form.addEventListener("submit", async function (e) {

            e.preventDefault();

            const formData = new FormData(form);


            form.reset();

            // Hide popup form
            document.querySelectorAll(".form-popup").forEach((popup) => {
                popup.style.display = "none";
            });

            // Loading popup
            Swal.fire({
                title: 'Sending...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {

                const response = await fetch("sendmail.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.status === "success") {

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: result.message,
                        // confirmButtonColor: "#3085d6",

                        didOpen: () => {

                            const swalContainer = document.querySelector('.swal2-container');

                            if (swalContainer) {
                                swalContainer.style.zIndex = '999999999999';
                            }
                        }
                    });
                } else {

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: result.message
                    });
                }

            } catch (error) {

                console.log(error);

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong!"
                });
            }

        });

    });

});

// --------------Send Mail request a Quote End-----------------------------

// --------------Send Mail Brochure Start-----------------------------

document.addEventListener("DOMContentLoaded", function () {

    const forms = document.querySelectorAll(".brochureForm");

    forms.forEach((form) => {

        form.addEventListener("submit", async function (e) {

            e.preventDefault();

            const formData = new FormData(form);


            form.reset();

            // Hide popup form
            document.querySelectorAll(".popup-form").forEach((popup) => {
                popup.style.display = "none";
            });

            // Loading popup
            Swal.fire({
                title: 'Sending...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {

                const response = await fetch("sendbrochuremail.php", {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.status === "success") {

                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: result.message,
                        // confirmButtonColor: "#3085d6",

                        didOpen: () => {

                            const swalContainer = document.querySelector('.swal2-container');

                            if (swalContainer) {
                                swalContainer.style.zIndex = '999999999999';
                            }
                        }
                    });
                } else {

                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: result.message
                    });
                }

            } catch (error) {

                console.log(error);

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong!"
                });
            }

        });

    });

});

// --------------Send Mail Brochure End-----------------------------