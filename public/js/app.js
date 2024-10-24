/*
Template: SocialV - Responsive Bootstrap 5 Admin Dashboard Template
Author: iqonicthemes.in
Design and Developed by: iqonicthemes.in
NOTE: This file contains the styling for responsive Template.
*/

/*----------------------------------------------
Index Of Script
------------------------------------------------
:: LoaderInit
:: Tooltip
:: range Button
:: right-sidebar
:: Sticky-Nav
:: Sidebar Toggle
:: Sidebar Left Active Border
:: Scrollbar
:: ColorChange Mode
:: Progress Bar
:: Inline Flatpickr
:: Search input
:: chat
:: todo
:: checkout
:: page-loader
:: Mailbox
:: Confirm Button
:: Select input
:: Fieldset
:: Vanila Datepicker
:: Form Validation
:: Form Wizard-validate
:: calender
:: weather
:: Editable Table
:: Resize Plugins
:: DOMContentLoaded
:: Window Resize


------------------------------------------------
Index Of Script
----------------------------------------------*/

(function(jQuery) {

  "use strict";
  /*------------LoaderInit----------------*/
  const loaderInit = () => {
    const loader = document.querySelector('.loader')
    if(loader !== null) {
      loader.classList.add('animate__animated', 'animate__fadeOut')
      setTimeout(() => {
        loader.classList.add('d-none')
      }, 200)
    }
  }
  jQuery(document).ready(function() {

    /*---------------------------------------------------------------------
    Tooltip
    -----------------------------------------------------------------------*/
        jQuery('[data-bs-toggle="popover"]').popover();
        jQuery('[data-bs-toggle="tooltip"]').tooltip();

    /*---------------------------------------------------------------------
    range Button
    -----------------------------------------------------------------------*/
        function wcqib_refresh_quantity_increments() {
            jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                var c = jQuery(b);
                c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
            })
        }
        String.prototype.getDecimals || (String.prototype.getDecimals = function() {
            var a = this,
                b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
            return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
        }), jQuery(document).ready(function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("updated_wc_div", function() {
            wcqib_refresh_quantity_increments()
        }), jQuery(document).on("click", ".plus, .minus", function() {
            var a = jQuery(this).closest(".quantity").find(".qty"),
                b = parseFloat(a.val()),
                c = parseFloat(a.attr("max")),
                d = parseFloat(a.attr("min")),
                e = a.attr("step");
            b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
        });
    /*---------------------------------------------------------------------
        right-sidebar
    -----------------------------------------------------------------------*/
        ! function(e) {
            "use strict";
        
            function t(t) {
                t ? e(".right-sidebar-mini").addClass("right-sidebar") : e(".right-sidebar-mini").removeClass("right-sidebar")
                t ? e("body").addClass("right-sidebar-close") : e("body").removeClass("right-sidebar-close")
            }
            e(document).ready(function() {
                const scrollbarTrackY = document.querySelector('.scrollbar-track-y')
                const body = document.querySelector('body')
                scrollbarTrackY.classList.add('d-none')
                var screenWidth = $(window).width(); 

                if (screenWidth > 1099) {
                    body.classList.add('sidebar-main')
                    const sidebar = document.querySelector('.sidebar')
                    sidebar.classList.remove('sidebar-mini')
                }

                var a = false; // Change 'false' to 'true' to hide the sidebar by default
                t(a);
                // e(document).on("click", ".right-sidebar-toggle", function() {
                //     t(a = !a)
                // })
            })
        }(jQuery);
        
    /*---------------------------------------------------------------------
       Sidebar Toggle
    -----------------------------------------------------------------------*/
        function updateSidebarType() {
            if(typeof IQSetting !== typeof undefined) {
            const sidebarType = IQSetting.options.setting.sidebar_type.value
            const newTypes = sidebarType
            if(sidebarType.includes('sidebar-mini')) {
                const indexOf = newTypes.findIndex(x => x == 'sidebar-mini')
                newTypes.splice(indexOf, 1)
            } else {
                newTypes.push('sidebar-mini')
            }
            IQSetting.sidebar_type(newTypes)
            }
        }
        const sidebarToggle = (elem) => {
            elem.addEventListener('click', (e) => {
            const sidebar = document.querySelector('.sidebar')
            const scrollbarTrackY = document.querySelector('.scrollbar-track-y')
            if (sidebar.classList.contains('sidebar-mini')) {
                sidebar.classList.remove('sidebar-mini')
                scrollbarTrackY.classList.remove('d-none')
                updateSidebarType()
            } else {
                sidebar.classList.add('sidebar-mini')
                scrollbarTrackY.classList.add('d-none')
                updateSidebarType()
            }
            })
        }
        jQuery(document).on('click', '[data-toggle="sidebar"]', function() {
            jQuery("body").toggleClass("sidebar-main");
            jQuery(this).toggleClass('mini');
        });
        const sidebarToggleBtn = document.querySelectorAll('[data-toggle="sidebar"]')
        const sidebar = document.querySelector('[data-toggle="main-sidebar"]')
        if (sidebar !== null) {
            const sidebarActiveItem = sidebar.querySelectorAll('.active')
            Array.from(sidebarActiveItem, (elem) => {
            elem.classList.add('active')
            if (!elem.closest('ul').classList.contains('iq-main-menu')) {
                const childMenu = elem.closest('ul')
                const parentMenu = childMenu.closest('li').querySelector('.nav-link')
                parentMenu.classList.add('active')
                new bootstrap.Collapse(childMenu, {
                toggle: true
                });
            }
            })
        }
        Array.from(sidebarToggleBtn, (sidebarBtn) => {
            sidebarToggle(sidebarBtn)
        })

    /*---------------------------------------------------------------------
                Sidebar Left Active Border
    -----------------------------------------------------------------------*/
        window.addEventListener('load', () => {
        const leftSidebar = document.querySelector('[data-toggle="main-sidebar"]')
            if (leftSidebar !== null) {
                const collapseElementList = [].slice.call(leftSidebar.querySelectorAll('.collapse'))
                const collapseList = collapseElementList.map(function (collapseEl) {
                    collapseEl.addEventListener('show.bs.collapse', function (elem) {
                    collapseEl.closest('li').classList.add('active')
                    })
                    collapseEl.addEventListener('hidden.bs.collapse', function (elem) {
                    collapseEl.closest('li').classList.remove('active')
                    })
                })

                const active = leftSidebar.querySelector('.active')
                if (active !== null) {
                    active.closest('li').classList.add('active')
                }
            }
        })

    /*---------------------------------------------------------------------
        Scrollbar
    -----------------------------------------------------------------------*/
        let Scrollbar
        if (typeof Scrollbar !== typeof null) {
        if (document.querySelectorAll(".data-scrollbar").length) {
            Scrollbar = window.Scrollbar
            Scrollbar.init(document.querySelector('.data-scrollbar'), {
            continuousScrolling: false,
            })
        }
        }
    /*---------------------------------------------------------------------
         ColorChange Mode
    -----------------------------------------------------------------------*/
        const customizerMode = (custombodyclass,colors,colorInfo) => {
            document.querySelector('body').classList.add(`${custombodyclass}`)
            sessionStorage.setItem('colorcustomchart-mode', getComputedStyle(document.body).getPropertyValue('--bs-primary'))
            document.documentElement.style.setProperty('--bs-info', colors);
            const color = sessionStorage.getItem('colorcustomchart-mode')
            if(color !== 'null' && color !== undefined && color !== ''){
            const event = new CustomEvent("ColorChange", {detail :{detail1:color.trim(), detail2:colors.trim()}});
            document.dispatchEvent(event);
            }
            else{
            const event = new CustomEvent("ColorChange", {detail :{detail1:colorInfo.trim(), detail2:colors.trim()}});
            document.dispatchEvent(event);
            }
            const elements = document.querySelectorAll('[data-setting="color-mode1"][data-name="color"]')
                Array.from(elements, (mode) => {
                    const colorclass = mode.getAttribute('data-value');
                    if(colorclass === custombodyclass ){
                        mode.classList.add('active')
                    }
                    else{
                        mode.classList.remove('active')
                    }
                })
            }
        const elements = document.querySelectorAll('[data-setting="color-mode1"][data-name="color"]')
        Array.from(elements, (mode) => {
        mode.addEventListener('click', (e) => {
            Array.from(elements, (el) => {
                el.classList.remove('active')
                document.querySelector('body').classList.remove(el.getAttribute('data-value'))
            })
            sessionStorage.setItem('colorcustom-mode', mode.getAttribute('data-value'))
            sessionStorage.setItem('colorcustominfo-mode', mode.getAttribute('data-info'))

            mode.classList.add('active')
            const colors = mode.getAttribute('data-info');
            const color = getComputedStyle(document.body).getPropertyValue('--bs-primary');
            customizerMode(mode.getAttribute('data-value'),colors,color)

            })
        })
        const custombodyclass = sessionStorage.getItem('colorcustom-mode')
        const colors = sessionStorage.getItem('colorcustominfo-mode')
        const color = sessionStorage.getItem('colorcustomchart-mode')
        if(custombodyclass !== null && custombodyclass !== undefined && colors !== null && colors !== undefined){
            customizerMode(custombodyclass,colors,color)
        }
    /*---------------------------------------------------------------------
         Progress Bar
    -----------------------------------------------------------------------*/
        const progressBarInit = (elem) => {
            const currentValue = elem.getAttribute('aria-valuenow')
            elem.style.width = '0%'
            elem.style.transition = 'width 2s'
            if (typeof Waypoint !== typeof undefined) {
            new Waypoint({
                element: elem,
                handler: function () {
                setTimeout(() => {
                    elem.style.width = currentValue + '%'
                }, 100);
                },
                offset: 'bottom-in-view',
            })
            }
        }
        const customProgressBar = document.querySelectorAll('[data-toggle="progress-bar"]')
        Array.from(customProgressBar, (elem) => {
            progressBarInit(elem)
        })

    /*---------------------------------------------------------------------
        Inline Flatpickr
    -----------------------------------------------------------------------*/
        const inline_flatpickr = document.querySelectorAll('.inline_flatpickr')
        Array.from(inline_flatpickr, (elem) => {
            if (typeof flatpickr !== typeof undefined) {
            flatpickr(elem, {
                inline: true,
                minDate: "today",
                dateFormat: "Y-m-d",
            })
            }
        })

    /*---------------------------------------------------------------------
    chatuser
    -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.chat-head .chat-user-profile', function() {
            jQuery(this).parent().next().toggleClass('show');
        });
        jQuery(document).on('click', '.user-profile .close-popup', function() {
            jQuery(this).parent().parent().removeClass('show');
        });

    /*---------------------------------------------------------------------
    chatuser main
    -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.chat-search .chat-profile', function() {
            jQuery(this).parent().next().toggleClass('show');
        });
        jQuery(document).on('click', '.user-profile .close-popup', function() {
            jQuery(this).parent().parent().removeClass('show');
        });

    /*---------------------------------------------------------------------
    Chat start
    -----------------------------------------------------------------------*/
        jQuery(document).on('click', '#chat-start', function() {
            jQuery('.chat-data-left').toggleClass('show');
        });
        jQuery(document).on('click', '.close-btn-res', function() {
            jQuery('.chat-data-left').removeClass('show');
        });
        jQuery(document).on('click', '.iq-chat-ui li', function() {
            jQuery('.chat-data-left').removeClass('show');
        });
        jQuery(document).on('click', '.sidebar-toggle', function() {
            jQuery('.chat-data-left').addClass('show');
        });
        jQuery(document).on('click', '.left-sidebar-toggle', function() {
            jQuery('.chat-data-left').addClass('show');
        });

    /*---------------------------------------------------------------------
        todo Page
    -----------------------------------------------------------------------*/
        jQuery(document).on('click', '.todo-task-list > li > a', function() {
            jQuery('.todo-task-list li').removeClass('active');
            jQuery('.todo-task-list .sub-task').removeClass('show');
            jQuery(this).parent().toggleClass('active');
            jQuery(this).next().toggleClass('show');
        });
        jQuery(document).on('click', '.todo-task-list > li li > a', function() {
            jQuery('.todo-task-list li li').removeClass('active');
            jQuery(this).parent().toggleClass('active');
        });

    /*---------------------------------------------------------------------
           checkout
    -----------------------------------------------------------------------*/
        jQuery(document).ready(function(){
            jQuery('#place-order').click(function(){
                jQuery('#cart').removeClass('show');
                jQuery('#address').addClass('show');
            });
            jQuery('#deliver-address').click(function(){
                jQuery('#address').removeClass('show');
                jQuery('#payment').addClass('show');
            });
            jQuery('#checkout-order').click(function(){
                jQuery('#cart').removeClass('show');
                jQuery('#payment').addClass('show');
            });
        });

    /*---------------------------------------------------------------------
            Page Loader
    -----------------------------------------------------------------------*/
        jQuery("#load").fadeOut();
        jQuery("#loading").delay().fadeOut("");

    /*---------------------------------------------------------------------
        Mailbox
    -----------------------------------------------------------------------*/
        jQuery(document).on('click', 'ul.iq-email-sender-list li', function(e) {
            if (e.target.closest('.email-app-details') === null) {
                jQuery(this).find('.email-app-details').addClass('show');
            }
        });

        jQuery(document).on('click', '.email-remove', function(e) {
            jQuery(this).closest('.email-app-details').removeClass('show');
        });

    /*---------------------------------------------------------------------
        Confirm Button
    -----------------------------------------------------------------------*/
        $('.confirm-btn').on('click',function() {
            $(this).closest('.confirm-click-btn').find('.request-btn').hide()
        })

    /*---------------------------------------------------------------------
        Select input
    -----------------------------------------------------------------------*/
        jQuery('.select2jsMultiSelect').select2({
            tags: true
        });

    /*---------------------------------------------------------------------
        Fieldset
    -----------------------------------------------------------------------*/
        $(document).ready(function() {
            var e, t, a, n, o = 1,
                r = $("fieldset").length;

            function i(e) {
                var t = parseFloat(100 / r) * e;
                t = t.toFixed(), $(".progress-bar").css("width", t + "%")
            }
            i(o), $(".next").click(function() {
                e = $(this).parent(), t = $(this).parent().next(), $("#top-tab-list li").eq($("fieldset").index(t)).addClass("active"), $("#top-tab-list li").eq($("fieldset").index(e)).addClass("done"), t.show(), e.animate({
                    opacity: 0
                }, {
                    step: function(a) {
                        n = 1 - a, e.css({
                            display: "none",
                            position: "relative"
                        }), t.css({
                            opacity: n
                        })
                    },
                    duration: 500
                }), i(++o)
            }), $(".previous").click(function() {
                e = $(this).parent(), a = $(this).parent().prev(), $("#top-tab-list li").eq($("fieldset").index(e)).removeClass("active"), $("#top-tab-list li").eq($("fieldset").index(a)).removeClass("done"), a.show(), e.animate({
                    opacity: 0
                }, {
                    step: function(t) {
                        n = 1 - t, e.css({
                            display: "none",
                            position: "relative"
                        }), a.css({
                            opacity: n
                        })
                    },
                    duration: 500
                }), i(--o)
            }), $(".submit").click(function() {
                return !1
            })
        }), $(document).ready(function() {
            var e = $("div.setup-panel div a"),
                t = $(".setup-content"),
                a = $(".nextBtn");
            t.hide(), e.click(function(a) {
                a.preventDefault();
                var n = $($(this).attr("href")),
                    o = $(this);
                o.hasClass("disabled") || (e.addClass("active"), o.parent().addClass("active"), t.hide(), n.show(), n.find("input:eq(0)").focus())
            }), a.click(function() {
                var e = $(this).closest(".setup-content"),
                    t = e.attr("id"),
                    a = $('div.setup-panel div a[href="#' + t + '"]').parent().next().children("a"),
                    n = e.find("input[type='text'],input[type='email'],input[type='password'],input[type='url'],textarea"),
                    o = !0;
                $(".form-group").removeClass("has-error");
                for (var r = 0; r < n.length; r++) n[r].validity.valid || (o = !1, $(n[r]).closest(".form-group").addClass("has-error"));
                o && a.removeAttr("disabled").trigger("click")
            }), $("div.setup-panel div a.active").trigger("click")
        }), $(document).ready(function() {
            var e, t, a, n, o = 1,
                r = $("fieldset").length;

            function i(e) {
                var t = parseFloat(100 / r) * e;
                t = t.toFixed(), $(".progress-bar").css("width", t + "%")
            }
            i(o), $(".next").click(function() {
                e = $(this).parent(), t = $(this).parent().next(), $("#top-tabbar-vertical li").eq($("fieldset").index(t)).addClass("active"), t.show(), e.animate({
                    opacity: 0
                }, {
                    step: function(a) {
                        n = 1 - a, e.css({
                            display: "none",
                            position: "relative"
                        }), t.css({
                            opacity: n
                        })
                    },
                    duration: 500
                }), i(++o)
            }), $(".previous").click(function() {
                e = $(this).parent(), a = $(this).parent().prev(), $("#top-tabbar-vertical li").eq($("fieldset").index(e)).removeClass("active"), a.show(), e.animate({
                    opacity: 0
                }, {
                    step: function(t) {
                        n = 1 - t, e.css({
                            display: "none",
                            position: "relative"
                        }), a.css({
                            opacity: n
                        })
                    },
                    duration: 500
                }), i(--o)
            }), $(".submit").click(function() {
                return !1
            })
        }), $(document).ready(function() {
            $(".file-upload").on("change", function() {
                ! function(e) {
                    if (e.files && e.files[0]) {
                        var t = new FileReader;
                        t.onload = function(e) {
                            $(".profile-pic").attr("src", e.target.result)
                        }, t.readAsDataURL(e.files[0])
                    }
                }(this)
            }), $(".upload-button").on("click", function() {
                $(".file-upload").click()
            })
        }), $(function() {
            function e(e) {
                return e / 100 * 360
            }
            $(".progress-round").each(function() {
                var t = $(this).attr("data-value"),
                    a = $(this).find(".progress-left .progress-bar"),
                    n = $(this).find(".progress-right .progress-bar");
                t > 0 && (t <= 50 ? n.css("transform", "rotate(" + e(t) + "deg)") : (n.css("transform", "rotate(180deg)"), a.css("transform", "rotate(" + e(t - 50) + "deg)")))
            })
        });

    /*---------------------------------------------------------------------
            Vanila Datepicker
    -----------------------------------------------------------------------*/
        const datepickers = document.querySelectorAll('.vanila-datepicker')
        Array.from(datepickers, (elem) => {
        new Datepicker(elem)
        })
        const daterangePickers = document.querySelectorAll('.vanila-daterangepicker')
        Array.from(daterangePickers, (elem) => {
        new DateRangePicker(elem)
        })

    /*---------------------------------------------------------------------
            Form Validation
    -----------------------------------------------------------------------*/
        // Example starter JavaScript for disabling form submissions if there are invalid fields
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

    /*---------------------------------------------------------------------
            Form Wizard-validate
    -----------------------------------------------------------------------*/
        var registrationForm = $('#registration');
        if(registrationForm.length) {
            const wizard = new Enchanter('registration', {}, {
            onNext: () => {
            }
            });
        }

    /*-----------------------------------------------------------------------------
                calender
    ------------------------------------------------------------------------------*/
        if (jQuery('#calendar1').length) {
            let calendarEl = document.getElementById('calendar1');
              let calendar1 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "list", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth",
                contentHeight: "auto",
                eventLimit: true,
                dayMaxEvents: 4,
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
                },
                dateClick: function (info) {
                    $('#schedule-start-date').val(info.dateStr)
                    $('#schedule-end-date').val(info.dateStr)
                    $('#date-event').modal('show')
                },
                // events: [
                //     {
                //         title: 'Click for Google',
                //         url: 'http://google.com/',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-20, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#50b5ff'
                //     },
                //     {
                //         title: 'All Day Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-18, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#a09e9e'
                //     },
                //     {
                //         title: 'Long Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-16, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         end: moment(new Date(), 'YYYY-MM-DD').add(-13, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#49f0d3'
                //     },
                //     {
                //         groupId: '999',
                //         title: 'Repeating Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-14, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#ffba68'
                //     },
                //     {
                //         groupId: '999',
                //         title: 'Repeating Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-12, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#d592ff '
                //     },
                //     {
                //         groupId: '999',
                //         title: 'Repeating Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-10, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#ff9b8a'
                //     },
                //     {
                //         title: 'Birthday Party',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-8, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#49f0d3'
                //     },
                //     {
                //         title: 'Meeting',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-6, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#a09e9e'
                //     },
                //     {
                //         title: 'Birthday Party',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-5, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#49f0d3'
                //     },
                //     {
                //         title: 'Birthday Party',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(-2, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#ff9b8a '
                //     },

                //     {
                //         title: 'Meeting',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(0, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#ff9b8a'
                //     },
                //     {
                //         title: 'Click for Google',
                //         url: 'http://google.com/',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(0, 'days').format('YYYY-MM-DD') + 'T06:30:00.000Z',
                //         color: '#d592ff'
                //     },
                //     {
                //         groupId: '999',
                //         title: 'Repeating Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(0, 'days').format('YYYY-MM-DD') + 'T07:30:00.000Z',
                //         color: '#49f0d3'
                //     },
                //     {
                //         title: 'Birthday Party',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(0, 'days').format('YYYY-MM-DD') + 'T08:30:00.000Z',
                //         color: '#f4a965'
                //     },
                //     {
                //         title: 'Doctor Meeting',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(0, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#f4a965'
                //     },
                //     {
                //         title: 'All Day Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(1, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: ' #50b5ff'
                //     },
                //     {
                //         groupId: '999',
                //         title: 'Repeating Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(8, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: ' #50b5ff'
                //     },
                //     {
                //         groupId: '999',
                //         title: 'Repeating Event',
                //         start: moment(new Date(), 'YYYY-MM-DD').add(10, 'days').format('YYYY-MM-DD') + 'T05:30:00.000Z',
                //         color: '#49f0d3'
                //     }
                // ]
            });
            calendar1.render();
        }

    /*---------------------------------------------------------------------
        weather
    -----------------------------------------------------------------------*/
        if(jQuery('#weather-chart').length){
            am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end


        // Create map instance
        var chart = am4core.create("weather-chart", am4maps.MapChart);

        // Set map definition
        chart.geodata = am4geodata_worldHigh;

        // Set projection
        chart.projection = new am4maps.projections.Mercator();

        // Center on the groups by default
        chart.homeZoomLevel = 6;
        chart.homeGeoPoint = { longitude: 10, latitude: 51 };

        // Polygon series
        var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
        polygonSeries.exclude = ["AQ"];
        polygonSeries.useGeodata = true;
        polygonSeries.nonScalingStroke = true;
        polygonSeries.strokeOpacity = 0.5;

        // Image series
        var imageSeries = chart.series.push(new am4maps.MapImageSeries());
        var imageTemplate = imageSeries.mapImages.template;
        imageTemplate.propertyFields.longitude = "longitude";
        imageTemplate.propertyFields.latitude = "latitude";
        imageTemplate.nonScaling = true;

        var image = imageTemplate.createChild(am4core.Image);
        image.propertyFields.href = "imageURL";
        image.width = 50;
        image.height = 50;
        image.horizontalCenter = "middle";
        image.verticalCenter = "middle";

        var label = imageTemplate.createChild(am4core.Label);
        label.text = "{label}";
        label.horizontalCenter = "middle";
        label.verticalCenter = "top";
        label.dy = 20;

        imageSeries.data = [{
          "latitude": 40.416775,
          "longitude": -3.703790,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/rainy-1.svg",
          "width": 32,
          "height": 32,
          "label": "Madrid: +22C"
        }, {
          "latitude": 48.856614,
          "longitude": 2.352222,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/thunder.svg",
          "width": 32,
          "height": 32,
          "label": "Paris: +18C"
        }, {
          "latitude": 52.520007,
          "longitude": 13.404954,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/cloudy-day-1.svg",
          "width": 32,
          "height": 32,
          "label": "Berlin: +13C"
        }, {
          "latitude": 52.229676,
          "longitude": 21.012229,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/day.svg",
          "width": 32,
          "height": 32,
          "label": "Warsaw: +22C"
        }, {
          "latitude": 41.872389,
          "longitude": 12.480180,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/day.svg",
          "width": 32,
          "height": 32,
          "label": "Rome: +29C"
        }, {
          "latitude": 51.507351,
          "longitude": -0.127758,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/rainy-7.svg",
          "width": 32,
          "height": 32,
          "label": "London: +10C"
        }, {
          "latitude": 59.329323,
          "longitude": 18.068581,
          "imageURL": "https://www.amcharts.com/lib/images/weather/animated/rainy-1.svg",
          "width": 32,
          "height": 32,
          "label": "Stockholm: +8C"
        } ];

        });
        }

    /*---------------------------------------------------------------------
    Editable Table
    -----------------------------------------------------------------------*/
        const $tableID = $("#table"),
        $BTN = $("#export-btn"),
        $EXPORT = $("#export"),
        newTr = '\n<tr class="hide">\n  <td class="pt-3-half" contenteditable="true">Example</td>\n  <td class="pt-3-half" contenteditable="true">Example</td>\n  <td class="pt-3-half" contenteditable="true">Example</td>\n  <td class="pt-3-half" contenteditable="true">Example</td>\n  <td class="pt-3-half" contenteditable="true">Example</td>\n  <td class="pt-3-half">\n    <span class="table-up"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a></span>\n    <span class="table-down"><a href="#!" class="indigo-text"><i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a></span>\n  </td>\n  <td>\n    <span class="table-remove"><button type="button" class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light">Remove</button></span>\n  </td>\n</tr>';
        $(".table-add").on("click", "i", () => {
            const e = $tableID.find("tbody tr").last().clone(!0).removeClass("hide table-line");
            0 === $tableID.find("tbody tr").length && $("tbody").append(newTr), $tableID.find("table").append(e)
        }), $tableID.on("click", ".table-remove", function() {
            $(this).parents("tr").detach()
        }), $tableID.on("click", ".table-up", function() {
            const e = $(this).parents("tr");
            1 !== e.index() && e.prev().before(e.get(0))
        }), $tableID.on("click", ".table-down", function() {
            const e = $(this).parents("tr");
            e.next().after(e.get(0))
        }), jQuery.fn.pop = [].pop, jQuery.fn.shift = [].shift, $BTN.on("click", () => {
            const e = $tableID.find("tr:not(:hidden)"),
                t = [],
                a = [];
            $(e.shift()).find("th:not(:empty)").each(function() {
                t.push($(this).text().toLowerCase())
            }), e.each(function() {
                const e = $(this).find("td"),
                    n = {};
                t.forEach((t, a) => {
                    n[t] = e.eq(a).text()
                }), a.push(n)
            }), $EXPORT.text(JSON.stringify(a))
        }), $(document).ready(function() {
            var e, t, a, n, o = 1,
                r = $("fieldset").length;

            function i(e) {
                var t = parseFloat(100 / r) * e;
                t = t.toFixed(), $(".progress-bar").css("width", t + "%")
            }
            i(o), $(".next").click(function() {
                e = $(this).parent(), t = $(this).parent().next(), $("#top-tab-list li").eq($("fieldset").index(t)).addClass("active"), $("#top-tab-list li").eq($("fieldset").index(e)).addClass("done"), t.show(), e.animate({
                    opacity: 0
                }, {
                    step: function(a) {
                        n = 1 - a, e.css({
                            display: "none",
                            position: "relative"
                        }), t.css({
                            opacity: n
                        })
                    },
                    duration: 500
                }), i(++o)
            }), $(".previous").click(function() {
                e = $(this).parent(), a = $(this).parent().prev(), $("#top-tab-list li").eq($("fieldset").index(e)).removeClass("active"), $("#top-tab-list li").eq($("fieldset").index(a)).removeClass("done"), a.show(), e.animate({
                    opacity: 0
                }, {
                    step: function(t) {
                        n = 1 - t, e.css({
                            display: "none",
                            position: "relative"
                        }), a.css({
                            opacity: n
                        })
                    },
                    duration: 500
                }), i(--o)
            }), $(".submit").click(function() {
                return !1
            })
        }), $(document).ready(function() {
        var e = $("div.setup-panel div a"),
            t = $(".setup-content"),
            a = $(".nextBtn");
        t.hide(), e.click(function(a) {
            a.preventDefault();
            var n = $($(this).attr("href")),
                o = $(this);
            o.hasClass("disabled") || (e.addClass("active"), o.parent().addClass("active"), t.hide(), n.show(), n.find("input:eq(0)").focus())
        }), a.click(function() {
            var e = $(this).closest(".setup-content"),
                t = e.attr("id"),
                a = $('div.setup-panel div a[href="#' + t + '"]').parent().next().children("a"),
                n = e.find("input[type='text'],input[type='email'],input[type='password'],input[type='url'],textarea"),
                o = !0;
            $(".form-group").removeClass("has-error");
            for (var r = 0; r < n.length; r++) n[r].validity.valid || (o = !1, $(n[r]).closest(".form-group").addClass("has-error"));
            o && a.removeAttr("disabled").trigger("click")
        }), $("div.setup-panel div a.active").trigger("click")
        }), $(document).ready(function() {
        var e, t, a, n, o = 1,
            r = $("fieldset").length;
        function i(e) {
            var t = parseFloat(100 / r) * e;
            t = t.toFixed(), $(".progress-bar").css("width", t + "%")
        }
        i(o), $(".next").click(function() {
            e = $(this).parent(), t = $(this).parent().next(), $("#top-tabbar-vertical li").eq($("fieldset").index(t)).addClass("active"), t.show(), e.animate({
                opacity: 0
            }, {
                step: function(a) {
                    n = 1 - a, e.css({
                        display: "none",
                        position: "relative"
                    }), t.css({
                        opacity: n
                    })
                },
                duration: 500
            }), i(++o)
        }), $(".previous").click(function() {
            e = $(this).parent(), a = $(this).parent().prev(), $("#top-tabbar-vertical li").eq($("fieldset").index(e)).removeClass("active"), a.show(), e.animate({
                opacity: 0
            }, {
                step: function(t) {
                    n = 1 - t, e.css({
                        display: "none",
                        position: "relative"
                    }), a.css({
                        opacity: n
                    })
                },
                duration: 500
            }), i(--o)
        }), $(".submit").click(function() {
            return !1
        })
        }), $(document).ready(function() {
        $(".file-upload").on("change", function() {
            ! function(e) {
                if (e.files && e.files[0]) {
                    var t = new FileReader;
                    t.onload = function(e) {
                        $(".profile-pic").attr("src", e.target.result)
                    }, t.readAsDataURL(e.files[0])
                }
            }(this)
        }), $(".upload-button").on("click", function() {
            $(".file-upload").click()
        })
        }), $(function() {
            function e(e) {
                return e / 100 * 360
            }
            $(".progress-round").each(function() {
                var t = $(this).attr("data-value"),
                    a = $(this).find(".progress-left .progress-bar"),
                    n = $(this).find(".progress-right .progress-bar");
                t > 0 && (t <= 50 ? n.css("transform", "rotate(" + e(t) + "deg)") : (n.css("transform", "rotate(180deg)"), a.css("transform", "rotate(" + e(t - 50) + "deg)")))
            })
        });
    });

    /*------------Resize Plugins--------------*/
    const resizePlugins = () => {
        // For sidebar-mini & responsive
        const sidebarResponsive = document.querySelector('[data-sidebar="responsive"]')
        if (window.innerWidth < 1025) {
            if (sidebarResponsive !== null) {
                if (!sidebarResponsive.classList.contains('sidebar-mini')) {
                sidebarResponsive.classList.add('sidebar-mini', 'on-resize')
                }
            }
        }
        else {
            if (sidebarResponsive !== null) {
                if (sidebarResponsive.classList.contains('sidebar-mini') && sidebarResponsive.classList.contains('on-resize')) {
                sidebarResponsive.classList.remove('sidebar-mini', 'on-resize')
                }
            }
        }
    }

    /*------------DOMContentLoaded--------------*/
        document.addEventListener('DOMContentLoaded', (event) => {
            resizePlugins()
        });
    /*------------Window Resize------------------*/
        window.addEventListener('resize', function (event) {
            resizePlugins()
        });
})(jQuery);

