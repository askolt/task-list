<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Task List</title>

        <link rel="stylesheet" href="{{ asset('/public/css/app.css') }}">
        <script src="{{ asset('/public/js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            <navbar-component></navbar-component>
            <router-link to="/task-list">Task-list</router-link>
            <router-view></router-view>
{{--            <task-list-component></task-list-component>--}}
        </div>
    </body>
</html>
