<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Description">
    <title>Title</title>
    <link rel="stylesheet" href="assets/styles/frontend/main.css">
</head>
<body id="doc">

<section class="container">
    <h1>Lorem ipsum dolor sit amet</h1>
    <h2>Lorem ipsum dolor sit amet</h2>
    <h3>Lorem ipsum dolor sit amet</h3>
    <h4>Lorem ipsum dolor sit amet</h4>
    <h5>Lorem ipsum dolor sit amet</h5>
    <h6>Lorem ipsum dolor sit amet</h6>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, alias beatae, dolores eligendi eos est,
        itaque nulla omnis porro praesentium quaerat totam! Id modi molestias nisi praesentium quibusdam, reiciendis tempore.
    </p>
</section>
<section class="buttons">
    <h1 class="text-white">Button</h1>
    <button class="btn btn-primary">Primary</button>
    <button class="btn btn-info">Info</button>
    <button class="btn btn-danger">Danger</button>
    <button class="btn btn-warning">Warning</button>
    <!--   <div class="button">Flex Grow</div> -->
    <button class="btn btn-round">Rounded Corners</button>
    <button class="btn btn-scale">Scale</button>
    <button class="btn btn-shadow-in">Border (Inner Shadow)</button>
    <button class="btn btn-shadow-out">Border (Outer Shadow)</button>
    <button class="btn btn-primary btn-ghost">
        Ghost
    </button>
    <button class="btn btn-primary btn-jittery">
        <i class="fas fa-shopping-cart"></i>
        <span>6</span>
    </button>
    <button class="btn btn-primary btn-finger">
        Finger
    </button>
    <button class="btn btn-primary btn-icon">
        <i class="fas fa-arrow-circle-left"></i>
        <span>Logout</span>
    </button>
    <button class="btn btn-primary btn-jelly">
        Jelly
    </button>
    <button class="btn btn-primary btn-ghost btn-fill">
        Fill In
    </button>
    <button class="btn btn-primary btn-pulse">
        Pulse
    </button>
    <button class="btn btn-primary btn-ghost btn-close">
        Close
    </button>
    <button class="btn btn-primary btn-ghost btn-fill-up">
        Fill Up
    </button>
    <button class="btn btn-primary btn-ghost btn-slide">
        Slide
    </button>
    <button class="btn btn-primary btn-ghost btn-offset">
        Offset
    </button>
    <button class="btn btn-primary btn-ghost btn-flip-down">
        Flip Down
        <div class="front">Flip Down</div>
        <div class="back">Flip Down</div>
    </button>
    <button class="btn btn-primary btn-marquee">
        <span data-text="Marquee">Marquee</span>
    </button>
</section>

<div class="container" id="grid">
    <h1>Grid :</h1>
    <div class="row">
        <div class="col-1">
            <div class="col-inner">col-1</div>
        </div>
        <div class="col-2">
            <div class="col-inner">col-2</div>
        </div>
        <div class="col-3">
            <div class="col-inner">col-3</div>
        </div>
        <div class="col-4">
            <div class="col-inner">col-4</div>
        </div>
        <div class="col-2">
            <div class="col-inner">col-2</div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="col-inner">col-5</div>
        </div>
        <div class="col-7">
            <div class="col-inner">col-7</div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="col-inner">col-6</div>
        </div>
        <div class="col-6">
            <div class="col-inner">col-6</div>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <div class="col-inner">col-9</div>
        </div>
        <div class="col-3">
            <div class="col-inner">col-3</div>
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <div class="col-inner">col-10</div>
        </div>
        <div class="col-2">
            <div class="col-inner">col-2</div>
        </div>
    </div>
    <div class="row">
        <div class="col-11">
            <div class="col-inner">col-11</div>
        </div>
        <div class="col-1">
            <div class="col-inner">col-1</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-9 col-md-6 col-lg-12">
            <div class="col-inner">col-12</div>
        </div>
    </div>
</div>