function current_password_show_hide() {
    var x = document.getElementById("current_password");
    var show_eye = document.getElementById("show_eye2");
    var hide_eye = document.getElementById("hide_eye2");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}

function password_show_hide() {
    var x = document.getElementById("password");
    var show_eye = document.getElementById("show_eye");
    var hide_eye = document.getElementById("hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}

function confirm_password_show_hide() {
    var x = document.getElementById("password_confirmation");
    var show_eye = document.getElementById("show_eye1");
    var hide_eye = document.getElementById("hide_eye1");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye1.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye1.style.display = "none";
    }
}

var existingFiles = [];
var addMoreTime = 0;
function addMoreFiles() {

    var currentTime = Date.now();
    if (currentTime - addMoreTime < 50) {
        return;
    }
    addMoreTime = currentTime;
    var input = document.getElementsByClassName("fileInputGetOldValues");
    var newFiles = input[0].files;
    var allFiles = existingFiles.concat(Array.from(newFiles));
    var dataTransfer = new DataTransfer();
    allFiles.forEach(function (file) {
        dataTransfer.items.add(file);
    });
    input[0].files = dataTransfer.files;
    existingFiles = allFiles;

}

function previewImages() {
    console.log(existingFiles, 'oldfile');
    var inputODI = document.getElementsByClassName("fileInputGetOldValues");
    console.log(inputODI[0].files ,'new');
    var newFilesODI = inputODI[0].files;
    var allFilesODI = existingFiles.concat(Array.from(newFilesODI));
    var dataTransferODI = new DataTransfer();
    allFilesODI.forEach(function (file) {
      dataTransferODI.items.add(file);
    });
    console.log(dataTransferODI.files, 'old');
    inputODI[0].files = dataTransferODI.files;
    existingFiles = [];

    var preview = document.querySelector('#preview');
    preview.innerHTML = '';
    var files = document.querySelector('#profileImagePost').files;
    
    var index = 0;

    for (var i = 0; i < files.length; i++) {

        let file = files[i];
        var index = i;


        let reader = new FileReader();
        (function(index) {
        reader.onload = function (event) {
            var element;

            if (file.type.match('video.*')) { // Check if the file is a video
                let preview = document.getElementById('preview');

                // Create a video element
                var div = document.createElement('div')
                var button = document.createElement('button')
                div.style.position ="relative";
                button.textContent = "X"
                button.id = file.lastModified;
                button.title = "delete image"
                button.style.position="absolute";
                button.style.top="15px";
                button.style.right="15px";
                button.style.color="#e8e4ed";
                button.style.marginTop ="11px";
                button.style.backgroundColor="#121111";
                button.style.fontWeight="600";
                button.style.borderRadius="50%";
                button.style.border="solid #e8e4ed 2px";
                button.style.zIndex="999";
                button.style.width="28px";

                let element = document.createElement('video');
                element.classList.add('custom-video');
                element.style.marginTop = "1rem";
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                element.src = URL.createObjectURL(file); // Create a new URL for each video file

                // Create a button element
                let elementButton = document.createElement('button');
                elementButton.classList.add('play-pause-button');
                elementButton.onclick = function(e) {
                    e.preventDefault();
                    // let video = document.getElementsByClassName('custom-video')[0];
                    let video = this.parentElement.querySelector('.custom-video');
                    // let playPauseButton = document.getElementsByClassName('play-pause-button')[0];
                    let playPauseButton = this.parentElement.querySelector('.play-pause-button');
                    if (video.paused) {
                        video.play();
                        playPauseButton.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg style=\'color: rgb(140, 104, 205)\' viewBox=\'0 0 1024 1024\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath fill=\'rgb(140, 104, 205)\' d=\'M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768zm-96-544q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32zm192 0q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32z\'%3E%3C/path%3E%3C/svg%3E")';
                    } else {
                        video.pause();
                        playPauseButton.style.backgroundImage = "url('data:image/svg+xml,%3Csvg style=\'color: rgb(140, 104, 205)\' xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' class=\'bi bi-play\' viewBox=\'0 0 16 16\'%3E%3Cpath d=\'M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z\' fill=\'rgb(140, 104, 205)\'%3E%3C/path%3E%3C/svg%3E')";
                    }
                };

                // Add the video and button elements to the video container div
                button.addEventListener('click', (evt) => {
                  //here i transfer reset the file input by removing the file on index base
                    var sourceInput = document.querySelector('#profileImagePost');
                    var destinationInput = document.querySelector('#profileImagePost');
                    var files = sourceInput.files;
                    files =Array.from(files);
                    files.splice(evt.target.lastModified,1);
                    // Create a new DataTransfer object
                    var dataTransfer = new DataTransfer();
                    // Add files from the source input to the DataTransfer object
                    for (let i = 0; i < files.length; i++) {
                      var file = files[i];
                      dataTransfer.items.add(file);
                    }
                    destinationInput.files = dataTransfer.files;

                    preview.removeChild(div)
                  })
                //end code
            let videoContainer = document.createElement('div');
            videoContainer.classList.add('video-container');
            div.appendChild(button)
            div.appendChild(element);
            div.appendChild(elementButton);
            div.appendChild(videoContainer)
            preview.appendChild(div)
            } else {

                var div = document.createElement('div') //create wrapper of image
                var button = document.createElement('button') //create button for remove image
                div.style.position ="relative";
                button.textContent = "X"
                button.title = "delete image"
                button.id = file.lastModified;
                button.style.position="absolute";
                button.style.top="15px";
                button.style.right="15px";
                button.style.color="#e8e4ed";
                button.style.marginTop ="11px";
                button.style.backgroundColor="#121111";
                button.style.fontWeight="600";
                button.style.borderRadius="50%";
                button.style.border="solid #e8e4ed 2px";
                button.style.width="28px";

                element = document.createElement('img');
                element.src = event.target.result;
                element.style.marginTop = "1rem";
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                // function for remove image on btn click
                button.addEventListener('click', (evt) => {
                    var sourceInput = document.querySelector('#profileImagePost');
                    var destinationInput = document.querySelector('#profileImagePost');
                    var files = sourceInput.files;

                    files =Array.from(files);
                    files.splice(evt.target.lastModified,1);

                    // Create a new DataTransfer object
                    
                    var dataTransfer = new DataTransfer();
                    files.forEach(function(file) {
                        dataTransfer.items.add(file);
                    });

                    destinationInput.files = dataTransfer.files
                    preview.removeChild(div);
                  })
                //end code
                div.appendChild(button)
                div.appendChild(element)
                preview.appendChild(div)
            }
        };
    })(index);
        reader.readAsDataURL(file);
    }
}

function previewalbumImages()
        {
            var preview = document.querySelector('#previewalbum');
            preview.innerHTML = '';
            var files = document.querySelector('#albumsImage').files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();
                reader.onload = function (event) {
                    var element;
                        element = document.createElement('img');
                        element.src = event.target.result;
                        element.style.marginTop = "1rem";
                        element.style.width = '100%';
                        element.style.height = '100%';
                        element.style.objectFit = 'cover';
                    preview.appendChild(element);
                };
                reader.readAsDataURL(file);
            }
        }

