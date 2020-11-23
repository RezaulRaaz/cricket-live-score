<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cricket Score</title>
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" />
    </head>
    <body class="antialiased">
        <div id="app">
        <div class="body_wrapper">
            <div class="score">
                <h2 class="text-center">Cricket score </h2>
                <div class="score-nav">
                <ul class="wrap-tab">
                    <li>
                    <a class="score-active">Live & Upcoming</a>
                    </li>
                    <li><a href="#">Result</a></li>
                </ul>
                </div>
                <div class="scorbody tab-content" style="display: block">
                    <div class="score-container">
                      <!-- live Comonents -->
                      <live-components token="{{env('ACCESS_TOKEN')}}"></live-components>
                      <upcoming-components token="{{env('ACCESS_TOKEN')}}"></upcoming-components>
                    </div>
                  </div>
                  <div class="scorbody tab-content" style="display: none">
                    <div class="score-container">
                      <!-- live Comonents -->
                      <complete-components token="{{env('ACCESS_TOKEN')}}"></complete-components>
                    </div>
                  </div>

            </div>
        </div>


        {{-- <welcome-component token="{{env('ACCESS_TOKEN')}}"></welcome-component> --}}
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            let tabs = document.querySelectorAll(".wrap-tab li a");
            let tabContent = document.querySelectorAll(".tab-content");

            tabs.forEach((tab, index) => {
              tab.addEventListener("click", () => {
                tabs.forEach((tab) => {
                  tab.classList.remove("score-active");
                });
                tab.classList.add("score-active");

                tabContent.forEach((content, content_index) => {
                  if (content_index == index) {
                    content.style.display = "block";
                  } else {
                    content.style.display = "none";
                  }
                });
              });
            });
            </script>

    </body>
</html>
