<?php

// Share error messages along all views
View::share('errors', (array) Session::get('errors', array()));

// Share success messages along all views
View::share('success', (array) Session::get('success', array()));