<section class="container" id="checkbox">
    <h1>CSS3 Checkbox Styles</h1>
    <em>Click any button below</em>

    <ul class="tg-list">
        <li class="tg-list-item">
            <h4>Light</h4>
            <input class="tgl tgl-light" id="cb1" type="checkbox">
            <label class="tgl-btn" for="cb1"></label>
        </li>
        <li class="tg-list-item">
            <h4>iOS</h4>
            <input class="tgl tgl-ios" id="cb2" type="checkbox">
            <label class="tgl-btn" for="cb2"></label>
        </li>
        <li class="tg-list-item">
            <h4>Skewed</h4>
            <input class="tgl tgl-skewed" id="cb3" type="checkbox">
            <label class="tgl-btn" data-tg-off="OFF" data-tg-on="ON" for="cb3"></label>
        </li>
        <li class="tg-list-item">
            <h4>Flat</h4>
            <input class="tgl tgl-flat" id="cb4" type="checkbox">
            <label class="tgl-btn" for="cb4"></label>
        </li>
        <li class="tg-list-item">
            <h4>Flip</h4>
            <input class="tgl tgl-flip" id="cb5" type="checkbox">
            <label class="tgl-btn" data-tg-off="Nope" data-tg-on="Yeah!" for="cb5"></label>
        </li>
    </ul>
</section>
<!--section class="container">
    <div class="square_box box_three"></div>
    <div class="square_box box_four"></div>
    <div class="container mt-5">
        <div class="row">

            <div class="col-sm-12">
                <div class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true"><a href="http://www.cakecounter.com/" target="_blank">
                    <i class="fa fa-times greencross"></i>
                    </a></span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="start-icon far fa-check-circle faa-tada animated"></i>
                    <strong class="font__weight-semibold">Well done!</strong> You successfullyread this important.
                </div>
            </div>

            <div class="col-sm-12">
                <div class="alert fade alert-simple alert-info alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                     role="alert" data-brk-library="component__alert">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true">
										<i class="fa fa-times blue-cross"></i>
									</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="start-icon  fa fa-info-circle faa-shake animated"></i>
                    <strong class="font__weight-semibold">Heads up!</strong> This alert needs your attention, but it's not super important.
                </div>

            </div>

            <div class="col-sm-12">
                <div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                     role="alert" data-brk-library="component__alert">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true">
										<i class="fa fa-times warning"></i>
									</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="start-icon fa fa-exclamation-triangle faa-flash animated"></i>
                    <strong class="font__weight-semibold">Warning!</strong> Better check yourself, you're not looking too good.
                </div>
            </div>

            <div class="col-sm-12">
                <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                     role="alert" data-brk-library="component__alert">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
									<span aria-hidden="true">
										<i class="fa fa-times danger "></i>
									</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="start-icon far fa-times-circle faa-pulse animated"></i>
                    <strong class="font__weight-semibold">Oh snap!</strong> Change a few things up and try submitting again.
                </div>
            </div>

            <div class="col-sm-12">
                <div class="alert fade alert-simple alert-primary alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show"
                     role="alert" data-brk-library="component__alert">
                    <button type="button" class="close font__size-18" data-dismiss="alert">
                        <span aria-hidden="true"><i class="fa fa-times alertprimary"></i></span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="start-icon fa fa-thumbs-up faa-bounce animated"></i>
                    <strong class="font__weight-semibold">Well done!</strong> You successfullyread this important.
                </div>

            </div>

        </div>
    </div>
</section-->
<div class="container">
    <h1>Hamburger Icon Animations</h1>
    <div class="row cf">
        <div class="three col">
            <div class="hamburger" id="hamburger-1">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-2">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-3">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-4">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </div>
    <div class="row cf">
        <div class="three col">
            <div class="hamburger" id="hamburger-5">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-6">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-7">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-8">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </div>
    <div class="row cf">
        <div class="three col">
            <div class="hamburger" id="hamburger-9">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-10">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-11">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <div class="three col">
            <div class="hamburger" id="hamburger-12">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </div>
</div>

