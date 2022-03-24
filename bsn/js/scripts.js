(function($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/

    var preloader = $('#preloader');
    $(window).on('load', function() {
        setTimeout(function() {
            preloader.fadeOut('slow', function() { $(this).remove(); });
        }, 300)
    });

    /*================================
    sidebar collapsing
    ==================================*/
    if (window.innerWidth <= 1364) {
        $('.page-container').addClass('sbar_collapsed');
    }
    $('.nav-btn').on('click', function() {
        $('.page-container').toggleClass('sbar_collapsed');
    });

    /*================================
    Start Footer resizer
    ==================================*/
    var e = function() {
        var e = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 5;
        (e -= 67) < 1 && (e = 1), e > 67 && $(".main-content").css("min-height", e + "px")
    };
    $(window).ready(e), $(window).on("resize", e);

    /*================================
    sidebar menu
    ==================================*/
    $("#menu").metisMenu();

    /*================================
    slimscroll activation
    ==================================*/
    $('.menu-inner').slimScroll({
        height: 'auto'
    });
    $('.nofity-list').slimScroll({
        height: '435px'
    });
    $('.timeline-area').slimScroll({
        height: '500px'
    });
    $('.recent-activity').slimScroll({
        height: 'calc(100vh - 114px)'
    });
    $('.settings-list').slimScroll({
        height: 'calc(100vh - 158px)'
    });

    /*================================
    stickey Header
    ==================================*/
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();

        // console.log(mainHeader.innerHeight());
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });

    /*================================
    form bootstrap validation
    ==================================*/
    $('[data-toggle="popover"]').popover()

    /*------------- Start form Validation -------------*/
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    /*================================
    datatable active
    ==================================*/
    if ($('#dataTable').length) {
        $('#dataTable').DataTable({
        "ajax": i_lokasi + g_view + '.json',
        "columnDefs": [ {
            "targets": -1,
            "data": null,
			"render": function ( data, type, row, meta ) {
			  return '<a href="?pastiin='+g_view+'&edit='+data[3]+'&hash='+toqen+'" title="EDIT"><i class="ti-eraser"></i></a> &nbsp; | &nbsp; <a href=\"?pastiin='+g_view+'&del='+data[3]+'&token='+toqen+'&token_status='+toqen_s+'"\" onclick=\"return confirm(\'Delete ?\');\" title="DELETE"><i class="ti-trash"></i></a>';
			}
        } ],
        "order": [[ 3, "desc" ]],
        'autoWidth': true,
        'responsive': true,
		"pagingType": "simple_numbers",
		"info": false,
		"bLengthChange": false,
		language: {
			'search'				: "",
			'searchPlaceholder'		: "Cari",
			"info"					: "Ke _START_ dari _TOTAL_",
			"lengthMenu"			: "Tampilkan _MENU_",
			"loadingRecords"		: "Tunggu...",
			"processing"			: "Memproses...",
			"infoFiltered"			: "",
			"paginate": {
					"first"			: "Awal",
					"last"			: "Akhir",
					"next"			: "Selanjutnya",
					"previous"		: "Sebelumnya"
					},
			"zeroRecords"			: "Tidak ada data",
			"emptyTable"			: "Tidak ada data",
			}
        });
		$(document).keydown(function(e){
		var dtatable = $('#dataTable').DataTable();
			if (e.keyCode == 37) {
				dtatable.page( 'previous' ).draw( 'page' );
			   return false;
			}
			if (e.keyCode == 39) {
				dtatable.page( 'next' ).draw( 'page' );
			   return false;
			}
		});
    }
    if ($('#dataTable1').length) {
        $('#dataTable1').DataTable({
        "ajax": i_lokasi + g_view + '.json',
        "columnDefs": [ {
            "targets": -1,
            "data": null,
			"render": function ( data, type, row, meta ) {
			  return '<a href="?pastiin='+g_view+'&edit='+data[2]+'&hash='+toqen+'" title="EDIT"><i class="ti-eraser"></i></a> &nbsp; | &nbsp; <a href=\"?pastiin='+g_view+'&del='+data[2]+'&token='+toqen+'&token_status='+toqen_s+'"\" onclick=\"return confirm(\'Delete ?\');\" title="DELETE"><i class="ti-trash"></i></a>';
			}
        } ],
        "order": [[ 2, "desc" ]],
        'autoWidth': true,
        'responsive': true,
		"pagingType": "simple_numbers",
		"info": false,
		"bLengthChange": false,
		language: {
			'search'				: "",
			'searchPlaceholder'		: "Cari",
			"info"					: "Ke _START_ dari _TOTAL_",
			"lengthMenu"			: "Tampilkan _MENU_",
			"loadingRecords"		: "Tunggu...",
			"processing"			: "Memproses...",
			"infoFiltered"			: "",
			"paginate": {
					"first"			: "Awal",
					"last"			: "Akhir",
					"next"			: "Selanjutnya",
					"previous"		: "Sebelumnya"
					},
			"zeroRecords"			: "Tidak ada data",
			"emptyTable"			: "Tidak ada data",
			}
        });
		$(document).keydown(function(e){
		var dtatable = $('#dataTable1').DataTable();
			if (e.keyCode == 37) {
				dtatable.page( 'previous' ).draw( 'page' );
			   return false;
			}
			if (e.keyCode == 39) {
				dtatable.page( 'next' ).draw( 'page' );
			   return false;
			}
		});
    }
    if ($('#dataTable2').length) {
        $('#dataTable2').DataTable({
        "ajax": i_lokasi + g_view + '.json',
        "columnDefs": [ {
            "targets": -1,
            "data": null,
			"render": function ( data, type, row, meta ) {
			  return '<a href="?pastiin='+g_view+'&edit='+data[1]+'&hash='+toqen+'" title="EDIT"><i class="ti-eraser"></i></a> &nbsp; | &nbsp; <a href=\"?pastiin='+g_view+'&del='+data[1]+'&token='+toqen+'&token_status='+toqen_s+'"\" onclick=\"return confirm(\'Delete ?\');\" title="DELETE"><i class="ti-trash"></i></a>';
			}
        } ],
        "order": [[ 0, "desc" ]],
        'autoWidth': true,
        'responsive': true,
		"pagingType": "simple_numbers",
		"info": false,
		"bLengthChange": false,
		language: {
			'search'				: "",
			'searchPlaceholder'		: "Cari",
			"info"					: "Ke _START_ dari _TOTAL_",
			"lengthMenu"			: "Tampilkan _MENU_",
			"loadingRecords"		: "Tunggu...",
			"processing"			: "Memproses...",
			"infoFiltered"			: "",
			"paginate": {
					"first"			: "Awal",
					"last"			: "Akhir",
					"next"			: "Selanjutnya",
					"previous"		: "Sebelumnya"
					},
			"zeroRecords"			: "Tidak ada data",
			"emptyTable"			: "Tidak ada data",
			}
        });
		$(document).keydown(function(e){
		var dtatable = $('#dataTable').DataTable();
			if (e.keyCode == 37) {
				dtatable.page( 'previous' ).draw( 'page' );
			   return false;
			}
			if (e.keyCode == 39) {
				dtatable.page( 'next' ).draw( 'page' );
			   return false;
			}
		});
    }
	
    /*================================
    Slicknav mobile menu
    ==================================*/
    $('ul#nav_menu').slicknav({
        prependTo: "#mobile_menu"
    });

    /*================================
    login form
    ==================================*/
    $('.form-gp input').on('focus', function() {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function() {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });

    /*================================
    slider-area background setting
    ==================================*/
    $('.settings-btn, .offset-close').on('click', function() {
        $('.offset-area').toggleClass('show_hide');
        $('.settings-btn').toggleClass('active');
    });

    /*================================
    Owl Carousel
    ==================================*/
    function slider_area() {
        var owl = $('.testimonial-carousel').owlCarousel({
            margin: 50,
            loop: true,
            autoplay: false,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                450: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 2
                },
                1360: {
                    items: 1
                },
                1600: {
                    items: 2
                }
            }
        });
    }
    slider_area();

})(jQuery);