<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('currency:check')->everyMinute();