<section id="credit-card" class="container">
    <div class="checkout">
        <div class="credit-card-box">
            <div class="flip">
                <div class="front">
                    <div class="chip"></div>
                    <div class="logo">
                        <svg version="1.1" id="visa" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="47.834px" height="47.834px" viewBox="0 0 47.834 47.834" style="enable-background:new 0 0 47.834 47.834;">
                            <g>
                                <g>
                                    <path d="M44.688,16.814h-3.004c-0.933,0-1.627,0.254-2.037,1.184l-5.773,13.074h4.083c0,0,0.666-1.758,0.817-2.143
                         c0.447,0,4.414,0.006,4.979,0.006c0.116,0.498,0.474,2.137,0.474,2.137h3.607L44.688,16.814z M39.893,26.01
                         c0.32-0.819,1.549-3.987,1.549-3.987c-0.021,0.039,0.317-0.825,0.518-1.362l0.262,1.23c0,0,0.745,3.406,0.901,4.119H39.893z
                         M34.146,26.404c-0.028,2.963-2.684,4.875-6.771,4.875c-1.743-0.018-3.422-0.361-4.332-0.76l0.547-3.193l0.501,0.228
                         c1.277,0.532,2.104,0.747,3.661,0.747c1.117,0,2.313-0.438,2.325-1.393c0.007-0.625-0.501-1.07-2.016-1.77
                         c-1.476-0.683-3.43-1.827-3.405-3.876c0.021-2.773,2.729-4.708,6.571-4.708c1.506,0,2.713,0.31,3.483,0.599l-0.526,3.092
                         l-0.351-0.165c-0.716-0.288-1.638-0.566-2.91-0.546c-1.522,0-2.228,0.634-2.228,1.227c-0.008,0.668,0.824,1.108,2.184,1.77
                         C33.126,23.546,34.163,24.783,34.146,26.404z M0,16.962l0.05-0.286h6.028c0.813,0.031,1.468,0.29,1.694,1.159l1.311,6.304
                         C7.795,20.842,4.691,18.099,0,16.962z M17.581,16.812l-6.123,14.239l-4.114,0.007L3.862,19.161
                         c2.503,1.602,4.635,4.144,5.386,5.914l0.406,1.469l3.808-9.729L17.581,16.812L17.581,16.812z M19.153,16.8h3.89L20.61,31.066
                         h-3.888L19.153,16.8z"/>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <div class="number"></div>
                    <div class="card-holder">
                        <label>Card holder</label>
                        <div></div>
                    </div>
                    <div class="card-expiration-date">
                        <label>Expires</label>
                        <div></div>
                    </div>
                </div>
                <div class="back">
                    <div class="strip"></div>
                    <div class="logo">
                        <svg version="1.1" id="visa" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="47.834px" height="47.834px" viewBox="0 0 47.834 47.834" style="enable-background:new 0 0 47.834 47.834;">
                            <g>
                                <g>
                                    <path d="M44.688,16.814h-3.004c-0.933,0-1.627,0.254-2.037,1.184l-5.773,13.074h4.083c0,0,0.666-1.758,0.817-2.143
                         c0.447,0,4.414,0.006,4.979,0.006c0.116,0.498,0.474,2.137,0.474,2.137h3.607L44.688,16.814z M39.893,26.01
                         c0.32-0.819,1.549-3.987,1.549-3.987c-0.021,0.039,0.317-0.825,0.518-1.362l0.262,1.23c0,0,0.745,3.406,0.901,4.119H39.893z
                         M34.146,26.404c-0.028,2.963-2.684,4.875-6.771,4.875c-1.743-0.018-3.422-0.361-4.332-0.76l0.547-3.193l0.501,0.228
                         c1.277,0.532,2.104,0.747,3.661,0.747c1.117,0,2.313-0.438,2.325-1.393c0.007-0.625-0.501-1.07-2.016-1.77
                         c-1.476-0.683-3.43-1.827-3.405-3.876c0.021-2.773,2.729-4.708,6.571-4.708c1.506,0,2.713,0.31,3.483,0.599l-0.526,3.092
                         l-0.351-0.165c-0.716-0.288-1.638-0.566-2.91-0.546c-1.522,0-2.228,0.634-2.228,1.227c-0.008,0.668,0.824,1.108,2.184,1.77
                         C33.126,23.546,34.163,24.783,34.146,26.404z M0,16.962l0.05-0.286h6.028c0.813,0.031,1.468,0.29,1.694,1.159l1.311,6.304
                         C7.795,20.842,4.691,18.099,0,16.962z M17.581,16.812l-6.123,14.239l-4.114,0.007L3.862,19.161
                         c2.503,1.602,4.635,4.144,5.386,5.914l0.406,1.469l3.808-9.729L17.581,16.812L17.581,16.812z M19.153,16.8h3.89L20.61,31.066
                         h-3.888L19.153,16.8z"/>
                                </g>
                            </g>
                        </svg>

                    </div>
                    <div class="ccv">
                        <label>CCV</label>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <form class="form" autocomplete="off" novalidate>
            <fieldset>
                <label for="card-number">Card Number</label>
                <input type="num" id="card-number" class="input-cart-number" maxlength="4" />
                <input type="num" id="card-number-1" class="input-cart-number" maxlength="4" />
                <input type="num" id="card-number-2" class="input-cart-number" maxlength="4" />
                <input type="num" id="card-number-3" class="input-cart-number" maxlength="4" />
            </fieldset>
            <fieldset>
                <label for="card-holder">Card holder</label>
                <input type="text" id="card-holder" />
            </fieldset>
            <fieldset class="fieldset-expiration">
                <label for="card-expiration-month">Expiration date</label>
                <div class="select">
                    <select id="card-expiration-month">
                        <option></option>
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                    </select>
                </div>
                <div class="select">
                    <select id="card-expiration-year">
                        <option></option>
                        <option>2016</option>
                        <option>2017</option>
                        <option>2018</option>
                        <option>2019</option>
                        <option>2020</option>
                        <option>2021</option>
                        <option>2022</option>
                        <option>2023</option>
                        <option>2024</option>
                        <option>2025</option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="fieldset-ccv">
                <label for="card-ccv">CCV</label>
                <input type="text" id="card-ccv" maxlength="3" />
            </fieldset>
            <button class="btn"><i class="fa fa-lock"></i> submit</button>
        </form>
    </div>