function previewStoryImages() {
    var preview = document.querySelector('#previewStoryImgDisplay');
    preview.innerHTML = '';
    var files = document.querySelector('#profileImageStory').files;
    for (var i = 0; i < 1; i++) {
        var file = files[i];
        var reader = new FileReader();
        reader.onload = function (event) {
            var element;
            //console.log(event);
            //console.log(event.currentTarget.result.indexOf("video",5));
            var getType =  event.currentTarget.result.indexOf("video",5);
            //if (file.type.match('video.*')) { // Check if the file is a video
              if (getType != -1) {
                let preview = document.getElementById('previewStoryImgDisplay');
                // Create a video element
                console.log(file);
                let element = document.createElement('video');
                element.classList.add('custom-video');
                element.style.marginTop = "1rem";
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                element.src = URL.createObjectURL(file); // Create a new URL for each video file

                // Create a button element
                let elementButton = document.createElement('button');
                elementButton.classList.add('play-pause-button');
                elementButton.onclick = function(e) {
                    e.preventDefault();
                    // let video = document.getElementsByClassName('custom-video')[0];
                    let video = this.parentElement.querySelector('.custom-video');
                    // let playPauseButton = document.getElementsByClassName('play-pause-button')[0];
                    let playPauseButton = this.parentElement.querySelector('.play-pause-button');
                    if (video.paused) {
                        video.play();
                        playPauseButton.style.backgroundImage = 'url("data:image/svg+xml,%3Csvg style=\'color: rgb(140, 104, 205)\' viewBox=\'0 0 1024 1024\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath fill=\'rgb(140, 104, 205)\' d=\'M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm0 832a384 384 0 0 0 0-768 384 384 0 0 0 0 768zm-96-544q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32zm192 0q32 0 32 32v256q0 32-32 32t-32-32V384q0-32 32-32z\'%3E%3C/path%3E%3C/svg%3E")';
                    } else {
                        video.pause();
                        playPauseButton.style.backgroundImage = "url('data:image/svg+xml,%3Csvg style=\'color: rgb(140, 104, 205)\' xmlns=\'http://www.w3.org/2000/svg\' width=\'16\' height=\'16\' fill=\'currentColor\' class=\'bi bi-play\' viewBox=\'0 0 16 16\'%3E%3Cpath d=\'M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z\' fill=\'rgb(140, 104, 205)\'%3E%3C/path%3E%3C/svg%3E')";
                    }
                };

                // Add the video and button elements to the video container div
                let videoContainer = document.createElement('div');
                videoContainer.classList.add('video-container');
                videoContainer.appendChild(element);
                videoContainer.appendChild(elementButton);

                preview.appendChild(videoContainer);

            } else {
                element = document.createElement('img');
                element.src = event.target.result;
                element.style.marginTop = "1rem";
                element.style.width = '100%';
                element.style.height = '100%';
                element.style.objectFit = 'cover';
                preview.appendChild(element);
            }
            // preview.appendChild(element);
        };
        reader.readAsDataURL(file);
    }
}

