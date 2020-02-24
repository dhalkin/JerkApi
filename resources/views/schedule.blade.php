<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="Студия DiDance, онлайн расписание занятий." />
<!--    <meta name="keywords" content="ключевые слова" />-->
    
    <!-- fonts -->
    <link href="{{ asset('css/montseratt.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/awesome.css') }}" rel="stylesheet" />
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/sweetalert2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/vuenotify.css') }}" rel="stylesheet" />
    
    <title>{{ $title }}</title>

</head>
<body>
<div id="app" class="wrapper">
    <div class="row">
        <div class="col col-md-10 ml-auto mr-auto">
            <div class="card">
                <div class="card-body">
                    <notifications transition-name="list" transition-mode="out-in"></notifications>
                    <public-schedule
                        company-uid="{{ $companyUid }}"
                        company-name="{{ $companyName }}"
                        company-timezone="{{ $companyTimezone }}"
                    >
                    </public-schedule>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script src="{{ asset('/js/lang.js') }}"></script>
<script src="{{ asset('js/schedule.js')}}"></script>