</section>

<section id="card" class="container">


    <ul class="cards">
        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--fence"></div>
                <div class="card__content">
                    <div class="card__title">Flex</div>
                    <p class="card__text">This is the shorthand for flex-grow, flex-shrink and flex-basis combined. The second and third parameters (flex-shrink and flex-basis) are optional. Default is 0 1 auto. </p>
                    <button class="btn btn--block card__btn">Button</button>
                </div>
            </div>
        </li>
        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--river"></div>
                <div class="card__content">
                    <div class="card__title">Flex Grow</div>
                    <p class="card__text">This defines the ability for a flex item to grow if necessary. It accepts a unitless value that serves as a proportion. It dictates what amount of the available space inside the flex container the item should take up.</p>
                    <button class="btn btn--block card__btn">Button</button>
                </div>
            </div>
        </li>
        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--record"></div>
                <div class="card__content">
                    <div class="card__title">Flex Shrink</div>
                    <p class="card__text">This defines the ability for a flex item to shrink if necessary. Negative numbers are invalid.</p>
                    <button class="btn btn--block card__btn">Button</button>
                </div>
            </div>
        </li>
        <li class="cards__item">
            <div class="card">
                <div class="card__image card__image--flowers"></div>
                <div class="card__content">
                    <div class="card__title">Flex Basis</div>
                    <p class="card__text">This defines the default size of an element before the remaining space is distributed. It can be a length (e.g. 20%, 5rem, etc.) or a keyword. The auto keyword means "look at my width or height property."</p>
                    <button class="btn btn--block card__btn">Button</button>
                </div>
            </div>
        </li>
    </ul>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="../assets/scripts/creditCard.js"></script>
</body>
</html>