function leaveGroup(userId,groupId)
   {
    console.log(userId,groupId);
      $.ajax({
         method: 'POST',
         url: '/leaveGroup',
         data: {userId: userId,groupId:groupId},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {
        console.log(response);
            var joinGroupButton = $("#groupPagerefresh");
            if (joinGroupButton.length) {
                joinGroupButton.hide().load(" #groupPagerefresh"+"> *").fadeIn(0);
            }

            var leaveGroupButton = $("#joinOrLeaveGroupButton");
            if (leaveGroupButton.length) {
                leaveGroupButton.hide().load(" #joinOrLeaveGroupButton"+"> *").fadeIn(0);
            }

            window.location.reload();
      });
   }
    function joinGroup(userId,groupId)
    {
      $.ajax({
         method: 'POST',
         url: '/join-group',
         data: {userId: userId,groupId:groupId},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {
         $("#joinOrLeaveGroupButton").hide().load(" #joinOrLeaveGroupButton"+"> *").fadeIn(0);
         $("#groupPagerefresh").hide().load(" #groupPagerefresh"+"> *").fadeIn(0);
      });
    }
    function unfollowGroupMember(userId,groupId)
    {
      $.ajax({
         method: 'POST',
         url: '/unfollowGroupMember',
         data: {userId: userId,groupId:groupId},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {

         $("#joinOrLeaveGroupButton").hide().load(" #joinOrLeaveGroupButton"+"> *").fadeIn(0);
      });
    }
    function followGroupMember(userId,groupId)
    {
      $.ajax({
         method: 'POST',
         url: '/followGroupMember',
         data: {userId: userId,groupId:groupId},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {

         $("#joinOrLeaveGroupButton").hide().load(" #joinOrLeaveGroupButton"+"> *").fadeIn(0);
      });
    }

// profile blade friend request
function approveRequestProfile(user_id) {
    $.ajax({
       method: 'GET',
       url: '/user-confirm/'+user_id,
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
     $("#updateProfileFriendRequestDiv").hide().load(" #updateProfileFriendRequestDiv"+"> *").fadeIn(0);

    });
 }


 function disapproveRequestProfile(reqID) {
    $.ajax({
       method: 'GET',
       url: '/user-delete/'+reqID,
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
         $("#updateProfileFriendRequestDiv").hide().load(" #updateProfileFriendRequestDiv"+"> *").fadeIn(0);
    });
 }

 function notificationReadBadge()
 {
    $('#notificationBadgeReadFresh').html('');
    $.ajax({
       method: 'GET',
       url: "/notificationreadbadge",
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
    })
 }

function joinGroupForm(groupId,userId) {
    $.ajax({
        method: 'POST',
        url: '/join-group',
        data: {userId: userId, groupId :groupId},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (response) {
        refreshNavlinks();
        $("#leaveGroupForm").removeClass('d-none');
        if(response.alreadyJoined == 0){
            if(response.Private == 1){
                $('.cancelGroupRequest_'+groupId+'_'+userId).removeClass('d-none');
                $('.joinGroup_'+groupId+'_'+userId).addClass('d-none');
            }
            else{
                $('.leaveGroup_'+groupId+'_'+userId).removeClass('d-none');
                $('.joinGroup_'+groupId+'_'+userId).addClass('d-none');
            }
        }
        else{
            $('.joinGroup_'+groupId+'_'+userId).addClass('d-none');
        }
    });
}

function leaveGroupForm(groupId,userId)
   {
      $.ajax({
         method: 'POST',
         url: '/leave-group',
         data: {userId: userId,groupId:groupId},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {
        console.log(response);
        $("#joinOrLeaveGroupButton").hide().load(" #joinOrLeaveGroupButton"+"> *").fadeIn(0);
        refreshNavlinks();
        if(response.alreadyJoined == 0){
            if(response.Private == 1){
                $('.cancelGroupRequest_'+groupId+'_'+userId).addClass('d-none');
                $('.joinGroup_'+groupId+'_'+userId).removeClass('d-none');
            }
            else{
                $('.leaveGroup_'+groupId+'_'+userId).addClass('d-none');
                $('.joinGroup_'+groupId+'_'+userId).removeClass('d-none');
            }
        }
        else{
            $('.cancelGroupRequest_'+groupId+'_'+userId).addClass('d-none');
            $('.leaveGroup_'+groupId+'_'+userId).addClass('d-none');
            $('.joinGroup_'+groupId+'_'+userId).removeClass('d-none');
        }
      });
   }

 function likePageForm(pageId,userId) {

    $.ajax({
       method: 'POST',
       url: '/like-page',
       data: {userId: userId, pageId :pageId},
       headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
    }).done(function (response) {
        console.log(response);
    //    $('.likePage'+pageId).text('Liked').prop('disabled', true);
    refreshNavlinks();
    if(response.alreadyLiked == 0){
        if(response.Private == 1){
            $('.cancelRequestPage'+pageId).removeClass('d-none');
            $('.likePage'+pageId).addClass('d-none');
        }
        else{
            $('.UnlikePage'+pageId).removeClass('d-none');
            $('.likePage'+pageId).addClass('d-none');
        }
    }
    else{
        $('.cancelRequestPage'+pageId).addClass('d-none');
        $('.UnlikePage'+pageId).addClass('d-none');
        $('.likePage'+pageId).removeClass('d-none');
    }


    });
 }

 function UnLikePageIndex(pageId,userId)
   {
      $.ajax({
         method: 'POST',
         url: '/leave-page',
         data: {userId: userId,pageId:pageId},
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      }).done(function (response) {
        refreshNavlinks();
        if(response.alreadyJoined == 0){
            if(response.Private == 1){
                $('.cancelRequestPage'+pageId).addClass('d-none');
                $('.likePage'+pageId).removeClass('d-none');
            }
            else{
                $('.UnlikePage'+pageId).addClass('d-none');
                $('.likePage'+pageId).removeClass('d-none');
            }
        }
        else{
            $('.cancelRequestPage'+pageId).addClass('d-none');
            $('.UnlikePage'+pageId).addClass('d-none');
            $('.likePage'+pageId).removeClass('d-none');
        }
      });
   }
//Profile Blade Page Javascript>
function refreshNavlinks(){
    // $("#join-groups-list").load(" #join-groups-list"+"> *");
    // $("#liked-pages-list").load(" #liked-pages-list"+"> *");

}

function updateNotificationData(){
    var notificationArea = $('#notification-area').scrollTop();
    $("#notification-area").hide().load(" #notification-area"+"> *").fadeIn(0);
    $('#notification-area').scrollTop(notificationArea);
}
function updateFriendRequestData(){
    $("#friendRequestUpdate").hide().load(" #friendRequestUpdate"+"> *").fadeIn(0);
}
function updateChatData(){
    var user_chats = $('#user_chats').scrollTop();
    $("#user_chats").hide().load(" #user_chats"+"> *").fadeIn(0);
    $('#user_chats').scrollTop(user_chats);
}

    var updateNotification = false;
    var notificationRefresh = 0;
    var chatRefresh = 0;
    var friendRequestRefresh = 0;
    function notificationBadgeReadFreshSpan() {
        if (typeof updateNotification == true) {
            return;
        }
        $.ajax({
        url: "/get-badge-data-bodyheader",
        type: "GET",
        success: function(response) {
            if(response) {
                if(response.notifications > 0){

                    if(notificationRefresh != response.notifications){
                        updateNotificationData();
                    }
                    notificationRefresh = response.notifications;
                    
                    $('#notificationBadgeReadFresh').html('<span id="notificationBadge" class="badge badge-pill position-absolute rounded-pill" style="background-color: var(--bs-primary); font-size:14px; bottom:40px; padding:2px 5px 20px 5px; height:17px; left:27px;"><p>'+ response.notifications +'</p></span>').show();
                }else{
                    $('#notificationBadgeReadFresh').html('')
                }
                if(response.chats > 0){

                    if(chatRefresh != response.chats){
                        updateNotificationData();
                    }
                    chatRefresh = response.chats;
                    
                    $('#chatBadgeReadFresh').html('<span id="chatBadge" class="badge badge-pill position-absolute rounded-pill" style="background-color: var(--bs-primary); font-size:14px; bottom:40px; padding:2px 5px 20px 5px; height:17px; left:27px;"><p>'+ response.chats +'</p></span>').show()
                }else{
                    $('#chatBadgeReadFresh').html('')
                }
                if(response.friendRequest > 0){
                    
                    if(friendRequestRefresh != response.friendRequest){
                        updateNotificationData();
                    }
                    friendRequestRefresh = response.friendRequest;

                    $('#friendRequestBadgeReadFresh').html('<span id="friendRequesBadge" class="badge badge-pill position-absolute rounded-pill" style="background-color: var(--bs-primary); font-size:14px; bottom:40px; padding:2px 5px 20px 5px; height:17px; left:27px;"><p>'+ response.friendRequest +'</p></span>').show()
                }else{
                    $('#friendRequestBadgeReadFresh').html('')
                }

                updateNotification = false;
            }
        }
        });
    };
    setInterval(notificationBadgeReadFreshSpan, 5000);

    function followFriendUser(userName) {
        $.ajax({
            method: 'GET',
            url: '/followUser/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.followFriend_' + userName).addClass('d-none');
            $('.unfollowFriend_' + userName).removeClass('d-none');
            $("#updateFollowFollowing").hide().load(" #updateFollowFollowing"+"> *").fadeIn(0);
        });
    }

    function unfollowFriendUser(userName) {
        $.ajax({
            method: 'GET',
            url: '/unfollowUser/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.followFriend_' + userName).removeClass('d-none');
            $('.unfollowFriend_' + userName).addClass('d-none');
            $("#updateFollowFollowing").hide().load(" #updateFollowFollowing"+"> *").fadeIn(0);
        });
    }

    function blockFriendUser(userName) {
        $.ajax({
            method: 'GET',
            url: '/blockFriend/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            location.replace('/generalsetting')
        });
    }

    function unblockFriendUser(userName) {
        $.ajax({
            method: 'GET',
            url: '/unblockFriend/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.blockFriend_' + userName).removeClass('d-none');
            $('.unblockFriend_' + userName).addClass('d-none');
        });
    }

    function blockFriendUserTab(userName) {
        $.ajax({
            method: 'GET',
            url: '/blockFriend/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            location.replace('/generalsetting')
        });
    }

    function unblockFriendUserTab(userName) {
        $.ajax({
            method: 'GET',
            url: '/unblockFriend/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.blockFriendBlockSection_' + userName).removeClass('d-none');
            $('.unblockFriendBlockSection_' + userName).addClass('d-none');
        });
    }

    function unFriendUser(userName) {
        $.ajax({
            method: 'GET',
            url: '/unFriend/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.updateProfileFriendRequestDiv_' + userName).addClass('d-none');
            $('.addToFriend_' + userName).removeClass('d-none');

        });
    }

    function addToFriendUser(userName) {
        $.ajax({
            method: 'GET',
            url: '/addToFriend/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.addToFriend_' + userName).addClass('d-none');
            $('.updateProfileFriendRequestDiv_' + userName).addClass('d-none');
            $('.cancelRequest_' + userName).removeClass('d-none');
        });
    }

    function cancelRequestUser(userName) {

        $.ajax({
            method: 'GET',
            url: '/cancelRequest/' + userName,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            $('.cancelRequest_' + userName).addClass('d-none');
            $('.addToFriend_' + userName).removeClass('d-none');

        });
    }
    function approveRequestProfileUser(user_id , userName) {
        $.ajax({
           method: 'GET',
           url: '/user-confirm/'+user_id,
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        }).done(function (response) {

            $('.hideApproveFriendSection_' + userName).removeClass('d-none');
            $('.respondRequest_' + userName).addClass('d-none');
        });
     }


     function disapproveRequestProfileUser(reqID , userName) {
        $.ajax({
           method: 'GET',
           url: '/user-delete/'+reqID,
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        }).done(function (response) {
            $('.addToFriend_' + userName).removeClass('d-none');
            $('.respondRequest_' + userName).addClass('d-none');
        });
     }

     function savePost(feedId) {
        $.ajax({
            method: 'GET',
            url: '/savePost/'+ feedId,
            data: {
                feedId: feedId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if(response.status == 1){
                $('#savePostDiv_'+feedId).addClass('d-none');
                $('#removePostDiv_'+feedId).removeClass('d-none');
            }
        });
    }
    function removePost(feedId) {
        $.ajax({
            method: 'GET',
            url: '/removePost/'+ feedId,
            data: {
                feedId: feedId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if(response.status == 1){
                $('#savePostDiv_'+feedId).removeClass('d-none');
                $('#removePostDiv_'+feedId).addClass('d-none');
            }
        });
    }
    // Page And Group Post Create
    $(document).on('submit', 'form.groupAndPagePostCreate', function(e) {
    e.preventDefault();
    console.log(e);
    if ($('#postText').val() == '' && $('#profileImagePost').val() == '') {
            $('#PostCreateButton').attr('disabled','disabled');
        }else{
            $('.cover_spin_ProfilePhotoUpdate').show();
            $.ajax({
            url:'/createGroupAndPagePost',
            method:'POST',
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false
            }).done(function(response){
                existingFiles = [];
                $('.create-post-form')[0].reset();
                $("#preview").empty();
                
                if(response.feedType == 'groupfeed', response.data.groupRequest == 'Private')
                    $(".feedApprovals").hide().load(" .feedApprovals"+"> *").fadeIn(0);
                
                $('#post-modal').modal("hide");
                $(".updateFeed").hide().load(" .updateFeed"+"> *").fadeIn(0);
                // Enable submit button
                $('#PostCreateButton').removeAttr('disabled');
                setTimeout(function() {
                    $('.cover_spin_ProfilePhotoUpdate').hide();
                }, 3000);
            });
        }
        $('#PostCreateButton').attr('disabled','disabled');
    });


    $('.buttonEnable').click(function(event) {
        $("#PostCreateButton").removeAttr('disabled');
    });

    var postText = document.getElementById("postText");
    if(postText){
        postText.addEventListener("input", function() {
            $("#PostCreateButton").removeAttr('disabled');
        });
    }
    var profileImagePost = document.getElementById("profileImagePost");
    if(profileImagePost){
        profileImagePost.addEventListener("change", function() {
            $("#PostCreateButton").removeAttr('disabled');
        });
    }
    // Profile And Timeline Post Create 
    function enableButton(){
        $("#PostCreateButton").removeAttr('disabled');
    }

    function createPostModalShow(){
        $('#post-modal').modal("show");
    }

    $(document).on('submit', 'form.profileTimelineFeed', function(e) {
        e.preventDefault();
        if ($('#postText').val() == '' && $('#profileImagePost').val() == '') {
            $('#PostCreateButton').attr('disabled','disabled');
        }else{
            $('.cover_spin_ProfilePhotoUpdate').show();
            $.ajax({
            url:'/createProfileTimelineFeed',
            method:'POST',
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false
            }).done(function(response){
                existingFiles = [];
                $('.create-post-form')[0].reset();
                $("#preview").empty();
                $('#post-modal').modal("hide");
                $(".updateFeed").hide().load(" .updateFeed"+"> *").fadeIn(0);
                // Enable submit button
                $('#PostCreateButton').removeAttr('disabled');
                setTimeout(function() {
                    $('.cover_spin_ProfilePhotoUpdate').hide();
                }, 3000);
                
            });
        }
            $('#PostCreateButton').attr('disabled','disabled');
    });

        // $('.buttonEnable').click(function(event) {
        //     $("#PostCreateButton").removeAttr('disabled');
        // });

        var postText = document.getElementById("postText");
        if(postText){
            postText.addEventListener("input", function() {
                $("#PostCreateButton").removeAttr('disabled');
            });
        }
        var profileImagePost = document.getElementById("profileImagePost");
        if(profileImagePost){
            profileImagePost.addEventListener("change", function() {
                $("#PostCreateButton").removeAttr('disabled');
            });
        }

        // Group Requeset Approve
        function approveGroupRequest(requestedUserId, groupId, adminUserId)
        {
         $.ajax({
            method: 'POST',
            url: '/approveGroupRequest/'+requestedUserId+'/'+groupId+'/'+adminUserId,
            data: {requestedUserId: requestedUserId, groupId:groupId, adminUserId: adminUserId},
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         }).done(function (response) {
            $('#approveGroupRequest'+response.requestedUserId).hide();
            $('#rejectGroupRequest'+response.requestedUserId).hide();
            $('#approved'+response.requestedUserId).removeClass('d-none');
            $('.group-join-request-approve-'+response.requestedUserId).addClass('d-none');
            $(".iq-media-group").hide().load(" .iq-media-group"+"> *").fadeIn(0);
            $(".joinRequests").hide().load(" .joinRequests"+"> *").fadeIn(0);
            $(".allMembers").hide().load(" .allMembers"+"> *").fadeIn(0);
         });
        }
        // Group Requeset Reject
      function rejectGroupRequest(requestedUserId, groupId, adminUserId)
        {
         $.ajax({
            method: 'POST',
            url: '/rejectGroupRequest/'+requestedUserId+'/'+groupId+'/'+adminUserId,
            data: {requestedUserId: requestedUserId, groupId:groupId, adminUserId: adminUserId},
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         }).done(function (response) {
             $('#approveGroupRequest'+response.requestedUserId).hide();
            $('#rejectGroupRequest'+response.requestedUserId).hide();
            $('#rejected'+response.requestedUserId).removeClass('d-none');
            $(".iq-media-group").hide().load(" .iq-media-group"+"> *").fadeIn(0);
            $(".joinRequests").hide().load(" .joinRequests"+"> *").fadeIn(0);
         });
        }
      function removeMember(requestedUserId, groupId, adminUserId)
        {
         $.ajax({
            method: 'POST',
            url: '/removeMember/'+requestedUserId+'/'+groupId+'/'+adminUserId,
            data: {requestedUserId: requestedUserId, groupId:groupId, adminUserId: adminUserId},
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         }).done(function (response) {
                $('.removeMember'+response.requestedUserId).addClass('d-none');
                $(".joinRequests").hide().load(" .joinRequests"+"> *").fadeIn(0);
         });
        }

        var dropdownToggles = document.querySelectorAll('.avoideCloseDropdown');
        dropdownToggles.forEach(function(dropdownToggle) {
           dropdownToggle.addEventListener('click', function(event) {
              event.stopPropagation();
           });
        });

        $(document).on('mouseenter', '.readNotificationsDropdown', function() {
           $(this).find('.delete_notification_hover').removeClass('d-none');
        }).on('mouseleave', '.readNotificationsDropdown', function() {
           $(this).find('.delete_notification_hover').addClass('d-none');
           $(this).find('.delete_notification_hover :nth-child(2)').removeClass('show');
        });

        $(document).on('mouseenter', '.unReadNotificationsDropdown', function() {
           $(this).find('.unreadNotificationDot').addClass('d-none');
           $(this).find('.delete_notification_hover').removeClass('d-none');
        }).on('mouseleave', '.unReadNotificationsDropdown', function() {
           $(this).find('.delete_notification_hover').addClass('d-none');
           $(this).find('.delete_notification_hover :nth-child(2)').removeClass('show');
           $(this).find('.unreadNotificationDot').removeClass('d-none');
        });

        $(document).on('mouseenter', '.readNotificationsDropdownPage', function() {
            $(this).find('.delete_notification_hover_page').removeClass('d-none');
         }).on('mouseleave', '.readNotificationsDropdownPage', function() {
            $(this).find('.delete_notification_hover_page :nth-child(2)').removeClass('show');
         });

         $(document).on('mouseenter', '.unReadNotificationsDropdownPage', function() {
            $(this).find('.unreadNotificationDot').addClass('d-none');
            $(this).find('.delete_notification_hover_page').removeClass('d-none');
         }).on('mouseleave', '.unReadNotificationsDropdownPage', function() {
            $(this).find('.delete_notification_hover_page :nth-child(2)').removeClass('show');
            $(this).find('.unreadNotificationDot').removeClass('d-none');
         });

        function deleteNotification(deleteNotification) {
            $.ajax({
               method: 'GET',
               url: '/delete-notification/'+deleteNotification,
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            }).done(function (response) {
               $('.deleteNotification_'+deleteNotification).addClass('d-none');
            });
         }
         function scrollToTop() {
            $(window).scrollTop(0);
        }
        // Amir@add the functionality to show the related image in gallery
        function showAllImages(feed_id,image_array,user_id,url) {
            var totalLoadedImageLEngth = image_array.length;
            var totalAncherTagOnDiv = $("#graterThanTwoImageMainDiv-"+feed_id).find('a').length;
            if(totalLoadedImageLEngth == totalAncherTagOnDiv)
            {
                return false;
            }

            for (let index = 2; index < image_array.length; index++) {
                var img = image_array[index];
                var image_url =url+'/'+user_id+'/'+img.attachment;
                var a =` <a data-fslightbox="gallery-${feed_id}" href="${image_url}">
                <img src="${image_url}" alt="post4-image" class="img-fluid rounded w-100" loading="lazy">
                   </a>`;
                $("#graterThanTwoImageMainDiv-"+feed_id).append(a);
                refreshFsLightbox();

            }

        }
function saveLike(feedId, commentId, userId) {
    $.ajax({
        method: 'POST',
        url: '/savePostLike',
        data: {
            userId: userId,
            feedId: feedId,
            commentId: commentId,
            type: "like"
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function(response) {
        // console.log(response);
        updateDiv(feedId);
    });
}

$(document).ready(function() {
    $('#my-form').submit(function(event) {
        if ($('#postText').val() == '' && $('#profileImage').val() == '') {
            alert('Please enter at least one field!');
            event.preventDefault();
        }
    });
});

// var a2a_config = a2a_config || {};
//  a2a_config.linkname = 'Example Page 1';
//  a2a_config.linkurl = 'http://www.example.com/page_1.html';
// function updateLinkUrl(feedUrl) {
//     a2a_config.linkurl = feedUrl;
//     console.log(a2a_config);
// }
// document.getElementById('share-feed-button').addEventListener('click', function() {
//     var linkFeed = document.getElementById('share-feed-input').value;
//     var feedUrl = 'share-feed/' + linkFeed;
//     updateLinkUrl(feedUrl);
// });

// $(document).ready(function() {
//     var a2a_config = a2a_config || {};
//     a2a_config.linkname = 'Example Page 1';
//     a2a_config.linkurl = 'xyz';
//     a2a.init('page');
//     // a2a_config.num_services = 12;

    

    
    
// });

// var a2a_config = a2a_config || {};
// a2a_config.linkname = 'Example Page 1';
// a2a_config.linkurl = 'http://www.example.com/page_1.html';

// function updateLinkUrl(feedUrl) {
//     a2a_config.linkurl = feedUrl;
    
//     // Re-initialize the All-in-One Share Buttons script
//     if (window.a2a) {
//         a2a.init();
//     }
    
//     console.log(a2a_config);
// }

// document.getElementById('share-feed-button').addEventListener('click', function() {
//     var linkFeed = document.getElementById('share-feed-input').value;
//     var feedUrl = 'share-feed/' + linkFeed;
//     updateLinkUrl(feedUrl);
// });

$(document).ready(function() {
    $('#postText').on('keydown', function(event) {
        if (event.key === "Enter" || event.keyCode === 13) {
            event.preventDefault();
        }
    });
});

$(document).ready(function() {
    function handleResize() {
       var screenWidth = $(window).width(); 

        if (screenWidth <= 1099) {
            const body = document.querySelector('body');
            body.classList.remove('sidebar-main')
            const sidebar = document.querySelector('.sidebar')
            sidebar.classList.add('sidebar-mini')
        }else if(screenWidth > 1099){
            const body = document.querySelector('body');
            body.classList.add('sidebar-main')
            const sidebar = document.querySelector('.sidebar')
            sidebar.classList.remove('sidebar-mini')
        }
    }

    $(window).resize(handleResize);
});
  
function copyShareLink(shareLink) {
    navigator.clipboard.writeText(shareLink);
}

$('input[name="visibility"]').on('change', function() {
    const selectedOption = $('input[name="visibility"]:checked').val();
    switch (selectedOption) {
        case "public":
            $('#visibilityDropdown').html('<i class="fas fa-globe"></i> Public');
            break;
        case "friends":
            $('#visibilityDropdown').html('<i class="fas fa-users"></i> Friends');
            break;
        case "only-me":
            $('#visibilityDropdown').html('<i class="fas fa-lock"></i> Only Me');
            break;
        default:
            break;
    }
});

$(document).ready(function() {
    $('#postText').on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});

$(window).scroll(function(e){ 
    var $el = $('.fixedElement'); 
    var isPositionFixed = ($el.css('position') == 'fixed');
    console.log($(this).scrollTop());
    if ($(this).scrollTop() > 550 && !isPositionFixed){ 
        $el.css({'position': 'fixed', 'top': '88px', 'max-height': '88vh'}); 
        $el.addClass('hoverToScroll'); 
    }
    if ($(this).scrollTop() < 550 && isPositionFixed){
        $el.css({'position': 'static', 'top': '0px', 'max-height': 'max-content'}); 
        $el.removeClass('hoverToScroll'); 
    } 
});